@extends('layouts.app')

@section('page-title', 'Order #' . $order->id)

@section('styles')
<style>
    /* Jumia Theme for Order Show Page */
    .content-wrapper {
        padding: 2rem;
    }

    .order-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .order-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .order-header h4 {
        margin: 0;
        color: #111827;
        font-weight: 700;
        font-size: 1.5rem;
    }

    .order-body {
        padding: 2rem;
    }

    .order-info {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .order-info h6 {
        color: #374151;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #6b7280;
    }

    .info-value {
        color: #111827;
        font-weight: 500;
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

    .product-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .product-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        background: #f8f9fa;
    }

    .btn {
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: #f68b1e;
        border: none;
        color: white;
    }

    .btn-primary:hover {
        background: #e67e22;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(246, 139, 30, 0.3);
    }

    .btn-secondary {
        background: #6b7280;
        border: none;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
        transform: translateY(-2px);
    }

    .btn-success {
        background: #10b981;
        border: none;
        color: white;
    }

    .btn-success:hover {
        background: #059669;
        transform: translateY(-2px);
    }

    .btn-danger {
        background: #ef4444;
        border: none;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-2px);
    }

    .tracking-timeline {
        position: relative;
        padding-left: 2rem;
    }

    .tracking-timeline::before {
        content: '';
        position: absolute;
        left: 0.75rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e5e7eb;
    }

    .tracking-item {
        position: relative;
        margin-bottom: 1.5rem;
        padding-left: 1rem;
    }

    .tracking-item::before {
        content: '';
        position: absolute;
        left: -0.75rem;
        top: 0.5rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #f68b1e;
        border: 3px solid white;
        box-shadow: 0 0 0 2px #f68b1e;
    }

    .tracking-item:last-child::before {
        background: #10b981;
        box-shadow: 0 0 0 2px #10b981;
    }

    .tracking-content {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .tracking-location {
        font-weight: 700;
        color: #111827;
        margin-bottom: 0.25rem;
    }

    .tracking-status {
        color: #6b7280;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .tracking-time {
        color: #9ca3af;
        font-size: 0.8rem;
    }

    .tracking-description {
        color: #374151;
        font-size: 0.9rem;
        margin-top: 0.5rem;
        padding-top: 0.5rem;
        border-top: 1px solid #f3f4f6;
    }

    .no-tracking {
        text-align: center;
        padding: 2rem;
        color: #6b7280;
    }

    .no-tracking i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #d1d5db;
    }

    /* Enhanced form styles for modals */
    .focus-border-primary:focus {
        border-color: #f68b1e !important;
        box-shadow: 0 0 0 0.2rem rgba(246, 139, 30, 0.25) !important;
    }

    .form-control, .form-select {
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        transform: translateY(-1px);
    }

    /* Enhanced button styles */
    .btn-outline-primary {
        border-color: #f68b1e;
        color: #f68b1e;
    }

    .btn-outline-primary:hover {
        background-color: #f68b1e;
        border-color: #f68b1e;
        color: white;
    }

    .btn-outline-danger {
        border-color: #dc3545;
        color: #dc3545;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }

    /* Card enhancements */
    .card {
        border-radius: 12px;
        overflow: hidden;
    }

    .card-header {
        padding: 1rem 1.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Badge enhancements */
    .badge {
        font-size: 0.85rem;
        padding: 0.5rem 0.75rem;
        border-radius: 20px;
    }

    @media (max-width: 768px) {
        .content-wrapper {
            padding: 1rem;
        }
        
        .order-header {
            padding: 1rem;
        }
        
        .order-body {
            padding: 1rem;
        }
        
        .info-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
        
        .tracking-timeline {
            padding-left: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Order Details Container -->
    <div class="order-container">
        <div class="order-header">
            <h4>
                <i class="fas fa-shopping-bag me-2"></i>
                Order #{{ $order->id }}
            </h4>
        </div>
        <div class="order-body">
            <!-- Order Information -->
            <div class="order-info">
                <h6>Order Information</h6>
                <div class="info-row">
                    <span class="info-label">Order ID:</span>
                    <span class="info-value">#{{ $order->id }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Order Date:</span>
                    <span class="info-value">{{ $order->created_at->format('M d, Y H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="badge {{ $order->status === 'completed' ? 'bg-success' : ($order->status === 'cancelled' ? 'bg-danger' : 'bg-warning') }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Total Amount:</span>
                    <span class="info-value">${{ number_format($order->total_price, 2) }}</span>
                </div>
                @if($order->hasTracking())
                    <div class="info-row">
                        <span class="info-label">Current Location:</span>
                        <span class="info-value">{{ $order->current_location }}</span>
                    </div>
                @endif
            </div>

            <!-- Product Information -->
            <div class="product-card">
                <h6 class="mb-3">Product Information</h6>
                <div class="row">
                    <div class="col-md-8">
                        <h5 class="mb-2">{{ $order->product->title }}</h5>
                        <p class="text-muted mb-2">{{ $order->product->description }}</p>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Quantity:</strong> {{ $order->quantity }}
                            </div>
                            <div class="col-md-6">
                                <strong>Price per unit:</strong> ${{ number_format($order->product->price, 2) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        @if($order->product->image)
                            <img src="{{ Storage::url($order->product->image) }}" 
                                 alt="{{ $order->product->title }}" class="product-image">
                        @else
                            <div class="product-image d-flex align-items-center justify-content-center">
                                <i class="fas fa-box text-muted"></i>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Shipping Address Information -->
            @if($order->shippingAddress)
            <div class="order-info">
                <h6><i class="fas fa-map-marker-alt me-2 text-primary"></i>Shipping Address</h6>
                <div class="info-row">
                    <span class="info-label">Full Name:</span>
                    <span class="info-value">{{ $order->shippingAddress->full_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Phone:</span>
                    <span class="info-value">{{ $order->shippingAddress->phone }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Address:</span>
                    <span class="info-value">{{ $order->shippingAddress->address_line_1 }}</span>
                </div>
                @if($order->shippingAddress->address_line_2)
                <div class="info-row">
                    <span class="info-label">Address 2:</span>
                    <span class="info-value">{{ $order->shippingAddress->address_line_2 }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">City:</span>
                    <span class="info-value">{{ $order->shippingAddress->city }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">State/Province:</span>
                    <span class="info-value">{{ $order->shippingAddress->state_province }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Postal Code:</span>
                    <span class="info-value">{{ $order->shippingAddress->postal_code }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Country:</span>
                    <span class="info-value">{{ $order->shippingAddress->country }}</span>
                </div>
            </div>
            @endif

            @if(auth()->user()->isAdmin())
                <!-- Customer Information -->
                <div class="order-info">
                    <h6>Customer Information</h6>
                    <div class="info-row">
                        <span class="info-label">Customer Name:</span>
                        <span class="info-value">{{ $order->user->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Customer Email:</span>
                        <span class="info-value">{{ $order->user->email }}</span>
                    </div>
                </div>
            @endif

            <!-- Order Tracking -->
            <div class="order-info">
                <h6>Order Tracking</h6>
                @if($order->hasTracking())
                    <div class="tracking-timeline">
                        @foreach($order->tracking as $tracking)
                            <div class="tracking-item">
                                <div class="tracking-content">
                                    <div class="tracking-location">{{ $tracking->formatted_location }}</div>
                                    <div class="tracking-status">{{ $tracking->status_text }}</div>
                                    <div class="tracking-time">{{ $tracking->tracked_at->format('M d, Y H:i') }}</div>
                                    @if($tracking->description)
                                        <div class="tracking-description">{{ $tracking->description }}</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="no-tracking">
                        <i class="fas fa-truck"></i>
                        <h6>No tracking information available</h6>
                        <p>Your order tracking will appear here once it's shipped.</p>
                    </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="d-flex justify-content-between flex-wrap gap-2">
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>Back to Orders
                </a>
                
                @if(auth()->user()->isAdmin())
                    <div class="d-flex gap-2">
                        @if($order->status === 'pending')
                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check"></i>Mark as Completed
                                </button>
                            </form>
                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-times"></i>Cancel Order
                                </button>
                            </form>
                        @endif
                        
                        @if(auth()->user()->isAdmin())
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#trackingModal">
                                <i class="fas fa-truck"></i>Update Tracking
                            </button>
                        @else
                            @if($order->hasTracking())
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#trackingInfoModal">
                                    <i class="fas fa-eye"></i>View Tracking
                                </button>
                            @endif
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Tracking Update Modal (Admin Only) -->
@if(auth()->user()->isAdmin())
    <div class="modal fade" id="trackingModal" tabindex="-1" aria-labelledby="trackingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header text-white fw-bold" style="background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%); border-bottom: none;">
                    <h5 class="modal-title" id="trackingModalLabel">
                        <i class="fas fa-truck me-2"></i>Update Order Tracking
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="trackingForm">
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="location_country" class="form-label fw-semibold text-dark">
                                    <i class="fas fa-globe me-2 text-primary"></i>Country
                                </label>
                                <input type="text" class="form-control border-2 border-light focus-border-primary" 
                                       id="location_country" name="location_country" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="location_city" class="form-label fw-semibold text-dark">
                                    <i class="fas fa-city me-2 text-primary"></i>City
                                </label>
                                <input type="text" class="form-control border-2 border-light focus-border-primary" 
                                       id="location_city" name="location_city" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label fw-semibold text-dark">
                                    <i class="fas fa-info-circle me-2 text-primary"></i>Status
                                </label>
                                <select class="form-select border-2 border-light focus-border-primary" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="shipped">🚚 Shipped</option>
                                    <option value="in_transit">🚛 In Transit</option>
                                    <option value="out_for_delivery">📦 Out for Delivery</option>
                                    <option value="delivered">✅ Delivered</option>
                                    <option value="returned">↩️ Returned</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tracked_at" class="form-label fw-semibold text-dark">
                                    <i class="fas fa-calendar me-2 text-primary"></i>Tracked At
                                </label>
                                <input type="datetime-local" class="form-control border-2 border-light focus-border-primary" 
                                       id="tracked_at" name="tracked_at" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold text-dark">
                                <i class="fas fa-align-left me-2 text-primary"></i>Description
                            </label>
                            <textarea class="form-control border-2 border-light focus-border-primary" id="description" name="description" rows="3" 
                                      placeholder="Describe the current status..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="admin_notes" class="form-label fw-semibold text-dark">
                                <i class="fas fa-sticky-note me-2 text-primary"></i>Admin Notes
                            </label>
                            <textarea class="form-control border-2 border-light focus-border-primary" id="admin_notes" name="admin_notes" rows="2" 
                                      placeholder="Internal notes for admin use..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light border-2 fw-semibold" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary fw-semibold" style="background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%); border: none;">
                            <i class="fas fa-save me-2"></i>Update Tracking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<!-- Tracking Info Modal (Users Only) -->
@if(!auth()->user()->isAdmin() && $order->hasTracking())
    <div class="modal fade" id="trackingInfoModal" tabindex="-1" aria-labelledby="trackingInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header text-white fw-bold" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); border-bottom: none;">
                    <h5 class="modal-title" id="trackingInfoModalLabel">
                        <i class="fas fa-truck me-2"></i>Order Tracking Information
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="tracking-timeline">
                        @foreach($order->tracking()->orderBy('tracked_at', 'desc')->get() as $tracking)
                            <div class="tracking-item">
                                <div class="tracking-content">
                                    <div class="tracking-status mb-2">
                                        <span class="badge bg-{{ $tracking->status_badge_class }} fw-semibold">{{ $tracking->status_text }}</span>
                                    </div>
                                    <div class="tracking-location fw-bold text-dark">
                                        <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                        {{ $tracking->formatted_location }}
                                    </div>
                                    <div class="tracking-time text-muted fw-semibold">
                                        <i class="fas fa-clock me-2 text-primary"></i>
                                        {{ $tracking->tracked_at->format('M d, Y \a\t g:i A') }}
                                    </div>
                                    @if($tracking->description)
                                        <div class="tracking-description text-dark mt-2 pt-2 border-top">
                                            <i class="fas fa-info-circle me-2 text-primary"></i>
                                            {{ $tracking->description }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light border-2 fw-semibold" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection

@section('scripts')
@if(auth()->user()->isAdmin())
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set current datetime for tracked_at field
    const now = new Date();
    const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
    document.getElementById('tracking_at').value = localDateTime;

    // Handle tracking form submission
    document.getElementById('trackingForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        
        fetch(`/admin/orders/{{ $order->id }}/tracking`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload page to show updated tracking
                window.location.reload();
            } else {
                alert('Error updating tracking: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating tracking. Please try again.');
        });
    });
});
</script>
@endif
@endsection
