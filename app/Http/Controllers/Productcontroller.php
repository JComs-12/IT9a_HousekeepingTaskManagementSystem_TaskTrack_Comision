<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Productcontroller extends Controller
{
    public function showProducts(){
        $products = Product :: all();
        return view('products', ['products' => $products]
        )};
}
