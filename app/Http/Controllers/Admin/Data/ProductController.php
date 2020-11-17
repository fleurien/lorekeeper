<?php

namespace App\Http\Controllers\Admin\Data;

use DB;
use Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\ProductInfo;
use App\Models\Item\Item;

use App\Services\ProductService;

class ProductController extends Controller
{
    // returns current products
    public function Index(Request $request) {

        $query = Product::query();
        $data = $request->only(['product']);
        if(isset($data['product'])) 
            $query->where('product', 'LIKE', '%'.$data['product'].'%');

        return view('admin.paypal.index', [
            'products' => $query->orderBy('id', 'DESC')->paginate(20)->appends($request->query()),
        ]);
    }

    // create page
    public function getCreateProduct() {

        return view('admin.paypal.create_edit_product', [
            'products' => new Product,
            'items' => Item::orderBy('id')->pluck('name', 'id'),
        ]);
    }

    // edit page
    public function getEditProduct($id) {
        $product = Product::find($id);
        if(!$product) abort(404);
        return view('admin.paypal.create_edit_product', [
            'products' => $product,
            'items' => Item::orderBy('id')->pluck('name', 'id'),
        ]);
    }

    // creates or edits
    public function postCreateEditProduct(Request $request, ProductService $service, $id = null)
    {
        $id ? $request->validate(Product::$updateRules) : $request->validate(Product::$createRules);
        $data = $request->only([
            'price', 'quantity', 'is_limited', 'item_id', 'is_bundle', 'is_visible'
        ]);
        if($id && $service->updateProduct(Product::find($id), $data, Auth::user())) {
            flash('Product updated successfully.')->success();
        }
        else if (!$id && $product = $service->createProduct($data, Auth::user())) {
            flash('Product created successfully.')->success();
            return redirect()->to('admin/data/products/edit/'.$product->id);
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }

    // delete
    public function getDeleteProduct($id)
    {
        $products = Product::find($id);
        return view('admin.paypal._delete_product', [
            'products' => $products,
        ]);
    }
    
    // post delete
    public function postDeleteProduct(Request $request, ProductService $service, $id)
    {
        if($id && $service->deleteProduct(Product::find($id))) {
            flash('Product deleted successfully.')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->to('admin/data/products');
    }

    // shop
    public function getEditShop() {

        $shop = ProductInfo::where('id', 1)->first();
        return view('admin.paypal.edit_desc', [
            'shop' => $shop,
        ]);
    }

    public function postEditShop(Request $request, ProductService $service) {

        $data = $request->only([
            'title', 'desc', 'bdesc', 'btitle'
        ]);
        if($service->editShop(ProductInfo::find(1), $data)) {
            flash('Shop info edited successfully.')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->to('admin/data/products');
    }
}
