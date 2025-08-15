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
            // First, drop the old string-based fields
            $table->dropColumn(['brand', 'category', 'subcategory']);
            
            // Add proper foreign key relationships
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null')->after('title');
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null')->after('category_id');
            
            // Rename stock to stock_quantity
            $table->renameColumn('stock', 'stock_quantity');
            
            // Add missing fields that are referenced in the controller
            $table->boolean('is_active')->default(true)->after('stock_quantity');
            
            // Add SKU if it doesn't exist
            if (!Schema::hasColumn('products', 'sku')) {
                $table->string('sku')->unique()->nullable()->after('id');
            }
            
            // Add discount_percentage if it doesn't exist
            if (!Schema::hasColumn('products', 'discount_percentage')) {
                $table->decimal('discount_percentage', 5, 2)->nullable()->after('price');
            }
            
            // Add weight if it doesn't exist
            if (!Schema::hasColumn('products', 'weight')) {
                $table->decimal('weight', 8, 2)->nullable()->after('stock_quantity');
            }
            
            // Add dimensions if it doesn't exist
            if (!Schema::hasColumn('products', 'dimensions')) {
                $table->string('dimensions')->nullable()->after('weight');
            }
            
            // Add shipping_cost if it doesn't exist
            if (!Schema::hasColumn('products', 'shipping_cost')) {
                $table->decimal('shipping_cost', 8, 2)->nullable()->after('dimensions');
            }
            
            // Add is_featured if it doesn't exist
            if (!Schema::hasColumn('products', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('shipping_cost');
            }
            
            // Add additional_images if it doesn't exist
            if (!Schema::hasColumn('products', 'additional_images')) {
                $table->json('additional_images')->nullable()->after('image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['category_id']);
            $table->dropForeign(['brand_id']);
            
            // Drop the new columns
            $table->dropColumn(['category_id', 'brand_id', 'is_active']);
            
            // Rename stock_quantity back to stock
            $table->renameColumn('stock_quantity', 'stock');
            
            // Add back the old string-based fields
            $table->string('brand')->nullable()->after('title');
            $table->string('category')->nullable()->after('brand');
            $table->string('subcategory')->nullable()->after('category');
        });
    }
};
