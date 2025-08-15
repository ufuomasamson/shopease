@extends('layouts.admin')

@section('page-title', 'Fund User Wallets')

@section('content')

    <!-- Fund Wallet Header -->
    <div class="fund-header">
        <h1>
            <i class="fas fa-wallet me-3"></i>
            Fund User Wallet
        </h1>
        <p>Add funds to user wallets for seamless shopping experience</p>
    </div>

            <!-- Fund Wallet Container -->
            <div class="fund-container">
                <div class="fund-header-card">
                    <h5>
                        <i class="fas fa-plus-circle me-2"></i>
                        Wallet Funding Form
                    </h5>
                </div>
                <div class="fund-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.process-wallet-funding') }}" method="POST" id="fundWalletForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="user_id" class="form-label required-field">Select User</label>
                                <select class="form-select @error('user_id') is-invalid @enderror" 
                                        id="user_id" name="user_id" required onchange="loadUserInfo()">
                                    <option value="">Choose a user...</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" 
                                                data-name="{{ $user->name }}"
                                                data-email="{{ $user->email }}"
                                                data-balance="{{ $user->wallet ? $user->wallet->balance : 0 }}">
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Select the user whose wallet you want to fund</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="amount" class="form-label required-field">Amount to Add</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                           id="amount" name="amount" value="{{ old('amount') }}" 
                                           step="0.01" min="0.01" required>
                                </div>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Enter the amount you want to add to the wallet</div>
                            </div>
                        </div>

                        <!-- User Information Display -->
                        <div id="userInfo" style="display: none;">
                            <div class="user-info">
                                <h6>
                                    <i class="fas fa-user me-2"></i>
                                    User Information
                                </h6>
                                <div class="user-details">
                                    <div class="user-detail">
                                        <span class="user-detail-label">Name</span>
                                        <span class="user-detail-value" id="userName"></span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="user-detail-label">Email</span>
                                        <span class="user-detail-value" id="userEmail"></span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="user-detail-label">Current Balance</span>
                                        <span class="user-detail-value" id="currentBalance"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="wallet-balance">
                                <h6>New Balance After Funding</h6>
                                <div class="balance-amount" id="newBalance">$0.00</div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i>Back to Dashboard
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i>Fund Wallet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection

@section('scripts')
<script>

function loadUserInfo() {
    const select = document.getElementById('user_id');
    const userInfo = document.getElementById('userInfo');
    const amountInput = document.getElementById('amount');
    
    if (select.value) {
        const selectedOption = select.options[select.selectedIndex];
        const userName = selectedOption.getAttribute('data-name');
        const userEmail = selectedOption.getAttribute('data-email');
        const currentBalance = parseFloat(selectedOption.getAttribute('data-balance'));
        
        // Update user info display
        document.getElementById('userName').textContent = userName;
        document.getElementById('userEmail').textContent = userEmail;
        document.getElementById('currentBalance').textContent = '$' + currentBalance.toFixed(2);
        
        // Show user info section
        userInfo.style.display = 'block';
        
        // Add event listener to amount input for real-time balance calculation
        amountInput.addEventListener('input', calculateNewBalance);
        
        // Calculate initial new balance
        calculateNewBalance();
    } else {
        userInfo.style.display = 'none';
    }
}

function calculateNewBalance() {
    const select = document.getElementById('user_id');
    const amountInput = document.getElementById('amount');
    
    if (select.value && amountInput.value) {
        const selectedOption = select.options[select.selectedIndex];
        const currentBalance = parseFloat(selectedOption.getAttribute('data-balance'));
        const amount = parseFloat(amountInput.value);
        
        if (!isNaN(amount)) {
            const newBalance = currentBalance + amount;
            document.getElementById('newBalance').textContent = '$' + newBalance.toFixed(2);
        }
    }
}

// Form validation
document.getElementById('fundWalletForm').addEventListener('submit', function(e) {
    const userId = document.getElementById('user_id').value;
    const amount = document.getElementById('amount').value;
    
    if (!userId) {
        e.preventDefault();
        alert('Please select a user to fund.');
        return false;
    }
    
    if (!amount || parseFloat(amount) <= 0) {
        e.preventDefault();
        alert('Please enter a valid amount greater than 0.');
        return false;
    }
    
    // Confirm funding
    const selectedOption = document.getElementById('user_id').options[document.getElementById('user_id').selectedIndex];
    const userName = selectedOption.getAttribute('data-name');
    const confirmFunding = confirm(`Are you sure you want to add $${amount} to ${userName}'s wallet?`);
    
    if (!confirmFunding) {
        e.preventDefault();
        return false;
    }
});
</script>
@endsection

@section('styles')
<style>
    /* Admin Fund Wallet Styles */
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

    /* Fund Wallet Content */
    .fund-header {
        background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 8px 25px rgba(246, 139, 30, 0.3);
    }

    .fund-header h1 {
        margin: 0;
        font-weight: 800;
        font-size: 2.5rem;
    }

    .fund-header p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 1.1rem;
    }

    .fund-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .fund-header-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .fund-header-card h5 {
        margin: 0;
        color: #111827;
        font-weight: 700;
        font-size: 1.25rem;
    }

    .fund-body {
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

    .form-control, .form-select {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 0.75rem;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .form-control:focus, .form-select:focus {
        outline: none;
        border-color: #f68b1e;
        box-shadow: 0 0 0 3px rgba(246, 139, 30, 0.1);
    }

    .form-text {
        color: #6b7280;
        font-size: 0.875rem;
        margin-top: 0.25rem;
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

    .user-info {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid #e5e7eb;
    }

    .user-info h6 {
        color: #374151;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .user-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .user-detail {
        display: flex;
        flex-direction: column;
    }

    .user-detail-label {
        color: #6b7280;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }

    .user-detail-value {
        color: #111827;
        font-weight: 600;
        font-size: 1rem;
    }

    .wallet-balance {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .wallet-balance h6 {
        color: white;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.9;
    }

    .wallet-balance .balance-amount {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0;
    }

    .alert {
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        border: none;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border-left: 4px solid #10b981;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .fund-header h1 {
            font-size: 2rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .user-details {
            grid-template-columns: 1fr;
        }
    }
    
    /* Ensure proper layout with sidebar */
    .admin-main {
        box-sizing: border-box;
    }
    
    .fund-container {
        max-width: 100%;
        overflow-x: hidden;
    }
    
    /* Ensure proper spacing for all elements */
    .admin-main > * {
        margin-left: 0;
        margin-right: 0;
    }
    
    /* Ensure form elements don't overflow */
    .form-control, .form-select {
        max-width: 100%;
        box-sizing: border-box;
    }
    
    /* Ensure user info display is properly sized */
    .user-details {
        max-width: 100%;
    }
</style>
@endsection