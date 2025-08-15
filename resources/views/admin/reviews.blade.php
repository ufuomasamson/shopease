@extends('layouts.admin')

@section('page-title', 'Product Reviews')

@section('content')
        <div class="page-header">
            <div class="header-content">
                <h1><i class="fas fa-star"></i> Product Reviews</h1>
                <p>Manage customer reviews and generate positive feedback for products</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Generate Review
                </a>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filters-section">
            <div class="row g-3">
                <div class="col-md-3">
                    <select id="rating_filter" class="form-select">
                        <option value="">All Ratings</option>
                        <option value="5">5 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="2">2 Stars</option>
                        <option value="1">1 Star</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="status_filter" class="form-select">
                        <option value="">All Status</option>
                        <option value="approved">Approved</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" id="search" class="form-control" placeholder="Search reviews, products, or users...">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary w-100" onclick="applyFilters()">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </div>
        </div>

        <!-- Reviews Table -->
        <div class="content-card">
            <div class="card-header">
                <h3>All Reviews</h3>
                <div class="card-actions">
                    <span class="text-muted">{{ $reviews->total() }} reviews found</span>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Review</th>
                            <th>Product</th>
                            <th>User</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                            <tr>
                                <td>
                                    <div class="review-content">
                                        @if($review->title)
                                            <h6 class="mb-1">{{ $review->title }}</h6>
                                        @endif
                                        <p class="mb-0 text-muted">{{ Str::limit($review->comment, 80) }}</p>
                                        @if($review->is_verified_purchase)
                                            <small class="text-success">
                                                <i class="fas fa-check-circle"></i> Verified Purchase
                                            </small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="product-info">
                                        @if($review->product->image)
                                            <img src="{{ Storage::url($review->product->image) }}" 
                                                 alt="{{ $review->product->title }}" 
                                                 class="product-thumb">
                                        @endif
                                        <div>
                                            <strong>{{ $review->product->title }}</strong>
                                            <br>
                                            <small class="text-muted">${{ number_format($review->product->price, 2) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="user-info">
                                        <strong>{{ $review->user->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $review->user->email }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="rating-display">
                                        {!! $review->star_rating !!}
                                        <br>
                                        <small class="text-muted">{{ $review->rating }}/5</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $review->status_badge_class }}">
                                        {{ $review->status_text }}
                                    </span>
                                </td>
                                <td>{{ $review->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <div class="actions-column">
                                        <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        
                                        <form action="{{ route('admin.reviews.toggle-approval', $review) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-{{ $review->is_approved ? 'secondary' : 'success' }} btn-sm">
                                                <i class="fas fa-{{ $review->is_approved ? 'pause' : 'check' }}"></i>
                                                {{ $review->is_approved ? 'Unapprove' : 'Approve' }}
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Are you sure you want to delete this review?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <i class="fas fa-star"></i>
                                        <h5>No reviews found</h5>
                                        <p>Start generating positive reviews for your products to build customer confidence</p>
                                        <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Generate First Review
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($reviews->hasPages())
                <div class="d-flex justify-content-center p-3">
                    {{ $reviews->links() }}
                </div>
            @endif
        </div>
@endsection

@section('styles')
<style>
    /* Ensure proper spacing for all elements */
    .admin-main > * {
        margin-left: 0;
        margin-right: 0;
    }
    
    /* Review content styling */
    .review-content h6 {
        color: var(--primary-color);
        font-weight: 600;
    }
    
    .product-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .product-thumb {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
    }
    
    .user-info strong {
        color: var(--primary-color);
    }
    
    .rating-display {
        text-align: center;
    }
    
    .rating-display .fa-star {
        font-size: 14px;
    }
    
    .actions-column {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }
    
    .actions-column .btn {
        font-size: 12px;
        padding: 4px 8px;
    }
    
    /* Empty state styling */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: var(--text-muted);
    }
    
    .empty-state i {
        font-size: 48px;
        margin-bottom: 20px;
        color: var(--primary-color);
    }
    
    .empty-state h5 {
        color: var(--text-primary);
        margin-bottom: 10px;
    }
    
    /* Filters section */
    .filters-section {
        background: var(--card-bg);
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: var(--card-shadow);
    }
    
    /* Content card */
    .content-card {
        background: var(--card-bg);
        border-radius: 12px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }
    
    .card-header {
        background: var(--card-header-bg);
        padding: 20px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .card-header h3 {
        margin: 0;
        color: var(--text-primary);
    }
    
    .card-actions {
        color: var(--text-muted);
    }
    
    /* Table styling */
    .table {
        margin: 0;
    }
    
    .table th {
        background: var(--table-header-bg);
        border-bottom: 2px solid var(--border-color);
        color: var(--text-primary);
        font-weight: 600;
        padding: 15px;
    }
    
    .table td {
        padding: 15px;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
    }
    
    .table tbody tr:hover {
        background: var(--table-hover-bg);
    }
    
    /* Badge styling */
    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    
    /* Button styling */
    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    /* Page header */
    .page-header {
        background: var(--card-bg);
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: var(--card-shadow);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .header-content h1 {
        color: var(--text-primary);
        margin-bottom: 10px;
        font-size: 28px;
        font-weight: 700;
    }
    
    .header-content p {
        color: var(--text-muted);
        margin: 0;
        font-size: 16px;
    }
    
    .header-actions .btn {
        padding: 12px 24px;
        font-size: 16px;
        font-weight: 600;
    }
</style>
@endsection

@section('scripts')
<script>

// Apply filters function
function applyFilters() {
    const rating = document.getElementById('rating_filter').value;
    const status = document.getElementById('status_filter').value;
    const search = document.getElementById('search').value;
    
    let url = new URL(window.location);
    if (rating) url.searchParams.set('rating', rating);
    if (status) url.searchParams.set('status', status);
    if (search) url.searchParams.set('search', search);
    
    window.location = url;
}

// Set filter values from URL parameters
function setFilterValues() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('rating') && document.getElementById('rating_filter')) {
        document.getElementById('rating_filter').value = urlParams.get('rating');
    }
    if (urlParams.get('status') && document.getElementById('status_filter')) {
        document.getElementById('status_filter').value = urlParams.get('status');
    }
    if (urlParams.get('search') && document.getElementById('search')) {
        document.getElementById('search').value = urlParams.get('search');
    }
}

// Initialize filters on page load
document.addEventListener('DOMContentLoaded', setFilterValues);

// Handle search input
document.getElementById('search')?.addEventListener('input', function() {
    if (this.value.length >= 3 || this.value.length === 0) {
        applyFilters();
    }
});

// Handle filter changes
document.getElementById('rating_filter')?.addEventListener('change', applyFilters);
document.getElementById('status_filter')?.addEventListener('change', applyFilters);
</script>
@endsection
