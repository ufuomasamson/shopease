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
        Schema::table('orders', function (Blueprint $table) {
            // Shipping information
            $table->unsignedBigInteger('shipping_address_id')->nullable()->after('user_id');
            $table->string('shipping_method')->nullable()->after('shipping_address_id');
            $table->decimal('shipping_cost', 8, 2)->default(0.00)->after('shipping_method');
            $table->string('tracking_number')->nullable()->after('shipping_cost');
            $table->string('carrier')->nullable()->after('tracking_number');
            
            // Order details
            $table->text('order_notes')->nullable()->after('status');
            $table->string('payment_method')->nullable()->after('order_notes');
            $table->string('payment_status')->default('pending')->after('payment_method');
            $table->string('transaction_id')->nullable()->after('payment_status');
            
            // Delivery information
            $table->timestamp('estimated_delivery')->nullable()->after('transaction_id');
            $table->timestamp('delivered_at')->nullable()->after('estimated_delivery');
            $table->string('delivery_notes')->nullable()->after('delivered_at');
            
            // Customer service
            $table->boolean('is_cancelled')->default(false)->after('delivery_notes');
            $table->timestamp('cancelled_at')->nullable()->after('is_cancelled');
            $table->text('cancellation_reason')->nullable()->after('cancelled_at');
            $table->boolean('is_refunded')->default(false)->after('cancellation_reason');
            $table->timestamp('refunded_at')->nullable()->after('is_refunded');
            $table->decimal('refund_amount', 10, 2)->nullable()->after('refunded_at');
            
            // Indexes
            $table->index('shipping_address_id');
            $table->index('tracking_number');
            $table->index('payment_status');
            $table->index('estimated_delivery');
            $table->index('is_cancelled');
            $table->index('is_refunded');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_address_id', 'shipping_method', 'shipping_cost', 'tracking_number',
                'carrier', 'order_notes', 'payment_method', 'payment_status', 'transaction_id',
                'estimated_delivery', 'delivered_at', 'delivery_notes', 'is_cancelled',
                'cancelled_at', 'cancellation_reason', 'is_refunded', 'refunded_at', 'refund_amount'
            ]);
            
            $table->dropIndex(['shipping_address_id', 'tracking_number', 'payment_status', 
                              'estimated_delivery', 'is_cancelled', 'is_refunded']);
        });
    }
};
