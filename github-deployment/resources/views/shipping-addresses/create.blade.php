@extends('layouts.user')

@section('page-title', 'Add Shipping Address')

@section('styles')
<style>
    /* Jumia Theme for Shipping Address Form */
    .content-wrapper {
        padding: 2rem;
    }

    .form-header {
        background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 8px 25px rgba(246, 139, 30, 0.3);
    }

    .form-header h1 {
        margin: 0;
        font-weight: 800;
        font-size: 2.5rem;
    }

    .form-header p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 1.1rem;
    }

    .form-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .form-header-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .form-header-card h5 {
        margin: 0;
        color: #111827;
        font-weight: 700;
        font-size: 1.25rem;
    }

    .form-body {
        padding: 2rem;
    }

    .form-label {
        color: #374151;
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 0.75rem;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .form-control:focus {
        outline: none;
        border-color: #f68b1e;
        box-shadow: 0 0 0 3px rgba(246, 139, 30, 0.1);
    }

    .form-text {
        color: #6b7280;
        font-size: 0.875rem;
        margin-top: 0.25rem;
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

    .btn-secondary {
        background: #6b7280;
        border: none;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
        transform: translateY(-2px);
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e5e7eb;
    }

    .required-field::after {
        content: ' *';
        color: #ef4444;
    }

    @media (max-width: 768px) {
        .content-wrapper {
            padding: 1rem;
        }
        
        .form-header {
            padding: 1.5rem;
        }
        
        .form-header h1 {
            font-size: 2rem;
        }
        
        .form-body {
            padding: 1rem;
        }
        
        .form-actions {
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
    <!-- Form Header -->
    <div class="form-header">
        <h1>
            <i class="fas fa-plus-circle me-3"></i>
            Add Shipping Address
        </h1>
        <p>Add a new delivery address for your orders</p>
    </div>

    <!-- Form Card -->
    <div class="form-card">
        <div class="form-header-card">
            <h5>
                <i class="fas fa-map-marker-alt me-2"></i>
                Address Information
            </h5>
        </div>
        <div class="form-body">
            <form action="{{ route('shipping-addresses.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="first_name" class="form-label required-field">First Name</label>
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                               id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="last_name" class="form-label required-field">Last Name</label>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                               id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label required-field">Phone Number</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone') }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label required-field">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address_line_1" class="form-label required-field">Address Line 1</label>
                    <input type="text" class="form-control @error('address_line_1') is-invalid @enderror" 
                           id="address_line_1" name="address_line_1" value="{{ old('address_line_1') }}" required>
                    @error('address_line_1')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address_line_2" class="form-label">Address Line 2 (Optional)</label>
                    <input type="text" class="form-control @error('address_line_2') is-invalid @enderror" 
                           id="address_line_2" name="address_line_2" value="{{ old('address_line_2') }}">
                    @error('address_line_2')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="city" class="form-label required-field">City/Town</label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" 
                               id="city" name="city" value="{{ old('city') }}" required>
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="state" class="form-label required-field">State/Province</label>
                        <input type="text" class="form-control @error('state') is-invalid @enderror" 
                               id="state" name="state" value="{{ old('state') }}" required>
                        @error('state')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="postal_code" class="form-label required-field">Postal/ZIP Code</label>
                        <input type="text" class="form-control @error('postal_code') is-invalid @enderror" 
                               id="postal_code" name="postal_code" value="{{ old('postal_code') }}" required>
                        @error('postal_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="country" class="form-label required-field">Country</label>
                        <input type="text" class="form-control @error('country') is-invalid @enderror" 
                               id="country" name="country" value="{{ old('country') }}" required>
                        @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="additional_notes" class="form-label">Additional Notes (Optional)</label>
                    <textarea class="form-control @error('additional_notes') is-invalid @enderror" 
                              id="additional_notes" name="additional_notes" rows="3" 
                              placeholder="Any special delivery instructions...">{{ old('additional_notes') }}</textarea>
                    @error('additional_notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_default" name="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_default">
                                Set as Default Address
                            </label>
                            <div class="form-text">This will be your primary shipping address</div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_billing_address" name="is_billing_address" value="1" {{ old('is_billing_address') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_billing_address">
                                Use as Billing Address
                            </label>
                            <div class="form-text">This will be your billing address for invoices</div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('shipping-addresses.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>Save Address
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
