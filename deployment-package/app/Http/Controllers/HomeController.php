<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Only require authentication for the dashboard, not the welcome page
        $this->middleware('auth')->only(['index']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $latestProducts = Product::with(['reviews' => function($query) {
            $query->where('is_approved', true);
        }])->latest()->limit(6)->get();
        
        return view('home', compact('latestProducts'));
    }

    /**
     * Show the homepage with featured products.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function welcome()
    {
        // Load featured products (active products with reviews)
        $featuredProducts = Product::with(['reviews' => function($query) {
            $query->where('is_approved', true);
        }])
        ->where('is_active', true)
        ->where('is_featured', true)
        ->inRandomOrder()
        ->limit(8)
        ->get();
        
        // Load latest products for deals section
        $latestProducts = Product::with(['reviews' => function($query) {
            $query->where('is_approved', true);
        }])
        ->where('is_active', true)
        ->latest()
        ->limit(6)
        ->get();
        
        // Load categories for navigation
        $categories = \App\Models\Category::withCount('products')
            ->where('is_active', true)
            ->orderBy('products_count', 'desc')
            ->limit(8)
            ->get();
        
        return view('welcome', compact('featuredProducts', 'latestProducts', 'categories'));
    }
}
