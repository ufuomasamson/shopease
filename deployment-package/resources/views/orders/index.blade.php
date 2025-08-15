@extends('layouts.user')

@section('page-title', 'My Orders')

@section('styles')
<style>
    /* Jumia Theme for Orders Page */
    .content-wrapper {
        padding: 2rem;
    }

    .orders-header {
        background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 8px 25px rgba(246, 139, 30, 0.3);
    }

    .orders-header h1 {
        margin: 0;
        font-weight: 800;
        font-size: 2.5rem;
    }

    .orders-header p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 1.1rem;
    }

    .orders-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .orders-header-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .orders-header-card h5 {
        margin: 0;
        color: #111827;
        font-weight: 700;
        font-size: 1.25rem;
    }

    .orders-body {
        padding: 2rem;
    }

    .table {
        margin: 0;
    }

    .table th {
        background: #f8f9fa;
        color: #374151;
        font-weight: 600;
        border: none;
        padding: 1rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table td {
        padding: 1rem;
        border: none;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: #f8f9fa;
    }

    .product-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .product-image {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
        background: #f8f9fa;
    }

    .product-details {
        flex: 1;
    }

    .product-details h6 {
        margin: 0 0 0.25rem 0;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .product-details small {
        color: #6b7280;
        font-size: 0.8rem;
    }

    .badge {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .badge.bg-success {
        background: #10b981 !important;
    }

    .badge.bg-warning {
        background: #f59e0b !important;
    }

    .badge.bg-danger {
        background: #ef4444 !important;
    }

    .btn-outline-primary {
        border: 2px solid #f68b1e;
        color: #f68b1e;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-outline-primary:hover {
        background: #f68b1e;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(246, 139, 30, 0.3);
    }

    .pagination {
        margin: 2rem 0 0 0;
    }

    .page-link {
        border: none;
        color: #6b7280;
        padding: 0.75rem 1rem;
        margin: 0 0.25rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .page-link:hover {
        background: #f68b1e;
        color: white;
        transform: translateY(-2px);
    }

    .page-item.active .page-link {
        background: #f68b1e;
        border-color: #f68b1e;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: #d1d5db;
    }

    .empty-state h5 {
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .btn-primary {
        background: #f68b1e;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #e67e22;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(246, 139, 30, 0.3);
    }

    @media (max-width: 768px) {
        .content-wrapper {
            padding: 1rem;
        }
        
        .orders-header {
            padding: 1.5rem;
        }
        
        .orders-header h1 {
            font-size: 2rem;
        }
        
        .orders-body {
            padding: 1rem;
        }
        
        .table-responsive {
            font-size: 0.9rem;
        }
        
        .product-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
    }
    
    /* Tracking Timeline Styles */
    .tracking-timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .tracking-timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background-color: #e5e7eb;
    }
    
    .tracking-item {
        position: relative;
        margin-bottom: 20px;
    }
    
    .tracking-item::before {
        content: '';
        position: absolute;
        left: -22px;
        top: 0;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #007bff;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #e5e7eb;
    }
    
    .tracking-item:last-child::before {
        background-color: #28a745;
    }
    
    .tracking-content {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 3px solid #007bff;
    }
    
    .tracking-status {
        margin-bottom: 8px;
    }
    
    .tracking-location {
        font-weight: 600;
        color: #374151;
        margin-bottom: 5px;
    }
    
    .tracking-time {
        font-size: 0.85rem;
        color: #6b7280;
        margin-bottom: 5px;
    }
    
    .tracking-description {
        font-size: 0.9rem;
        color: #4b5563;
        font-style: italic;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Orders Header -->
    <div class="orders-header">
        <h1>
            <i class="fas fa-shopping-bag me-3"></i>
            My Orders
        </h1>
        <p>Track your purchases and order history</p>
    </div>

    <!-- Orders Card -->
    <div class="orders-card">
        <div class="orders-header-card">
            <h5>
                <i class="fas fa-history me-2"></i>
                Order History
            </h5>
        </div>
        <div class="orders-body">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <strong>#{{ $order->id }}</strong>
                                    </td>
                                    <td>
                                        <div class="product-info">
                                            @if($order->product->image)
                                                <img src="{{ Storage::url($order->product->image) }}" alt="{{ $order->product->title }}" class="product-image">
                                            @else
                                                <div class="product-image d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-box text-muted"></i>
                                                </div>
                                            @endif
                                            <div class="product-details">
                                                <h6>{{ $order->product->title }}</h6>
                                                <small>${{ number_format($order->product->price, 2) }} each</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $order->quantity }}</td>
                                    <td class="fw-bold">${{ number_format($order->total_price, 2) }}</td>
                                    <td>
                                        @if($order->status === 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($order->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @else
                                            <span class="badge bg-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="d-flex flex-column gap-2">
                                            <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye me-1"></i>View Details
                                            </a>
                                            @if($order->hasTracking())
                                                <button type="button" class="btn btn-outline-info btn-sm" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#trackingModal{{ $order->id }}">
                                                    <i class="fas fa-truck me-1"></i>Track Order
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-shopping-bag"></i>
                    <h5>No orders found</h5>
                    <p>You haven't placed any orders yet. Start shopping to see your order history here.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-cart me-2"></i>Browse Products
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Tracking Modals for Each Order -->
@foreach($orders as $order)
    @if($order->hasTracking())
        <div class="modal fade" id="trackingModal{{ $order->id }}" tabindex="-1" aria-labelledby="trackingModalLabel{{ $order->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title" id="trackingModalLabel{{ $order->id }}">
                            <i class="fas fa-truck me-2"></i>Order #{{ $order->id }} Tracking
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="tracking-timeline">
                            @foreach($order->tracking()->orderBy('tracked_at', 'desc')->get() as $tracking)
                                <div class="tracking-item">
                                    <div class="tracking-content">
                                        <div class="tracking-status">
                                            <span class="badge bg-{{ $tracking->status_badge_class }}">{{ $tracking->status_text }}</span>
                                        </div>
                                        <div class="tracking-location">
                                            <i class="fas fa-map-marker-alt me-2"></i>
                                            {{ $tracking->formatted_location }}
                                        </div>
                                        <div class="tracking-time">
                                            <i class="fas fa-clock me-2"></i>
                                            {{ $tracking->tracked_at->format('M d, Y \a\t g:i A') }}
                                        </div>
                                        @if($tracking->description)
                                            <div class="tracking-description">
                                                <i class="fas fa-info-circle me-2"></i>
                                                {{ $tracking->description }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i>Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
@endsection
