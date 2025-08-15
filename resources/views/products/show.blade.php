@extends('layouts.app')

@section('page-title', $product->title)

@section('styles')
<style>
    /* Mobile-First Responsive Product Show Page */
    
    /* Base Mobile Styles (Default) */
    .content-wrapper {
        padding: 1rem;
        max-width: 100%;
        margin: 0 auto;
        width: 100%;
    }

    .back-button {
        margin-bottom: 1rem;
    }

    .back-button .btn {
        background: #6b7280;
        color: white;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .back-button .btn:hover {
        background: #4b5563;
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }

    .product-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .product-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        text-align: center;
    }

    .product-header h4 {
        margin: 0;
        color: #111827;
        font-weight: 700;
        font-size: 1.25rem;
        line-height: 1.3;
    }

    .product-body {
        padding: 1rem;
    }

    .product-image-container {
        background: #f8f9fa;
        border-radius: 8px;
        overflow: hidden;
        height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        position: relative;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-image:hover {
        transform: scale(1.05);
    }

    .additional-images {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
        justify-content: center;
    }

    .additional-image {
        width: 60px;
        height: 60px;
        border-radius: 6px;
        object-fit: cover;
        cursor: pointer;
        transition: transform 0.3s ease;
        border: 2px solid #e5e7eb;
    }

    .additional-image:hover {
        transform: scale(1.1);
        border-color: #f68b1e;
    }

    .product-details h5 {
        color: #111827;
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }

    .product-description {
        color: #6b7280;
        line-height: 1.6;
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }

    .product-price {
        font-size: 1.5rem;
        font-weight: 900;
        color: #f68b1e;
        margin-bottom: 0.75rem;
    }

    .product-stock {
        color: #059669;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }

    .product-stock i {
        font-size: 1rem;
    }

    .product-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .btn-buy {
        background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.875rem 1.5rem;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.3s ease;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
    }

    .btn-buy:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(246, 139, 30, 0.3);
        text-decoration: none;
        color: white;
    }

    .btn-buy:disabled {
        background: #9ca3af;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .btn-add-cart {
        background: transparent;
        color: #f68b1e;
        border: 2px solid #f68b1e;
        border-radius: 8px;
        padding: 0.875rem 1.5rem;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.3s ease;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
    }

    .btn-add-cart:hover {
        background: #f68b1e;
        color: white;
        transform: translateY(-2px);
        text-decoration: none;
    }

    .product-meta {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .product-meta h6 {
        color: #111827;
        font-weight: 700;
        margin-bottom: 0.75rem;
        font-size: 1rem;
    }

    .meta-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #e5e7eb;
        font-size: 0.9rem;
    }

    .meta-item:last-child {
        border-bottom: none;
    }

    .meta-label {
        font-weight: 600;
        color: #374151;
    }

    .meta-value {
        color: #6b7280;
    }

    .reviews-section {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .reviews-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        text-align: center;
    }

    .reviews-header h4 {
        margin: 0;
        color: #111827;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .reviews-body {
        padding: 1rem;
    }

    .review-item {
        border-bottom: 1px solid #f3f4f6;
        padding: 1rem 0;
    }

    .review-item:last-child {
        border-bottom: none;
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .reviewer-name {
        font-weight: 600;
        color: #111827;
        font-size: 0.9rem;
    }

    .review-date {
        color: #9ca3af;
        font-size: 0.8rem;
    }

    .review-rating {
        margin-bottom: 0.5rem;
    }

    .review-text {
        color: #6b7280;
        line-height: 1.5;
        font-size: 0.9rem;
    }

    .no-reviews {
        text-align: center;
        color: #9ca3af;
        padding: 2rem 1rem;
    }

    .no-reviews i {
        font-size: 2.5rem;
        margin-bottom: 0.75rem;
        color: #e5e7eb;
    }

    .no-reviews h5 {
        color: #6b7280;
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }

    .no-reviews p {
        margin: 0;
        font-size: 0.85rem;
    }

    /* Tablet Styles */
    @media (min-width: 768px) {
        .content-wrapper {
            padding: 1.5rem;
            max-width: 1200px;
        }

        .product-body {
            padding: 1.5rem;
        }

        .product-header {
            padding: 1.5rem 2rem;
        }

        .product-header h4 {
            font-size: 1.5rem;
        }

        .product-image-container {
            height: 300px;
        }

        .product-details h5 {
            font-size: 1.5rem;
        }

        .product-price {
            font-size: 1.75rem;
        }

        .product-actions {
            flex-direction: row;
            gap: 1rem;
        }

        .btn-buy,
        .btn-add-cart {
            width: auto;
            flex: 1;
        }

        .additional-image {
            width: 70px;
            height: 70px;
        }

        .product-meta {
            padding: 1.5rem;
        }

        .reviews-header {
            padding: 1.5rem 2rem;
        }

        .reviews-body {
            padding: 1.5rem;
        }

        .reviews-header h4 {
            font-size: 1.25rem;
        }
    }

    /* Desktop Styles */
    @media (min-width: 1024px) {
        .content-wrapper {
            padding: 2rem;
        }

        .product-body {
            padding: 2rem;
        }

        .product-header {
            padding: 1.5rem 2rem;
        }

        .product-image-container {
            height: 400px;
        }

        .product-details h5 {
            font-size: 1.75rem;
        }

        .product-price {
            font-size: 2rem;
        }

        .additional-image {
            width: 80px;
            height: 80px;
        }

        .product-meta {
            padding: 2rem;
        }

        .reviews-header {
            padding: 1.5rem 2rem;
        }

        .reviews-body {
            padding: 2rem;
        }

        .reviews-header h4 {
            font-size: 1.5rem;
        }
    }

    /* Large Desktop Styles */
    @media (min-width: 1280px) {
        .content-wrapper {
            max-width: 1400px;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Back to Products Link -->
    <div class="back-button">
        <a href="{{ route('products.index') }}" class="btn">
            <i class="fas fa-arrow-left"></i>
            Back to Products
        </a>
    </div>

    <!-- Product Container -->
    <div class="product-container">
        <div class="product-header">
            <h4>
                <i class="fas fa-box text-primary me-2"></i>
                {{ $product->title }}
            </h4>
                    </div>
        
        <div class="product-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    <!-- Product Images -->
                    <div class="product-image-container">
                    @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" 
                                 alt="{{ $product->title }}" 
                                 class="product-image" 
                                 id="mainProductImage">
                        @else
                            <div class="product-icon-placeholder">
                                <i class="fas fa-file-alt" style="font-size: 3rem; color: #9ca3af;"></i>
                            </div>
                        @endif
                        </div>
                        
                    @if($product->image)
                            <div class="additional-images">
                            <img src="{{ Storage::url($product->image) }}" 
                                 alt="{{ $product->title }}" 
                                 class="additional-image"
                                 onclick="changeMainImage(this.src)">
                        </div>
                    @endif
                </div>
                
                <div class="col-12 col-md-6">
                    <!-- Product Details -->
                    <div class="product-details">
                        <h5>{{ $product->title }}</h5>
                        <p class="product-description">{{ $product->description }}</p>
                        
                        <div class="product-price">
                            ${{ number_format($product->price, 2) }}
                        </div>
                        
                        <div class="product-stock">
                            <i class="fas fa-check-circle"></i>
                            {{ $product->stock_quantity }} in stock
                        </div>
                        
                        <div class="product-actions">
                            @if($product->stock_quantity > 0)
                                <button type="button" class="btn-buy" data-bs-toggle="modal" data-bs-target="#buyModal">
                                    <i class="fas fa-shopping-cart"></i>
                                    Buy Now
                                </button>
                                <button type="button" class="btn-add-cart" onclick="addToCart({{ $product->id }})">
                                    <i class="fas fa-plus"></i>
                                    Add to Cart
                                </button>
                            @else
                                <button class="btn-buy" disabled>
                                    <i class="fas fa-times"></i>
                                    Out of Stock
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Product Meta Information -->
            <div class="product-meta">
                <h6>Product Information</h6>
                <div class="meta-item">
                    <span class="meta-label">Category:</span>
                    <span class="meta-value">{{ $product->category->name ?? 'General' }}</span>
                    </div>
                <div class="meta-item">
                    <span class="meta-label">Brand:</span>
                    <span class="meta-value">{{ $product->brand->name ?? 'Unknown' }}</span>
                    </div>
                <div class="meta-item">
                    <span class="meta-label">SKU:</span>
                    <span class="meta-value">{{ $product->sku ?? 'N/A' }}</span>
                    </div>
                <div class="meta-item">
                    <span class="meta-label">Created:</span>
                    <span class="meta-value">{{ $product->created_at->format('M d, Y') }}</span>
            </div>
        </div>
    </div>
</div>

    <!-- Reviews Section -->
<div class="reviews-section">
        <div class="reviews-header">
            <h4>
                <i class="fas fa-star text-warning me-2"></i>
                Product Reviews
            </h4>
    </div>

        <div class="reviews-body">
            @if($product->reviews && $product->reviews->count() > 0)
                @foreach($product->reviews as $review)
                <div class="review-item">
                    <div class="review-header">
                            <span class="reviewer-name">{{ $review->user->name }}</span>
                            <span class="review-date">{{ $review->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="review-rating">
                            {!! $review->star_rating !!}
                        </div>
                        <div class="review-text">
                            {{ $review->comment }}
                        </div>
                </div>
            @endforeach
    @else
                <div class="no-reviews">
                    <i class="fas fa-comment-slash"></i>
                    <h5>No Reviews Yet</h5>
                    <p>Be the first to review this product!</p>
        </div>
    @endif
        </div>
    </div>
</div>

<!-- Buy Modal -->
    @if($product->stock_quantity > 0)
        <div class="modal fade" id="buyModal" tabindex="-1" aria-labelledby="buyModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="buyModalLabel">
                            <i class="fas fa-shopping-cart me-2"></i>Buy {{ $product->title }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                                <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" required>
                                <div class="form-text">Available: {{ $product->stock_quantity }} units</div>
                            </div>
                        <div class="col-md-6">
                            <label class="form-label">Unit Price</label>
                            <div class="form-control-plaintext">
                                ${{ number_format($product->price, 2) }}
                            </div>
                        </div>
                    </div>
                    
                            <div class="alert alert-info">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Total Amount:</span>
                            <strong id="totalAmount">${{ number_format($product->price, 2) }}</strong>
                            </div>
                            </div>
                        </div>
                
                        <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                        <i class="fas fa-credit-card me-2"></i>Place Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

<script>
function changeMainImage(src) {
        document.getElementById('mainProductImage').src = src;
    }
    
    function addToCart(productId) {
        // Implement add to cart functionality
        alert('Add to cart functionality will be implemented here');
    }
    
    // Calculate total amount when quantity changes
document.getElementById('quantity')?.addEventListener('change', function() {
    const quantity = parseInt(this.value);
        const unitPrice = {{ $product->price }};
        const total = quantity * unitPrice;
        document.getElementById('totalAmount').textContent = '$' + total.toFixed(2);
    });
</script>
@endsection
