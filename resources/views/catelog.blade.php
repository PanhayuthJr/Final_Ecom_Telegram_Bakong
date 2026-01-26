<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/catalog.css') }}">
    <title>Modern Product Catalog</title>

</head>

<body>
    <!-- Cart Notification -->
    <div id="cartNotification" class="alert alert-success cart-notification d-none" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <span id="notificationMessage">Product added to cart!</span>
    </div>

    <!-- Confirmation Modal -->
    <div class="confirmation-modal" id="confirmationModal">
        <div class="confirmation-content">
            <h5 class="mb-3" id="confirmationTitle">Confirm Removal</h5>
            <p id="confirmationMessage">Are you sure you want to remove this item from your cart?</p>
            <div class="confirmation-actions">
                <button class="btn btn-secondary" id="cancelRemove">Cancel</button>
                <button class="btn btn-danger" id="confirmRemove">Remove</button>
            </div>
        </div>
    </div>



    <!-- Modern Header -->
    <!-- Modern Header -->
    <header class="modern-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="header-title">Tech & Electronics Store</h1>
                    <p class="header-subtitle">Premium electronics, gaming gear, and smart devices</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-inline-flex align-items-center bg-white rounded-pill px-3 py-2 shadow-sm me-3">
                        <i class="fas fa-boxes-stacked text-primary me-2"></i>
                        <span class="fw-medium">{{ count($products) }} Products Available</span>
                    </div>

                    @auth
                        <div class="d-inline-flex align-items-center bg-white rounded-pill px-3 py-2 shadow-sm me-3">
                            <i class="fas fa-user-circle text-primary me-2"></i>
                            <span class="fw-bold me-3">{{ Auth::user()->name }}</span>
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.products.index') }}" class="text-decoration-none fw-bold me-3 text-primary" title="Admin Dashboard">
                                    <i class="fas fa-cog"></i> Dashboard
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="p-0 border-0 bg-transparent text-slate-400 hover:text-danger flex items-center" title="Sign Out">
                                    <i class="fas fa-power-off"></i>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="d-inline-flex align-items-center bg-white rounded-pill px-3 py-2 shadow-sm me-3">
                            <i class="fas fa-lock text-primary me-2"></i>
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold me-2">Sign In</a>
                            <span class="text-slate-300">|</span>
                            <a href="{{ route('register') }}" class="text-decoration-none fw-bold ms-2">Join</a>
                        </div>
                    @endauth
                    
                    <!-- Cart Icon -->

                    <div class="cart-icon-container">
                        <a href="{{ route('cart.view') }}" class="cart-icon-btn">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-count-badge" id="headerCartCount">{{ $cartCount }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="container">
        <!-- Premium Promotional Banner Slider -->
        <div class="promo-banner">
            <div id="premiumPromoCarousel" class="carousel slide promo-carousel carousel-fade" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#premiumPromoCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#premiumPromoCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#premiumPromoCarousel" data-bs-slide-to="2"></button>
                </div>
                
                <div class="carousel-inner">
                    <!-- Slide 1: Gaming -->
                    <div class="carousel-item active" data-bs-interval="5000">
                        <img src="{{ asset('img/banners/banner1.png') }}" alt="Elite Gaming">
                        <div class="promo-caption">
                            <h2 class="promo-title">Next-Gen Gaming</h2>
                            <p class="promo-text">Unleash pure power with our latest collection of high-performance gaming hardware. Engineered for the elite.</p>
                            <button class="btn-promo-explore" onclick="document.getElementById('searchInput').focus()">Explore Now</button>
                        </div>
                    </div>

                    <!-- Slide 2: Audio/Lifestyle -->
                    <div class="carousel-item" data-bs-interval="5000">
                        <img src="{{ asset('img/banners/banner2.png') }}" alt="Premium Audio">
                        <div class="promo-caption">
                            <h2 class="promo-title">Pure Sound Architecture</h2>
                            <p class="promo-text">Experience acoustics like never before. Discover studio-grade audio equipment designed for ultimate clarity.</p>
                            <button class="btn-promo-explore" onclick="document.getElementById('searchInput').focus()">Discover Gear</button>
                        </div>
                    </div>

                    <!-- Slide 3: Productivity -->
                    <div class="carousel-item" data-bs-interval="5000">
                        <img src="{{ asset('img/banners/productivity.png') }}" alt="Productivity Setup">
                        <div class="promo-caption">
                            <h2 class="promo-title">Peak Productivity</h2>
                            <p class="promo-text">Optimized workstations for modern pioneers. Build your dream setup with our professional hardware selection.</p>
                            <button class="btn-promo-explore" onclick="document.getElementById('searchInput').focus()">Build Setup</button>
                        </div>
                    </div>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#premiumPromoCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true" style="filter: invert(1);"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#premiumPromoCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true" style="filter: invert(1);"></span>
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
            
            <div class="col-xl-3 col-lg-4 col-md-6 product-item" data-category="{{ strtolower($product['category'] ?? 'gaming') }}" data-stock="{{ $stockStatus }}" data-id="{{ $product['id'] }}">
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
                        <a href="{{ route('product.detail', ['id' => $product['id']]) }}">
                            <img src="{{ $product['image'] }}" class="product-img" alt="{{ $product['name'] }}">
                        </a>
                    </div>
                    
                    <div class="product-content">
                        <a href="{{ route('product.detail', ['id' => $product['id']]) }}" class="text-decoration-none">
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
                        
                        <div class="product-actions">
                            <form method="POST" action="{{ route('buy_now') }}" class="w-50">
                                @csrf
                                <input type="hidden" name="name" value="{{ $product['name'] }}">
                                <input type="hidden" name="price" value="{{ $product['price'] }}">
                                <input type="hidden" name="image" value="{{ $product['image'] }}">
                                
                                <button type="submit" class="modern-buy-btn" {{ $stockStatus === 'out-of-stock' ? 'disabled' : '' }}>
                                    @if($stockStatus === 'out-of-stock')
                                    <i class="fas fa-clock"></i> Notify
                                    @elseif($stockStatus === 'low-stock')
                                    <i class="fas fa-bolt"></i> Buy Now
                                    @else
                                    <i class="fas fa-bolt"></i> Buy Now
                                    @endif
                                </button>
                            </form>
                            
                            <form method="POST" action="{{ route('cart.add', ['id' => $product['id']]) }}">
                                @csrf
                                <button type="submit" class="btn-add-to-cart" {{ $stockStatus === 'out-of-stock' ? 'disabled' : '' }}>
                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                </button>
                            </form>
                        </div>
                        
                        @if($stockStatus === 'out-of-stock')
                        <div class="text-center mt-2">
                            <small class="text-muted">Expected restock: {{ date('M d', strtotime('+'.rand(3,14).' days')) }}</small>
                        </div>
                        @endif
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Cart data structure
        let cart = JSON.parse(localStorage.getItem('shoppingCart')) || [];
        let itemToRemove = null;

        // Initialize cart display
        document.addEventListener('DOMContentLoaded', function() {
            // Cart count logic if needed purely client-side or stick to server-side badges
        });


        // Search and filter functionality (existing)
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const productItems = document.querySelectorAll('.product-item');
            let visibleCount = 0;
            
            productItems.forEach(item => {
                const title = item.querySelector('.product-title').textContent.toLowerCase();
                const desc = item.querySelector('.product-description').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || desc.includes(searchTerm)) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Show/hide empty state
            document.getElementById('emptyState').classList.toggle('d-none', visibleCount > 0);
        });

        // Filter functionality (existing)
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const filter = this.dataset.filter;
                
                // Update active button
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                // Filter products
                const productItems = document.querySelectorAll('.product-item');
                let visibleCount = 0;
                
                productItems.forEach(item => {
                    const stock = item.dataset.stock;
                    const category = item.dataset.category;
                    
                    if (filter === 'all' || 
                        (filter === 'in-stock' && stock === 'in-stock') ||
                        (filter === 'out-of-stock' && stock === 'out-of-stock') ||
                        (filter === 'gaming' && category.includes('gaming'))) {
                        item.style.display = 'block';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });
                
                document.getElementById('emptyState').classList.toggle('d-none', visibleCount > 0);
            });
        });

        // Reset filters (existing)
        document.getElementById('resetFilters').addEventListener('click', function() {
            document.getElementById('searchInput').value = '';
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
                if (btn.dataset.filter === 'all') btn.classList.add('active');
            });
            
            document.querySelectorAll('.product-item').forEach(item => {
                item.style.display = 'block';
            });
            
            document.getElementById('emptyState').classList.add('d-none');
        });
    </script>
</body>
</html>