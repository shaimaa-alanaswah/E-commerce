<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProjectController extends Controller
{
    function index()
    {

        $products = DB::table('products')->limit(4)->get();
        return view('index', ['products' => $products]);
    }


    function single_product(Request $request, $id)
    {
        $product_array = DB::table('products')->where('id', $id)->get();
        return view('single_product', ['product_array' => $product_array]);
    }

    function products()
    {
        $products= DB::table('products')->paginate(4);

        return view('products',['products'=>$products]);
    }
}
