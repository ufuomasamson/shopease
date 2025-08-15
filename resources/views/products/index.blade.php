@extends('layouts.user')

@section('page-title', 'Products')

@section('styles')
<style>
    /* Jumia Theme for Products Page */
    .content-wrapper {
        padding: 2rem;
    }

    .search-filter-bar {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }

    .search-input {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        width: 100%;
        min-height: 48px;
    }

    .search-input:focus {
        outline: none;
        border-color: #f68b1e;
        box-shadow: 0 0 0 3px rgba(246, 139, 30, 0.1);
    }

    .filter-select {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        background: white;
        transition: all 0.3s ease;
        min-height: 48px;
        width: 100%;
    }

    .filter-select:focus {
        outline: none;
        border-color: #f68b1e;
        box-shadow: 0 0 0 3px rgba(246, 139, 30, 0.1);
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    /* Force 2 columns on mobile devices */
    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 1rem;
        }
    }

    @media (max-width: 576px) {
        .product-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 0.75rem;
        }
    }

    .product-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        border-color: #f68b1e;
    }

    .product-image-container {
        position: relative;
        height: 200px;
        overflow: hidden;
        background: #f8f9fa;
    }

    @media (max-width: 768px) {
        .product-image-container {
            height: 180px;
        }
    }

    @media (max-width: 576px) {
        .product-image-container {
            height: 160px;
        }
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    .product-icon-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        color: #9ca3af;
        font-size: 3rem;
    }

    .product-card-body {
        padding: 1.5rem;
    }

    .product-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .product-description {
        color: #6b7280;
        font-size: 0.875rem;
        margin-bottom: 1rem;
        line-height: 1.5;
    }

    .product-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .product-price {
        font-size: 1.25rem;
        font-weight: 800;
        color: #f68b1e;
    }

    .product-stock {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 500;
    }

    .product-actions {
        display: flex;
        gap: 0.75rem;
    }

    @media (max-width: 768px) {
        .product-actions {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .btn-view,
        .btn-buy {
            width: 100%;
            justify-content: center;
            min-height: 44px;
        }
    }

    .btn-view {
        background: transparent;
        color: #f68b1e;
        border: 2px solid #f68b1e;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        transition: all 0.3s ease;
        flex: 1;
        text-align: center;
        text-decoration: none;
    }

    .btn-view:hover {
        background: #f68b1e;
        color: white;
        transform: translateY(-2px);
        text-decoration: none;
    }

    .btn-buy {
        background: #f68b1e;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        transition: all 0.3s ease;
        flex: 1;
        text-align: center;
    }

    .btn-buy:hover {
        background: #e67e22;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(246, 139, 30, 0.4);
    }

    .btn-buy:disabled {
        background: #9ca3af;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    /* Modal Styling */
    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 20px 25px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        border-bottom: 1px solid #e5e7eb;
        padding: 1.5rem;
    }

    .modal-title {
        color: #111827;
        font-weight: 700;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        border-top: 1px solid #e5e7eb;
        padding: 1.5rem;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .content-wrapper {
            padding: 1.5rem;
        }
        
        .search-filter-bar {
            padding: 1.25rem;
        }
        
        .product-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.25rem;
        }
    }

    @media (max-width: 768px) {
        .content-wrapper {
            padding: 1rem;
        }
        
        .product-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 1rem;
        }
        
        .search-filter-bar {
            padding: 1rem;
        }
        
        .product-card-body {
            padding: 1rem;
        }
        
        .search-filter-bar .row {
            flex-direction: column;
        }
        
        .search-filter-bar .col-md-6,
        .search-filter-bar .col-md-3 {
            width: 100%;
            margin-bottom: 1rem;
        }
        
        .search-filter-bar .col-md-3:last-child {
            margin-bottom: 0;
        }
        
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }
        
        .product-title {
            font-size: 1rem;
        }
        
        .product-description {
            font-size: 0.875rem;
        }
        
        .product-meta {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .product-actions {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .product-actions .btn {
            width: 100%;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .content-wrapper {
            padding: 0.75rem;
        }
        
        .product-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 0.75rem;
        }
        
        .search-filter-bar {
            padding: 0.75rem;
        }
        
        .product-card-body {
            padding: 0.75rem;
        }
        
        .product-title {
            font-size: 0.95rem;
        }
        
        .product-description {
            font-size: 0.8rem;
        }
        
        .product-price {
            font-size: 1.1rem;
        }
        
        .product-stock {
            font-size: 0.8rem;
        }
    }

    /* Animations */
    .fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Search and Filter Bar -->
    <div class="search-filter-bar">
        <div class="row g-3" id="searchFilterRow">
            <div class="col-md-6 col-12">
                <input type="text" class="form-control search-input" placeholder="Search products..." id="searchInput">
            </div>
            <div class="col-md-3 col-6">
                <select class="form-select filter-select" id="sortSelect">
                    <option value="">Sort by</option>
                    <option value="price_low">Price: Low to High</option>
                    <option value="price_high">Price: High to Low</option>
                    <option value="newest">Newest First</option>
                    <option value="name">Name A-Z</option>
                </select>
            </div>
            <div class="col-md-3 col-6">
                <select class="form-select filter-select" id="categorySelect">
                    <option value="">All Categories</option>
                    <option value="digital">Digital Products</option>
                    <option value="software">Software</option>
                    <option value="courses">Online Courses</option>
                    <option value="templates">Templates</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Products Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="fas fa-box text-primary me-2"></i>
                All Products
            </h2>
            <p class="text-muted mb-0">Discover our collection of digital products</p>
        </div>
        @if(auth()->check() && auth()->user()->isAdmin())
            <a href="{{ route('admin.products.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-2"></i>Add New Product
            </a>
        @endif
    </div>

    <!-- Products Grid -->
    <div class="product-grid" id="productsGrid">
        @forelse($products as $product)
        <div class="product-card fade-in" data-product-name="{{ strtolower($product->title) }}" data-product-category="digital">
            <div class="product-image-container">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->title }}" class="product-image">
                @else
                    <div class="product-icon-placeholder">
                        <i class="fas fa-file-alt"></i>
                    </div>
                @endif
            </div>
            
            <div class="product-card-body">
                <h5 class="product-title">{{ $product->title }}</h5>
                <p class="product-description">{{ Str::limit($product->description, 120) }}</p>
                
                <div class="product-meta">
                    <span class="product-price">${{ number_format($product->price, 2) }}</span>
                    <span class="product-stock">{{ $product->stock_quantity }} in stock</span>
                </div>
                
                <div class="product-actions">
                    <a href="{{ route('products.show', $product) }}" class="btn-view">
                        <i class="fas fa-eye me-1"></i>View Details
                    </a>
                    @if($product->stock_quantity > 0)
                        <button type="button" class="btn-buy" data-bs-toggle="modal" data-bs-target="#buyModal{{ $product->id }}">
                            <i class="fas fa-shopping-cart me-1"></i>Buy Now
                        </button>
                    @else
                        <button class="btn-buy" disabled>
                            <i class="fas fa-times me-1"></i>Out of Stock
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Buy Modal -->
        @if($product->stock_quantity > 0)
            <div class="modal fade" id="buyModal{{ $product->id }}" tabindex="-1" aria-labelledby="buyModalLabel{{ $product->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="buyModalLabel{{ $product->id }}">
                                <i class="fas fa-shopping-cart me-2"></i>Buy {{ $product->title }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('orders.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="quantity{{ $product->id }}" class="form-label">Quantity</label>
                                        <input type="number" class="form-control" id="quantity{{ $product->id }}" name="quantity" 
                                               value="1" min="1" max="{{ $product->stock_quantity }}" required>
                                        <div class="form-text">Available: {{ $product->stock_quantity }} units</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Unit Price</label>
                                        <div class="form-control-plaintext">
                                            @if($product->hasDiscount())
                                                <span class="text-decoration-line-through text-muted">${{ number_format($product->price, 2) }}</span>
                                                <span class="text-danger fw-bold">${{ number_format($product->final_price, 2) }}</span>
                                                <span class="badge bg-danger ms-2">{{ $product->discount_percentage }}% OFF</span>
                                            @else
                                                ${{ number_format($product->price, 2) }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="alert alert-info">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong>Total Price:</strong>
                                        <span class="h5 mb-0">$<span id="totalPrice{{ $product->id }}">
                                            @if($product->hasDiscount())
                                                {{ number_format($product->final_price, 2) }}
                                            @else
                                                {{ number_format($product->price, 2) }}
                                            @endif
                                        </span></span>
                                    </div>
                                </div>
                                
                                <div class="alert alert-warning">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Digital Product:</strong> You'll receive instant access after purchase.
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-credit-card me-2"></i>Confirm Purchase
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                document.getElementById('quantity{{ $product->id }}').addEventListener('change', function() {
                    const quantity = this.value;
                    const price = {{ $product->hasDiscount() ? $product->final_price : $product->price }};
                    const total = quantity * price;
                    document.getElementById('totalPrice{{ $product->id }}').textContent = total.toFixed(2);
                });
            </script>
        @endif
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle fa-2x mb-3"></i>
                <h5>No products available at the moment.</h5>
                <p class="mb-0">Check back soon for new digital products!</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');
    const categorySelect = document.getElementById('categorySelect');
    const productsGrid = document.getElementById('productsGrid');
    
    // Search functionality
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const productCards = productsGrid.querySelectorAll('.product-card');
            
            productCards.forEach(card => {
                const productName = card.dataset.productName;
                if (productName.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
    
    // Sort functionality
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortValue = this.value;
            const productCards = Array.from(productsGrid.querySelectorAll('.product-card'));
            
            productCards.sort((a, b) => {
                const priceA = parseFloat(a.querySelector('.product-price').textContent.replace('$', ''));
                const priceB = parseFloat(b.querySelector('.product-price').textContent.replace('$', ''));
                
                switch(sortValue) {
                    case 'price_low':
                        return priceA - priceB;
                    case 'price_high':
                        return priceB - priceA;
                    case 'name':
                        const nameA = a.querySelector('.product-title').textContent.toLowerCase();
                        const nameB = b.querySelector('.product-title').textContent.toLowerCase();
                        return nameA.localeCompare(nameB);
                    case 'newest':
                        // For newest, we'll keep the current order since products are already sorted by latest
                        return 0;
                    default:
                        return 0;
                }
            });
            
            // Reorder products in the grid
            productCards.forEach(card => productsGrid.appendChild(card));
        });
    }
    
    // Category filter functionality
    if (categorySelect) {
        categorySelect.addEventListener('change', function() {
            const categoryValue = this.value;
            const productCards = productsGrid.querySelectorAll('.product-card');
            
            productCards.forEach(card => {
                const productCategory = card.dataset.productCategory;
                if (!categoryValue || productCategory === categoryValue) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
});
</script>
@endsection
