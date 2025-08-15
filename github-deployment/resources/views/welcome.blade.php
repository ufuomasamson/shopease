<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ShopEase') }} - Your Ultimate Shopping Destination</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jumia-theme.css') }}" rel="stylesheet">
    
    <style>
        /* Jumia-Style Homepage Styling */
        :root {
            --primary-color: #f68b1e;
            --secondary-color: #e67e22;
            --accent-color: #ff6b35;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --dark-color: #343a40;
            --light-color: #f8f9fa;
            --white-color: #ffffff;
            --text-primary: #212529;
            --text-secondary: #6c757d;
            --text-muted: #adb5bd;
            --border-color: #dee2e6;
            --shadow-light: 0 2px 10px rgba(0,0,0,0.1);
            --shadow-medium: 0 4px 20px rgba(0,0,0,0.15);
            --shadow-heavy: 0 8px 30px rgba(0,0,0,0.2);
            --gradient-primary: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);
            --gradient-secondary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-success: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }

        /* Global Styles */
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-primary);
            background-color: var(--light-color);
        }

        .btn {
            border-radius: 8px;
            font-weight: 600;
            padding: 12px 24px;
            transition: all 0.3s ease;
            border: none;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        .btn-primary {
            background: var(--gradient-primary);
            border: none;
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--gradient-primary);
            border-color: var(--primary-color);
        }

        /* Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
        }





        .navbar-brand {
            color: var(--primary-color) !important;
            font-weight: 800;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-primary) !important;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        /* Hero Banner */
        .hero-banner {
            margin-top: 76px;
            overflow: hidden;
        }

        .hero-slide {
            position: relative;
            min-height: 75vh;
            display: flex;
            align-items: center;
            background: var(--gradient-primary);
            overflow: hidden;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            font-weight: 400;
            margin-bottom: 2rem;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .hero-image {
            max-width: 100%;
            height: auto;
            border-radius: 20px;
            box-shadow: var(--shadow-heavy);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        /* Category Navigation */
        .category-nav {
            background: var(--white-color);
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow-light);
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .category-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1rem;
            text-decoration: none;
            color: var(--text-primary);
            border-radius: 12px;
            transition: all 0.3s ease;
            background: var(--white-color);
            border: 1px solid transparent;
        }

        .category-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-medium);
            border-color: var(--primary-color);
            color: var(--primary-color);
            text-decoration: none;
        }

        .category-icon {
            width: 50px;
            height: 50px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .category-name {
            font-weight: 600;
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 0.25rem;
        }

        .category-count {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-align: center;
        }

        /* Section Headers */
        .section-header {
            margin-bottom: 3rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: var(--text-secondary);
            font-weight: 400;
        }

        /* Featured Products */
        .featured-products {
            background: var(--white-color);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .product-card {
            background: var(--white-color);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-light);
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-heavy);
            border-color: var(--primary-color);
        }

        .product-image {
            position: relative;
            height: 200px;
            overflow: hidden;
            background: var(--light-color);
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .product-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 3rem;
        }

        .discount-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--danger-color);
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .product-info {
            padding: 1.5rem;
        }

        .product-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
            line-height: 1.3;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .product-rating .fa-star {
            color: var(--warning-color);
            font-size: 14px;
        }

        .rating-text {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .no-rating {
            font-size: 0.9rem;
            color: var(--text-muted);
            font-style: italic;
        }

        .product-price {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .original-price {
            text-decoration: line-through;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .final-price {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--primary-color);
        }

        .product-actions {
            display: flex;
            gap: 0.5rem;
        }

        .product-actions .btn {
            flex: 1;
            padding: 8px 16px;
            font-size: 0.9rem;
        }

        /* Deals Section */
        .deals-section {
            background: var(--light-color);
        }

        .deals-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .deal-card {
            background: var(--white-color);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-light);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .deal-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-heavy);
            border-color: var(--danger-color);
        }

        .deal-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .deal-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .deal-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 3rem;
            background: var(--light-color);
        }

        .deal-timer {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(220, 53, 69, 0.9);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .deal-info {
            padding: 1.5rem;
        }

        .deal-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .deal-price {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .deal-actions .btn {
            width: 100%;
            background: var(--danger-color);
            border: none;
        }

        /* Newsletter Section */
        .newsletter-section {
            background: var(--gradient-primary);
        }

        .newsletter-form .input-group {
            max-width: 500px;
            margin: 0 auto;
        }

        .newsletter-form .form-control {
            border: none;
            border-radius: 8px 0 0 8px;
            padding: 15px 20px;
            font-size: 1rem;
        }

        .newsletter-form .btn {
            border-radius: 0 8px 8px 0;
            padding: 15px 20px;
            font-weight: 600;
        }

        /* Footer */
        .footer {
            background: var(--dark-color);
            position: relative;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary-color), transparent);
        }

        .footer-section {
            height: 100%;
        }

        .footer-brand {
            display: flex;
            align-items: center;
        }

        .footer-brand i {
            color: var(--primary-color);
        }

        .footer-title {
            color: var(--white-color);
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 30px;
            height: 2px;
            background: var(--primary-color);
            border-radius: 1px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            position: relative;
            padding-left: 0;
        }

        .footer-links a::before {
            content: '→';
            position: absolute;
            left: -15px;
            opacity: 0;
            transition: all 0.3s ease;
            color: var(--primary-color);
        }

        .footer-links a:hover {
            color: var(--primary-color);
            padding-left: 15px;
        }

        .footer-links a:hover::before {
            opacity: 1;
        }

        .social-links {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }

        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, 0.08);
            color: var(--text-muted);
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .social-link:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(246, 139, 30, 0.4);
            border-color: var(--primary-color);
        }

        /* Footer Newsletter */
        .footer-newsletter {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-newsletter h6 {
            color: var(--white-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .newsletter-form-footer .input-group {
            max-width: 100%;
        }

        .newsletter-form-footer .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--white-color);
            border-radius: 8px 0 0 8px;
        }

        .newsletter-form-footer .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .newsletter-form-footer .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(246, 139, 30, 0.25);
        }

        .newsletter-form-footer .btn {
            border-radius: 0 8px 8px 0;
            background: var(--gradient-primary);
            border: none;
            font-weight: 600;
        }

        /* Footer Divider */
        .footer-divider {
            border-color: rgba(255, 255, 255, 0.1);
            margin: 2rem 0;
        }

        /* Bottom Footer */
        .footer-bottom-left p {
            font-size: 0.9rem;
        }

        .footer-legal a {
            font-size: 0.85rem;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-legal a:hover {
            color: var(--primary-color);
        }

        .footer-payment h6 {
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .payment-methods-img {
            height: 35px;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .payment-methods-img:hover {
            opacity: 1;
        }

        .footer-apps h6 {
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .app-buttons .btn {
            font-size: 0.8rem;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .app-buttons .btn:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .footer-languages .form-select {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--white-color);
            font-size: 0.85rem;
            border-radius: 6px;
            padding: 0.375rem 0.75rem;
        }

        .footer-languages .form-select:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(246, 139, 30, 0.25);
        }

        .footer-languages .form-select option {
            background: var(--dark-color);
            color: var(--white-color);
        }

        /* Responsive Footer */
        @media (max-width: 768px) {
            .footer-newsletter {
                padding: 1.5rem;
            }

            .footer-bottom-left,
            .footer-payment,
            .footer-bottom-right {
                text-align: center !important;
            }

            .footer-legal {
                justify-content: center;
                display: flex;
                flex-wrap: wrap;
                gap: 1rem;
            }

            .social-links {
                justify-content: center;
            }

            .app-buttons {
                justify-content: center;
                display: flex;
                gap: 0.5rem;
            }
        }

        @media (max-width: 576px) {
            .footer-newsletter {
                padding: 1rem;
            }

            .footer-newsletter .row {
                text-align: center;
            }

            .newsletter-form-footer .input-group {
                flex-direction: column;
            }

            .newsletter-form-footer .form-control,
            .newsletter-form-footer .btn {
                border-radius: 8px;
                margin-bottom: 0.5rem;
            }

            .footer-legal a {
                display: block;
                margin-bottom: 0.5rem;
            }
        }

        /* No Products State */
        .no-products {
            padding: 3rem 1rem;
        }

        .no-products i {
            color: var(--text-muted);
            margin-bottom: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1rem;
            }

            .deals-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 1rem;
            }

            .category-grid {
                grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
                gap: 0.5rem;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: stretch;
            }

            .hero-buttons .btn {
                margin: 0.5rem 0;
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 2rem;
            }

            .section-title {
                font-size: 1.75rem;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }

            .deals-grid {
                grid-template-columns: 1fr;
            }

            .category-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Smooth Animations */
        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Loading States */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        /* Hover Effects */
        .hover-lift {
            transition: transform 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--light-color);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-color);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3 text-primary" href="{{ url('/') }}">
                <i class="fas fa-shopping-bag me-2"></i>ShopEase
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#products">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#deals">Deals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#categories">Categories</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center">
                    <!-- Page Translator -->
                    <div class="me-3">
                        @include('components.page-translator')
                    </div>
                    
                    <div class="d-flex">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                        @else
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Admin Dashboard</a>
                            @else
                                <a href="{{ route('home') }}" class="btn btn-primary">Dashboard</a>
                            @endif
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Banner Section -->
    <section id="home" class="hero-banner pt-5 mt-5">
        <div class="container-fluid p-0">
            <div class="hero-slider">
                <!-- Banner 1 -->
                <div class="hero-slide active" style="background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);">
                    <div class="hero-content">
                        <div class="container">
                            <div class="row align-items-center min-vh-75">
                                <div class="col-lg-6">
                                    <h1 class="hero-title text-white mb-4">
                                        Discover Amazing <span class="fw-bold">Products</span>
                                    </h1>
                                    <p class="hero-subtitle text-white-50 mb-4">
                                        Shop the latest trends with unbeatable prices. Fast delivery, secure payments, and exceptional quality.
                                    </p>
                                    <div class="hero-buttons">
                                        <a href="{{ route('products.index') }}" class="btn btn-light btn-lg me-3">
                                            <i class="fas fa-shopping-cart me-2"></i>Shop Now
                                        </a>
                                        <a href="#deals" class="btn btn-outline-light btn-lg">
                                            <i class="fas fa-fire me-2"></i>View Deals
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-6 text-center">
                                    <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" 
                                         alt="Shopping" class="hero-image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Navigation -->
    <section class="category-nav py-4 bg-white">
        <div class="container">
            <div class="category-grid">
                @foreach($categories as $category)
                <a href="{{ route('products.index') }}?category={{ $category->id }}" class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-tag"></i>
                    </div>
                    <div class="category-name">{{ $category->name }}</div>
                    <div class="category-count">{{ $category->products_count }} items</div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section id="products" class="featured-products py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="section-title">Featured Products</h2>
                <p class="section-subtitle">Handpicked products for you</p>
            </div>
            
            @if($featuredProducts->count() > 0)
                <div class="products-grid">
                    @foreach($featuredProducts as $product)
                    <div class="product-card">
                        <div class="product-image">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->title }}">
                            @else
                                <div class="product-placeholder">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                            @if($product->hasDiscount())
                                <div class="discount-badge">{{ $product->discount_percentage }}% OFF</div>
                            @endif
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">{{ $product->title }}</h3>
                            <div class="product-rating">
                                @if($product->review_count > 0)
                                    {!! $product->star_rating !!}
                                    <span class="rating-text">({{ $product->review_count }})</span>
                                @else
                                    <span class="no-rating">No reviews yet</span>
                                @endif
                            </div>
                            <div class="product-price">
                                @if($product->hasDiscount())
                                    <span class="original-price">${{ number_format($product->price, 2) }}</span>
                                    <span class="final-price">${{ number_format($product->final_price, 2) }}</span>
                                @else
                                    <span class="final-price">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                            <div class="product-actions">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-primary btn-sm">View Details</a>
                                @if($product->stock_quantity > 0)
                                    <button class="btn btn-success btn-sm" onclick="addToCart({{ $product->id }})">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>Out of Stock</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="text-center mt-4">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg">
                        View All Products <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            @else
                <div class="no-products text-center">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h4>No Featured Products Yet</h4>
                    <p class="text-muted">Check back soon for amazing products!</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Deals Section -->
    <section id="deals" class="deals-section py-5 bg-light">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="section-title">🔥 Hot Deals</h2>
                <p class="section-subtitle">Limited time offers you can't miss</p>
            </div>
            
            @if($latestProducts->count() > 0)
                <div class="deals-grid">
                    @foreach($latestProducts as $product)
                    <div class="deal-card">
                        <div class="deal-image">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->title }}">
                            @else
                                <div class="deal-placeholder">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                            <div class="deal-timer">
                                <i class="fas fa-clock"></i> Ends Soon
                            </div>
                        </div>
                        <div class="deal-info">
                            <h3 class="deal-title">{{ $product->title }}</h3>
                            <div class="deal-price">
                                @if($product->hasDiscount())
                                    <span class="original-price">${{ number_format($product->price, 2) }}</span>
                                    <span class="final-price">${{ number_format($product->final_price, 2) }}</span>
                                @else
                                    <span class="final-price">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                            <div class="deal-actions">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-danger btn-sm">Shop Now</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Newsletter Section -->
    <section id="newsletter" class="newsletter-section py-5" style="background: linear-gradient(135deg, #f68b1e 0%, #e67e22 100%);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h3 class="text-white mb-3">Stay Updated with Latest Deals!</h3>
                    <p class="text-white-50 mb-4">Subscribe to our newsletter and never miss out on amazing offers</p>
                    <div class="newsletter-form">
                        <div class="input-group">
                            <input type="email" class="form-control form-control-lg" placeholder="Enter your email address">
                            <button class="btn btn-light btn-lg" type="button">
                                Subscribe <i class="fas fa-paper-plane ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer bg-dark text-white py-5">
        <div class="container">
            <!-- Main Footer Content -->
            <div class="row g-4 mb-4">
                <!-- Company Information -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="footer-section">
                        <div class="footer-brand mb-3">
                            <i class="fas fa-shopping-bag fa-2x text-primary me-2"></i>
                            <h5 class="mb-0">ShopEase</h5>
                        </div>
                        <p class="text-muted mb-3">Your ultimate shopping destination for quality products and amazing deals. We bring you the best prices and fastest delivery.</p>
                        <div class="social-links">
                            <a href="#" class="social-link" title="Follow us on Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link" title="Follow us on Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-link" title="Follow us on Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link" title="Follow us on LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="social-link" title="Subscribe to our YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-section">
                        <h6 class="footer-title mb-3">Quick Links</h6>
                        <ul class="footer-links">
                            <li><a href="#home">Home</a></li>
                            <li><a href="#products">Products</a></li>
                            <li><a href="#deals">Deals</a></li>
                            <li><a href="#categories">Categories</a></li>
                            <li><a href="{{ route('products.index') }}">All Products</a></li>
                            <li><a href="#newsletter">Newsletter</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Customer Service -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="footer-section">
                        <h6 class="footer-title mb-3">Customer Service</h6>
                        <ul class="footer-links">
                            <li><a href="#help">Help Center</a></li>
                            <li><a href="#contact">Contact Us</a></li>
                            <li><a href="#shipping">Shipping Information</a></li>
                            <li><a href="#returns">Returns & Exchanges</a></li>
                            <li><a href="#tracking">Order Tracking</a></li>
                            <li><a href="#faq">FAQ</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Account & Orders -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-section">
                        <h6 class="footer-title mb-3">My Account</h6>
                        <ul class="footer-links">
                            @guest
                                <li><a href="{{ route('login') }}">Login</a></li>
                                <li><a href="{{ route('register') }}">Register</a></li>
                                <li><a href="#guest-orders">Guest Orders</a></li>
                            @else
                                <li><a href="{{ route('home') }}">Dashboard</a></li>
                                <li><a href="{{ route('orders.index') }}">My Orders</a></li>
                                <li><a href="{{ route('wallet.show') }}">My Wallet</a></li>
                                <li><a href="#profile">Profile Settings</a></li>
                                <li><a href="#wishlist">Wishlist</a></li>
                            @endguest
                        </ul>
                    </div>
                </div>

                <!-- Business & Partners -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-section">
                        <h6 class="footer-title mb-3">Business</h6>
                        <ul class="footer-links">
                            <li><a href="#sell">Sell on ShopEase</a></li>
                            <li><a href="#partnership">Partnership</a></li>
                            <li><a href="#affiliate">Affiliate Program</a></li>
                            <li><a href="#careers">Careers</a></li>
                            <li><a href="#press">Press & Media</a></li>
                            <li><a href="#investors">Investors</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Newsletter Section in Footer -->
            <div class="footer-newsletter mb-4">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-3 mb-lg-0">
                        <h6 class="mb-2">Stay Updated with Latest Deals!</h6>
                        <p class="text-muted mb-0">Get exclusive offers and updates delivered to your inbox</p>
                    </div>
                    <div class="col-lg-6">
                        <div class="newsletter-form-footer">
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="Enter your email address" aria-label="Email for newsletter">
                                <button class="btn btn-primary" type="button">
                                    Subscribe <i class="fas fa-paper-plane ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <hr class="footer-divider my-4">

            <!-- Bottom Footer -->
            <div class="row align-items-center">
                <div class="col-lg-4 mb-3 mb-lg-0">
                    <div class="footer-bottom-left">
                        <p class="mb-0 text-muted">&copy; 2024 ShopEase. All rights reserved.</p>
                        <div class="footer-legal mt-2">
                            <a href="#privacy" class="text-muted me-3">Privacy Policy</a>
                            <a href="#terms" class="text-muted me-3">Terms of Service</a>
                            <a href="#cookies" class="text-muted">Cookie Policy</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-3 mb-lg-0">
                    <div class="footer-payment text-center">
                        <h6 class="text-muted mb-2">We Accept</h6>
                        <div class="payment-methods">
                            <img src="https://images.unsplash.com/photo-1563013544-824ae1b704d3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Payment Methods" class="payment-methods-img">
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="footer-bottom-right text-lg-end">
                        <div class="footer-apps mb-2">
                            <h6 class="text-muted mb-2">Download Our App</h6>
                            <div class="app-buttons">
                                <a href="#" class="btn btn-outline-light btn-sm me-2">
                                    <i class="fab fa-google-play me-1"></i>Google Play
                                </a>
                                <a href="#" class="btn btn-outline-light btn-sm">
                                    <i class="fab fa-apple me-1"></i>App Store
                                </a>
                            </div>
                        </div>
                        <div class="footer-languages">
                            <select class="form-select form-select-sm" style="width: auto; display: inline-block;">
                                <option value="en">🇺🇸 English</option>
                                <option value="es">🇪🇸 Español</option>
                                <option value="fr">🇫🇷 Français</option>
                                <option value="de">🇩🇪 Deutsch</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Add to cart functionality
        function addToCart(productId) {
            // Implement cart functionality
            alert('Product added to cart!');
        }
        
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
