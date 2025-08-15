@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-lg-5 col-md-7 col-sm-9">
                <!-- Login Card -->
                <div class="auth-card">
                    <div class="auth-header text-center mb-4">
                        <div class="auth-logo mb-3">
                            <i class="fas fa-shopping-bag text-primary"></i>
                        </div>
                        <h1 class="auth-title">Welcome Back!</h1>
                        <p class="auth-subtitle">Sign in to your ShopEase account</p>
                    </div>

                    <div class="auth-body">
                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf

                            <!-- Email Field -->
                            <div class="form-group mb-4">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2 text-primary"></i>Email Address
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-envelope text-muted"></i>
                                    </span>
                                    <input id="email" type="email" 
                                           class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email') }}" 
                                           placeholder="Enter your email address"
                                           required autocomplete="email" autofocus>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="form-group mb-4">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-2 text-primary"></i>Password
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-lock text-muted"></i>
                                    </span>
                                    <input id="password" type="password" 
                                           class="form-control border-start-0 @error('password') is-invalid @enderror" 
                                           name="password" placeholder="Enter your password"
                                           required autocomplete="current-password">
                                    <button class="btn btn-outline-secondary border-start-0" type="button" 
                                            id="togglePassword" onclick="togglePassword()">
                                        <i class="fas fa-eye" id="passwordIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" 
                                           id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        <i class="fas fa-check me-1"></i>Remember me
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="forgot-link" href="{{ route('password.request') }}">
                                        <i class="fas fa-key me-1"></i>Forgot password?
                                    </a>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group mb-4">
                                <button type="submit" class="btn btn-primary btn-lg w-100" id="loginBtn">
                                    <span class="btn-text">
                                        <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                    </span>
                                    <span class="btn-loading d-none">
                                        <i class="fas fa-spinner fa-spin me-2"></i>Signing In...
                                    </span>
                                </button>
                            </div>

                            <!-- Divider -->
                            <div class="text-center mb-4">
                                <span class="divider-text">or</span>
                            </div>

                            <!-- Register Link -->
                            <div class="text-center">
                                <p class="mb-0">
                                    Don't have an account? 
                                    <a href="{{ route('register') }}" class="register-link">
                                        <i class="fas fa-user-plus me-1"></i>Sign up here
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Back to Home -->
                <div class="text-center mt-4">
                    <a href="{{ route('welcome') }}" class="back-home-link">
                        <i class="fas fa-arrow-left me-2"></i>Back to Homepage
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.auth-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 20px 0;
}

.auth-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    padding: 2.5rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.auth-logo {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    font-size: 2rem;
    color: white;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.auth-title {
    font-size: 2rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.auth-subtitle {
    color: #718096;
    font-size: 1.1rem;
    margin-bottom: 0;
}

.form-label {
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
}

.form-control {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 0.875rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    outline: none;
}

.input-group-text {
    border: 2px solid #e2e8f0;
    border-right: none;
    background: #f7fafc;
    color: #a0aec0;
    border-radius: 12px 0 0 12px;
    padding: 0.875rem 1rem;
}

.input-group .form-control {
    border-left: none;
    border-radius: 0 12px 12px 0;
}

.input-group .btn {
    border: 2px solid #e2e8f0;
    border-left: none;
    border-radius: 0 12px 12px 0;
    background: #f7fafc;
    color: #a0aec0;
    padding: 0.875rem 1rem;
}

.input-group .btn:hover {
    background: #edf2f7;
    color: #4a5568;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 12px;
    padding: 1rem 2rem;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
}

.btn-primary:active {
    transform: translateY(0);
}

.form-check-input:checked {
    background-color: #667eea;
    border-color: #667eea;
}

.form-check-label {
    color: #4a5568;
    font-weight: 500;
}

.forgot-link {
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.forgot-link:hover {
    color: #764ba2;
    text-decoration: underline;
}

.register-link {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.register-link:hover {
    color: #764ba2;
    text-decoration: underline;
}

.back-home-link {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.back-home-link:hover {
    color: white;
}

.divider-text {
    position: relative;
    color: #a0aec0;
    font-weight: 500;
}

.divider-text::before,
.divider-text::after {
    content: '';
    position: absolute;
    top: 50%;
    width: 45%;
    height: 1px;
    background: #e2e8f0;
}

.divider-text::before {
    left: -50%;
}

.divider-text::after {
    right: -50%;
}

.invalid-feedback {
    font-size: 0.875rem;
    color: #e53e3e;
    margin-top: 0.5rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .auth-card {
        padding: 2rem 1.5rem;
        margin: 0 1rem;
    }
    
    .auth-title {
        font-size: 1.75rem;
    }
    
    .auth-subtitle {
        font-size: 1rem;
    }
}

@media (max-width: 576px) {
    .auth-card {
        padding: 1.5rem 1rem;
    }
    
    .auth-logo {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    .auth-title {
        font-size: 1.5rem;
    }
}

/* Animation Classes */
.auth-card {
    animation: slideInUp 0.6s ease-out;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Loading State */
.btn-loading {
    display: none;
}

.btn.loading .btn-text {
    display: none;
}

.btn.loading .btn-loading {
    display: inline-block;
}
</style>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const passwordIcon = document.getElementById('passwordIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.classList.remove('fa-eye');
        passwordIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        passwordIcon.classList.remove('fa-eye-slash');
        passwordIcon.classList.add('fa-eye');
    }
}

// Form submission handling
document.getElementById('loginForm').addEventListener('submit', function(e) {
    const loginBtn = document.getElementById('loginBtn');
    const btnText = loginBtn.querySelector('.btn-text');
    const btnLoading = loginBtn.querySelector('.btn-loading');
    
    // Show loading state
    loginBtn.classList.add('loading');
    loginBtn.disabled = true;
    
    // Re-enable after a delay (in case of validation errors)
    setTimeout(() => {
        loginBtn.classList.remove('loading');
        loginBtn.disabled = false;
    }, 5000);
});

// Add focus effects to form fields
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('focus', function() {
        this.parentElement.classList.add('focused');
    });
    
    input.addEventListener('blur', function() {
        this.parentElement.classList.remove('focused');
    });
});
</script>
@endsection
