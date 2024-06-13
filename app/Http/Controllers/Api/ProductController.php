<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProducts(Request $request)
    {
        $search = $request->query('search', '');
        $products = Product::search($search)->paginate(12);
        return response()->json($products);
    }
}
