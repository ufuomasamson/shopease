<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderTrackingController extends Controller
{
    /**
     * Show tracking information for an order
     */
    public function show(Order $order)
    {
        $trackingEntries = $order->tracking()->orderBy('tracked_at', 'desc')->get();
        return view('admin.orders.tracking.show', compact('order', 'trackingEntries'));
    }

    /**
     * Store a new tracking entry
     */
    public function store(Request $request, Order $order)
    {
        $request->validate([
            'location_country' => 'required|string|max:100',
            'location_city' => 'required|string|max:100',
            'status' => 'required|in:shipped,in_transit,out_for_delivery,delivered,returned',
            'description' => 'nullable|string|max:500',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        try {
            $tracking = OrderTracking::create([
                'order_id' => $order->id,
                'location_country' => $request->location_country,
                'location_city' => $request->location_city,
                'status' => $request->status,
                'description' => $request->description,
                'admin_notes' => $request->admin_notes,
                'tracked_at' => now(),
            ]);

            // Update order status if delivered
            if ($request->status === 'delivered') {
                $order->update([
                    'status' => 'completed',
                    'delivered_at' => now(),
                ]);
            }

            // Update order status if shipped
            if ($request->status === 'shipped' && $order->status === 'pending') {
                $order->update(['status' => 'processing']);
            }

            Log::info('Tracking entry created', [
                'order_id' => $order->id,
                'tracking_id' => $tracking->id,
                'status' => $request->status,
                'location' => "{$request->location_city}, {$request->location_country}"
            ]);

            return back()->with('success', 'Tracking information updated successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to create tracking entry', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to update tracking information: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing tracking entry
     */
    public function update(Request $request, OrderTracking $tracking)
    {
        $request->validate([
            'location_country' => 'required|string|max:100',
            'location_city' => 'required|string|max:100',
            'status' => 'required|in:shipped,in_transit,out_for_delivery,delivered,returned',
            'description' => 'nullable|string|max:500',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        try {
            $tracking->update([
                'location_country' => $request->location_country,
                'location_city' => $request->location_city,
                'status' => $request->status,
                'description' => $request->description,
                'admin_notes' => $request->admin_notes,
            ]);

            // Update order status if delivered
            if ($request->status === 'delivered') {
                $tracking->order->update([
                    'status' => 'completed',
                    'delivered_at' => now(),
                ]);
            }

            Log::info('Tracking entry updated', [
                'tracking_id' => $tracking->id,
                'order_id' => $tracking->order_id,
                'status' => $request->status
            ]);

            return back()->with('success', 'Tracking information updated successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to update tracking entry', [
                'tracking_id' => $tracking->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to update tracking information: ' . $e->getMessage());
        }
    }

    /**
     * Delete a tracking entry
     */
    public function destroy(OrderTracking $tracking)
    {
        try {
            $orderId = $tracking->order_id;
            $tracking->delete();

            Log::info('Tracking entry deleted', [
                'tracking_id' => $tracking->id,
                'order_id' => $orderId
            ]);

            return back()->with('success', 'Tracking entry deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to delete tracking entry', [
                'tracking_id' => $tracking->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to delete tracking entry: ' . $e->getMessage());
        }
    }
}
