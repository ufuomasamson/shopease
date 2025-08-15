@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('styles')
<style>
/* Cache Buster: {{ time() }} - Force Refresh */
    /* Jumia Theme for User Dashboard */
    .dashboard-container {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
        display: flex;
    }

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
        max-width: 1200px;
        margin: 0 auto;
        width: 100%;
    }

    /* Stats Grid with Jumia Theme */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
        justify-content: center;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
        text-align: center;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        border-color: #f68b1e;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin: 0 auto 1rem;
    }

    .stat-icon.products { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); }
    .stat-icon.wallet { background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%); }
    .stat-icon.orders { background: linear-gradient(135deg, #059669 0%, #10b981 100%); }
    .stat-icon.arrivals { background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: #6b7280;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Search and Filter Bar */
    .search-filter-bar {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        max-width: 100%;
    }

    .search-input {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        width: 100%;
    }

    .search-input:focus {
        outline: none;
        border-color: #f68b1e;
        box-shadow: 0 0 0 3px rgba(246, 139, 30, 0.1);
    }

    .filter-select {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        background: white;
        transition: all 0.3s ease;
    }

    .filter-select:focus {
        outline: none;
        border-color: #f68b1e;
        box-shadow: 0 0 0 3px rgba(246, 139, 30, 0.1);
    }

    /* Product Grid with Jumia Theme */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
        justify-content: center;
    }

    /* Force 2 columns on mobile devices like Jumia */
    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 1rem;
        }
    }

    @media (max-width: 576px) {
        .product-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 0.75rem;
        }
    }

    .product-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        border-color: #f68b1e;
    }

    .product-image-container {
        position: relative;
        height: 200px;
        overflow: hidden;
        background: #f8f9fa;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    .product-icon-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        color: #9ca3af;
        font-size: 3rem;
    }

    .product-card-body {
        padding: 1.5rem;
    }

    .product-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .product-description {
        color: #6b7280;
        font-size: 0.875rem;
        margin-bottom: 1rem;
        line-height: 1.5;
    }
    
    /* Product Reviews Summary */
    .product-reviews-summary {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 1rem;
        padding: 8px 0;
    }
    
    .reviews-rating {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .reviews-rating .fa-star {
        font-size: 14px;
        color: #ffc107;
    }
    
    .rating-text {
        font-weight: 600;
        color: #111827;
        font-size: 14px;
    }

    /* Featured Products Header */
    .featured-products-header {
        max-width: 100%;
        margin: 0 auto 2rem auto;
    }
    
    .reviews-count {
        color: #6b7280;
        font-size: 12px;
        font-weight: 500;
    }
    
    .product-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .product-price {
        font-size: 1.25rem;
        font-weight: 800;
        color: #f68b1e;
    }

    .product-stock {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 500;
    }

    .product-actions {
        display: flex;
        gap: 0.75rem;
    }

    .btn-view {
        background: transparent;
        color: #f68b1e;
        border: 2px solid #f68b1e;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        transition: all 0.3s ease;
        flex: 1;
        text-align: center;
    }

    .btn-view:hover {
        background: #f68b1e;
        color: white;
        transform: translateY(-2px);
    }

    .btn-buy {
        background: #f68b1e;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        transition: all 0.3s ease;
        flex: 1;
        text-align: center;
    }

    .btn-buy:hover {
        background: #e67e22;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(246, 139, 30, 0.4);
    }

    /* Quick Actions */
    .quick-actions {
        margin-top: 2rem;
    }

    .quick-actions h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 1.5rem;
    }

    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .quick-action-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        text-decoration: none;
        color: inherit;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .quick-action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        border-color: #f68b1e;
        text-decoration: none;
        color: inherit;
    }

    .quick-action-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #f68b1e 0%, #e67e22 100%);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .quick-action-card:hover::before {
        transform: scaleX(1);
    }

    .quick-action-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin: 0 auto 1rem;
    }

    .quick-action-card h4 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 0.5rem;
    }

    .quick-action-card p {
        color: #6b7280;
        font-size: 0.875rem;
        margin: 0;
    }

    /* Responsive Design */
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

        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .product-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .content-wrapper {
            padding: 1rem;
            max-width: 100%;
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
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        
        .product-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 0.75rem;
        }
        
        .quick-actions-grid {
            grid-template-columns: 1fr;
        }
        
        .search-filter-bar {
            padding: 1rem;
        }
        
        .product-card-body {
            padding: 1rem;
        }

        .content-wrapper {
            padding: 1rem;
            max-width: 100%;
        }



        .wallet-balance {
            align-self: center;
            max-width: 200px;
        }

        .filter-controls {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .search-box {
            width: 100%;
        }

        .filter-select {
            width: 100%;
        }

        .product-title {
            font-size: 1rem;
        }

        .product-description {
            font-size: 0.8rem;
        }

        .product-actions {
            flex-direction: column;
            gap: 0.5rem;
        }

        .product-actions .btn-view,
        .product-actions .btn-buy {
            width: 100%;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        .product-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 0.75rem;
        }

        .content-wrapper {
            padding: 0.5rem;
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

        .stat-card {
            padding: 0.75rem;
        }

        .stat-card h3 {
            font-size: 1.5rem;
        }

        .stat-card p {
            font-size: 0.9rem;
        }

        .product-grid {
            gap: 0.5rem;
        }

        .product-image-container {
            height: 180px;
        }

        .product-card-body {
            padding: 0.75rem;
        }

        .product-title {
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
            line-height: 1.3;
        }

        .product-description {
            font-size: 0.75rem;
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .product-meta {
            margin-bottom: 0.75rem;
        }

        .product-price {
            font-size: 1rem;
        }

        .product-stock {
            font-size: 0.75rem;
        }

        .product-actions {
            gap: 0.25rem;
        }

        .btn-view,
        .btn-buy {
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
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

        .stats-grid {
            gap: 0.5rem;
        }

        .stat-card {
            padding: 0.75rem;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
        }

        .stat-card h3 {
            font-size: 1.25rem;
        }

        .stat-card p {
            font-size: 0.8rem;
        }

        .product-grid {
            gap: 0.5rem;
        }

        .product-image-container {
            height: 180px;
        }

        .product-card-body {
            padding: 0.5rem;
        }

        .product-title {
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .product-description {
            font-size: 0.7rem;
            margin-bottom: 0.5rem;
        }

        .product-meta {
            margin-bottom: 0.75rem;
        }

        .product-price {
            font-size: 1rem;
        }

        .product-stock {
            font-size: 0.75rem;
        }

        .product-actions {
            gap: 0.25rem;
        }

        .btn-view,
        .btn-buy {
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
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

        .btn,
        .btn-view,
        .btn-buy {
            min-height: 44px;
            touch-action: manipulation;
        }

        .filter-select,
        .search-box {
            min-height: 44px;
            touch-action: manipulation;
        }

        .modal-dialog {
            max-width: calc(100vw - 2rem);
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
            width: 100vw;
            justify-content: flex-start;
        }

        .mobile-sidebar-toggle {
            top: 0.5rem;
            left: 0.5rem;
        }
    }

    /* High DPI displays */
    @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
        .product-image {
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
        }
    }

    /* Print styles */
    @media print {
        .sidebar,
        .mobile-sidebar-toggle,
        .top-navbar,
        .product-actions,
        .modal {
            display: none !important;
        }

        .main-content {
            margin-left: 0 !important;
            width: 100% !important;
        }

        .product-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        .product-card {
            break-inside: avoid;
            box-shadow: none;
            border: 1px solid #ccc;
        }
    }

    /* Animations */
    .fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Loading States */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    .loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid #e5e7eb;
        border-top: 2px solid #f68b1e;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endsection

@section('content')
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
            <li class="sidebar-item active">
                <a href="{{ route('home') }}" class="sidebar-link">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('products.index') }}" class="sidebar-link">
                    <i class="fas fa-box"></i>
                    <span>Products</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('orders.index') }}" class="sidebar-link">
                    <i class="fas fa-shopping-bag"></i>
                    <span>My Orders</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('wallet.show') }}" class="sidebar-link">
                    <i class="fas fa-wallet"></i>
                    <span>My Wallet</span>
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
        <div class="content-wrapper">
    <!-- Debug Information (remove this after fixing) -->
    @if(config('app.debug'))
    <div class="alert alert-info mb-4">
        <h6>Debug Info:</h6>
        <p><strong>Storage Link:</strong> {{ file_exists(public_path('storage')) ? 'Exists' : 'Missing' }}</p>
        <p><strong>Products Count:</strong> {{ $latestProducts->count() }}</p>
        @if($latestProducts->count() > 0)
            @php $firstProduct = $latestProducts->first(); @endphp
            <p><strong>First Product Image:</strong> {{ $firstProduct->image ?? 'No image' }}</p>
            <p><strong>Storage URL:</strong> {{ $firstProduct->image ? Storage::url($firstProduct->image) : 'N/A' }}</p>
            <p><strong>Full Path:</strong> {{ $firstProduct->image ? storage_path('app/public/' . $firstProduct->image) : 'N/A' }}</p>
            <p><strong>File Exists:</strong> {{ $firstProduct->image ? (file_exists(storage_path('app/public/' . $firstProduct->image)) ? 'Yes' : 'No') : 'N/A' }}</p>
        @endif
    </div>
    @endif

<!-- Dashboard Stats -->
<div class="stats-grid">
    <div class="stat-card fade-in">
        <div class="stat-icon products">
            <i class="fas fa-box"></i>
        </div>
        <div class="stat-value">{{ $latestProducts->count() }}</div>
        <div class="stat-label">Available Products</div>
    </div>
    
    <div class="stat-card fade-in">
        <div class="stat-icon wallet">
            <i class="fas fa-wallet"></i>
        </div>
        <div class="stat-value">${{ number_format(Auth::user()->wallet->balance ?? 0, 2) }}</div>
        <div class="stat-label">Wallet Balance</div>
    </div>
    
    <div class="stat-card fade-in">
        <div class="stat-icon orders">
            <i class="fas fa-shopping-bag"></i>
        </div>
        <div class="stat-value">{{ Auth::user()->orders->count() }}</div>
        <div class="stat-label">Total Orders</div>
    </div>
    
    <div class="stat-card fade-in">
        <div class="stat-icon arrivals">
            <i class="fas fa-star"></i>
        </div>
        <div class="stat-value">New</div>
        <div class="stat-label">Latest Arrivals</div>
    </div>
</div>

<!-- Search and Filter Bar -->
<div class="search-filter-bar">
    <div class="row g-3">
        <div class="col-md-6">
            <input type="text" class="form-control search-input" placeholder="Search products..." id="searchInput">
        </div>
        <div class="col-md-3">
            <select class="form-select filter-select" id="sortSelect">
                <option value="">Sort by</option>
                <option value="price_low">Price: Low to High</option>
                <option value="price_high">Price: High to Low</option>
                <option value="newest">Newest First</option>
                <option value="name">Name A-Z</option>
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-select filter-select" id="categorySelect">
                <option value="">All Categories</option>
                <option value="digital">Digital Products</option>
                <option value="software">Software</option>
                <option value="courses">Online Courses</option>
                <option value="templates">Templates</option>
            </select>
        </div>
    </div>
</div>

<!-- Featured Products Section -->
<div class="d-flex justify-content-between align-items-center mb-4 featured-products-header">
    <h3 class="mb-0">
        <i class="fas fa-star text-warning me-2"></i>
        Featured Products
    </h3>
    <a href="{{ route('products.index') }}" class="btn btn-primary">
        <i class="fas fa-th-large me-2"></i>View All Products
    </a>
</div>

<!-- Products Grid -->
<div class="product-grid" id="productsGrid">
    @forelse($latestProducts as $product)
    <div class="product-card fade-in" data-product-name="{{ strtolower($product->title) }}" data-product-category="digital">
        <div class="product-image-container">
            @if($product->image)
                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->title }}" class="product-image" 
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="product-icon-placeholder" style="display: none;">
                    <i class="fas fa-file-alt"></i>
                </div>
            @else
                <div class="product-icon-placeholder">
                    <i class="fas fa-file-alt"></i>
                </div>
            @endif
        </div>
        
        <div class="product-card-body">
            <h5 class="product-title">{{ $product->title }}</h5>
            <p class="product-description">{{ Str::limit($product->description, 120) }}</p>
            
            <!-- Product Reviews Summary -->
            @if($product->review_count > 0)
                <div class="product-reviews-summary">
                    <div class="reviews-rating">
                        {!! $product->star_rating !!}
                        <span class="rating-text">{{ number_format($product->average_rating, 1) }}</span>
                    </div>
                    <div class="reviews-count">
                        ({{ $product->review_count }} review{{ $product->review_count > 1 ? 's' : '' }})
                    </div>
                </div>
            @endif
            
            <div class="product-meta">
                <span class="product-price">${{ number_format($product->price, 2) }}</span>
                <span class="product-stock">{{ $product->stock_quantity }} in stock</span>
            </div>
            
            <div class="product-actions">
                <a href="{{ route('products.show', $product) }}" class="btn-view">
                    <i class="fas fa-eye me-1"></i>View Details
                </a>
                @if($product->stock_quantity > 0)
                    <button type="button" class="btn-buy" data-bs-toggle="modal" data-bs-target="#buyModal{{ $product->id }}">
                        <i class="fas fa-shopping-cart me-1"></i>Buy Now
                    </button>
                @else
                    <button class="btn-buy" disabled>
                        <i class="fas fa-times me-1"></i>Out of Stock
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Buy Modal -->
    @if($product->stock_quantity > 0)
        <div class="modal fade" id="buyModal{{ $product->id }}" tabindex="-1" aria-labelledby="buyModalLabel{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="buyModalLabel{{ $product->id }}">
                            <i class="fas fa-shopping-cart me-2"></i>Buy {{ $product->title }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="quantity{{ $product->id }}" class="form-label">Quantity</label>
                                    <input type="number" class="form-control" id="quantity{{ $product->id }}" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" required>
                                    <div class="form-text">Available: {{ $product->stock_quantity }} units</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Unit Price</label>
                                    <div class="form-control-plaintext">
                                        @if($product->hasDiscount())
                                            <span class="text-decoration-line-through text-muted">${{ number_format($product->price, 2) }}</span>
                                            <span class="text-danger fw-bold">${{ number_format($product->final_price, 2) }}</span>
                                            <span class="badge bg-danger ms-2">{{ $product->discount_percentage }}% OFF</span>
                                        @else
                                            ${{ number_format($product->price, 2) }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert alert-info">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>Total Price:</strong>
                                    <span class="h5 mb-0">$<span id="totalPrice{{ $product->id }}">
                                        @if($product->hasDiscount())
                                            {{ number_format($product->final_price, 2) }}
                                        @else
                                            {{ number_format($product->price, 2) }}
                                        @endif
                                    </span></span>
                                </div>
                            </div>
                            
                            <div class="alert alert-warning">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Digital Product:</strong> You'll receive instant access after purchase.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-credit-card me-2"></i>Confirm Purchase
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('quantity{{ $product->id }}').addEventListener('change', function() {
                const quantity = this.value;
                const price = {{ $product->hasDiscount() ? $product->final_price : $product->price }};
                const total = quantity * price;
                document.getElementById('totalPrice{{ $product->id }}').textContent = total.toFixed(2);
            });
        </script>
    @endif
    @empty
    <div class="col-12">
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle fa-2x mb-3"></i>
            <h5>No products available at the moment.</h5>
            <p class="mb-0">Check back soon for new digital products!</p>
        </div>
    </div>
    @endforelse
</div>

<!-- Quick Actions Section -->
<div class="row mt-5">
    <div class="col-12">
        <h4 class="mb-4">
            <i class="fas fa-bolt text-warning me-2"></i>
            Quick Actions
        </h4>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="feature-icon mb-3">
                    <i class="fas fa-wallet text-primary" style="font-size: 2.5rem;"></i>
                </div>
                <h5 class="card-title">Check Wallet</h5>
                <p class="card-text text-muted">View your balance and transaction history</p>
                <a href="{{ route('wallet.show') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-right me-2"></i>Go to Wallet
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="feature-icon mb-3">
                    <i class="fas fa-shopping-bag text-success" style="font-size: 2.5rem;"></i>
                </div>
                <h5 class="card-title">My Orders</h5>
                <p class="card-text text-muted">Track your purchases and downloads</p>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-success">
                    <i class="fas fa-arrow-right me-2"></i>View Orders
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="feature-icon mb-3">
                    <i class="fas fa-box text-info" style="font-size: 2.5rem;"></i>
                </div>
                <h5 class="card-title">Browse All</h5>
                <p class="card-text text-muted">Explore our complete product catalog</p>
                <a href="{{ route('products.index') }}" class="btn btn-outline-info">
                    <i class="fas fa-arrow-right me-2"></i>Browse Products
                </a>
            </div>
        </div>
    </div>
</div>
        </div> <!-- End of content-wrapper -->
        </div> <!-- End of main-content -->
    </div> <!-- End of dashboard-container -->
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');
    const categorySelect = document.getElementById('categorySelect');
    const productsGrid = document.getElementById('productsGrid');
    
    // Search functionality
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const productCards = productsGrid.querySelectorAll('.product-card');
            
            productCards.forEach(card => {
                const productName = card.dataset.productName;
                if (productName.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
    
    // Sort functionality
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortValue = this.value;
            const productCards = Array.from(productsGrid.querySelectorAll('.product-card'));
            
            productCards.sort((a, b) => {
                const priceA = parseFloat(a.querySelector('.product-price').textContent.replace('$', ''));
                const priceB = parseFloat(b.querySelector('.product-price').textContent.replace('$', ''));
                
                switch(sortValue) {
                    case 'price_low':
                        return priceA - priceB;
                    case 'price_high':
                        return priceB - priceA;
                    case 'name':
                        const nameA = a.querySelector('.product-title').textContent.toLowerCase();
                        const nameB = b.querySelector('.product-title').textContent.toLowerCase();
                        return nameA.localeCompare(nameB);
                    default:
                        return 0;
                }
            });
            
            // Reorder products in the grid
            productCards.forEach(card => productsGrid.appendChild(card));
        });
    }
    
    // Category filter functionality
    if (categorySelect) {
        categorySelect.addEventListener('change', function() {
            const categoryValue = this.value;
            const productCards = productsGrid.querySelectorAll('.product-card');
            
            productCards.forEach(card => {
                const productCategory = card.dataset.productCategory;
                if (!categoryValue || productCategory === categoryValue) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

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

    // Initialize mobile state
    if (window.innerWidth <= 768) {
        sidebar.classList.add('collapsed');
    }
});

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
@endsection
