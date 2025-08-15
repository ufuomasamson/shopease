@extends('layouts.admin')

@section('page-title', 'Manage Orders')

@section('content')

    <!-- Orders Header -->
    <div class="orders-header">
        <h1>
            <i class="fas fa-shopping-bag me-3"></i>
            Manage Orders
        </h1>
        <p>View and manage all customer orders from your store</p>
    </div>

            <!-- Orders Container -->
            <div class="orders-container">
                <!-- Filters Section -->
                <div class="filters-section">
                    <h5>
                        <i class="fas fa-filter me-2"></i>
                        Filter Orders
                    </h5>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="status_filter" class="form-label">Status</label>
                            <select class="form-select" id="status_filter">
                                <option value="">All Statuses</option>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="date_filter" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date_filter">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" class="form-control" id="search" placeholder="Customer or Product">
                        </div>
                        <div class="col-md-3 mb-3 d-flex align-items-end">
                            <button class="btn btn-primary" onclick="applyFilters()">
                                <i class="fas fa-search"></i>Apply Filters
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td>
                                        <strong>#{{ $order->id }}</strong>
                                    </td>
                                    <td>
                                        <div class="customer-info">
                                            <strong>{{ $order->user->name }}</strong><br>
                                            <small>{{ $order->user->email }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="product-info">
                                            <strong>{{ $order->product->title }}</strong><br>
                                            <small>${{ number_format($order->product->price, 2) }} each</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $order->quantity }}</span>
                                    </td>
                                    <td>
                                        <span class="price-info">${{ number_format($order->total_price, 2) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $order->status === 'completed' ? 'bg-success' : ($order->status === 'cancelled' ? 'bg-danger' : 'bg-warning') }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="actions-column">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>View
                                            </a>
                                            <a href="{{ route('admin.orders.tracking.show', $order) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-truck"></i>Track
                                            </a>
                                            @if($order->status === 'pending')
                                                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline status-update-form" data-order-id="{{ $order->id }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="btn btn-success btn-sm status-btn" data-status="completed">
                                                        <i class="fas fa-check"></i>Complete
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline status-update-form" data-order-id="{{ $order->id }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="btn btn-danger btn-sm status-btn" data-status="cancelled">
                                                        <i class="fas fa-times"></i>Cancel
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <i class="fas fa-shopping-cart"></i>
                                            <h5>No orders found</h5>
                                            <p>Orders will appear here once customers start shopping</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                    <div class="d-flex justify-content-center p-3">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
@endsection

@section('scripts')
<script>
function toggleSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    const main = document.getElementById('adminMain');
    const toggle = document.getElementById('sidebarToggle');
    
    sidebar.classList.toggle('collapsed');
    main.classList.toggle('expanded');
    toggle.classList.toggle('collapsed');
}

// Mobile sidebar toggle
function toggleMobileSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    sidebar.classList.toggle('mobile-open');
}

// Close sidebar on outside click (mobile)
document.addEventListener('click', function(event) {
    const sidebar = document.getElementById('adminSidebar');
    const toggle = document.getElementById('sidebarToggle');
    
    if (window.innerWidth <= 768) {
        if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
            sidebar.classList.remove('mobile-open');
        }
    }
});

// Auto-collapse sidebar on small screens
function handleResize() {
    const sidebar = document.getElementById('adminSidebar');
    const main = document.getElementById('adminMain');
    
    if (window.innerWidth <= 768) {
        sidebar.classList.remove('collapsed');
        main.classList.remove('expanded');
    }
}

window.addEventListener('resize', handleResize);
handleResize(); // Initial check

// Enhanced form submission handling
document.addEventListener('DOMContentLoaded', function() {
    // Handle status update forms
    const statusForms = document.querySelectorAll('.status-update-form');
    
    statusForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            const orderId = form.dataset.orderId;
            const status = form.querySelector('input[name="status"]').value;
            
            // Log form submission for debugging
            console.log('Status update form submitted:', {
                orderId: orderId,
                status: status,
                formAction: form.action,
                formMethod: form.method
            });
            
            // Show alert for debugging
            alert(`Updating order ${orderId} to status: ${status}`);
            
            // Disable button and show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
            submitBtn.classList.add('btn-loading');
            
            // Allow the form to submit normally
            // The form will handle the submission and redirect
        });
    });
    
    // Store original button text for error handling
    document.querySelectorAll('.status-btn').forEach(btn => {
        btn.dataset.originalText = btn.innerHTML;
    });
    
    // Handle search and filters
    const searchInput = document.getElementById('search');
    const statusFilter = document.getElementById('status_filter');
    const dateFilter = document.getElementById('date_filter');
    
    if (searchInput) {
        searchInput.addEventListener('input', debounce(function() {
            applyFilters();
        }, 500));
    }
    
    if (statusFilter) {
        statusFilter.addEventListener('change', applyFilters);
    }
    
    if (dateFilter) {
        dateFilter.addEventListener('change', applyFilters);
    }
});

// Debounce function for search input
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Apply filters function
function applyFilters() {
    const status = document.getElementById('status_filter')?.value;
    const date = document.getElementById('date_filter')?.value;
    const search = document.getElementById('search')?.value;
    
    let url = new URL(window.location);
    if (status) url.searchParams.set('status', status);
    if (date) url.searchParams.set('date', date);
    if (search) url.searchParams.set('search', search);
    
    window.location = url;
}

// Set filter values from URL parameters
function setFilterValues() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('status') && document.getElementById('status_filter')) {
        document.getElementById('status_filter').value = urlParams.get('status');
    }
    if (urlParams.get('date') && document.getElementById('date_filter')) {
        document.getElementById('date_filter').value = urlParams.get('date');
    }
    if (urlParams.get('search') && document.getElementById('search')) {
        document.getElementById('search').value = urlParams.get('search');
    }
}

// Initialize filters on page load
document.addEventListener('DOMContentLoaded', setFilterValues);
</script>
@endsection

@section('styles')
<style>
    /* Admin Orders Styles */
    .admin-top-nav {
        background: white;
        border-radius: 16px;
        padding: 1rem 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .sidebar-toggle {
        background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
    }

    .sidebar-toggle:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(246, 139, 30, 0.3);
    }

    .admin-top-nav h2 {
        margin: 0;
        color: #111827;
        font-weight: 700;
        font-size: 1.5rem;
    }

    .admin-top-nav .admin-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    /* Orders Content */
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

    .orders-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .filters-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .filters-section h5 {
        color: #111827;
        font-weight: 700;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .form-label {
        color: #374151;
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control, .form-select {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 0.75rem;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .form-control:focus, .form-select:focus {
        outline: none;
        border-color: #f68b1e;
        box-shadow: 0 0 0 3px rgba(246, 139, 30, 0.1);
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
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background: #f68b1e;
        color: white;
    }

    .btn-primary:hover {
        background: #e67e22;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(246, 139, 30, 0.3);
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
        transform: translateY(-2px);
    }

    .btn-success {
        background: #10b981;
        color: white;
    }

    .btn-success:hover {
        background: #059669;
        transform: translateY(-2px);
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-2px);
    }

    .btn-info {
        background: #3b82f6;
        color: white;
    }

    .btn-info:hover {
        background: #2563eb;
        transform: translateY(-2px);
    }

    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }

    .table {
        margin: 0;
    }

    .table th {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        color: #111827;
        font-weight: 700;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        padding: 1rem;
    }

    .table td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f3f4f6;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .badge {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
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

    .customer-info strong {
        color: #111827;
        font-weight: 700;
    }

    .customer-info small {
        color: #6b7280;
        font-size: 0.8rem;
    }

    .product-info strong {
        color: #111827;
        font-weight: 700;
    }

    .product-info small {
        color: #6b7280;
        font-size: 0.8rem;
    }

    .price-info {
        color: #111827;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .actions-column {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
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

    .pagination {
        justify-content: center;
        margin-top: 2rem;
    }

    .page-link {
        color: #f68b1e;
        border-color: #e5e7eb;
        border-radius: 8px;
        margin: 0 0.25rem;
    }

    .page-link:hover {
        color: #e67e22;
        background-color: #fef3c7;
        border-color: #f68b1e;
    }

    .page-item.active .page-link {
        background-color: #f68b1e;
        border-color: #f68b1e;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .orders-header h1 {
            font-size: 2rem;
        }

        .table-responsive {
            font-size: 0.875rem;
        }

        .actions-column {
            flex-direction: column;
        }

        .btn-sm {
            width: 100%;
            justify-content: center;
        }
    }
    
    /* Ensure proper layout with sidebar */
    .admin-main {
        box-sizing: border-box;
    }
    
    .orders-container {
        max-width: 100%;
        overflow-x: hidden;
    }
    
    .table-responsive {
        max-width: 100%;
        overflow-x: auto;
    }
    
    /* Ensure buttons don't get cut off */
    .actions-column {
        min-width: 200px;
    }
    
    /* Ensure proper spacing for all elements */
    .admin-main > * {
        margin-left: 0;
        margin-right: 0;
    }
    
    /* Button loading states */
    .btn-loading {
        opacity: 0.7;
        cursor: not-allowed;
    }
    
    .btn-loading:hover {
        transform: none !important;
    }
    
    /* Status update button animations */
    .btn-success, .btn-danger {
        transition: all 0.3s ease;
    }
    
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
    }
    
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
    }
    
    /* Form submission feedback */
    .form-submitting {
        pointer-events: none;
        opacity: 0.7;
    }
</style>
@endsection
