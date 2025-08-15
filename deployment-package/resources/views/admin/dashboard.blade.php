@extends('layouts.admin')

@section('page-title', 'Admin Dashboard')

@section('styles')
<style>

    /* Dashboard Content */
    .dashboard-content {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .dashboard-header {
        background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .dashboard-header h1 {
        margin: 0;
        font-weight: 800;
        font-size: 2.5rem;
    }

    .dashboard-header p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 1.1rem;
    }

    .dashboard-body {
        padding: 2rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #f68b1e, #e67e22);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin-bottom: 1rem;
    }

    .stat-icon.bg-primary {
        background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
    }

    .stat-icon.bg-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .stat-icon.bg-info {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }

    .stat-icon.bg-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: #6b7280;
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-change {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1rem;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .stat-change.positive {
        color: #10b981;
    }

    .stat-change.negative {
        color: #ef4444;
    }

    .quick-actions {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        margin-bottom: 2rem;
    }

    .quick-actions h3 {
        color: #111827;
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .action-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .action-card:hover {
        border-color: #f68b1e;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        transform: translateY(-2px);
        text-decoration: none;
        color: inherit;
    }

    .action-card i {
        font-size: 2.5rem;
        color: #f68b1e;
        margin-bottom: 1rem;
    }

    .action-card h5 {
        color: #111827;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .action-card p {
        color: #6b7280;
        margin: 0;
        font-size: 0.9rem;
    }

    .recent-orders {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        margin-bottom: 2rem;
    }

    .recent-orders h3 {
        color: #111827;
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid #f3f4f6;
        transition: background-color 0.2s ease;
    }

    .order-item:hover {
        background-color: #f8f9fa;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-info h6 {
        color: #111827;
        font-weight: 600;
        margin: 0 0 0.25rem 0;
    }

    .order-info p {
        color: #6b7280;
        margin: 0;
        font-size: 0.875rem;
    }

    .order-status {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
    }

    .order-status.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .order-status.completed {
        background: #d1fae5;
        color: #065f46;
    }

    .order-status.cancelled {
        background: #fee2e2;
        color: #991b1b;
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

    .btn-success {
        background: #10b981;
        color: white;
    }

    .btn-success:hover {
        background: #059669;
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

    .btn-warning {
        background: #f59e0b;
        color: white;
    }

    .btn-warning:hover {
        background: #d97706;
        transform: translateY(-2px);
    }

    .view-all-btn {
        background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 25px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }

    .view-all-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(246, 139, 30, 0.3);
        color: white;
        text-decoration: none;
    }

    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #d1d5db;
    }

    .empty-state h5 {
        color: #374151;
        margin-bottom: 0.5rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .admin-sidebar {
            transform: translateX(-100%);
        }

        .admin-sidebar.mobile-open {
            transform: translateX(0);
        }

        .admin-main {
            margin-left: 0;
            padding: 1rem;
        }

        .dashboard-header h1 {
            font-size: 2rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .actions-grid {
            grid-template-columns: 1fr;
        }

        .order-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
    }

    /* Sidebar Toggle Animation */
    .sidebar-toggle i {
        transition: transform 0.3s ease;
    }

    .sidebar-toggle.collapsed i {
        transform: rotate(180deg);
    }
</style>
@endsection

@section('content')
        <!-- Dashboard Content -->
        <div class="dashboard-content">

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <div class="dashboard-header">
                <h1>
                    <i class="fas fa-tachometer-alt me-3"></i>
                    Welcome to Admin Dashboard
                </h1>
                <p>Manage your store, monitor sales, and assist customers</p>
            </div>
            <div class="dashboard-body">
                <!-- Statistics Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon bg-primary">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="stat-value">{{ $stats['totalOrders'] }}</div>
                        <div class="stat-label">Total Orders</div>
                        <div class="stat-change {{ $stats['orderGrowth'] >= 0 ? 'positive' : 'negative' }}">
                            <i class="fas fa-arrow-{{ $stats['orderGrowth'] >= 0 ? 'up' : 'down' }}"></i>
                            <span>{{ $stats['orderGrowth'] >= 0 ? '+' : '' }}{{ $stats['orderGrowth'] }}% from last month</span>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon bg-success">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-value">${{ number_format($stats['totalRevenue'], 2) }}</div>
                        <div class="stat-label">Total Revenue</div>
                        <div class="stat-change {{ $stats['revenueGrowth'] >= 0 ? 'positive' : 'negative' }}">
                            <i class="fas fa-arrow-{{ $stats['revenueGrowth'] >= 0 ? 'up' : 'down' }}"></i>
                            <span>{{ $stats['revenueGrowth'] >= 0 ? '+' : '' }}{{ $stats['revenueGrowth'] }}% from last month</span>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon bg-info">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-value">{{ $stats['totalUsers'] }}</div>
                        <div class="stat-label">Total Users</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i>
                            <span>+5% from last month</span>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon bg-warning">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stat-value">{{ $stats['totalProducts'] }}</div>
                        <div class="stat-label">Total Products</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i>
                            <span>+3% from last month</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <h3>
                        <i class="fas fa-bolt text-warning"></i>
                        Quick Actions
                    </h3>
                    <div class="actions-grid">
                        <a href="{{ route('admin.products.create') }}" class="action-card">
                            <i class="fas fa-plus-circle"></i>
                            <h5>Add Product</h5>
                            <p>Create a new product listing</p>
                        </a>

                        <a href="{{ route('admin.orders') }}" class="action-card">
                            <i class="fas fa-shopping-bag"></i>
                            <h5>Manage Orders</h5>
                            <p>View and process orders</p>
                        </a>

                        <a href="{{ route('admin.fund-wallet') }}" class="action-card">
                            <i class="fas fa-wallet"></i>
                            <h5>Fund Wallet</h5>
                            <p>Add funds to user wallets</p>
                        </a>

                        <a href="{{ route('admin.products.index') }}" class="action-card">
                            <i class="fas fa-boxes"></i>
                            <h5>Products</h5>
                            <p>Manage product inventory</p>
                        </a>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="recent-orders">
                    <h3>
                        <i class="fas fa-clock text-info"></i>
                        Recent Orders
                    </h3>
                    
                    @if($recentOrders->count() > 0)
                        @foreach($recentOrders as $order)
                            <div class="order-item">
                                <div class="order-info">
                                    <h6>Order #{{ $order->id }} - {{ $order->product->title }}</h6>
                                    <p>{{ $order->user->name }} • {{ $order->created_at->format('M d, Y H:i') }}</p>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="order-status {{ $order->status }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i>View
                                    </a>
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="text-center">
                            <a href="{{ route('admin.orders') }}" class="view-all-btn">
                                <i class="fas fa-list"></i>View All Orders
                            </a>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-shopping-cart"></i>
                            <h5>No orders yet</h5>
                            <p>Orders will appear here once customers start shopping</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
@endsection

@section('scripts')
<script>
// Sidebar functionality is now handled by the sidebar partial
</script>
@endsection
