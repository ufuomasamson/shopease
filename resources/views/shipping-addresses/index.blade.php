@extends('layouts.user')

@section('page-title', 'Shipping Addresses')

@section('styles')
<style>
    /* Jumia Theme for Shipping Addresses */
    .content-wrapper {
        padding: 2rem;
    }

    .addresses-header {
        background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 8px 25px rgba(246, 139, 30, 0.3);
    }

    .addresses-header h1 {
        margin: 0;
        font-weight: 800;
        font-size: 2.5rem;
    }

    .addresses-header p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 1.1rem;
    }

    .address-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        overflow: hidden;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .address-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .address-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .address-header h5 {
        margin: 0;
        color: #111827;
        font-weight: 700;
        font-size: 1.25rem;
    }

    .address-badges {
        display: flex;
        gap: 0.5rem;
    }

    .badge {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .badge.bg-primary {
        background: #f68b1e !important;
    }

    .badge.bg-success {
        background: #10b981 !important;
    }

    .badge.bg-info {
        background: #3b82f6 !important;
    }

    .address-body {
        padding: 2rem;
    }

    .address-info {
        margin-bottom: 1.5rem;
    }

    .address-info h6 {
        color: #374151;
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .address-info p {
        color: #111827;
        margin: 0;
        font-size: 1rem;
        line-height: 1.5;
    }

    .address-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
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
    }

    .btn-primary {
        background: #f68b1e;
        border: none;
        color: white;
    }

    .btn-primary:hover {
        background: #e67e22;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(246, 139, 30, 0.3);
    }

    .btn-outline-primary {
        border: 2px solid #f68b1e;
        color: #f68b1e;
        background: transparent;
    }

    .btn-outline-primary:hover {
        background: #f68b1e;
        color: white;
        transform: translateY(-2px);
    }

    .btn-outline-danger {
        border: 2px solid #ef4444;
        color: #ef4444;
        background: transparent;
    }

    .btn-outline-danger:hover {
        background: #ef4444;
        color: white;
        transform: translateY(-2px);
    }

    .btn-outline-success {
        border: 2px solid #10b981;
        color: #10b981;
        background: transparent;
    }

    .btn-outline-success:hover {
        background: #10b981;
        color: white;
        transform: translateY(-2px);
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: #d1d5db;
    }

    .empty-state h5 {
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .add-address-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 2px dashed #d1d5db;
        border-radius: 16px;
        padding: 3rem 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .add-address-card:hover {
        border-color: #f68b1e;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        transform: translateY(-2px);
    }

    .add-address-card i {
        font-size: 3rem;
        color: #9ca3af;
        margin-bottom: 1rem;
    }

    .add-address-card h5 {
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .add-address-card p {
        color: #6b7280;
        margin: 0;
    }

    @media (max-width: 768px) {
        .content-wrapper {
            padding: 1rem;
        }
        
        .addresses-header {
            padding: 1.5rem;
        }
        
        .addresses-header h1 {
            font-size: 2rem;
        }
        
        .address-body {
            padding: 1rem;
        }
        
        .address-actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Addresses Header -->
    <div class="addresses-header">
        <h1>
            <i class="fas fa-map-marker-alt me-3"></i>
            Shipping Addresses
        </h1>
        <p>Manage your delivery addresses for seamless shopping</p>
    </div>

    <!-- Add New Address Card -->
    <div class="add-address-card" onclick="window.location.href='{{ route('shipping-addresses.create') }}'">
        <i class="fas fa-plus-circle"></i>
        <h5>Add New Address</h5>
        <p>Click here to add a new shipping address</p>
    </div>

    <!-- Addresses List -->
    @if($addresses->count() > 0)
        @foreach($addresses as $address)
            <div class="address-card">
                <div class="address-header">
                    <h5>
                        <i class="fas fa-map-marker-alt me-2"></i>
                        {{ $address->full_name }}
                    </h5>
                    <div class="address-badges">
                        @if($address->is_default)
                            <span class="badge bg-primary">Default</span>
                        @endif
                        @if($address->is_billing_address)
                            <span class="badge bg-success">Billing</span>
                        @endif
                        <span class="badge bg-info">{{ $address->city }}, {{ $address->state }}</span>
                    </div>
                </div>
                <div class="address-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="address-info">
                                <h6>Full Name</h6>
                                <p>{{ $address->full_name }}</p>
                            </div>
                            <div class="address-info">
                                <h6>Phone</h6>
                                <p>{{ $address->formatted_phone }}</p>
                            </div>
                            <div class="address-info">
                                <h6>Email</h6>
                                <p>{{ $address->email }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="address-info">
                                <h6>Address</h6>
                                <p>{{ $address->full_address }}</p>
                            </div>
                            <div class="address-info">
                                <h6>City & State</h6>
                                <p>{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</p>
                            </div>
                            <div class="address-info">
                                <h6>Country</h6>
                                <p>{{ $address->country }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if($address->additional_notes)
                        <div class="address-info">
                            <h6>Additional Notes</h6>
                            <p>{{ $address->additional_notes }}</p>
                        </div>
                    @endif

                    <div class="address-actions">
                        <a href="{{ route('shipping-addresses.edit', $address) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit"></i>Edit
                        </a>
                        
                        @if(!$address->is_default)
                            <form action="{{ route('shipping-addresses.set-default', $address) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-success">
                                    <i class="fas fa-star"></i>Set as Default
                                </button>
                            </form>
                        @endif
                        
                        <form action="{{ route('shipping-addresses.destroy', $address) }}" method="POST" class="d-inline" 
                              onsubmit="return confirm('Are you sure you want to delete this address?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-trash"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="empty-state">
            <i class="fas fa-map-marker-alt"></i>
            <h5>No shipping addresses found</h5>
            <p>You haven't added any shipping addresses yet. Add your first address to get started with shopping.</p>
        </div>
    @endif
</div>
@endsection
