@extends('layouts.admin')

@section('page-title', 'Add New Product')

@section('styles')
<style>
    /* Jumia Theme for Admin Product Create with Sidebar */
    .admin-product-create {
        display: flex;
        min-height: 100vh;
        background: #f8f9fa;
    }

    /* Admin Sidebar */
    .admin-sidebar {
        width: 280px;
        background: white;
        border-right: 1px solid #e5e7eb;
        position: fixed;
        height: 100vh;
        overflow-y: auto;
        z-index: 1000;
        transition: all 0.3s ease;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }

    .admin-sidebar.collapsed {
        width: 70px;
    }

    .sidebar-header {
        background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
        color: white;
        padding: 2rem 1.5rem;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar-header h3 {
        margin: 0;
        font-weight: 800;
        font-size: 1.5rem;
        white-space: nowrap;
        overflow: hidden;
    }

    .sidebar-header p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 0.9rem;
        white-space: nowrap;
        overflow: hidden;
    }

    .sidebar-nav {
        padding: 1.5rem 0;
        flex-grow: 1;
    }

    .nav-section {
        margin-bottom: 2rem;
    }

    .nav-section-title {
        color: #6b7280;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin: 0 1.5rem 0.75rem;
        white-space: nowrap;
        overflow: hidden;
    }

    .sidebar-nav ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-nav li {
        margin: 0 1rem;
    }

    /* Override global app.css sidebar styles with !important */
    .admin-sidebar .sidebar-link,
    .admin-sidebar .sidebar-link *,
    .admin-sidebar .sidebar-link span,
    .admin-sidebar .sidebar-link i,
    .admin-sidebar .sidebar-item .sidebar-link,
    .admin-sidebar .sidebar-item .sidebar-link *,
    .admin-sidebar .sidebar-item .sidebar-link span,
    .admin-sidebar .sidebar-item .sidebar-link i {
        color: #111827 !important;
    }

    /* Force sidebar text visibility with !important */
    .admin-sidebar .sidebar-link,
    .admin-sidebar .sidebar-link *,
    .admin-sidebar .sidebar-link span,
    .admin-sidebar .sidebar-link i {
        color: #111827 !important;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        color: #111827 !important;
        text-decoration: none;
        transition: all 0.3s ease;
        border-radius: 12px;
        margin-bottom: 0.5rem;
        white-space: nowrap;
        overflow: hidden;
        background: #f8f9fa !important;
        border: 1px solid #e5e7eb;
        font-weight: 600 !important;
    }

    .sidebar-link:hover {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%) !important;
        color: #f68b1e !important;
        transform: translateX(5px);
        text-decoration: none;
        border-color: #f68b1e;
    }

    .sidebar-link.active {
        background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%) !important;
        color: white !important;
        box-shadow: 0 4px 12px rgba(246, 139, 30, 0.3);
        border-color: #f68b1e;
    }

    .sidebar-link i {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
        color: inherit !important;
    }

    .sidebar-link span {
        font-weight: 600;
        font-size: 0.95rem;
        color: inherit !important;
    }

    .sidebar-footer {
        padding: 1.5rem;
        border-top: 1px solid #e5e7eb;
        background: #f8f9fa;
    }

    .admin-user-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
    }

    .admin-avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .admin-user-details h6 {
        margin: 0;
        color: #111827;
        font-weight: 700;
        font-size: 0.9rem;
        white-space: nowrap;
        overflow: hidden;
    }

    .admin-user-details p {
        margin: 0;
        color: #6b7280;
        font-size: 0.8rem;
        white-space: nowrap;
        overflow: hidden;
    }

    /* Main Content Area */
    .admin-main {
        flex: 1;
        margin-left: 280px;
        transition: all 0.3s ease;
        padding: 2rem;
    }

    .admin-main.expanded {
        margin-left: 70px;
    }

    /* Top Navigation Bar */
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

    /* Product Create Content */
    .product-create-header {
        background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 8px 25px rgba(246, 139, 30, 0.3);
    }

    .product-create-header h1 {
        margin: 0;
        font-weight: 800;
        font-size: 2.5rem;
    }

    .product-create-header p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 1.1rem;
    }

    .product-create-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .form-section {
        padding: 2rem;
        border-bottom: 1px solid #f3f4f6;
    }

    .form-section:last-child {
        border-bottom: none;
    }

    .form-section h5 {
        color: #111827;
        font-weight: 700;
        margin-bottom: 1.5rem;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-section h5 i {
        color: #f68b1e;
    }

    .form-label {
        color: #374151;
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control, .form-select, .form-textarea {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 0.75rem;
        transition: all 0.3s ease;
        font-size: 1rem;
        background: #f9fafb;
    }

    .form-control:focus, .form-select:focus, .form-textarea:focus {
        outline: none;
        border-color: #f68b1e;
        box-shadow: 0 0 0 3px rgba(246, 139, 30, 0.1);
        background: white;
    }

    .form-textarea {
        min-height: 120px;
        resize: vertical;
    }

    .form-check-input:checked {
        background-color: #f68b1e;
        border-color: #f68b1e;
    }

    .form-check-input:focus {
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

    .btn-lg {
        padding: 1rem 2rem;
        font-size: 1.1rem;
    }

    .image-preview {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 12px;
        border: 3px solid #e5e7eb;
        margin-top: 1rem;
    }

    .image-preview-container {
        text-align: center;
        margin-top: 1rem;
    }

    .additional-images-preview {
        margin-top: 1rem;
    }

    .preview-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .preview-item {
        transition: transform 0.3s ease;
    }

    .preview-item:hover {
        transform: scale(1.05);
    }

    .form-actions {
        background: #f8f9fa;
        padding: 2rem;
        border-top: 1px solid #e5e7eb;
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        align-items: center;
    }

    .alert {
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
    }

    .alert-danger {
        background-color: #fef2f2;
        border-color: #fecaca;
        color: #dc2626;
    }

    .alert-success {
        background-color: #f0fdf4;
        border-color: #bbf7d0;
        color: #16a34a;
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

        .product-create-header h1 {
            font-size: 2rem;
        }

        .form-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-product-create">
    <!-- Admin Sidebar -->
    <div class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <h3>
                <i class="fas fa-crown me-2"></i>
                Admin Panel
            </h3>
            <p>ShopEase Management</p>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">
                <h6 class="nav-section-title">Main Menu</h6>
                <ul>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.products.index') }}" class="sidebar-link">
                            <i class="fas fa-box"></i>
                            <span>Products</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.orders') }}" class="sidebar-link">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Orders</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reviews') }}" class="sidebar-link">
                            <i class="fas fa-star"></i>
                            <span>Reviews</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.fund-wallet') }}" class="sidebar-link">
                            <i class="fas fa-wallet"></i>
                            <span>Fund Wallets</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="nav-section">
                <h6 class="nav-section-title">Quick Actions</h6>
                <ul>
                    <li>
                        <a href="{{ route('admin.products.create') }}" class="sidebar-link active">
                            <i class="fas fa-plus-circle"></i>
                            <span>Add Product</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('welcome') }}" class="sidebar-link">
                            <i class="fas fa-home"></i>
                            <span>View Site</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="sidebar-footer">
            <div class="admin-user-info">
                <div class="admin-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="admin-user-details">
                    <h6>{{ Auth::user()->name }}</h6>
                    <p>Administrator</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="admin-main" id="adminMain">
        <!-- Top Navigation Bar -->
        <div class="admin-top-nav">
            <button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h2>Add New Product</h2>
            <div class="admin-actions">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>Back to Products
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-info">
                    <i class="fas fa-tachometer-alt"></i>Dashboard
                </a>
            </div>
        </div>

        <!-- Product Create Header -->
        <div class="product-create-header">
            <h1>
                <i class="fas fa-plus-circle me-3"></i>
                Add New Product
            </h1>
            <p>Create a new product for your store inventory</p>
        </div>

        <!-- Product Create Form -->
        <div class="product-create-container">
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" id="productForm">
                @csrf

                <!-- Basic Information -->
                <div class="form-section">
                    <h5>
                        <i class="fas fa-info-circle"></i>
                        Basic Information
                    </h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="title" class="form-label">Product Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" class="form-control @error('sku') is-invalid @enderror" 
                                   id="sku" name="sku" value="{{ old('sku') }}" required>
                            @error('sku')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-textarea @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing & Stock -->
                <div class="form-section">
                    <h5>
                        <i class="fas fa-dollar-sign"></i>
                        Pricing & Stock
                    </h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="price" class="form-label">Price</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                       id="price" name="price" step="0.01" min="0" value="{{ old('price') }}" required>
                            </div>
                            @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="discount_percentage" class="form-label">Discount %</label>
                            <input type="number" class="form-control @error('discount_percentage') is-invalid @enderror" 
                                   id="discount_percentage" name="discount_percentage" step="0.01" min="0" max="100" 
                                   value="{{ old('discount_percentage') }}">
                            @error('discount_percentage')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="stock_quantity" class="form-label">Stock Quantity</label>
                            <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" 
                                   id="stock_quantity" name="stock_quantity" min="0" value="{{ old('stock_quantity', 100) }}" required>
                            @error('stock_quantity')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Category & Brand -->
                <div class="form-section">
                    <h5>
                        <i class="fas fa-tags"></i>
                        Category & Brand
                    </h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="brand_id" class="form-label">Brand</label>
                            <select class="form-select @error('brand_id') is-invalid @enderror" 
                                    id="brand_id" name="brand_id">
                                <option value="">Select Brand</option>
                                @foreach($brands ?? [] as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Product Images -->
                <div class="form-section">
                    <h5>
                        <i class="fas fa-images"></i>
                        Product Images
                    </h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="image" class="form-label">Main Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*" required>
                            @error('image')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            
                            <div class="image-preview-container" id="imagePreview" style="display: none;">
                                <p class="form-label">Image Preview:</p>
                                <img id="imagePreviewImg" class="image-preview" alt="Image Preview">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="additional_images" class="form-label">Additional Images</label>
                            <input type="file" class="form-control @error('additional_images') is-invalid @enderror" 
                                   id="additional_images" name="additional_images[]" accept="image/*" multiple>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                You can select up to 5 additional images. Hold Ctrl (or Cmd on Mac) to select multiple files.
                            </div>
                            @error('additional_images')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="form-section">
                    <h5>
                        <i class="fas fa-cogs"></i>
                        Product Details
                    </h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number" class="form-control @error('weight') is-invalid @enderror" 
                                   id="weight" name="weight" step="0.01" min="0" value="{{ old('weight') }}">
                            @error('weight')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="dimensions" class="form-label">Dimensions (L×W×H cm)</label>
                            <input type="text" class="form-control @error('dimensions') is-invalid @enderror" 
                                   id="dimensions" name="dimensions" value="{{ old('dimensions') }}" 
                                   placeholder="30×20×10">
                            @error('dimensions')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="shipping_cost" class="form-label">Shipping Cost</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control @error('shipping_cost') is-invalid @enderror" 
                                       id="shipping_cost" name="shipping_cost" step="0.01" min="0" 
                                       value="{{ old('shipping_cost') }}">
                            </div>
                            @error('shipping_cost')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Product Status -->
                <div class="form-section">
                    <h5>
                        <i class="fas fa-toggle-on"></i>
                        Product Status
                    </h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active Product
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" 
                                       {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    Featured Product
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i>Create Product
                    </button>
                </div>
            </form>
        </div>
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

// Image preview functionality
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('imagePreviewImg');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});

// Additional images preview functionality
document.getElementById('additional_images').addEventListener('change', function(e) {
    const files = e.target.files;
    const previewContainer = document.getElementById('additionalImagesPreview');
    
    if (!previewContainer) {
        // Create preview container if it doesn't exist
        const container = document.createElement('div');
        container.id = 'additionalImagesPreview';
        container.className = 'additional-images-preview mt-3';
        container.innerHTML = '<h6 class="form-label">Additional Images Preview:</h6><div class="preview-grid"></div>';
        this.parentNode.appendChild(container);
    }
    
    const previewGrid = document.getElementById('additionalImagesPreview').querySelector('.preview-grid');
    previewGrid.innerHTML = '';
    
    if (files.length > 0) {
        Array.from(files).forEach((file, index) => {
            if (index < 5) { // Limit to 5 images
                const reader = new FileReader();
                const previewDiv = document.createElement('div');
                previewDiv.className = 'preview-item';
                previewDiv.style.cssText = 'display: inline-block; margin: 5px; text-align: center;';
                
                reader.onload = function(e) {
                    previewDiv.innerHTML = `
                        <img src="${e.target.result}" alt="Preview ${index + 1}" 
                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb;">
                        <div style="font-size: 0.8rem; color: #6b7280; margin-top: 5px;">Image ${index + 1}</div>
                    `;
                }
                
                reader.readAsDataURL(file);
                previewGrid.appendChild(previewDiv);
            }
        });
        
        if (files.length > 5) {
            const warningDiv = document.createElement('div');
            warningDiv.className = 'alert alert-warning mt-2';
            warningDiv.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Only the first 5 images will be uploaded.';
            previewGrid.appendChild(warningDiv);
        }
    }
});
</script>
@endsection
