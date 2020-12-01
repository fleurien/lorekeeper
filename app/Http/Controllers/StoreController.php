<?php

namespace App\Http\Controllers;

use Auth;
use DB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\InventoryManager;
use App\Services\ShopManager;
use App\Models\Product;
use App\Models\ProductInfo;

class StoreController extends Controller
{

    public function storeFront() {
    // add products
    $products = Product::where('is_visible', 1)->orderBy('sort', 'DESC')->get();
    $desc = ProductInfo::where('id', 1)->first();
       
        return view('paypal.paypal_welcome', [
            'products' => $products,
            'shop' => $desc,
        ]);
    }

    public function success(){
        
        return view('paypal.paypal_success', [
           
        ]);
    }
}