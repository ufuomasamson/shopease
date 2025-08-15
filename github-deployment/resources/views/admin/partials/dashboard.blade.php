<div class="dashboard-content">
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon users">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $stats['total_users'] }}</h3>
                <p class="stat-label">Total Users</p>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up text-success"></i>
                    <span class="text-success">Active</span>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon products">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $stats['total_products'] }}</h3>
                <p class="stat-label">Total Products</p>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up text-success"></i>
                    <span class="text-success">Available</span>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orders">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $stats['total_orders'] }}</h3>
                <p class="stat-label">Total Orders</p>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up text-success"></i>
                    <span class="text-success">Growing</span>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon revenue">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">${{ number_format($stats['total_wallet_balance'], 2) }}</h3>
                <p class="stat-label">Total Wallet Balance</p>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up text-success"></i>
                    <span class="text-success">Healthy</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h3 class="section-title">Quick Actions</h3>
        <div class="actions-grid">
            <a href="{{ route('admin.products.create') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-plus"></i>
                </div>
                <h4>Add Product</h4>
                <p>Create a new digital product</p>
                <div class="action-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <a href="{{ route('admin.orders') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-list"></i>
                </div>
                <h4>View Orders</h4>
                <p>Manage customer orders</p>
                <div class="action-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <a href="{{ route('admin.fund-wallet') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <h4>Fund Wallets</h4>
                <p>Add balance to user wallets</p>
                <div class="action-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>

            <a href="{{ route('admin.products.index') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <h4>Manage Products</h4>
                <p>Edit or delete products</p>
                <div class="action-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="recent-activity">
        <div class="row">
            <!-- Recent Orders -->
            <div class="col-lg-6">
                <div class="activity-card">
                    <div class="card-header">
                        <h4><i class="fas fa-shopping-cart me-2"></i>Recent Orders</h4>
                        <a href="{{ route('admin.orders') }}" class="view-all">View All</a>
                    </div>
                    <div class="card-body">
                        @if($recent_orders->count() > 0)
                            <div class="activity-list">
                                @foreach($recent_orders as $order)
                                    <div class="activity-item">
                                        <div class="activity-icon order">
                                            <i class="fas fa-shopping-bag"></i>
                                        </div>
                                        <div class="activity-content">
                                            <h6>{{ $order->product->title }}</h6>
                                            <p>Ordered by {{ $order->user->name }}</p>
                                            <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="activity-status">
                                            <span class="status-badge status-{{ $order->status }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-shopping-cart text-muted"></i>
                                <p>No orders yet</p>
                                <small>Orders will appear here once customers start purchasing</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Users -->
            <div class="col-lg-6">
                <div class="activity-card">
                    <div class="card-header">
                        <h4><i class="fas fa-users me-2"></i>Recent Users</h4>
                    </div>
                    <div class="card-body">
                        @if($recent_users->count() > 0)
                            <div class="activity-list">
                                @foreach($recent_users as $user)
                                    <div class="activity-item">
                                        <div class="activity-icon user">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="activity-content">
                                            <h6>{{ $user->name }}</h6>
                                            <p>{{ $user->email }}</p>
                                            <small class="text-muted">Joined {{ $user->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="activity-status">
                                            <span class="status-badge status-{{ $user->role }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-users text-muted"></i>
                                <p>No users yet</p>
                                <small>User registrations will appear here</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
