@extends('layouts.admin')

@section('page-title', 'Categories & Brands')

@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <h1>
            <i class="fas fa-tags me-3"></i>
            Manage Categories & Brands
        </h1>
        <p>Organize your products with categories and brands for better customer experience</p>
    </div>

    <!-- Management Tabs -->
    <div class="management-tabs">
        <div class="tab-nav">
            <button class="tab-nav-item active" onclick="showTab('categories')">
                <i class="fas fa-tags me-2"></i>Categories
            </button>
            <button class="tab-nav-item" onclick="showTab('brands')">
                <i class="fas fa-copyright me-2"></i>Brands
            </button>
        </div>

        <!-- Categories Tab -->
        <div id="categories-tab" class="tab-content active">
            <div class="section-header">
                <h3 class="section-title">Product Categories</h3>
                <span class="text-muted">{{ $categories->total() }} categories found</span>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Products</th>
                            <th>Status</th>
                            <th>Sort Order</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories ?? [] as $category)
                            <tr>
                                <td>
                                    <strong>{{ $category->name }}</strong>
                                    <br>
                                    <small class="text-muted">Slug: {{ $category->slug }}</small>
                                </td>
                                <td>{{ Str::limit($category->description, 100) ?: 'No description' }}</td>
                                <td>
                                    <div class="actions-column">
                                        <span class="badge bg-info">{{ $category->products_count }} products</span>
                                        <small class="text-muted d-block">ID: {{ $category->id }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-warning' }}">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $category->sort_order }}</td>
                                <td>
                                    <div class="actions-column">
                                        <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>View
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>Edit
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this category?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    {{ $category->products_count > 0 ? 'disabled' : '' }}>
                                                <i class="fas fa-trash"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="fas fa-tags"></i>
                                        <h5>No categories found</h5>
                                        <p>Categories will appear here once you add them</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($categories) && $categories->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>

        <!-- Brands Tab -->
        <div id="brands-tab" class="tab-content">
            <div class="section-header">
                <h3 class="section-title">Product Brands</h3>
                <span class="text-muted">{{ $brands->total() }} brands found</span>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Website</th>
                            <th>Products</th>
                            <th>Status</th>
                            <th>Sort Order</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($brands ?? [] as $brand)
                            <tr>
                                <td>
                                    <strong>{{ $brand->name }}</strong>
                                    <br>
                                    <small class="text-muted">Slug: {{ $brand->slug }}</small>
                                </td>
                                <td>{{ Str::limit($brand->description, 100) ?: 'No description' }}</td>
                                <td>
                                    @if($brand->website)
                                        <a href="{{ $brand->website }}" target="_blank" class="text-primary">
                                            <i class="fas fa-external-link-alt"></i> Visit
                                        </a>
                                    @else
                                        <span class="text-muted">No website</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="actions-column">
                                        <span class="badge bg-info">{{ $brand->products_count }} products</span>
                                        <small class="text-muted d-block">ID: {{ $brand->id }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $brand->is_active ? 'bg-success' : 'bg-warning' }}">
                                        {{ $brand->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $brand->sort_order }}</td>
                                <td>
                                    <div class="actions-column">
                                        <a href="{{ route('admin.brands.show', $brand) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>View
                                        </a>
                                        <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>Edit
                                        </a>
                                        <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this brand?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    {{ $brand->products_count > 0 ? 'disabled' : '' }}>
                                                <i class="fas fa-trash"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fas fa-copyright"></i>
                                        <h5>No brands found</h5>
                                        <p>Brands will appear here once you add them</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($brands) && $brands->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $brands->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
/* Jumia Theme Styling */
.admin-top-nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 0;
    margin-bottom: 2rem;
    border-bottom: 2px solid #f68b1e;
}

.admin-top-nav h2 {
    color: #f68b1e;
    margin: 0;
    font-weight: 700;
}

.page-header {
    margin-bottom: 2rem;
    text-align: center;
}

.page-header h1 {
    color: #f68b1e;
    font-weight: 800;
    margin-bottom: 0.5rem;
}

.page-header p {
    color: #6b7280;
    font-size: 1.1rem;
}

.management-tabs {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.tab-nav {
    display: flex;
    background: #f8f9fa;
    border-bottom: 1px solid #e5e7eb;
}

.tab-nav-item {
    flex: 1;
    padding: 1rem 1.5rem;
    background: transparent;
    border: none;
    color: #6b7280;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    border-bottom: 3px solid transparent;
}

.tab-nav-item:hover {
    background: #e9ecef;
    color: #f68b1e;
}

.tab-nav-item.active {
    background: white;
    color: #f68b1e;
    border-bottom-color: #f68b1e;
}

.tab-content {
    display: none;
    padding: 2rem;
}

.tab-content.active {
    display: block;
}

.section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
}

.section-title {
    color: #f68b1e;
    margin: 0;
    font-weight: 700;
}

.table {
    margin-bottom: 0;
}

.table th {
    background: #f8f9fa;
    color: #374151;
    font-weight: 700;
    border-bottom: 2px solid #f68b1e;
}

.table td {
    vertical-align: middle;
    border-color: #e5e7eb;
}

.actions-column {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 6px;
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: #6b7280;
}

.empty-state i {
    font-size: 3rem;
    color: #d1d5db;
    margin-bottom: 1rem;
}

.empty-state h5 {
    color: #374151;
    margin-bottom: 0.5rem;
}

.badge {
    font-size: 0.875rem;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .admin-top-nav {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .tab-nav {
        flex-direction: column;
    }
    
    .section-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .actions-column {
        flex-direction: column;
    }
    
    .btn-sm {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection

@section('scripts')
<script>

// Tab functionality
function showTab(tabName) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => content.classList.remove('active'));
    
    // Remove active class from all tab nav items
    const tabNavItems = document.querySelectorAll('.tab-nav-item');
    tabNavItems.forEach(item => item.classList.remove('active'));
    
    // Show selected tab content
    document.getElementById(tabName + '-tab').classList.add('active');
    
    // Add active class to clicked tab nav item
    event.target.classList.add('active');
}
</script>
@endsection
