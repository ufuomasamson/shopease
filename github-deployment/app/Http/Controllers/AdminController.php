<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Show the admin dashboard
     */
    public function dashboard(Request $request)
    {
        // Get comprehensive statistics
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');
        $totalUsers = User::where('role', 'user')->count();
        $totalProducts = Product::count();
        
        // Get recent orders with user and product relationships
        $recentOrders = Order::with(['user', 'product'])
            ->latest()
            ->take(5)
            ->get();

        // Get recent users
        $recentUsers = User::where('role', 'user')
            ->latest()
            ->take(5)
            ->get();

        // Calculate monthly growth (simplified)
        $currentMonthOrders = Order::whereMonth('created_at', now()->month)->count();
        $lastMonthOrders = Order::whereMonth('created_at', now()->subMonth()->month)->count();
        $orderGrowth = $lastMonthOrders > 0 ? (($currentMonthOrders - $lastMonthOrders) / $lastMonthOrders) * 100 : 0;

        $currentMonthRevenue = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');
        $lastMonthRevenue = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->sum('total_price');
        $revenueGrowth = $lastMonthRevenue > 0 ? (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 : 0;

        $stats = [
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'totalUsers' => $totalUsers,
            'totalProducts' => $totalProducts,
            'orderGrowth' => round($orderGrowth, 1),
            'revenueGrowth' => round($revenueGrowth, 1),
        ];

        if ($request->ajax()) {
            return view('admin.partials.dashboard', compact('stats', 'recentOrders', 'recentUsers'));
        }

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentUsers'));
    }

    /**
     * Show wallet funding form
     */
    public function fundWallet(Request $request)
    {
        $users = User::where('role', 'user')->get();

        if ($request->ajax()) {
            return view('admin.partials.fund-wallet', compact('users'));
        }

        return view('admin.fund-wallet', compact('users'));
    }

    /**
     * Process wallet funding
     */
    public function processWalletFunding(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $user = User::findOrFail($request->user_id);
        $wallet = $user->wallet ?? $user->wallet()->create();

        try {
            $wallet->credit($request->amount, 'Admin funding');
            
            return redirect()->route('admin.dashboard')
                ->with('success', "Successfully funded {$user->name}'s wallet with $" . number_format($request->amount, 2));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to fund wallet: ' . $e->getMessage());
        }
    }

    /**
     * Show all orders
     */
    public function orders(Request $request)
    {
        $orders = Order::with(['user', 'product'])
            ->when(request('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->when(request('date'), function ($query, $date) {
                $query->whereDate('created_at', $date);
            })
            ->when(request('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                                 ->orWhere('email', 'like', "%{$search}%");
                    })->orWhereHas('product', function ($productQuery) use ($search) {
                        $productQuery->where('title', 'like', "%{$search}%");
                    });
                });
            })
            ->latest()
            ->paginate(15);

        if ($request->ajax()) {
            return view('admin.partials.orders', compact('orders'));
        }

        return view('admin.orders', compact('orders'));
    }

    /**
     * Update order status
     */
    public function updateOrderStatus(Request $request, Order $order)
    {
        Log::info('Order status update requested', [
            'order_id' => $order->id,
            'current_status' => $order->status,
            'new_status' => $request->status,
            'request_method' => $request->method(),
            'request_data' => $request->all(),
            'order_exists' => $order->exists,
            'order_attributes' => $order->getAttributes()
        ]);

        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,completed,cancelled,refunded'
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        Log::info('Order status updated successfully', [
            'order_id' => $order->id,
            'old_status' => $oldStatus,
            'new_status' => $order->status,
            'update_successful' => $order->wasChanged('status')
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

    /**
     * Show order details
     */
    public function showOrder(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function categoriesBrands()
    {
        $categories = Category::withCount('products')->orderBy('name')->paginate(15);
        $brands = Brand::withCount('products')->orderBy('name')->paginate(15);
        
        return view('admin.categories-brands', compact('categories', 'brands'));
    }

    /**
     * Show all product reviews
     */
    public function reviews(Request $request)
    {
        $reviews = ProductReview::with(['product', 'user'])
            ->when(request('rating'), function ($query, $rating) {
                $query->where('rating', $rating);
            })
            ->when(request('status'), function ($query, $status) {
                if ($status === 'approved') {
                    $query->where('is_approved', true);
                } elseif ($status === 'pending') {
                    $query->where('is_approved', false);
                }
            })
            ->when(request('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('product', function ($productQuery) use ($search) {
                        $productQuery->where('title', 'like', "%{$search}%");
                    })->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                                 ->orWhere('email', 'like', "%{$search}%");
                    })->orWhere('title', 'like', "%{$search}%")
                      ->orWhere('comment', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15);

        if ($request->ajax()) {
            return view('admin.partials.reviews', compact('reviews'));
        }

        return view('admin.reviews', compact('reviews'));
    }

    /**
     * Show review creation form
     */
    public function createReview()
    {
        $products = Product::where('is_active', true)->orderBy('title')->get();
        $users = User::where('role', 'user')->orderBy('name')->get();
        
        return view('admin.reviews.create', compact('products', 'users'));
    }

    /**
     * Store a new review
     */
    public function storeReview(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|between:1,5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string|min:10',
            'is_verified_purchase' => 'boolean',
            'is_approved' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Check if review already exists for this user and product
        $existingReview = ProductReview::where('product_id', $request->product_id)
            ->where('user_id', $request->user_id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'A review already exists for this user and product.');
        }

        $reviewData = [
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'is_verified_purchase' => $request->boolean('is_verified_purchase'),
            'is_approved' => $request->boolean('is_approved', true),
        ];

        // Handle image uploads
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('reviews', 'public');
                $images[] = $path;
            }
            $reviewData['images'] = $images;
        }

        ProductReview::create($reviewData);

        return redirect()->route('admin.reviews')
            ->with('success', 'Review created successfully!');
    }

    /**
     * Show review edit form
     */
    public function editReview(ProductReview $review)
    {
        $products = Product::where('is_active', true)->orderBy('title')->get();
        $users = User::where('role', 'user')->orderBy('name')->get();
        
        return view('admin.reviews.edit', compact('review', 'products', 'users'));
    }

    /**
     * Update review
     */
    public function updateReview(Request $request, ProductReview $review)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|between:1,5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string|min:10',
            'is_verified_purchase' => 'boolean',
            'is_approved' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Check if review already exists for this user and product (excluding current review)
        $existingReview = ProductReview::where('product_id', $request->product_id)
            ->where('user_id', $request->user_id)
            ->where('id', '!=', $review->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'A review already exists for this user and product.');
        }

        $reviewData = [
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'is_verified_purchase' => $request->boolean('is_verified_purchase'),
            'is_approved' => $request->boolean('is_approved'),
        ];

        // Handle image uploads
        if ($request->hasFile('images')) {
            // Delete old images
            if ($review->images) {
                foreach ($review->images as $oldImage) {
                    \Storage::disk('public')->delete($oldImage);
                }
            }
            
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('reviews', 'public');
                $images[] = $path;
            }
            $reviewData['images'] = $images;
        }

        $review->update($reviewData);

        return redirect()->route('admin.reviews')
            ->with('success', 'Review updated successfully!');
    }

    /**
     * Delete review
     */
    public function deleteReview(ProductReview $review)
    {
        // Delete associated images
        if ($review->images) {
            foreach ($review->images as $image) {
                \Storage::disk('public')->delete($image);
            }
        }

        $review->delete();

        return redirect()->route('admin.reviews')
            ->with('success', 'Review deleted successfully!');
    }

    /**
     * Toggle review approval status
     */
    public function toggleReviewApproval(ProductReview $review)
    {
        $review->update(['is_approved' => !$review->is_approved]);
        
        $status = $review->is_approved ? 'approved' : 'pending';
        return redirect()->back()->with('success', "Review {$status} successfully!");
    }
}
