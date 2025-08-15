<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ShopEase') }} - @yield('page-title', 'Admin Dashboard')</title>

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
            @if(Auth::user()->isAdmin())
                <!-- Admin Layout with Sidebar -->
                <div class="admin-dashboard">
                    <!-- Include Admin Sidebar -->
                    @include('admin.partials.sidebar')

                    <!-- Main Content Area -->
                    <div class="admin-main" id="adminMain">
                        <!-- Top Navigation Bar -->
                        <div class="admin-top-nav">
                            <button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()">
                                <i class="fas fa-bars"></i>
                            </button>
                            <h2>@yield('page-title', 'Admin Dashboard')</h2>
                            <div class="admin-actions">
                                <a href="{{ route('welcome') }}" class="btn btn-primary">
                                    <i class="fas fa-external-link-alt"></i>View Site
                                </a>
                            </div>
                        </div>

                        <!-- Page Content -->
                        <div class="page-content">
                            @yield('content')
                        </div>
                    </div>
                </div>

                <!-- Admin Dashboard CSS -->
                <style>
                    /* Jumia Theme for Admin Dashboard with Sidebar */
                    .admin-dashboard {
                        display: flex;
                        min-height: 100vh;
                        background: #f8f9fa;
                    }

                    /* Main Content Area */
                    .admin-main {
                        flex: 1;
                        margin-left: 280px;
                        transition: all 0.3s ease;
                        padding: 2rem;
                    }

                    .admin-main.expanded {
                        margin-left: 70px;
                    }

                    /* Top Navigation Bar */
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

                    /* Page Content */
                    .page-content {
                        background: white;
                        border-radius: 16px;
                        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                        border: 1px solid #e5e7eb;
                        padding: 2rem;
                        margin-bottom: 2rem;
                    }

                    /* Responsive Design */
                    @media (max-width: 768px) {
                        .admin-main {
                            margin-left: 0;
                            padding: 1rem;
                        }

                        .admin-top-nav {
                            padding: 1rem;
                        }

                        .page-content {
                            padding: 1rem;
                        }
                    }
                </style>

                <!-- Admin Dashboard JavaScript -->
                <script>
                    function toggleSidebar() {
                        const sidebar = document.getElementById('adminSidebar');
                        const main = document.getElementById('adminMain');
                        const toggle = document.getElementById('sidebarToggle');
                        
                        sidebar.classList.toggle('collapsed');
                        main.classList.toggle('expanded');
                        toggle.classList.toggle('collapsed');
                    }

                    // Mobile sidebar toggle
                    function toggleMobileSidebar() {
                        const sidebar = document.getElementById('adminSidebar');
                        sidebar.classList.toggle('mobile-open');
                    }

                    // Close sidebar on outside click (mobile)
                    document.addEventListener('click', function(event) {
                        const sidebar = document.getElementById('adminSidebar');
                        const toggle = document.getElementById('sidebarToggle');
                        
                        if (window.innerWidth <= 768) {
                            if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                                sidebar.classList.remove('mobile-open');
                            }
                        }
                    });

                    // Auto-collapse sidebar on small screens
                    function handleResize() {
                        const sidebar = document.getElementById('adminSidebar');
                        const main = document.getElementById('adminMain');
                        
                        if (window.innerWidth <= 768) {
                            sidebar.classList.remove('collapsed');
                            main.classList.remove('expanded');
                        }
                    }

                    window.addEventListener('resize', handleResize);
                    handleResize(); // Initial check
                </script>
            @else
                <!-- Redirect non-admin users -->
                <script>window.location.href = '{{ route("home") }}';</script>
            @endif
        @else
            <!-- Redirect unauthenticated users -->
            <script>window.location.href = '{{ route("login") }}';</script>
        @endauth
    </div>
</body>
</html>
