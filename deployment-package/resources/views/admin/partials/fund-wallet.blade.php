<div class="form-container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.process-wallet-funding') }}">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label for="user_id" class="form-label">Select User</label>
                <select class="form-select" id="user_id" name="user_id" required>
                    <option value="" disabled selected>Choose a user...</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" step="0.01" min="0.01" required>
            </div>
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary">Fund Wallet</button>
            </div>
        </div>
    </form>
</div>
