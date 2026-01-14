<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <title>{{ $product['name'] }} - Modern Product Catalog</title>

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
            text-decoration: none;
        }

        .header-subtitle {
            color: rgba(255,255,255,0.85);
            font-size: 1rem;
        }

        /* Product Detail Styles */
        .product-detail-card {
            background: white;
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .product-image-section {
            background: linear-gradient(135deg, #f6f7f9 0%, #edf0f3 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            min-height: 500px;
        }

        .product-image-full {
            max-width: 100%;
            max-height: 450px;
            object-fit: contain;
            filter: drop-shadow(0 20px 30px rgba(0,0,0,0.15));
            transition: var(--transition);
        }

        .product-image-full:hover {
            transform: scale(1.05);
        }

        .product-info-section {
            padding: 3rem;
        }

        .back-link {
            color: var(--text-secondary);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            margin-bottom: 1.5rem;
            transition: var(--transition);
        }

        .back-link:hover {
            color: var(--primary-color);
            transform: translateX(-5px);
        }

        .product-detail-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .product-detail-price {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stock-badge-lg {
            font-size: 0.9rem;
            padding: 6px 16px;
            border-radius: 30px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-in-stock { background: rgba(16, 185, 129, 0.1); color: #10b981; }
        .badge-out-of-stock { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
        .badge-low-stock { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }

        .product-detail-desc {
            font-size: 1.1rem;
            line-height: 1.7;
            color: var(--text-secondary);
            margin-bottom: 2rem;
        }

        .specs-container {
            background-color: #f8fafc;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .specs-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .specs-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .spec-item-detail {
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 0.5rem;
        }

        .spec-label-detail {
            display: block;
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-bottom: 4px;
        }

        .spec-value-detail {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 1rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-buy-lg {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px 40px;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
            transition: var(--transition);
            flex-grow: 1;
        }

        .btn-buy-lg:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
            color: white;
        }
        
        .btn-buy-lg:disabled {
             background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%);
             cursor: not-allowed;
             opacity: 0.7;
        }

        /* Footer */
        .modern-footer {
            margin-top: 4rem;
            padding: 2.5rem 0;
            background-color: #1e293b;
            color: #cbd5e1;
            text-align: center;
        }

        @media (max-width: 768px) {
            .product-image-section {
                padding: 2rem;
                min-height: 300px;
            }
            .specs-grid {
                grid-template-columns: 1fr;
            }
            .product-info-section {
                padding: 1.5rem;
            }
            .header-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Modern Header -->
    <header class="modern-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <a href="{{ route('home') }}" class="header-title">Tech & Electronics Store</a>
                    <p class="header-subtitle">Premium electronics, gaming gear, and smart devices</p>
                </div>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="product-detail-card">
            <div class="row g-0">
                <div class="col-lg-6">
                    <div class="product-image-section">
                        <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="product-image-full">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product-info-section">
                        <a href="{{ route('home') }}" class="back-link">
                            <i class="fas fa-arrow-left me-2"></i> Back to Catalog
                        </a>
                        
                        <div class="d-flex align-items-start justify-content-between">
                            <h1 class="product-detail-title">{{ $product['name'] }}</h1>
                        </div>

                        <div class="d-flex align-items-center gap-3 mb-4">
                            <span class="badge bg-light text-dark border"><i class="fas fa-tag me-1"></i> {{ $product['category'] }}</span>
                            @php
                                $stockStatus = $product['stock'] ?? 'in-stock';
                                $badgeClass = match($stockStatus) {
                                    'in-stock' => 'badge-in-stock',
                                    'out-of-stock' => 'badge-out-of-stock',
                                    'low-stock' => 'badge-low-stock',
                                    default => 'badge-in-stock'
                                };
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
                            @endphp
                            <div class="stock-badge-lg {{ $badgeClass }}">
                                <i class="{{ $stockIcon }}"></i> {{ $stockText }}
                            </div>
                        </div>

                        <div class="product-detail-price">
                            {{ number_format($product['price'], 2) }} KHR
                        </div>

                        <p class="product-detail-desc">
                            {{ $product['desc'] }}
                        </p>

                        @if(!empty($product['specifications']))
                        <div class="specs-container">
                            <div class="specs-title">
                                <i class="fas fa-microchip text-primary"></i> Technical Specifications
                            </div>
                            <div class="specs-grid">
                                @foreach($product['specifications'] as $key => $value)
                                <div class="spec-item-detail">
                                    <span class="spec-label-detail">{{ $key }}</span>
                                    <span class="spec-value-detail">{{ $value }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('buy_now') }}">
                            @csrf
                            <input type="hidden" name="name" value="{{ $product['name'] }}">
                            <input type="hidden" name="price" value="{{ $product['price'] }}">
                            
                            <div class="action-buttons">
                                <button type="submit" class="btn btn-buy-lg" {{ $stockStatus === 'out-of-stock' ? 'disabled' : '' }}>
                                    @if($stockStatus === 'out-of-stock')
                                    <i class="fas fa-clock me-2"></i> Notify When Available
                                    @else
                                    <i class="fas fa-shopping-cart me-2"></i> Buy Now
                                    @endif
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="modern-footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} Tech & Electronics Store. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
