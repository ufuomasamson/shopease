<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ShopEase') }} - @yield('page-title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jumia-theme.css') }}" rel="stylesheet">
    
    @yield('styles')
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    
    @yield('scripts')
</head>
<body>
    <div id="app">
        @auth
            @if(!Auth::user()->isAdmin())
                <!-- User Layout with Responsive Sidebar -->
                <!-- Mobile Sidebar Toggle Button -->
                <button class="mobile-sidebar-toggle" id="mobileSidebarToggle" onclick="toggleMobileSidebar()">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Sidebar Overlay -->
                <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeMobileSidebar()"></div>

                <!-- Dashboard Container -->
                <div class="dashboard-container">
                    <!-- Sidebar -->
                    <nav class="sidebar" id="sidebar">
                        <div class="sidebar-header">
                            <a href="{{ route('home') }}" class="navbar-brand">
                                <i class="fas fa-shopping-bag"></i>
                                <span>ShopEase</span>
                            </a>
                            <button class="btn-close" onclick="closeMobileSidebar()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <ul class="sidebar-nav">
                            <li class="sidebar-item {{ request()->routeIs('home') ? 'active' : '' }}">
                                <a href="{{ route('home') }}" class="sidebar-link">
                                    <i class="fas fa-tachometer-alt"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li class="sidebar-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                                <a href="{{ route('products.index') }}" class="sidebar-link">
                                    <i class="fas fa-box"></i>
                                    <span>Products</span>
                                </a>
                            </li>
                            <li class="sidebar-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                                <a href="{{ route('orders.index') }}" class="sidebar-link">
                                    <i class="fas fa-shopping-bag"></i>
                                    <span>My Orders</span>
                                </a>
                            </li>
                            <li class="sidebar-item {{ request()->routeIs('wallet.*') ? 'active' : '' }}">
                                <a href="{{ route('wallet.show') }}" class="sidebar-link">
                                    <i class="fas fa-wallet"></i>
                                    <span>My Wallet</span>
                                </a>
                            </li>
                            <li class="sidebar-item {{ request()->routeIs('shipping-addresses.*') ? 'active' : '' }}">
                                <a href="{{ route('shipping-addresses.index') }}" class="sidebar-link">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>Shipping Addresses</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a href="{{ route('welcome') }}" class="sidebar-link">
                                    <i class="fas fa-home"></i>
                                    <span>Homepage</span>
                                </a>
                            </li>
                        </ul>

                        <div class="sidebar-footer">
                            <div class="user-info">
                                <div class="user-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="user-details">
                                    <div class="user-name">{{ Auth::user()->name }}</div>
                                    <div class="user-role">{{ Auth::user()->role ?? 'User' }}</div>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-light">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </nav>

                    <!-- Main Content -->
                    <div class="main-content">
                        <!-- Top Navigation Bar -->
                        <div class="top-navbar">
                            <div class="d-flex align-items-center">
                                <button class="btn-link me-3" onclick="toggleSidebar()">
                                    <i class="fas fa-bars"></i>
                                </button>
                                <h4>@yield('page-title', 'Dashboard')</h4>
                            </div>
                            <div class="wallet-balance">
                                <i class="fas fa-wallet"></i>
                                <span class="balance-amount">${{ number_format(Auth::user()->wallet->balance ?? 0, 2) }}</span>
                            </div>
                        </div>

                        <div class="content-wrapper">
                            @yield('content')
                        </div>
                    </div>
                </div>

                <!-- Include Chat Widget -->
                @include('partials.chat-widget')

                <!-- User Dashboard CSS -->
                <style>
                    /* Jumia Theme for User Dashboard with Sidebar */
                    .dashboard-container {
                        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                        min-height: 100vh;
                        display: flex;
                    }

                    /* Admin Sidebar */
                    .admin-sidebar {
                        width: 280px;
                        background: white;
                        border-right: 1px solid #e5e7eb;
                        position: fixed;
                        height: 100vh;
                        overflow-y: auto;
                        z-index: 1000;
                        transition: all 0.3s ease;
                        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
                    }

                    .admin-sidebar.collapsed {
                        width: 70px;
                    }

                    .sidebar-header {
                        background: linear-gradient(180deg, #f68b1e 0%, #e67e22 100%);
                        color: white;
                        padding: 2rem 1.5rem;
                        text-align: center;
                        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                    }

                    .sidebar-header h3 {
                        margin: 0;
                        font-weight: 800;
                        font-size: 1.5rem;
                        white-space: nowrap;
                        overflow: hidden;
                    }

                    .sidebar-header p {
                        margin: 0.5rem 0 0 0;
                        opacity: 0.9;
                        font-size: 0.9rem;
                        white-space: nowrap;
                        overflow: hidden;
                    }

                    .sidebar-nav {
                        padding: 1.5rem 0;
                        flex-grow: 1;
                    }

                    .nav-section {
                        margin-bottom: 2rem;
                    }

                    .nav-section-title {
                        color: #6b7280;
                        font-size: 0.75rem;
                        font-weight: 600;
                        text-transform: uppercase;
                        letter-spacing: 0.05em;
                        margin: 0 1.5rem 0.75rem;
                        white-space: nowrap;
                        overflow: hidden;
                    }

                    .sidebar-nav ul {
                        list-style: none;
                        padding: 0;
                        margin: 0;
                    }

                    .sidebar-nav li {
                        margin: 0 1rem;
                    }

                    /* Override global app.css sidebar styles with !important */
                    .admin-sidebar .sidebar-link,
                    .admin-sidebar .sidebar-link *,
                    .admin-sidebar .sidebar-link span,
                    .admin-sidebar .sidebar-link i,
                    .admin-sidebar .sidebar-item .sidebar-link,
                    .admin-sidebar .sidebar-item .sidebar-link *,
                    .admin-sidebar .sidebar-item .sidebar-link span,
                    .admin-sidebar .sidebar-item .sidebar-link i {
                        color: #111827 !important;
                    }

                    /* Force sidebar text visibility with !important */
                    .admin-sidebar .sidebar-link,
                    .admin-sidebar .sidebar-link *,
                    .admin-sidebar .sidebar-link span,
                    .admin-sidebar .sidebar-link i {
                        color: #111827 !important;
                    }

                    /* User Dashboard Sidebar Styles */
                    .sidebar {
                        background: linear-gradient(180deg, #f68b1e 0%, #e67e22 100%);
                        color: white;
                        box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
                        width: 280px;
                        min-height: 100vh;
                        position: fixed;
                        left: 0;
                        top: 0;
                        z-index: 1000;
                        display: flex;
                        flex-direction: column;
                        transition: all 0.3s ease;
                    }

                    .sidebar.collapsed {
                        width: 70px;
                    }

                    .sidebar.collapsed .sidebar-link span,
                    .sidebar.collapsed .user-details,
                    .sidebar.collapsed .navbar-brand span {
                        display: none;
                    }

                    .sidebar.collapsed .sidebar-link {
                        justify-content: center;
                        padding: 1rem 0.5rem;
                    }

                    .sidebar.collapsed .sidebar-link i {
                        margin: 0;
                        font-size: 1.2rem;
                    }

                    .sidebar-header {
                        background: rgba(255, 255, 255, 0.1);
                        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
                        padding: 1.5rem;
                        text-align: center;
                    }

                    .sidebar-header .navbar-brand {
                        color: white !important;
                        font-weight: 800;
                        font-size: 1.5rem;
                        text-decoration: none;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        gap: 0.5rem;
                    }

                    .sidebar-header .btn-close {
                        position: absolute;
                        top: 1rem;
                        right: 1rem;
                        background: rgba(255, 255, 255, 0.2);
                        border: none;
                        border-radius: 50%;
                        width: 30px;
                        height: 30px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: white;
                    }

                    .sidebar-nav {
                        flex: 1;
                        padding: 1rem 0;
                        list-style: none;
                        margin: 0;
                    }

                    .sidebar-item {
                        margin: 0.25rem 1rem;
                    }

                    .sidebar-link {
                        color: rgba(255, 255, 255, 0.9) !important;
                        padding: 1rem 1.5rem;
                        border-radius: 12px;
                        transition: all 0.3s ease;
                        border: none;
                        background: transparent;
                        text-decoration: none;
                        display: flex;
                        align-items: center;
                        gap: 0.75rem;
                        font-weight: 500;
                        position: relative;
                        overflow: hidden;
                    }

                    .sidebar-link::before {
                        content: '';
                        position: absolute;
                        left: 0;
                        top: 0;
                        height: 100%;
                        width: 4px;
                        background: white;
                        transform: scaleY(0);
                        transition: transform 0.3s ease;
                    }

                    .sidebar-link:hover {
                        background-color: rgba(255, 255, 255, 0.2);
                        color: white !important;
                        transform: translateX(8px);
                        text-decoration: none;
                    }

                    .sidebar-link:hover::before {
                        transform: scaleY(1);
                    }

                    .sidebar-item.active .sidebar-link {
                        background-color: rgba(255, 255, 255, 0.3);
                        color: white !important;
                        border-left: 4px solid white;
                    }

                    .sidebar-item.active .sidebar-link::before {
                        transform: scaleY(1);
                    }

                    .sidebar-link i {
                        font-size: 1.1rem;
                        width: 20px;
                        text-align: center;
                    }

                    .sidebar-footer {
                        background: rgba(255, 255, 255, 0.1);
                        border-top: 1px solid rgba(255, 255, 255, 0.2);
                        padding: 1.5rem;
                        margin-top: auto;
                    }

                    .user-info {
                        display: flex;
                        align-items: center;
                        gap: 0.75rem;
                        margin-bottom: 1rem;
                        padding: 1rem;
                        background: rgba(255, 255, 255, 0.1);
                        border-radius: 12px;
                    }

                    .user-avatar {
                        width: 40px;
                        height: 40px;
                        background: rgba(255, 255, 255, 0.2);
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 1.2rem;
                        color: white;
                    }

                    .user-details {
                        flex: 1;
                    }

                    .user-name {
                        color: white;
                        font-weight: 700;
                        font-size: 0.9rem;
                        margin-bottom: 0.25rem;
                    }

                    .user-role {
                        color: rgba(255, 255, 255, 0.8);
                        font-size: 0.8rem;
                        text-transform: capitalize;
                    }

                    .sidebar-footer .btn {
                        width: 100%;
                        border-radius: 8px;
                        padding: 0.75rem;
                        font-weight: 600;
                        transition: all 0.3s ease;
                    }

                    .sidebar-footer .btn:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                    }

                    .main-content {
                        flex: 1;
                        margin-left: 280px;
                        transition: all 0.3s ease;
                        min-height: 100vh;
                        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                    }

                    .sidebar.collapsed + .main-content {
                        margin-left: 70px;
                    }

                    .top-navbar {
                        background: white;
                        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                        border-bottom: 1px solid #e5e7eb;
                        padding: 1rem 2rem;
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        position: sticky;
                        top: 0;
                        z-index: 999;
                    }

                    .top-navbar .btn-link {
                        color: #6b7280;
                        text-decoration: none;
                        padding: 0.5rem;
                        border-radius: 8px;
                        transition: all 0.3s ease;
                    }

                    .top-navbar .btn-link:hover {
                        background: #f3f4f6;
                        color: #f68b1e;
                    }

                    .top-navbar h4 {
                        color: #111827;
                        font-weight: 700;
                        margin: 0;
                    }

                    .wallet-balance {
                        background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
                        color: white;
                        padding: 0.75rem 1.5rem;
                        border-radius: 25px;
                        font-weight: 600;
                        display: flex;
                        align-items: center;
                        gap: 0.5rem;
                        box-shadow: 0 4px 12px rgba(246, 139, 30, 0.3);
                    }

                    .balance-amount {
                        font-size: 1.1rem;
                        font-weight: 700;
                    }

                    .content-wrapper {
                        padding: 2rem;
                    }

                    /* Mobile Responsive Design for User Dashboard */
                    @media (max-width: 1024px) {
                        .sidebar {
                            transform: translateX(-100%);
                            z-index: 1001;
                        }

                        .sidebar.mobile-open {
                            transform: translateX(0);
                        }

                        .main-content {
                            margin-left: 0;
                            width: 100%;
                        }

                        .sidebar.collapsed + .main-content {
                            margin-left: 0;
                        }

                        .mobile-sidebar-toggle {
                            display: block;
                        }

                        .content-wrapper {
                            padding: 1rem;
                        }

                        .top-navbar {
                            padding: 1rem;
                            flex-wrap: wrap;
                            gap: 1rem;
                        }

                        .top-navbar h4 {
                            font-size: 1.25rem;
                        }

                        .wallet-balance {
                            padding: 0.5rem 1rem;
                            font-size: 0.9rem;
                        }

                        .balance-amount {
                            font-size: 1rem;
                        }
                    }

                    @media (max-width: 768px) {
                        .content-wrapper {
                            padding: 0.75rem;
                        }

                        .top-navbar {
                            padding: 0.75rem;
                            flex-direction: column;
                            align-items: stretch;
                            text-align: center;
                        }

                        .top-navbar .btn-link {
                            align-self: center;
                        }

                        .wallet-balance {
                            align-self: center;
                            max-width: 200px;
                        }
                    }

                    @media (max-width: 576px) {
                        .content-wrapper {
                            padding: 0.5rem;
                        }

                        .top-navbar {
                            padding: 0.5rem;
                        }

                        .top-navbar h4 {
                            font-size: 1.1rem;
                        }

                        .wallet-balance {
                            padding: 0.5rem 0.75rem;
                            font-size: 0.85rem;
                            flex-direction: column;
                            gap: 0.25rem;
                            text-align: center;
                        }

                        .balance-amount {
                            font-size: 0.9rem;
                        }
                    }

                    @media (max-width: 480px) {
                        .sidebar {
                            width: 100%;
                        }

                        .sidebar.collapsed {
                            width: 100%;
                        }

                        .sidebar-header {
                            padding: 1rem;
                        }

                        .sidebar-header .navbar-brand {
                            font-size: 1.25rem;
                        }

                        .sidebar-nav {
                            padding: 0.5rem 0;
                        }

                        .sidebar-item {
                            margin: 0.125rem 0.5rem;
                        }

                        .sidebar-link {
                            padding: 0.75rem 1rem;
                            font-size: 0.9rem;
                        }

                        .sidebar-footer {
                            padding: 1rem;
                        }

                        .user-info {
                            padding: 0.75rem;
                        }

                        .user-avatar {
                            width: 35px;
                            height: 35px;
                            font-size: 1rem;
                        }

                        .user-name {
                            font-size: 0.85rem;
                        }

                        .user-role {
                            font-size: 0.75rem;
                        }
                    }

                    /* Mobile Sidebar Toggle Button */
                    .mobile-sidebar-toggle {
                        display: none;
                        position: fixed;
                        top: 1rem;
                        left: 1rem;
                        z-index: 1002;
                        background: var(--primary-color);
                        border: none;
                        border-radius: 50%;
                        width: 50px;
                        height: 50px;
                        color: white;
                        font-size: 1.2rem;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                        transition: all 0.3s ease;
                    }

                    .mobile-sidebar-toggle:hover {
                        background: var(--secondary-color);
                        transform: scale(1.1);
                    }

                    @media (max-width: 1024px) {
                        .mobile-sidebar-toggle {
                            display: block;
                        }
                    }

                    /* Overlay for mobile sidebar */
                    .sidebar-overlay {
                        display: none;
                        position: fixed;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        background: rgba(0, 0, 0, 0.5);
                        z-index: 1000;
                        opacity: 0;
                        transition: opacity 0.3s ease;
                    }

                    .sidebar-overlay.active {
                        display: block;
                        opacity: 1;
                    }

                    @media (max-width: 1024px) {
                        .sidebar-overlay.active {
                            display: block;
                        }
                    }

                    /* Touch-friendly improvements */
                    @media (max-width: 768px) {
                        .sidebar-link {
                            min-height: 48px;
                            touch-action: manipulation;
                        }

                        .btn {
                            min-height: 44px;
                            touch-action: manipulation;
                        }
                    }

                    /* Landscape orientation adjustments */
                    @media (max-width: 768px) and (orientation: landscape) {
                        .sidebar {
                            width: 280px;
                            transform: translateX(-100%);
                        }

                        .sidebar.mobile-open {
                            transform: translateX(0);
                        }

                        .main-content {
                            margin-left: 0;
                        }

                        .mobile-sidebar-toggle {
                            top: 0.5rem;
                            left: 0.5rem;
                        }
                    }
                </style>

                <!-- User Dashboard JavaScript -->
                <script>
                    // Mobile sidebar functions
                    function toggleMobileSidebar() {
                        const sidebar = document.getElementById('sidebar');
                        const overlay = document.getElementById('sidebarOverlay');
                        
                        if (sidebar && overlay) {
                            sidebar.classList.toggle('mobile-open');
                            overlay.classList.toggle('active');
                        }
                    }

                    function closeMobileSidebar() {
                        const sidebar = document.getElementById('sidebar');
                        const overlay = document.getElementById('sidebarOverlay');
                        
                        if (sidebar && overlay) {
                            sidebar.classList.remove('mobile-open');
                            overlay.classList.remove('active');
                        }
                    }

                    function toggleSidebar() {
                        const sidebar = document.getElementById('sidebar');
                        if (sidebar) {
                            sidebar.classList.toggle('collapsed');
                        }
                    }

                    // Close sidebar on mobile when clicking outside
                    document.addEventListener('click', function(e) {
                        if (window.innerWidth <= 1024) {
                            const sidebar = document.getElementById('sidebar');
                            const mobileToggle = document.getElementById('mobileSidebarToggle');
                            
                            if (sidebar && mobileToggle && !sidebar.contains(e.target) && !mobileToggle.contains(e.target)) {
                                closeMobileSidebar();
                            }
                        }
                    });

                    // Handle window resize for mobile responsiveness
                    window.addEventListener('resize', function() {
                        const sidebar = document.getElementById('sidebar');
                        if (window.innerWidth <= 1024) {
                            if (sidebar) {
                                sidebar.classList.remove('mobile-open');
                                document.getElementById('sidebarOverlay')?.classList.remove('active');
                            }
                        }
                    });
                </script>
            @else
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
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
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
            @endif
        @else
            <!-- Guest Layout -->
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
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            @guest
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
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4">
                @yield('content')
            </main>
        @endauth
    </div>
</body>
</html>
