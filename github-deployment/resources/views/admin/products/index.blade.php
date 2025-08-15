@extends('layouts.admin')

@section('page-title', 'Manage Products')

@section('styles')
<style>
    /* Admin Products Page - Clean & Organized Design */
    .admin-products-page {
        padding: 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 8px 25px rgba(246, 139, 30, 0.3);
        text-align: center;
    }

    .page-header h1 {
        margin: 0;
        font-weight: 800;
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }

    .page-header p {
        margin: 0;
        opacity: 0.9;
        font-size: 1.1rem;
    }

    /* Back Button */
    .back-button {
        margin-bottom: 1.5rem;
    }

    .back-button .btn {
        background: #6b7280;
        color: white;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .back-button .btn:hover {
        background: #4b5563;
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }

    /* Create Product Button */
    .create-product-section {
        margin-bottom: 2rem;
        text-align: right;
    }

    .create-product-section .btn {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border-radius: 12px;
        padding: 1rem 2rem;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .create-product-section .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        color: white;
        text-decoration: none;
    }

    /* Filters Section */
    .filters-section {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .filters-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .filters-header h5 {
        color: #111827;
        font-weight: 700;
        margin: 0;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filters-body {
        padding: 2rem;
    }

    .filter-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
    }

    .filter-label {
        color: #374151;
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-input {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 0.75rem;
        transition: all 0.3s ease;
        font-size: 1rem;
        background: white;
    }

    .filter-input:focus {
        outline: none;
        border-color: #f68b1e;
        box-shadow: 0 0 0 3px rgba(246, 139, 30, 0.1);
    }

    .filter-button {
        background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        min-height: 48px;
    }

    .filter-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(246, 139, 30, 0.3);
    }

    /* Products Table */
    .products-table-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .table {
        margin: 0;
        width: 100%;
    }

    .table th {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        color: #111827;
        font-weight: 700;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        padding: 1.25rem 1rem;
        text-align: left;
        white-space: nowrap;
    }

    .table td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f3f4f6;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.2s ease;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Product Image */
    .product-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #e5e7eb;
        display: block;
    }

    .product-image-placeholder {
        width: 60px;
        height: 60px;
        background: #f3f4f6;
        border-radius: 8px;
        border: 2px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
        font-size: 1.5rem;
    }

    /* Product Info */
    .product-info {
        min-width: 200px;
    }

    .product-title {
        color: #111827;
        font-weight: 700;
        margin-bottom: 0.25rem;
        font-size: 1rem;
        line-height: 1.3;
    }

    .product-category {
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 500;
    }

    /* Price Display */
    .price-display {
        font-weight: 600;
        color: #111827;
    }

    .price-original {
        text-decoration: line-through;
        color: #9ca3af;
        font-size: 0.875rem;
        margin-right: 0.5rem;
    }

    .price-final {
        color: #10b981;
        font-weight: 700;
    }

    /* Stock Display */
    .stock-display {
        text-align: center;
    }

    .stock-amount {
        display: block;
        font-weight: 700;
        color: #111827;
        margin-bottom: 0.25rem;
    }

    /* Status Badges */
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        display: inline-block;
        text-align: center;
        min-width: 100px;
    }

    .status-badge.active {
        background: #10b981;
        color: white;
    }

    .status-badge.inactive {
        background: #f59e0b;
        color: white;
    }

    .status-badge.out-of-stock {
        background: #ef4444;
        color: white;
    }

    .status-badge.low-stock {
        background: #f59e0b;
        color: white;
    }

    .status-badge.in-stock {
        background: #10b981;
        color: white;
    }

    /* Action Buttons */
    .actions-column {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        min-width: 200px;
    }

    .action-btn {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        min-width: 80px;
        justify-content: center;
    }

    .action-btn.view {
        background: #3b82f6;
        color: white;
    }

    .action-btn.view:hover {
        background: #2563eb;
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }

    .action-btn.edit {
        background: #f68b1e;
        color: white;
    }

    .action-btn.edit:hover {
        background: #e67e22;
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }

    .action-btn.delete {
        background: #ef4444;
        color: white;
    }

    .action-btn.delete:hover {
        background: #dc2626;
        transform: translateY(-2px);
        color: white;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #9ca3af;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #e5e7eb;
    }

    .empty-state h5 {
        color: #6b7280;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    .empty-state p {
        margin: 0;
        font-size: 0.9rem;
    }

    /* Pagination */
    .pagination-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        margin-top: 2rem;
        padding: 1.5rem;
        text-align: center;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .admin-products-page {
            padding: 1.5rem;
        }
        
        .filter-row {
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
        }
    }

    @media (max-width: 768px) {
        .admin-products-page {
            padding: 1rem;
        }
        
        .page-header {
            padding: 1.5rem;
        }
        
        .page-header h1 {
            font-size: 2rem;
        }
        
        .filter-row {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .actions-column {
            flex-direction: column;
            min-width: auto;
        }
        
        .action-btn {
            width: 100%;
            justify-content: center;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
    }

    @media (max-width: 576px) {
        .admin-products-page {
            padding: 0.75rem;
        }
        
        .page-header {
            padding: 1rem;
        }
        
        .page-header h1 {
            font-size: 1.75rem;
        }
        
        .filters-body {
            padding: 1rem;
        }
        
        .table th,
        .table td {
            padding: 0.75rem 0.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-products-page">
    <!-- Back Button -->
    <div class="back-button">
        <a href="{{ route('admin.dashboard') }}" class="btn">
            <i class="fas fa-arrow-left"></i>
            Back to Dashboard
        </a>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <h1>
            <i class="fas fa-boxes me-3"></i>
            Manage Products
        </h1>
        <p>View and manage all products in your store inventory</p>
    </div>

    <!-- Create Product Button -->
    <div class="create-product-section">
        <a href="{{ route('admin.products.create') }}" class="btn">
            <i class="fas fa-plus"></i>
            Create New Product
        </a>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
        <div class="filters-header">
            <h5>
                <i class="fas fa-filter"></i>
                Filter Products
            </h5>
        </div>
        <div class="filters-body">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="category_filter" class="filter-label">Category</label>
                    <select class="filter-input" id="category_filter">
                        <option value="">All Categories</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label for="brand_filter" class="filter-label">Brand</label>
                    <select class="filter-input" id="brand_filter">
                        <option value="">All Brands</option>
                        @foreach($brands ?? [] as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label for="search" class="filter-label">Search</label>
                    <input type="text" class="filter-input" id="search" placeholder="Product name...">
                </div>
                <div class="filter-group">
                    <button class="filter-button" onclick="applyFilters()">
                        <i class="fas fa-search"></i>
                        Apply Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="products-table-container">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" 
                                         alt="{{ $product->title }}" 
                                         class="product-image">
                                @else
                                    <div class="product-image-placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="product-info">
                                    <div class="product-title">{{ $product->title }}</div>
                                    <div class="product-category">{{ $product->category->name ?? 'No Category' }}</div>
                                </div>
                            </td>
                            <td>{{ $product->category->name ?? 'No Category' }}</td>
                            <td>{{ $product->brand->name ?? 'No Brand' }}</td>
                            <td>
                                <div class="price-display">
                                    @if($product->hasDiscount())
                                        <span class="price-original">${{ number_format($product->price, 2) }}</span>
                                        <span class="price-final">${{ number_format($product->final_price, 2) }}</span>
                                    @else
                                        ${{ number_format($product->price, 2) }}
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="stock-display">
                                    <span class="stock-amount">{{ $product->stock_quantity }}</span>
                                    @if($product->isOutOfStock())
                                        <span class="status-badge out-of-stock">Out of Stock</span>
                                    @elseif($product->isLowStock())
                                        <span class="status-badge low-stock">Low Stock</span>
                                    @else
                                        <span class="status-badge in-stock">In Stock</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="status-badge {{ $product->status === 'active' ? 'active' : 'inactive' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="actions-column">
                                    <a href="{{ route('admin.products.show', $product) }}" 
                                       class="action-btn view">
                                        <i class="fas fa-eye"></i>
                                        View
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="action-btn edit">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" 
                                          method="POST" 
                                          class="d-inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete">
                                            <i class="fas fa-trash"></i>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-box"></i>
                                    <h5>No products found</h5>
                                    <p>Products will appear here once you add them to your store</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="pagination-container">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
function applyFilters() {
    const category = document.getElementById('category_filter').value;
    const brand = document.getElementById('brand_filter').value;
    const search = document.getElementById('search').value;
    
    let url = new URL(window.location);
    
    if (category) url.searchParams.set('category', category);
    if (brand) url.searchParams.set('brand', brand);
    if (search) url.searchParams.set('search', search);
    
    window.location.href = url.toString();
}

// Auto-apply filters when values change
document.getElementById('category_filter').addEventListener('change', applyFilters);
document.getElementById('brand_filter').addEventListener('change', applyFilters);

// Auto-apply search after typing (with delay)
let searchTimeout;
document.getElementById('search').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(applyFilters, 500);
});
</script>
@endsection
