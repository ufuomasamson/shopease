@extends('layouts.app')

@section('content')
<div class="admin-main">
    @include('admin.partials.sidebar')
    
    <div class="main-content">
        <div class="page-header">
            <div class="header-content">
                <h1><i class="fas fa-plus"></i> Generate Product Review</h1>
                <p>Create positive customer reviews to build product confidence and increase sales</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.reviews') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Reviews
                </a>
            </div>
        </div>

        <div class="content-card">
            <div class="card-header">
                <h3>Create New Review</h3>
                <p class="mb-0">Fill in the details below to generate a positive product review</p>
            </div>
            
            <div class="card-body">
                <form action="{{ route('admin.reviews.store') }}" method="POST" enctype="multipart/form-data" id="reviewForm">
                    @csrf
                    
                    <div class="row">
                        <!-- Product Selection -->
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="product_id" class="form-label">
                                    <i class="fas fa-box"></i> Select Product <span class="text-danger">*</span>
                                </label>
                                <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                                    <option value="">Choose a product...</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" 
                                                data-price="{{ $product->price }}"
                                                data-image="{{ $product->image ? Storage::url($product->image) : '' }}"
                                                data-description="{{ $product->description }}">
                                            {{ $product->title }} - ${{ number_format($product->price, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                                <!-- Product Preview -->
                                <div id="productPreview" class="mt-3" style="display: none;">
                                    <div class="product-preview-card">
                                        <div class="product-image">
                                            <img id="previewImage" src="" alt="Product" class="img-fluid">
                                        </div>
                                        <div class="product-details">
                                            <h6 id="previewTitle"></h6>
                                            <p id="previewDescription" class="text-muted"></p>
                                            <span class="price" id="previewPrice"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Selection -->
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="user_id" class="form-label">
                                    <i class="fas fa-user"></i> Select User <span class="text-danger">*</span>
                                </label>
                                <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                    <option value="">Choose a user...</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" data-email="{{ $user->email }}">
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Rating Selection -->
                    <div class="form-group mb-4">
                        <label class="form-label">
                            <i class="fas fa-star"></i> Rating <span class="text-danger">*</span>
                        </label>
                        <div class="rating-input">
                            <div class="stars">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" class="star-input" required>
                                    <label for="star{{ $i }}" class="star-label">
                                        <i class="far fa-star"></i>
                                    </label>
                                @endfor
                            </div>
                            <div class="rating-text mt-2">
                                <span id="ratingText" class="text-muted">Select a rating</span>
                            </div>
                        </div>
                        @error('rating')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Review Title -->
                    <div class="form-group mb-4">
                        <label for="title" class="form-label">
                            <i class="fas fa-heading"></i> Review Title (Optional)
                        </label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                               placeholder="e.g., 'Amazing product!', 'Great value for money'">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Review Comment -->
                    <div class="form-group mb-4">
                        <label for="comment" class="form-label">
                            <i class="fas fa-comment"></i> Review Comment <span class="text-danger">*</span>
                        </label>
                        <textarea name="comment" id="comment" rows="5" class="form-control @error('comment') is-invalid @enderror" 
                                  placeholder="Write a detailed, positive review about the product..." required></textarea>
                        <div class="form-text">Minimum 10 characters. Make it sound authentic and helpful.</div>
                        @error('comment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Review Options -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <div class="form-check">
                                    <input type="checkbox" name="is_verified_purchase" id="is_verified_purchase" 
                                           class="form-check-input" value="1" checked>
                                    <label for="is_verified_purchase" class="form-check-label">
                                        <i class="fas fa-check-circle"></i> Mark as Verified Purchase
                                    </label>
                                    <div class="form-text">This makes the review more trustworthy</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <div class="form-check">
                                    <input type="checkbox" name="is_approved" id="is_approved" 
                                           class="form-check-input" value="1" checked>
                                    <label for="is_approved" class="form-check-label">
                                        <i class="fas fa-thumbs-up"></i> Auto-approve Review
                                    </label>
                                    <div class="form-text">Review will be visible immediately</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Review Images -->
                    <div class="form-group mb-4">
                        <label for="images" class="form-label">
                            <i class="fas fa-images"></i> Review Images (Optional)
                        </label>
                        <input type="file" name="images[]" id="images" class="form-control @error('images.*') is-invalid @enderror" 
                               multiple accept="image/*">
                        <div class="form-text">Upload up to 5 images. Max size: 2MB each. Formats: JPEG, PNG, JPG, GIF</div>
                        @error('images.*')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                        
                        <!-- Image Preview -->
                        <div id="imagePreview" class="mt-3" style="display: none;">
                            <div class="image-preview-grid" id="imagePreviewGrid"></div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Generate Review
                        </button>
                        <a href="{{ route('admin.reviews') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Ensure proper spacing for all elements */
    .admin-main > * {
        margin-left: 0;
        margin-right: 0;
    }
    
    /* Product preview card */
    .product-preview-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 15px;
        display: flex;
        gap: 15px;
        align-items: center;
    }
    
    .product-image img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
    }
    
    .product-details h6 {
        margin: 0 0 5px 0;
        color: var(--text-primary);
        font-weight: 600;
    }
    
    .product-details p {
        margin: 0 0 5px 0;
        font-size: 14px;
    }
    
    .price {
        color: var(--primary-color);
        font-weight: 600;
        font-size: 16px;
    }
    
    /* Rating input styling */
    .rating-input .stars {
        display: flex;
        flex-direction: row-reverse;
        gap: 5px;
    }
    
    .star-input {
        display: none;
    }
    
    .star-label {
        cursor: pointer;
        font-size: 24px;
        color: var(--text-muted);
        transition: all 0.2s ease;
    }
    
    .star-label:hover,
    .star-label:hover ~ .star-label,
    .star-input:checked ~ .star-label {
        color: #ffc107;
    }
    
    .star-input:checked ~ .star-label {
        transform: scale(1.1);
    }
    
    /* Image preview grid */
    .image-preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 10px;
        margin-top: 10px;
    }
    
    .image-preview-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        aspect-ratio: 1;
    }
    
    .image-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .image-preview-item .remove-image {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(220, 53, 69, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        font-size: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Form styling */
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }
    
    .form-control, .form-select {
        border-radius: 8px;
        border: 2px solid var(--border-color);
        padding: 12px 16px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    /* Form actions */
    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-start;
        align-items: center;
        padding-top: 20px;
        border-top: 1px solid var(--border-color);
    }
    
    .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 12px 24px;
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    /* Content card */
    .content-card {
        background: var(--card-bg);
        border-radius: 12px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        margin-bottom: 20px;
    }
    
    .card-header {
        background: var(--card-header-bg);
        padding: 25px;
        border-bottom: 1px solid var(--border-color);
    }
    
    .card-header h3 {
        margin: 0 0 10px 0;
        color: var(--text-primary);
        font-size: 20px;
        font-weight: 600;
    }
    
    .card-header p {
        margin: 0;
        color: var(--text-muted);
    }
    
    .card-body {
        padding: 25px;
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

// Product selection change
document.getElementById('product_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const preview = document.getElementById('productPreview');
    
    if (this.value) {
        const price = selectedOption.dataset.price;
        const image = selectedOption.dataset.image;
        const description = selectedOption.dataset.description;
        const title = selectedOption.text;
        
        document.getElementById('previewImage').src = image;
        document.getElementById('previewTitle').textContent = title.split(' - ')[0];
        document.getElementById('previewDescription').textContent = description;
        document.getElementById('previewPrice').textContent = `$${parseFloat(price).toFixed(2)}`;
        
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
});

// Rating selection
document.querySelectorAll('.star-input').forEach(input => {
    input.addEventListener('change', function() {
        const rating = this.value;
        const ratingText = document.getElementById('ratingText');
        
        const ratingDescriptions = {
            1: 'Poor - Not recommended',
            2: 'Fair - Below average',
            3: 'Good - Satisfactory',
            4: 'Very Good - Recommended',
            5: 'Excellent - Highly recommended'
        };
        
        ratingText.textContent = `${rating} Star${rating > 1 ? 's' : ''} - ${ratingDescriptions[rating]}`;
        ratingText.className = 'fw-bold';
        
        // Update star colors
        document.querySelectorAll('.star-label').forEach((label, index) => {
            const starNumber = 5 - index;
            if (starNumber <= rating) {
                label.style.color = '#ffc107';
            } else {
                label.style.color = 'var(--text-muted)';
            }
        });
    });
});

// Image preview
document.getElementById('images').addEventListener('change', function() {
    const files = this.files;
    const preview = document.getElementById('imagePreview');
    const grid = document.getElementById('imagePreviewGrid');
    
    if (files.length > 0) {
        grid.innerHTML = '';
        
        Array.from(files).forEach((file, index) => {
            if (index >= 5) return; // Limit to 5 images
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'image-preview-item';
                div.innerHTML = `
                    <img src="${e.target.result}" alt="Preview">
                    <button type="button" class="remove-image" onclick="removeImage(${index})">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                grid.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
        
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
});

// Remove image preview
function removeImage(index) {
    const input = document.getElementById('images');
    const dt = new DataTransfer();
    
    Array.from(input.files).forEach((file, i) => {
        if (i !== index) {
            dt.items.add(file);
        }
    });
    
    input.files = dt.files;
    
    // Re-trigger change event to update preview
    const event = new Event('change');
    input.dispatchEvent(event);
}

// Form validation
document.getElementById('reviewForm').addEventListener('submit', function(e) {
    const comment = document.getElementById('comment').value;
    
    if (comment.length < 10) {
        e.preventDefault();
        alert('Review comment must be at least 10 characters long.');
        document.getElementById('comment').focus();
        return false;
    }
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating Review...';
    submitBtn.disabled = true;
});
</script>
@endsection
