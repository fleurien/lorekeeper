<?php

namespace App\Http\Controllers\Admin\Data;

use DB;
use Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Item\Item;

class ProductController extends Controller
{

    public function Index(Request $request) {

        $query = Product::query();
        $data = $request->only(['product']);
        if(isset($data['product'])) 
            $query->where('product', 'LIKE', '%'.$data['product'].'%');

        return view('admin.paypal.index', [
            'products' => $query->orderBy('id', 'DESC')->paginate(20)->appends($request->query()),
        ]);
    }

    //
    public function getCreateProduct() {

        return view('admin.paypal.create_edit_product', [
            'products' => new Product,
            'items' => Item::orderBy('id')->pluck('name', 'id'),
        ]);
    }
}
