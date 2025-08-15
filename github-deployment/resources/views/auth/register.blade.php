@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-lg-5 col-md-7 col-sm-9">
                <!-- Register Card -->
                <div class="auth-card">
                    <div class="auth-header text-center mb-4">
                        <div class="auth-logo mb-3">
                            <i class="fas fa-user-plus text-primary"></i>
                        </div>
                        <h1 class="auth-title">Join ShopEase!</h1>
                        <p class="auth-subtitle">Create your account and start shopping digital products</p>
                    </div>

                    <div class="auth-body">
                        <form method="POST" action="{{ route('register') }}" id="registerForm">
                            @csrf

                            <!-- Name Field -->
                            <div class="form-group mb-4">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-2 text-primary"></i>Full Name
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-user text-muted"></i>
                                    </span>
                                    <input id="name" type="text" 
                                           class="form-control border-start-0 @error('name') is-invalid @enderror" 
                                           name="name" value="{{ old('name') }}" 
                                           placeholder="Enter your full name"
                                           required autocomplete="name" autofocus>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

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
                                           required autocomplete="email">
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
                                           name="password" placeholder="Create a strong password"
                                           required autocomplete="new-password">
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
                                <div class="password-strength mt-2" id="passwordStrength">
                                    <div class="strength-bar">
                                        <div class="strength-fill" id="strengthFill"></div>
                                    </div>
                                    <small class="strength-text" id="strengthText">Password strength</small>
                                </div>
                            </div>

                            <!-- Confirm Password Field -->
                            <div class="form-group mb-4">
                                <label for="password-confirm" class="form-label">
                                    <i class="fas fa-lock me-2 text-primary"></i>Confirm Password
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-lock text-muted"></i>
                                    </span>
                                    <input id="password-confirm" type="password" 
                                           class="form-control border-start-0" 
                                           name="password_confirmation" 
                                           placeholder="Confirm your password"
                                           required autocomplete="new-password">
                                </div>
                                <div class="password-match mt-2" id="passwordMatch">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>Passwords must match
                                    </small>
                                </div>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="form-group mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the 
                                        <a href="#" class="terms-link">Terms and Conditions</a> 
                                        and 
                                        <a href="#" class="terms-link">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group mb-4">
                                <button type="submit" class="btn btn-primary btn-lg w-100" id="registerBtn">
                                    <span class="btn-text">
                                        <i class="fas fa-user-plus me-2"></i>Create Account
                                    </span>
                                    <span class="btn-loading d-none">
                                        <i class="fas fa-spinner fa-spin me-2"></i>Creating Account...
                                    </span>
                                </button>
                            </div>

                            <!-- Divider -->
                            <div class="text-center mb-4">
                                <span class="divider-text">or</span>
                            </div>

                            <!-- Login Link -->
                            <div class="text-center">
                                <p class="mb-0">
                                    Already have an account? 
                                    <a href="{{ route('login') }}" class="login-link">
                                        <i class="fas fa-sign-in-alt me-1"></i>Sign in here
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

.terms-link {
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
}

.terms-link:hover {
    color: #764ba2;
    text-decoration: underline;
}

.login-link {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.login-link:hover {
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

/* Password Strength Indicator */
.password-strength {
    display: none;
}

.password-strength.show {
    display: block;
}

.strength-bar {
    width: 100%;
    height: 4px;
    background: #e2e8f0;
    border-radius: 2px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.strength-fill {
    height: 100%;
    width: 0%;
    transition: all 0.3s ease;
    border-radius: 2px;
}

.strength-fill.weak {
    width: 33.33%;
    background: #e53e3e;
}

.strength-fill.medium {
    width: 66.66%;
    background: #d69e2e;
}

.strength-fill.strong {
    width: 100%;
    background: #38a169;
}

.strength-text {
    font-size: 0.75rem;
    color: #718096;
}

.strength-text.weak {
    color: #e53e3e;
}

.strength-text.medium {
    color: #d69e2e;
}

.strength-text.strong {
    color: #38a169;
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

// Password strength checker
function checkPasswordStrength(password) {
    let strength = 0;
    let feedback = '';
    
    if (password.length >= 8) strength++;
    if (password.match(/[a-z]/)) strength++;
    if (password.match(/[A-Z]/)) strength++;
    if (password.match(/[0-9]/)) strength++;
    if (password.match(/[^a-zA-Z0-9]/)) strength++;
    
    const strengthBar = document.getElementById('strengthFill');
    const strengthText = document.getElementById('strengthText');
    const passwordStrength = document.getElementById('passwordStrength');
    
    if (password.length > 0) {
        passwordStrength.classList.add('show');
        
        if (strength <= 2) {
            strengthBar.className = 'strength-fill weak';
            strengthText.className = 'strength-text weak';
            strengthText.textContent = 'Weak password';
        } else if (strength <= 3) {
            strengthBar.className = 'strength-fill medium';
            strengthText.className = 'strength-text medium';
            strengthText.textContent = 'Medium strength';
        } else {
            strengthBar.className = 'strength-fill strong';
            strengthText.className = 'strength-text strong';
            strengthText.textContent = 'Strong password';
        }
    } else {
        passwordStrength.classList.remove('show');
    }
}

// Password confirmation checker
function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password-confirm').value;
    const passwordMatch = document.getElementById('passwordMatch');
    
    if (confirmPassword.length > 0) {
        if (password === confirmPassword) {
            passwordMatch.innerHTML = '<small class="text-success"><i class="fas fa-check-circle me-1"></i>Passwords match!</small>';
        } else {
            passwordMatch.innerHTML = '<small class="text-danger"><i class="fas fa-times-circle me-1"></i>Passwords do not match</small>';
        }
    } else {
        passwordMatch.innerHTML = '<small class="text-muted"><i class="fas fa-info-circle me-1"></i>Passwords must match</small>';
    }
}

// Event listeners
document.getElementById('password').addEventListener('input', function() {
    checkPasswordStrength(this.value);
});

document.getElementById('password-confirm').addEventListener('input', checkPasswordMatch);

// Form submission handling
document.getElementById('registerForm').addEventListener('submit', function(e) {
    const registerBtn = document.getElementById('registerBtn');
    
    // Show loading state
    registerBtn.classList.add('loading');
    registerBtn.disabled = true;
    
    // Re-enable after a delay (in case of validation errors)
    setTimeout(() => {
        registerBtn.classList.remove('loading');
        registerBtn.disabled = false;
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
