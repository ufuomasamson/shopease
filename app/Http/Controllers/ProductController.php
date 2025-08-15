<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::with(['category', 'brand'])->latest()->paginate(12);
        
        // Check if the request is coming from admin route
        if (request()->route()->getName() === 'admin.products.index') {
            return view('admin.products.index', compact('products'));
        }
        
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Category::where('is_active', true)->orderBy('name')->get();
        $brands = \App\Models\Brand::where('is_active', true)->orderBy('name')->get();
        
        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0.01',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:100',
            'shipping_cost' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images' => 'nullable|array',
            'additional_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only([
            'title', 'sku', 'description', 'price', 'discount_percentage', 
            'stock_quantity', 'category_id', 'brand_id', 'weight', 
            'dimensions', 'shipping_cost', 'is_active', 'is_featured'
        ]);

        // Handle main image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        // Handle additional images
        if ($request->hasFile('additional_images')) {
            $additionalImages = [];
            $files = $request->file('additional_images');
            
            // Ensure we have an array of files
            if (!is_array($files)) {
                $files = [$files];
            }
            
            // Limit to 5 images
            $files = array_slice($files, 0, 5);
            
            foreach ($files as $image) {
                if ($image && $image->isValid()) {
                    $path = $image->store('products', 'public');
                    $additionalImages[] = $path;
                }
            }
            
            if (!empty($additionalImages)) {
                $data['additional_images'] = json_encode($additionalImages);
            }
        }

        // Set default values
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // Load the product with reviews for display
        $product->load(['reviews' => function($query) {
            $query->where('is_approved', true)->latest();
        }]);
        
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = \App\Models\Category::where('is_active', true)->orderBy('name')->get();
        $brands = \App\Models\Brand::where('is_active', true)->orderBy('name')->get();
        
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku,' . $product->id,
            'description' => 'required|string',
            'price' => 'required|numeric|min:0.01',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:100',
            'shipping_cost' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images' => 'nullable|array',
            'additional_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only([
            'title', 'sku', 'description', 'price', 'discount_percentage', 
            'stock_quantity', 'category_id', 'brand_id', 'weight', 
            'dimensions', 'shipping_cost', 'is_active', 'is_featured'
        ]);

        // Handle main image
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        // Handle additional images
        if ($request->hasFile('additional_images')) {
            // Delete old additional images
            if ($product->additional_images) {
                $oldImages = json_decode($product->additional_images, true);
                if (is_array($oldImages)) {
                    foreach ($oldImages as $oldImage) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }
            
            $additionalImages = [];
            $files = $request->file('additional_images');
            
            // Ensure we have an array of files
            if (!is_array($files)) {
                $files = [$files];
            }
            
            // Limit to 5 images
            $files = array_slice($files, 0, 5);
            
            foreach ($files as $image) {
                if ($image && $image->isValid()) {
                    $path = $image->store('products', 'public');
                    $additionalImages[] = $path;
                }
            }
            
            if (!empty($additionalImages)) {
                $data['additional_images'] = json_encode($additionalImages);
            }
        }

        // Set default values
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}
