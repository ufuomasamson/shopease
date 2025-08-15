@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Order #{{ $order->id }} Details</h4>
                    <a href="{{ route('admin.orders') }}" class="btn btn-secondary">Back to Orders</a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Customer Information</h5>
                            <p><strong>Name:</strong> {{ $order->user->name }}</p>
                            <p><strong>Email:</strong> {{ $order->user->email }}</p>
                            <p><strong>Account Created:</strong> {{ $order->user->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Order Information</h5>
                            <p>
                                <strong>Status:</strong> 
                                <span class="badge {{ $order->status === 'completed' ? 'bg-success' : ($order->status === 'cancelled' ? 'bg-danger' : 'bg-warning') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                            <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                            <p><strong>Total Amount:</strong> ${{ number_format($order->total_price, 2) }}</p>
                        </div>
                    </div>

                    <h5>Product Details</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($order->product->image)
                                                <img src="{{ Storage::url($order->product->image) }}" alt="{{ $order->product->title }}" class="img-thumbnail me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary me-3" style="width: 60px; height: 60px;"></div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $order->product->title }}</h6>
                                                <small class="text-muted">{{ Str::limit($order->product->description, 50) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>${{ number_format($order->product->price, 2) }}</td>
                                    <td>{{ $order->quantity }}</td>
                                    <td>${{ number_format($order->total_price, 2) }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td><strong>${{ number_format($order->total_price, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if($order->status === 'pending')
                        <div class="mt-4 d-flex gap-2">
                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="btn btn-success">Mark as Completed</button>
                            </form>
                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn btn-danger">Cancel Order</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection