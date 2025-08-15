<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show user's orders
     */
    public function index()
    {
        $orders = auth()->user()->orders()->with('product')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show order details
     */
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        return view('orders.show', compact('order'));
    }

    /**
     * Create a new order
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $user = auth()->user();
        $wallet = $user->wallet;

        // Debug information
        \Log::info('Order creation attempt', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'product_price' => $product->price,
            'wallet_exists' => $wallet ? 'yes' : 'no',
            'wallet_balance' => $wallet ? $wallet->balance : 'N/A'
        ]);

        // Check if wallet exists
        if (!$wallet) {
            \Log::error('User has no wallet', ['user_id' => $user->id]);
            return back()->with('error', 'You need to have a wallet to make purchases. Please contact admin to fund your wallet.');
        }

        // Check stock
        if (!$product->hasStock($request->quantity)) {
            \Log::warning('Insufficient stock', [
                'product_id' => $product->id,
                'requested_quantity' => $request->quantity,
                'available_stock' => $product->stock_quantity
            ]);
            return back()->with('error', 'Insufficient stock for this product. Available: ' . $product->stock_quantity . ' units');
        }

        // Calculate total price using discounted price
        $unitPrice = $product->hasDiscount() ? $product->final_price : $product->price;
        $totalPrice = Order::calculateTotal($unitPrice, $request->quantity);
        
        \Log::info('Price calculation', [
            'original_price' => $product->price,
            'discount_percentage' => $product->discount_percentage,
            'discounted_price' => $unitPrice,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice
        ]);

        // Check wallet balance
        if ($wallet->balance < $totalPrice) {
            \Log::warning('Insufficient wallet balance', [
                'user_id' => $user->id,
                'required_amount' => $totalPrice,
                'available_balance' => $wallet->balance
            ]);
            return back()->with('error', 'Insufficient wallet balance. Required: $' . number_format($totalPrice, 2) . ', Available: $' . number_format($wallet->balance, 2));
        }

        try {
            \Log::info('Creating order...', [
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'total_price' => $totalPrice
            ]);

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'total_price' => $totalPrice,
                'status' => 'pending', // Changed from 'completed' to 'pending'
                'payment_status' => 'paid',
                'payment_method' => 'wallet'
            ]);

            \Log::info('Order created successfully', ['order_id' => $order->id]);

            // Debit wallet
            $wallet->debit($totalPrice, "Purchase: {$product->title} (Qty: {$request->quantity})");
            
            \Log::info('Wallet debited successfully', [
                'amount' => $totalPrice,
                'new_balance' => $wallet->balance
            ]);

            // Decrease product stock
            $product->decreaseStock($request->quantity);
            
            \Log::info('Stock decreased successfully', [
                'product_id' => $product->id,
                'new_stock' => $product->stock_quantity
            ]);

            return redirect()->route('orders.show', $order)
                ->with('success', 'Order placed successfully! Your wallet has been charged $' . number_format($totalPrice, 2));

        } catch (\Exception $e) {
            \Log::error('Order creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }
}
