<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ShopEase') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jumia-theme.css') }}" rel="stylesheet">
    
    <style>
        /* Make main application navbar sticky */
        .navbar {
            position: sticky !important;
            top: 0;
            z-index: 1030;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        /* Ensure proper spacing when navbar is sticky */
        main {
            padding-top: 0;
        }
        
        /* Add subtle shadow for better visual separation */
        .navbar.shadow-sm {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
        }
        
        /* Responsive sticky behavior */
        @media (max-width: 768px) {
            .navbar {
                position: sticky !important;
                top: 0;
                z-index: 1031;
            }
        }


    </style>
    
    @yield('styles')
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    
    @yield('scripts')
</head>
<body>
    <div id="app">
        @auth
            @if(Auth::user()->isAdmin())
                <!-- Admin Layout (No Sidebar - Uses Admin Dashboard) -->
                <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                    <div class="container">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            {{ config('app.name', 'ShopEase') }}
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <!-- Left Side Of Navbar -->
                            <ul class="navbar-nav me-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-1"></i>Admin Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('products.index') }}">
                                        <i class="fas fa-box me-1"></i>Products
                                    </a>
                                </li>
                            </ul>

                            <!-- Right Side Of Navbar -->
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('wallet.show') }}">
                                            <i class="fas fa-wallet me-2"></i>My Wallet
                                        </a>
                                        <a class="dropdown-item" href="{{ route('orders.index') }}">
                                            <i class="fas fa-shopping-bag me-2"></i>My Orders
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i>{{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <main class="py-4">
                    @yield('content')
                </main>
            @else
                <!-- User Dashboard Layout with Sidebar -->
                <div class="dashboard-container">
                    <!-- Sidebar -->
                    <nav id="sidebar" class="sidebar">
                        <div class="sidebar-header">
                            <a class="navbar-brand text-white" href="{{ url('/') }}">
                                <i class="fas fa-shopping-bag me-2"></i>{{ config('app.name', 'ShopEase') }}
                            </a>
                            <button class="btn-close btn-close-white d-md-none" id="sidebarToggle"></button>
                        </div>
                        
                        <ul class="sidebar-nav">
                            <li class="sidebar-item">
                                <a class="sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                    <i class="fas fa-home me-2"></i>Dashboard
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                                    <i class="fas fa-box me-2"></i>Products
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link {{ request()->routeIs('shipping-addresses.*') ? 'active' : '' }}" href="{{ route('shipping-addresses.index') }}">
                                    <i class="fas fa-map-marker-alt me-2"></i>Shipping Addresses
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link {{ request()->routeIs('wallet.*') ? 'active' : '' }}" href="{{ route('wallet.show') }}">
                                    <i class="fas fa-wallet me-2"></i>My Wallet
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                                    <i class="fas fa-shopping-bag me-2"></i>My Orders
                                </a>
                            </li>
                        </ul>
                        
                        <div class="sidebar-footer">
                            <div class="user-info">
                                <div class="user-avatar">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <div class="user-details">
                                    <div class="user-name">{{ Auth::user()->name }}</div>
                                    <div class="user-role">{{ ucfirst(Auth::user()->role) }}</div>
                                </div>
                            </div>
                            <a href="{{ route('logout') }}" class="btn btn-outline-light btn-sm w-100" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </nav>

                    <!-- Main Content -->
                    <div class="main-content">
                        <!-- Top Navigation -->
                        <nav class="top-navbar">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-link d-md-none" id="sidebarToggleBtn">
                                    <i class="fas fa-bars"></i>
                                </button>
                                <h4 class="mb-0 ms-3">@yield('page-title', 'Dashboard')</h4>
                            </div>
                            <div class="top-navbar-right">
                                <div class="wallet-balance">
                                    <i class="fas fa-wallet me-2"></i>
                                    <span class="balance-amount">${{ number_format(Auth::user()->wallet->balance ?? 0, 2) }}</span>
                                </div>
                            </div>
                        </nav>

                        <!-- Page Content -->
                        <div class="content-wrapper">
                            @yield('content')
                        </div>
                    </div>
                </div>
            @endif
        @else
            <!-- Guest Layout (No Sidebar) -->
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'ShopEase') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('products.index') }}">
                                    <i class="fas fa-box me-1"></i>Products
                                </a>
                            </li>
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            <!-- Page Translator -->
                            <li class="nav-item me-3">
                                @include('components.page-translator')
                            </li>
                            
                            <!-- Authentication Links -->
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4">
                @yield('content')
            </main>
        @endauth
    </div>

    <!-- Include Chat Widget -->
    @include('partials.chat-widget')

    <script>
        // Sidebar toggle functionality (only for user dashboard)
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
            const sidebar = document.getElementById('sidebar');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                });
            }
            
            if (sidebarToggleBtn && sidebar) {
                sidebarToggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                });
            }
        });
    </script>
</body>
</html>
