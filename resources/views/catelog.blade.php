<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <title>Modern Product Catalog</title>

    <style>
        :root {
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --secondary-color: #f8fafc;
            --card-bg: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.12);
            --shadow-md: 0 10px 25px -5px rgba(0,0,0,0.1);
            --shadow-lg: 0 20px 40px -10px rgba(0,0,0,0.15);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            --in-stock: #10b981;
            --out-of-stock: #ef4444;
            --low-stock: #f59e0b;
        }

        body {
            background-color: #f9fafb;
            color: var(--text-primary);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        /* Modern Header */
        .modern-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            padding: 1.5rem 0;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
        }

        .modern-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #8b5cf6, #10b981, #f59e0b);
        }

        .header-title {
            font-weight: 800;
            font-size: 2.2rem;
            color: white;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header-subtitle {
            color: rgba(255,255,255,0.85);
            font-size: 1rem;
        }

        /* Promotional Banner Slider */
        .promo-banner {
            margin-bottom: 2.5rem;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }

        .carousel-item {
            height: 400px;
            position: relative;
            overflow: hidden;
        }

        .carousel-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, rgba(0,0,0,0.1) 100%);
            z-index: 1;
        }

        .carousel-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 10s ease;
        }

        .carousel-item.active .carousel-image {
            transform: scale(1.1);
        }

        .carousel-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 2.5rem;
            text-align: left;
            z-index: 2;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        }

        .promo-badge {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 6px 16px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 1rem;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .promo-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: white;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }

        .promo-subtitle {
            font-size: 1.1rem;
            color: rgba(255,255,255,0.9);
            margin-bottom: 1.5rem;
            max-width: 600px;
        }

        .promo-btn {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 28px;
            font-weight: 700;
            font-size: 1rem;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .promo-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }

        .carousel-indicators {
            bottom: 20px;
        }

        .carousel-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin: 0 6px;
            background-color: rgba(255,255,255,0.5);
            border: none;
        }

        .carousel-indicators button.active {
            background-color: var(--primary-color);
            transform: scale(1.2);
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 60px;
            height: 60px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            margin: 0 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .carousel-control-prev {
            left: 20px;
        }

        .carousel-control-next {
            right: 20px;
        }

        /* Search & Filter Bar */
        .search-filter-bar {
            background: white;
            border-radius: 14px;
            padding: 1.25rem;
            box-shadow: var(--shadow-sm);
            margin-bottom: 2.5rem;
            border: 1px solid var(--border-color);
        }

        .search-box {
            position: relative;
        }

        .search-box i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }

        .search-box input {
            padding-left: 46px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            height: 48px;
            transition: var(--transition);
        }

        .search-box input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }

        /* Stock Status Badge */
        .stock-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 20px;
            z-index: 2;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .stock-badge.in-stock {
            background-color: rgba(16, 185, 129, 0.95);
            color: white;
        }

        .stock-badge.out-of-stock {
            background-color: rgba(239, 68, 68, 0.95);
            color: white;
        }

        .stock-badge.low-stock {
            background-color: rgba(245, 158, 11, 0.95);
            color: white;
        }

        /* Modern Product Card */
        .modern-product-card {
            background: var(--card-bg);
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid var(--border-color);
            transition: var(--transition);
            height: 100%;
            box-shadow: var(--shadow-sm);
        }

        .modern-product-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
            border-color: transparent;
        }

        .product-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: #8b5cf6;
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
            z-index: 2;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .product-img-container {
            height: 220px;
            background: linear-gradient(135deg, #f6f7f9 0%, #edf0f3 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .product-img {
            max-height: 180px;
            object-fit: contain;
            transition: var(--transition);
            z-index: 1;
        }

        .modern-product-card:hover .product-img {
            transform: scale(1.05);
        }

        .product-content {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .product-title {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .product-description {
            color: var(--text-secondary);
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1rem;
            flex-grow: 1;
        }

        /* Specifications Section */
        .product-specifications {
            background-color: #f8fafc;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.25rem;
            border-left: 3px solid var(--primary-color);
        }

        .spec-title {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .spec-title i {
            color: var(--primary-color);
        }

        .spec-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .spec-item {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            padding: 4px 0;
            border-bottom: 1px dashed #e2e8f0;
        }

        .spec-label {
            color: var(--text-secondary);
            font-weight: 500;
        }

        .spec-value {
            color: var(--text-primary);
            font-weight: 600;
        }

        .product-price {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--primary-dark);
            margin-bottom: 1.25rem;
        }

        .product-meta {
            display: flex;
            align-items: center;
            color: var(--text-secondary);
            font-size: 0.85rem;
            margin-bottom: 1.25rem;
        }

        .product-meta i {
            margin-right: 6px;
            color: var(--primary-color);
        }

        .modern-buy-btn {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 20px;
            font-weight: 700;
            font-size: 1rem;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
        }

        .modern-buy-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.35);
            color: white;
        }

        .modern-buy-btn:disabled {
            background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%);
            cursor: not-allowed;
            opacity: 0.7;
        }

        .modern-buy-btn i {
            margin-right: 8px;
            font-size: 1.1rem;
        }

        /* Quick Stats Bar */
        .stats-bar {
            background: white;
            border-radius: 14px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }

        .stat-item {
            text-align: center;
            padding: 0 1rem;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.9rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        /* Footer */
        .modern-footer {
            margin-top: 4rem;
            padding: 2.5rem 0;
            background-color: #1e293b;
            color: #cbd5e1;
            text-align: center;
        }

        .footer-title {
            color: white;
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-state-icon {
            font-size: 4rem;
            color: var(--border-color);
            margin-bottom: 1.5rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .header-title {
                font-size: 1.8rem;
            }
            
            .carousel-item {
                height: 300px;
            }
            
            .promo-title {
                font-size: 1.6rem;
            }
            
            .promo-subtitle {
                font-size: 1rem;
            }
            
            .product-img-container {
                height: 180px;
            }
            
            .product-img {
                max-height: 140px;
            }
            
            .spec-list {
                grid-template-columns: 1fr;
            }
            
            .carousel-control-prev,
            .carousel-control-next {
                width: 40px;
                height: 40px;
                margin: 0 10px;
            }
        }
    </style>
</head>

<body>
    <!-- Modern Header -->
    <header class="modern-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="header-title">Tech & Electronics Store</h1>
                    <p class="header-subtitle">Premium electronics, gaming gear, and smart devices</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-inline-flex align-items-center bg-white rounded-pill px-3 py-2 shadow-sm">
                        <i class="fas fa-boxes-stacked text-primary me-2"></i>
                        <span class="fw-medium">{{ count($products) }} Products Available</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="container">
        <!-- Promotional Banner Slider -->
        <div class="promo-banner">
            <div id="promoCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                
                {{-- <div class="carousel-inner">
                    <!-- Banner 1: Black Friday Sale -->
                    <div class="carousel-item active">
                        <img src="image/Monitor-Asus-banner.jpg" class="carousel-image" alt="Black Friday Sale">
                        <div class="carousel-caption">
                            <div class="promo-badge">
                                <i class="fas fa-bolt me-2"></i> LIMITED TIME OFFER
                            </div>
                            <h2 class="promo-title">Black Friday Mega Sale</h2>
                            <p class="promo-subtitle">Get up to 50% OFF on premium gaming laptops. Special deals on Acer Predator, Asus ROG, and MSI Katana. Offer ends soon!</p>
                            <a href="#productsContainer" class="btn promo-btn">
                                <i class="fas fa-shopping-cart me-2"></i> Shop Now
                            </a>
                        </div>
                    </div>
                    
                    <!-- Banner 2: New Arrivals -->
                    <div class="carousel-item">
                        <img src="/image/Asus-Gaming-banner.jpg" class="carousel-image" alt="New Arrivals">
                        <div class="carousel-caption">
                            <div class="promo-badge">
                                <i class="fas fa-star me-2"></i> NEW ARRIVALS
                            </div>
                            <h2 class="promo-title">Latest Tech Collection</h2>
                            <p class="promo-subtitle">Discover our new lineup of premium laptops including MacBook Pro M3, Surface Laptop Studio, and Razer Blade 16.</p>
                            <a href="#productsContainer" class="btn promo-btn">
                                <i class="fas fa-eye me-2"></i> Explore Collection
                            </a>
                        </div>
                    </div>
                    
                    <!-- Banner 3: Back to School -->
                    <div class="carousel-item">
                        <img src="image/Asus-Book-banner.jpg" class="carousel-image" alt="Back to School">
                        <div class="carousel-caption">
                            <div class="promo-badge">
                                <i class="fas fa-graduation-cap me-2"></i> STUDENT DISCOUNT
                            </div>
                            <h2 class="promo-title">Back to School Special</h2>
                            <p class="promo-subtitle">Get 20% OFF on all laptops with student verification. Perfect for students and professionals. Free shipping included.</p>
                            <a href="#productsContainer" class="btn promo-btn">
                                <i class="fas fa-percentage me-2"></i> Get Discount
                            </a>
                        </div>
                    </div>
                </div> --}}
                
                <button class="carousel-control-prev" type="button" data-bs-target="#promoCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#promoCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

        <!-- Quick Stats Bar -->
        <div class="stats-bar">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-3 mb-md-0">
                    <div class="stat-item">
                        <div class="stat-number">10+</div>
                        <div class="stat-label">Premium Brands</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3 mb-md-0">
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Customer Support</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">✓</div>
                        <div class="stat-label">Free Shipping</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">30</div>
                        <div class="stat-label">Day Returns</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search & Filter Bar -->
        <div class="search-filter-bar">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" id="searchInput" placeholder="Search products by name, description, or specifications...">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-wrap align-items-center justify-content-md-end">
                        <span class="me-3 fw-medium">Filter by:</span>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary btn-sm filter-btn active" data-filter="all">All</button>
                            <button type="button" class="btn btn-outline-primary btn-sm filter-btn" data-filter="in-stock">In Stock</button>
                            <button type="button" class="btn btn-outline-primary btn-sm filter-btn" data-filter="out-of-stock">Out of Stock</button>
                            <button type="button" class="btn btn-outline-primary btn-sm filter-btn" data-filter="gaming">Gaming</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="row g-4" id="productsContainer">
            @foreach($products as $index => $product)
            @php
                // Determine stock status icon and text
                $stockStatus = $product['stock'] ?? 'in-stock';
                $stockText = match($stockStatus) {
                    'in-stock' => 'In Stock',
                    'out-of-stock' => 'Out of Stock',
                    'low-stock' => 'Low Stock',
                    default => 'In Stock'
                };
                $stockIcon = match($stockStatus) {
                    'in-stock' => 'fas fa-check-circle',
                    'out-of-stock' => 'fas fa-times-circle',
                    'low-stock' => 'fas fa-exclamation-circle',
                    default => 'fas fa-check-circle'
                };
                
                // Get specifications from product data
                $specifications = $product['specifications'] ?? [];
            @endphp
            
            <div class="col-xl-3 col-lg-4 col-md-6 product-item" data-category="{{ strtolower($product['category'] ?? 'gaming') }}" data-stock="{{ $stockStatus }}">
                <div class="modern-product-card">
                    <div class="stock-badge {{ $stockStatus }}">
                        <i class="{{ $stockIcon }}"></i>
                        <span>{{ $stockText }}</span>
                    </div>
                    
                    <!-- Product badge (optional) -->
                    @if($stockStatus === 'low-stock')
                    <div class="product-badge">Limited Stock</div>
                    @elseif($index < 2)
                    <div class="product-badge">Featured</div>
                    @endif
                    
                    <div class="product-img-container">
                        <a href="{{ route('product.detail', ['id' => $index]) }}">
                            <img src="{{ $product['image'] }}" class="product-img" alt="{{ $product['name'] }}">
                        </a>
                    </div>
                    
                    <div class="product-content">
                        <a href="{{ route('product.detail', ['id' => $index]) }}" class="text-decoration-none">
                            <h3 class="product-title">{{ $product['name'] }}</h3>
                        </a>
                        
                        <div class="product-meta">
                            <span class="me-3"><i class="fas fa-star"></i> 4.{{ rand(5,9) }}</span>
                            <span><i class="fas fa-tag"></i> {{ $product['category'] ?? 'Gaming' }}</span>
                        </div>
                        
                        <p class="product-description">
                            {{ $product['desc'] }}
                        </p>
                        
                        @if(!empty($specifications))
                        <div class="product-specifications">
                            <div class="spec-title">
                                <i class="fas fa-list-check"></i>
                                <span>Key Specifications</span>
                            </div>
                            <ul class="spec-list">
                                @foreach(array_slice($specifications, 0, 4) as $key => $value)
                                <li class="spec-item">
                                    <span class="spec-label">{{ $key }}:</span>
                                    <span class="spec-value">{{ $value }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        
                        <div class="d-flex align-items-center justify-content-between mt-auto">
                            <div class="product-price">
                                @if($product['price'] < 10)
                                    {{ number_format($product['price'], 2) }}KHR
                                @else
                                    {{ number_format($product['price'], 2) }}KHR
                                @endif
                            </div>
                            <div class="text-muted small">
                                @if($stockStatus === 'in-stock')
                                <i class="fas fa-shipping-fast text-success me-1"></i> Free Shipping
                                @elseif($stockStatus === 'low-stock')
                                <i class="fas fa-exclamation-triangle text-warning me-1"></i> Only a few left
                                @else
                                <i class="fas fa-clock text-danger me-1"></i> Backorder available
                                @endif
                            </div>
                        </div>
                        
                        <form method="POST" action="{{ route('buy_now') }}" class="mt-3">
                            @csrf
                            <input type="hidden" name="name" value="{{ $product['name'] }}">
                            <input type="hidden" name="price" value="{{ $product['price'] }}">
                            
                            <button type="submit" class="modern-buy-btn" {{ $stockStatus === 'out-of-stock' ? 'disabled' : '' }}>
                                @if($stockStatus === 'out-of-stock')
                                <i class="fas fa-clock"></i> Notify When Available
                                @elseif($stockStatus === 'low-stock')
                                <i class="fas fa-bolt"></i> Buy Now - Limited Stock
                                @else
                                <i class="fas fa-bolt"></i> Buy Now
                                @endif
                            </button>
                            
                            @if($stockStatus === 'out-of-stock')
                            <div class="text-center mt-2">
                                <small class="text-muted">Expected restock: {{ date('M d', strtotime('+'.rand(3,14).' days')) }}</small>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Empty State (hidden by default) -->
        <div id="emptyState" class="empty-state d-none">
            <div class="empty-state-icon">
                <i class="fas fa-search"></i>
            </div>
            <h3 class="mb-3">No products found</h3>
            <p class="text-muted">Try adjusting your search or filter to find what you're looking for.</p>
            <button class="btn btn-primary mt-3" id="resetFilters">
                <i class="fas fa-redo me-2"></i> Reset Filters
            </button>
        </div>
    </main>

    <!-- Footer -->
    <footer class="modern-footer">
        <div class="container">
            <h4 class="footer-title">Premium Laptop Store</h4>
            <p class="mb-4">Power by Thet Panhayuth</p>
            <div>
                <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-light me-3"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-light me-3"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-light"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></sc>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const filterButtons = document.querySelectorAll('.filter-btn');
            const productItems = document.querySelectorAll('.product-item');
            const productsContainer = document.getElementById('productsContainer');
            const emptyState = document.getElementById('emptyState');
            const resetFiltersBtn = document.getElementById('resetFilters');
            
            // Filter products based on search and filter
            function filterProducts() {
                const searchTerm = searchInput.value.toLowerCase();
                const activeFilter = document.querySelector('.filter-btn.active').getAttribute('data-filter');
                let visibleCount = 0;
                
                productItems.forEach(item => {
                    const productName = item.querySelector('.product-title').textContent.toLowerCase();
                    const productDesc = item.querySelector('.product-description').textContent.toLowerCase();
                    const productSpecs = item.querySelector('.product-specifications')?.textContent.toLowerCase() || '';
                    const productStock = item.getAttribute('data-stock');
                    const productCategory = item.getAttribute('data-category');
                    
                    // Combine all searchable text
                    const searchableText = productName + ' ' + productDesc + ' ' + productSpecs;
                    
                    const matchesSearch = searchableText.includes(searchTerm);
                    const matchesFilter = activeFilter === 'all' || 
                                         (activeFilter === 'in-stock' && productStock === 'in-stock') ||
                                         (activeFilter === 'out-of-stock' && productStock === 'out-of-stock') ||
                                         (activeFilter === 'gaming' && productCategory === 'gaming');
                    
                    if (matchesSearch && matchesFilter) {
                        item.style.display = 'block';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });
                
                // Show empty state if no products visible
                if (visibleCount === 0) {
                    productsContainer.classList.add('d-none');
                    emptyState.classList.remove('d-none');
                } else {
                    productsContainer.classList.remove('d-none');
                    emptyState.classList.add('d-none');
                }
            }
            
            // Event listeners for search input
            searchInput.addEventListener('input', filterProducts);
            
            // Event listeners for filter buttons
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    // Filter products
                    filterProducts();
                });
            });
            
            // Reset filters button
            resetFiltersBtn.addEventListener('click', function() {
                searchInput.value = '';
                filterButtons.forEach(btn => {
                    btn.classList.remove('active');
                    if (btn.getAttribute('data-filter') === 'all') {
                        btn.classList.add('active');
                    }
                });
                filterProducts();
            });
            
            // Add subtle animation to cards on page load
            setTimeout(() => {
                productItems.forEach((item, index) => {
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(20px)';
                    
                    setTimeout(() => {
                        item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                        item.style.opacity = '1';
                        item.style.transform = 'translateY(0)';
                    }, index * 100);
                });
            }, 300);
            
            // Initialize stock status display
            productItems.forEach(item => {
                const stockBadge = item.querySelector('.stock-badge');
                const buyButton = item.querySelector('.modern-buy-btn');
                const stockStatus = item.getAttribute('data-stock');
                
                // Add stock-specific styling
                if (stockStatus === 'out-of-stock') {
                    buyButton.disabled = true;
                    buyButton.innerHTML = '<i class="fas fa-clock"></i> Notify When Available';
                } else if (stockStatus === 'low-stock') {
                    buyButton.innerHTML = '<i class="fas fa-bolt"></i> Buy Now - Limited Stock';
                }
            });
            
            // Auto-rotate promo carousel
            const promoCarousel = document.getElementById('promoCarousel');
            if (promoCarousel) {
                const carousel = new bootstrap.Carousel(promoCarousel, {
                    interval: 5000,
                    ride: 'carousel'
                });
            }
        });
    </script>
</body>
</html>