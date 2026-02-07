<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::latest()->take(10)->get();
        $categories = Category::all();
        return view('home', compact('products', 'categories'));
    }
    
    public function product(Product $product)
    {
        return view('product', compact('product'));
    }
}
