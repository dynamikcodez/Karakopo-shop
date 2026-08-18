<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class StorefrontController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('primaryImage')
            ->where('is_published', true)
            ->where('is_featured', true)
            ->take(8)
            ->get();
            
        $popularProducts = Product::with('primaryImage')
            ->where('is_published', true)
            ->inRandomOrder()
            ->take(4)
            ->get();

        $categories = Category::where('is_published', true)->take(6)->get();

        return view('home', compact('featuredProducts', 'popularProducts', 'categories'));
    }

    public function shop(Request $request)
    {
        $query = Product::with('primaryImage')->where('is_published', true);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        if ($request->filled('sort')) {
            if ($request->sort === 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($request->sort === 'price_desc') {
                $query->orderBy('price', 'desc');
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_published', true)->get();

        return view('shop', compact('products', 'categories'));
    }

    public function product($slug)
    {
        $product = Product::with(['category', 'images'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $relatedProducts = Product::with('primaryImage')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_published', true)
            ->take(4)
            ->get();

        return view('product', compact('product', 'relatedProducts'));
    }
}
