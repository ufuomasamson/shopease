<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Basic product info
            $table->string('sku')->unique()->nullable()->after('id');
            $table->string('brand')->nullable()->after('title');
            $table->string('category')->nullable()->after('brand');
            $table->string('subcategory')->nullable()->after('category');
            
            // Physical attributes
            $table->decimal('weight', 8, 2)->nullable()->after('stock'); // in kg
            $table->string('dimensions')->nullable()->after('weight'); // LxWxH in cm
            $table->string('color')->nullable()->after('dimensions');
            $table->string('size')->nullable()->after('color');
            $table->string('material')->nullable()->after('size');
            
            // E-commerce features
            $table->decimal('original_price', 10, 2)->nullable()->after('price');
            $table->decimal('discount_percentage', 5, 2)->nullable()->after('original_price');
            $table->boolean('is_featured')->default(false)->after('discount_percentage');
            $table->boolean('is_on_sale')->default(false)->after('is_featured');
            $table->boolean('is_new_arrival')->default(false)->after('is_on_sale');
            $table->boolean('is_bestseller')->default(false)->after('is_new_arrival');
            
            // Shipping & availability
            $table->string('shipping_weight')->nullable()->after('is_bestseller');
            $table->string('shipping_class')->nullable()->after('shipping_weight'); // standard, express, etc.
            $table->integer('shipping_days')->nullable()->after('shipping_class');
            $table->boolean('free_shipping')->default(false)->after('shipping_days');
            $table->decimal('shipping_cost', 8, 2)->nullable()->after('free_shipping');
            
            // Product details
            $table->text('features')->nullable()->after('shipping_cost'); // JSON or text
            $table->text('specifications')->nullable()->after('features'); // JSON or text
            $table->text('warranty_info')->nullable()->after('specifications');
            $table->text('return_policy')->nullable()->after('warranty_info');
            
            // SEO & marketing
            $table->string('meta_title')->nullable()->after('return_policy');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('meta_keywords')->nullable()->after('meta_description');
            
            // Status & visibility
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active')->after('meta_keywords');
            $table->timestamp('published_at')->nullable()->after('status');
            
            // Additional images
            $table->json('additional_images')->nullable()->after('image');
            $table->json('product_variants')->nullable()->after('additional_images'); // For different sizes/colors
            
            // Ratings & reviews
            $table->decimal('average_rating', 3, 2)->default(0.00)->after('product_variants');
            $table->integer('total_reviews')->default(0)->after('average_rating');
            
            // Inventory management
            $table->integer('min_order_quantity')->default(1)->after('total_reviews');
            $table->integer('max_order_quantity')->nullable()->after('min_order_quantity');
            $table->boolean('allow_backorders')->default(false)->after('max_order_quantity');
            $table->integer('low_stock_threshold')->default(5)->after('allow_backorders');
            
            // Vendor/Supplier info
            $table->string('vendor_name')->nullable()->after('low_stock_threshold');
            $table->string('vendor_id')->nullable()->after('vendor_name');
            $table->string('supplier_code')->nullable()->after('vendor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'sku', 'brand', 'category', 'subcategory', 'weight', 'dimensions',
                'color', 'size', 'material', 'original_price', 'discount_percentage',
                'is_featured', 'is_on_sale', 'is_new_arrival', 'is_bestseller',
                'shipping_weight', 'shipping_class', 'shipping_days', 'free_shipping',
                'shipping_cost', 'features', 'specifications', 'warranty_info',
                'return_policy', 'meta_title', 'meta_description', 'meta_keywords',
                'status', 'published_at', 'additional_images', 'product_variants',
                'average_rating', 'total_reviews', 'min_order_quantity', 'max_order_quantity',
                'allow_backorders', 'low_stock_threshold', 'vendor_name', 'vendor_id', 'supplier_code'
            ]);
        });
    }
};
