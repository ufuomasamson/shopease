@extends('layouts.app')

@section('title', 'Order Tracking - ' . $order->id)

@section('content')
<!-- Sidebar -->
@include('admin.partials.sidebar')

<!-- Main Content -->
<div class="admin-main" id="adminMain">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-truck me-2"></i>
            Order Tracking - #{{ $order->id }}
        </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back to Order
            </a>
        </div>
    </div>

            <!-- Order Summary -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-lg">
                        <div class="card-header text-white fw-bold" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-bottom: none;">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Order Details</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-6">
                                    <strong class="text-dark">Order ID:</strong><br>
                                    <span class="text-muted fw-semibold">#{{ $order->id }}</span>
                                </div>
                                <div class="col-6">
                                    <strong class="text-dark">Status:</strong><br>
                                    <span class="badge bg-{{ $order->status_badge_class }} fw-semibold">{{ $order->status_text }}</span>
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="row">
                                <div class="col-6">
                                    <strong class="text-dark">Customer:</strong><br>
                                    <span class="text-muted fw-semibold">{{ $order->user->name }}</span>
                                </div>
                                <div class="col-6">
                                    <strong class="text-dark">Product:</strong><br>
                                    <span class="text-muted fw-semibold">{{ $order->product->title }}</span>
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="row">
                                <div class="col-6">
                                    <strong class="text-dark">Quantity:</strong><br>
                                    <span class="text-muted fw-semibold">{{ $order->quantity }}</span>
                                </div>
                                <div class="col-6">
                                    <strong class="text-dark">Total:</strong><br>
                                    <span class="text-muted fw-semibold">${{ number_format($order->total_price, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 shadow-lg">
                        <div class="card-header text-white fw-bold" style="background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%); border-bottom: none;">
                            <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Add Tracking Update</h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('admin.orders.tracking.store', $order) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="location_country" class="form-label fw-semibold text-dark">
                                            <i class="fas fa-globe me-2 text-primary"></i>Country
                                        </label>
                                        <input type="text" class="form-control border-2 border-light focus-border-primary @error('location_country') is-invalid @enderror" 
                                               id="location_country" name="location_country" value="{{ old('location_country') }}" required>
                                        @error('location_country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="location_city" class="form-label fw-semibold text-dark">
                                            <i class="fas fa-city me-2 text-primary"></i>City
                                        </label>
                                        <input type="text" class="form-control border-2 border-light focus-border-primary @error('location_city') is-invalid @enderror" 
                                               id="location_city" name="location_city" value="{{ old('location_city') }}" required>
                                        @error('location_city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label fw-semibold text-dark">
                                        <i class="fas fa-info-circle me-2 text-primary"></i>Status
                                    </label>
                                    <select class="form-select border-2 border-light focus-border-primary @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="shipped" {{ old('status') == 'shipped' ? 'selected' : '' }}>🚚 Shipped</option>
                                        <option value="in_transit" {{ old('status') == 'in_transit' ? 'selected' : '' }}>🚛 In Transit</option>
                                        <option value="out_for_delivery" {{ old('status') == 'out_for_delivery' ? 'selected' : '' }}>📦 Out for Delivery</option>
                                        <option value="delivered" {{ old('status') == 'delivered' ? 'selected' : '' }}>✅ Delivered</option>
                                        <option value="returned" {{ old('status') == 'returned' ? 'selected' : '' }}>↩️ Returned</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label fw-semibold text-dark">
                                        <i class="fas fa-align-left me-2 text-primary"></i>Description
                                    </label>
                                    <textarea class="form-control border-2 border-light focus-border-primary @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="2" 
                                              placeholder="e.g., Package picked up from warehouse">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="admin_notes" class="form-label fw-semibold text-dark">
                                        <i class="fas fa-sticky-note me-2 text-primary"></i>Admin Notes (Optional)
                                    </label>
                                    <textarea class="form-control border-2 border-light focus-border-primary @error('admin_notes') is-invalid @enderror" 
                                              id="admin_notes" name="admin_notes" rows="2" 
                                              placeholder="Internal notes for admin use">{{ old('admin_notes') }}</textarea>
                                    @error('admin_notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn w-100 fw-semibold" style="background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%); border: none; color: white;">
                                    <i class="fas fa-plus me-2"></i>Add Tracking Update
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tracking Timeline -->
            <div class="card border-0 shadow-lg">
                <div class="card-header text-white fw-bold" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); border-bottom: none;">
                    <h5 class="mb-0"><i class="fas fa-route me-2"></i>Tracking Timeline</h5>
                </div>
                <div class="card-body p-4">
                    @if($trackingEntries->count() > 0)
                        <div class="timeline">
                            @foreach($trackingEntries as $tracking)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-{{ $tracking->status_badge_class }} shadow-sm"></div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1 fw-bold text-dark">{{ $tracking->status_text }}</h6>
                                                <p class="mb-1 text-muted">
                                                    <i class="fas fa-map-marker-alt me-1 text-primary"></i>
                                                    <span class="fw-semibold">{{ $tracking->formatted_location }}</span>
                                                </p>
                                                @if($tracking->description)
                                                    <p class="mb-1 text-dark">{{ $tracking->description }}</p>
                                                @endif
                                                <small class="text-muted">
                                                    <i class="fas fa-clock me-1 text-primary"></i>
                                                    <span class="fw-semibold">{{ $tracking->tracked_at->format('M d, Y \a\t g:i A') }}</span>
                                                </small>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-primary border-2 fw-semibold" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editTrackingModal{{ $tracking->id }}">
                                                    <i class="fas fa-edit me-1"></i>Edit
                                                </button>
                                                <form action="{{ route('admin.orders.tracking.destroy', $tracking) }}" 
                                                      method="POST" class="d-inline" 
                                                      onsubmit="return confirm('Are you sure you want to delete this tracking entry?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger border-2 fw-semibold">
                                                        <i class="fas fa-trash me-1"></i>Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Tracking Modal -->
                                <div class="modal fade" id="editTrackingModal{{ $tracking->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content border-0 shadow-lg">
                                            <div class="modal-header" style="background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%); border-bottom: none;">
                                                <h5 class="modal-title text-white fw-bold">
                                                    <i class="fas fa-edit me-2"></i>Edit Tracking Entry
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.orders.tracking.update', $tracking) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body p-4">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="edit_location_country_{{ $tracking->id }}" class="form-label fw-semibold text-dark">
                                                                <i class="fas fa-globe me-2 text-primary"></i>Country
                                                            </label>
                                                            <input type="text" class="form-control border-2 border-light focus-border-primary" 
                                                                   id="edit_location_country_{{ $tracking->id }}" 
                                                                   name="location_country" value="{{ $tracking->location_country }}" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="edit_location_city_{{ $tracking->id }}" class="form-label fw-semibold text-dark">
                                                                <i class="fas fa-city me-2 text-primary"></i>City
                                                            </label>
                                                            <input type="text" class="form-control border-2 border-light focus-border-primary" 
                                                                   id="edit_location_city_{{ $tracking->id }}" 
                                                                   name="location_city" value="{{ $tracking->location_city }}" required>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="edit_status_{{ $tracking->id }}" class="form-label fw-semibold text-dark">
                                                            <i class="fas fa-info-circle me-2 text-primary"></i>Status
                                                        </label>
                                                        <select class="form-select border-2 border-light focus-border-primary" id="edit_status_{{ $tracking->id }}" name="status" required>
                                                            <option value="shipped" {{ $tracking->status == 'shipped' ? 'selected' : '' }}>🚚 Shipped</option>
                                                            <option value="in_transit" {{ $tracking->status == 'in_transit' ? 'selected' : '' }}>🚛 In Transit</option>
                                                            <option value="out_for_delivery" {{ $tracking->status == 'out_for_delivery' ? 'selected' : '' }}>📦 Out for Delivery</option>
                                                            <option value="delivered" {{ $tracking->status == 'delivered' ? 'selected' : '' }}>✅ Delivered</option>
                                                            <option value="returned" {{ $tracking->status == 'returned' ? 'selected' : '' }}>↩️ Returned</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="edit_description_{{ $tracking->id }}" class="form-label fw-semibold text-dark">
                                                            <i class="fas fa-align-left me-2 text-primary"></i>Description
                                                        </label>
                                                        <textarea class="form-control border-2 border-light focus-border-primary" id="edit_description_{{ $tracking->id }}" 
                                                                  name="description" rows="2" placeholder="Describe the current status...">{{ $tracking->description }}</textarea>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="edit_admin_notes_{{ $tracking->id }}" class="form-label fw-semibold text-dark">
                                                            <i class="fas fa-sticky-note me-2 text-primary"></i>Admin Notes
                                                        </label>
                                                        <textarea class="form-control border-2 border-light focus-border-primary" id="edit_admin_notes_{{ $tracking->id }}" 
                                                                  name="admin_notes" rows="2" placeholder="Internal notes for admin use...">{{ $tracking->admin_notes }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 pt-0">
                                                    <button type="button" class="btn btn-light border-2 fw-semibold" data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-2"></i>Cancel
                                                    </button>
                                                    <button type="submit" class="btn btn-primary fw-semibold" style="background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%); border: none;">
                                                        <i class="fas fa-save me-2"></i>Update Tracking
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-truck fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No tracking information yet</h5>
                            <p class="text-muted">Add the first tracking update above to start tracking this order.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 0;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 0 0 3px #f68b1e;
}

.timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: -26px;
    top: 20px;
    width: 2px;
    height: calc(100% + 10px);
    background: linear-gradient(180deg, #f68b1e 0%, #e67e22 100%);
}

.timeline-content {
    background: #ffffff;
    padding: 20px;
    border-radius: 12px;
    border-left: 4px solid #f68b1e;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.timeline-content:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
}

/* Custom focus styles for form elements */
.focus-border-primary:focus {
    border-color: #f68b1e !important;
    box-shadow: 0 0 0 0.2rem rgba(246, 139, 30, 0.25) !important;
}

/* Enhanced button styles */
.btn-outline-primary {
    border-color: #f68b1e;
    color: #f68b1e;
}

.btn-outline-primary:hover {
    background-color: #f68b1e;
    border-color: #f68b1e;
    color: white;
}

.btn-outline-danger {
    border-color: #dc3545;
    color: #dc3545;
}

.btn-outline-danger:hover {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
}

/* Card enhancements */
.card {
    border-radius: 12px;
    overflow: hidden;
}

.card-header {
    padding: 1rem 1.5rem;
}

.card-body {
    padding: 1.5rem;
}

/* Form enhancements */
.form-control, .form-select {
    border-radius: 8px;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    transform: translateY(-1px);
}

/* Badge enhancements */
.badge {
    font-size: 0.85rem;
    padding: 0.5rem 0.75rem;
    border-radius: 20px;
}
</style>
@endsection
