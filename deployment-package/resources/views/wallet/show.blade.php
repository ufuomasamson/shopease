@extends('layouts.user')

@section('page-title', 'My Wallet')

@section('styles')
<style>
    /* Jumia Theme for Wallet Page */
    .content-wrapper {
        padding: 2rem;
    }

    .wallet-header {
        background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 8px 25px rgba(246, 139, 30, 0.3);
    }

    .wallet-header h1 {
        margin: 0;
        font-weight: 800;
        font-size: 2.5rem;
    }

    .wallet-header p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 1.1rem;
    }

    .balance-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }

    .balance-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .balance-amount {
        font-size: 3rem;
        font-weight: 900;
        color: #f68b1e;
        margin: 0;
        text-align: center;
    }

    .balance-label {
        color: #6b7280;
        font-size: 1.1rem;
        text-align: center;
        margin-bottom: 1rem;
    }

    .transaction-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .transaction-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .transaction-header h5 {
        margin: 0;
        color: #111827;
        font-weight: 700;
        font-size: 1.25rem;
    }

    .transaction-body {
        padding: 2rem;
    }

    .table {
        margin: 0;
    }

    .table th {
        background: #f8f9fa;
        color: #374151;
        font-weight: 600;
        border: none;
        padding: 1rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table td {
        padding: 1rem;
        border: none;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: #f8f9fa;
    }

    .badge {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .badge.bg-success {
        background: #10b981 !important;
    }

    .badge.bg-danger {
        background: #ef4444 !important;
    }

    .text-success {
        color: #10b981 !important;
        font-weight: 700;
    }

    .text-danger {
        color: #ef4444 !important;
        font-weight: 700;
    }

    .pagination {
        margin: 2rem 0 0 0;
    }

    .page-link {
        border: none;
        color: #6b7280;
        padding: 0.75rem 1rem;
        margin: 0 0.25rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .page-link:hover {
        background: #f68b1e;
        color: white;
        transform: translateY(-2px);
    }

    .page-item.active .page-link {
        background: #f68b1e;
        border-color: #f68b1e;
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

    @media (max-width: 768px) {
        .content-wrapper {
            padding: 1rem;
        }
        
        .wallet-header {
            padding: 1.5rem;
        }
        
        .wallet-header h1 {
            font-size: 2rem;
        }
        
        .balance-amount {
            font-size: 2.5rem;
        }
        
        .transaction-body {
            padding: 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Wallet Header -->
    <div class="wallet-header">
        <h1>
            <i class="fas fa-wallet me-3"></i>
            My Wallet
        </h1>
        <p>Manage your balance and track your transactions</p>
    </div>

    <!-- Wallet Balance Card -->
    <div class="balance-card">
        <div class="balance-label">Current Balance</div>
        <div class="balance-amount">${{ number_format($wallet->balance, 2) }}</div>
    </div>

    <!-- Transaction History -->
    <div class="transaction-card">
        <div class="transaction-header">
            <h5>
                <i class="fas fa-history me-2"></i>
                Transaction History
            </h5>
        </div>
        <div class="transaction-body">
            @if($transactions->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        @if($transaction->type === 'credit')
                                            <span class="badge bg-success">Credit</span>
                                        @else
                                            <span class="badge bg-danger">Debit</span>
                                        @endif
                                    </td>
                                    <td class="{{ $transaction->type === 'credit' ? 'text-success' : 'text-danger' }}">
                                        {{ $transaction->type === 'credit' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                                    </td>
                                    <td>{{ $transaction->description }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center">
                    {{ $transactions->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-receipt"></i>
                    <h5>No transactions found</h5>
                    <p>Your transaction history will appear here once you make your first transaction.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
