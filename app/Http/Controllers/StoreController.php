<?php

namespace App\Http\Controllers;

use Auth;
use DB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\InventoryManager;
use App\Services\ShopManager;
use App\Models\Product;

class StoreController extends Controller
{

    public function storeFront() {
    // add products
    $products = Product::where('is_visible', 1)->get();
       
        return view('paypal.paypal_welcome', [
            'products' => $products,
        ]);
    }

    public function success(){
        
        return view('paypal.paypal_success', [
           
        ]);
    }
}