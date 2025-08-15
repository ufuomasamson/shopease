<!-- Admin Sidebar -->
<nav class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-header">
        <div class="logo-container">
            <i class="fas fa-shopping-cart"></i>
            <span class="logo-text">ShopEase Admin</span>
        </div>
    </div>

    <div class="sidebar-content">
        <div class="nav-section">
            <h6 class="nav-section-title">Main Menu</h6>
            <ul>
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="fas fa-box"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders') }}" class="sidebar-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Orders</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reviews') }}" class="sidebar-link {{ request()->routeIs('admin.reviews*') ? 'active' : '' }}">
                        <i class="fas fa-star"></i>
                        <span>Reviews</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.chat.index') }}" class="sidebar-link {{ request()->routeIs('admin.chat*') ? 'active' : '' }}">
                        <i class="fas fa-comments"></i>
                        <span>Customer Support</span>
                        @if(auth()->user()->unread_admin_message_count > 0)
                            <span class="badge bg-danger ms-auto">{{ auth()->user()->unread_admin_message_count }}</span>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.fund-wallet') }}" class="sidebar-link {{ request()->routeIs('admin.fund-wallet*') ? 'active' : '' }}">
                        <i class="fas fa-wallet"></i>
                        <span>Fund Wallets</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <h6 class="nav-section-title">Quick Actions</h6>
            <ul>
                <li>
                    <a href="{{ route('admin.products.create') }}" class="sidebar-link {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                        <i class="fas fa-plus-circle"></i>
                        <span>Add Product</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.categories-brands') }}" class="sidebar-link {{ request()->routeIs('admin.categories-brands') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i>
                        <span>Categories & Brands</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('welcome') }}" class="sidebar-link">
                        <i class="fas fa-home"></i>
                        <span>View Site</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="sidebar-footer">
        <div class="admin-user-info">
            <div class="admin-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="admin-user-details">
                <h6>{{ Auth::user()->name }}</h6>
                <p>Administrator</p>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Sidebar Toggle -->
<button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

<style>
/* Admin Sidebar Styles */
.admin-sidebar {
    width: 280px;
    height: 100vh;
    background: white;
    border-right: 1px solid #e5e7eb;
    position: fixed;
    left: 0;
    top: 0;
    z-index: 1000;
    transition: all 0.3s ease;
    overflow-y: auto;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
}

.admin-sidebar.collapsed {
    width: 70px;
}

.admin-sidebar.collapsed .logo-text,
.admin-sidebar.collapsed .nav-section-title,
.admin-sidebar.collapsed .sidebar-link span,
.admin-sidebar.collapsed .admin-user-details {
    display: none;
}

.sidebar-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
    color: white;
}

.logo-container {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 1.2rem;
    font-weight: 700;
}

.logo-container i {
    font-size: 1.5rem;
}

.sidebar-content {
    padding: 1.5rem 0;
    flex: 1;
}

.nav-section {
    margin-bottom: 2rem;
}

.nav-section-title {
    color: #6b7280;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0 1.5rem 1rem 1.5rem;
}

.nav-section ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.nav-section li {
    margin: 0;
}

.sidebar-link {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.5rem;
    color: #111827 !important;
    text-decoration: none;
    transition: all 0.3s ease;
    border-radius: 0;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    background: transparent !important;
    border: none;
    font-weight: 600 !important;
    border-left: 3px solid transparent;
}

.sidebar-link:hover {
    background: #f8f9fa !important;
    color: #f68b1e !important;
    text-decoration: none;
    border-left-color: #f68b1e;
}

.sidebar-link.active {
    background: #f8f9fa !important;
    color: #f68b1e !important;
    border-left-color: #f68b1e;
}

.sidebar-link i {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
    color: inherit !important;
}

.sidebar-link span {
    font-weight: 600;
    font-size: 0.95rem;
    color: inherit !important;
}

.sidebar-footer {
    padding: 1.5rem;
    border-top: 1px solid #e5e7eb;
    background: #f8f9fa;
    margin-top: auto;
}

.admin-user-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: white;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
}

.admin-avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.admin-user-details h6 {
    margin: 0;
    color: #111827;
    font-weight: 700;
    font-size: 0.9rem;
    white-space: nowrap;
    overflow: hidden;
}

.admin-user-details p {
    margin: 0;
    color: #6b7280;
    font-size: 0.8rem;
    white-space: nowrap;
    overflow: hidden;
}

/* Sidebar Toggle Button */
.sidebar-toggle {
    position: fixed;
    top: 1rem;
    left: 1rem;
    z-index: 1001;
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

.sidebar-toggle.collapsed {
    left: 1rem;
}

/* Main Content Adjustment */
.admin-main {
    margin-left: 280px;
    transition: all 0.3s ease;
    padding: 2rem;
    min-height: 100vh;
    width: calc(100% - 280px);
}

.admin-main.expanded {
    margin-left: 70px;
    width: calc(100% - 70px);
}

/* Container adjustments for admin pages */
.container-fluid {
    margin-left: 0 !important;
    padding-left: 0 !important;
}

.row {
    margin-left: 0 !important;
}

/* Ensure proper spacing for all admin content */
.col-md-9.ms-sm-auto.col-lg-10.px-md-4 {
    margin-left: 0 !important;
    padding-left: 0 !important;
    width: 100% !important;
}

/* Body adjustments for admin pages */
body {
    overflow-x: hidden;
}

/* Ensure sidebar doesn't interfere with page content */
.admin-sidebar {
    z-index: 1000;
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    overflow-y: auto;
}

/* Main content area adjustments */
.admin-main {
    position: relative;
    z-index: 1;
}

/* Ensure all admin pages have proper spacing */
.admin-main > * {
    max-width: 100%;
    overflow-x: hidden;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .admin-sidebar {
        transform: translateX(-100%);
    }
    
    .admin-sidebar.mobile-open {
        transform: translateX(0);
    }
    
    .admin-main {
        margin-left: 0;
        padding: 1rem;
    }
    
    .sidebar-toggle {
        display: block;
    }
}

@media (min-width: 769px) {
    .sidebar-toggle {
        display: none;
    }
}
</style>

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

// Handle window resize
window.addEventListener('resize', function() {
    const sidebar = document.getElementById('adminSidebar');
    if (window.innerWidth > 768) {
        sidebar.classList.remove('mobile-open');
    }
});
</script>
