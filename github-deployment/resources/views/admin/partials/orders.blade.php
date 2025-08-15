<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">All Orders</h4>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="status_filter" class="form-label">Filter by Status</label>
                            <select class="form-select" id="status_filter">
                                <option value="">All Statuses</option>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="date_filter" class="form-label">Filter by Date</label>
                            <input type="date" class="form-control" id="date_filter">
                        </div>
                        <div class="col-md-3">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" class="form-control" id="search" placeholder="Customer or Product">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button class="btn btn-primary" onclick="applyFilters()">Apply Filters</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
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
                                        <td>#{{ $order->id }}</td>
                                        <td>
                                            <strong>{{ $order->user->name }}</strong><br>
                                            <small class="text-muted">{{ $order->user->email }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ $order->product->title }}</strong><br>
                                            <small class="text-muted">${{ number_format($order->product->price, 2) }} each</small>
                                        </td>
                                        <td>{{ $order->quantity }}</td>
                                        <td><strong>${{ number_format($order->total_price, 2) }}</strong></td>
                                        <td>
                                            <span class="badge {{ $order->status === 'completed' ? 'bg-success' : ($order->status === 'cancelled' ? 'bg-danger' : 'bg-warning') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info btn-sm">View</a>
                                            @if($order->status === 'pending')
                                                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="btn btn-success btn-sm">Complete</button>
                                                </form>
                                                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($orders->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function applyFilters() {
    const status = document.getElementById('status_filter').value;
    const date = document.getElementById('date_filter').value;
    const search = document.getElementById('search').value;
    
    let url = new URL(window.location);
    if (status) url.searchParams.set('status', status);
    if (date) url.searchParams.set('date', date);
    if (search) url.search_params.set('search', search);
    
    window.location = url;
}

// Set filter values from URL parameters
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('status')) {
        document.getElementById('status_filter').value = urlParams.get('status');
    }
    if (urlParams.get('date')) {
        document.getElementById('date_filter').value = urlParams.get('date');
    }
    if (urlParams.get('search')) {
        document.getElementById('search').value = urlParams.get('search');
    }
});
</script>
