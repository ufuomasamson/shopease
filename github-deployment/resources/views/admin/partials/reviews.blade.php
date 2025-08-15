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

@if($reviews->hasPages())
    <div class="d-flex justify-content-center">
        {{ $reviews->links() }}
    </div>
@endif
