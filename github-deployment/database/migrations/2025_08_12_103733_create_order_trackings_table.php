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
        Schema::create('order_trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('location_country');
            $table->string('location_city');
            $table->enum('status', [
                'shipped',
                'in_transit', 
                'out_for_delivery',
                'delivered',
                'returned'
            ])->default('shipped');
            $table->text('description')->nullable();
            $table->timestamp('tracked_at');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
            
            // Index for better performance
            $table->index(['order_id', 'tracked_at']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_trackings');
    }
};
