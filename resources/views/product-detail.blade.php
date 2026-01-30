<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:type" content="product">
    <meta property="og:title" content="{{ $product['name'] }} - Premium Tech">
    <meta property="og:description" content="{{ Str::limit(strip_tags($product['desc']), 150) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset($product['image']) }}">
    
    <title>{{ $product['name'] }} | TechPremium Selection</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/product-detail.css') }}?v={{ time() }}"> 
</head>
<body>

    <header class="site-header">
        <div class="premium-container h-20 flex items-center justify-between">
            <a href="{{ route('home') }}" class="header-logo">
                Tech<span>Premium</span>
            </a>
            
            <div class="flex items-center gap-8">
                @auth
                    <div class="flex items-center gap-4">
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Curator</span>
                        <span class="text-sm font-bold">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="text-slate-400 hover:text-rose-500 transition-colors" title="Logout">
                                <i class="fas fa-power-off"></i>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex items-center gap-6">
                        <a href="{{ route('login') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-indigo-600 transition-colors">Sign In</a>
                        <a href="{{ route('register') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-indigo-600 transition-colors">Register</a>
                    </div>
                @endauth

                <div class="h-4 w-[1px] bg-slate-200"></div>

                <a href="{{ route('cart.view') }}" class="text-sm font-bold flex items-center gap-3 hover:text-indigo-600 transition-colors">
                    <span class="text-slate-400 uppercase tracking-widest text-[10px]">Your Selection</span>
                    <div class="bg-slate-900 text-white w-8 h-8 rounded-full flex items-center justify-center text-xs">
                        {{ $cartCount }}
                    </div>
                </a>
            </div>

        </div>
    </header>

    <main class="premium-container">
        <nav class="py-8 text-[11px] font-bold uppercase tracking-[0.2em] text-slate-400 flex items-center gap-3">
            <a href="{{ route('home') }}" class="hover:text-indigo-600">Market</a>
            <i class="fas fa-chevron-right text-[8px] opacity-30"></i>
            <span class="text-slate-900">{{ $product['category'] }}</span>
        </nav>

        <div class="product-grid">
            <div class="image-stage flex flex-col w-full" id="imgStage">
                <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="product-main-img" id="mainImg">

                <div class="related-products-container">
                    <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-6">You might also like</h3>
                    
                    @if(isset($relatedProducts) && count($relatedProducts) > 0)
                        <div class="grid grid-cols-2 gap-4">
                            @foreach($relatedProducts as $related)
                            <a href="{{ route('product.detail', $related['id']) }}" class="group block bg-white rounded-lg p-3 border border-slate-100 hover:border-indigo-100 hover:shadow-lg transition-all duration-300">
                                <div class="aspect-square bg-slate-50 rounded-lg overflow-hidden mb-3 relative">
                                    <img src="{{ asset($related['image']) }}" alt="{{ $related['name'] }}" class="w-full h-full object-contain p-2 group-hover:scale-105 transition-transform duration-500">
                                </div>
                                <h4 class="font-bold text-slate-900 text-xs mb-1 truncate group-hover:text-indigo-600 transition-colors">{{ $related['name'] }}</h4>
                                <p class="text-[10px] text-slate-500 font-bold">{{ number_format($related['price'], 0) }} KHR</p>
                            </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="content-stage">
                <span class="category-tag">{{ $product['category'] }} Selection</span>
                <h1 class="product-name">{{ $product['name'] }}</h1>
                
                <div class="flex items-center gap-4 mb-8">
                    <div class="flex text-amber-400 gap-1 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star text-slate-200"></i>
                    </div>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-l border-slate-200 pl-4">4.8 / 5.0 Rating</span>
                </div>

                <div class="product-price-minimal">
                    {{ number_format($product['price'], 0) }}
                    <small>KHR</small>
                </div>

                <div class="space-y-4">
                    @php 
                        $isOut = trim($product['stock'] ?? '') === 'out-of-stock';
                        $product_id = $product['id'] ?? '0';
                    @endphp
                    
                    <form method="POST" action="{{ route('buy_now') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product_id }}">
                        <input type="hidden" name="name" value="{{ $product['name'] }}">
                        <input type="hidden" name="price" value="{{ $product['price'] }}">
                        <input type="hidden" name="image" value="{{ $product['image'] }}">
                        
                        <button type="submit" class="btn-elite btn-elite-primary" {{ $isOut ? 'disabled' : '' }}>
                            @if($isOut) 
                                <i class="fas fa-bell-slash me-2 opacity-50"></i> Out of Stock 
                            @else 
                                <i class="fas fa-shopping-bag me-2 opacity-70"></i> Buy it Now 
                            @endif
                        </button>
                    </form>

                    <div class="flex gap-4">
                        <form method="POST" action="{{ route('cart.add', ['id' => $product_id]) }}" class="flex-grow">
                            @csrf
                            <button type="submit" class="btn-elite btn-elite-secondary" {{ $isOut ? 'disabled' : '' }}>
                                Add to Selection
                            </button>
                        </form>
                        
                        <button id="wishlistTrigger" class="w-[66px] h-[66px] rounded-2xl border border-slate-200 flex items-center justify-center text-slate-400 hover:text-rose-500 hover:border-rose-200 hover:bg-rose-50 transition-all duration-300">
                            <i class="fas fa-heart text-xl"></i>
                        </button>
                    </div>
                </div>

                <div class="mt-12">
                    <h3 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-4">The Selection Strategy</h3>
                    <p class="text-slate-600 font-medium leading-relaxed">
                        {{ $product['desc'] }}
                    </p>
                </div>

                <div class="minimal-specs">
                    @foreach($product['specifications'] as $key => $value)
                    <div class="spec-tile">
                        <span class="label">{{ $key }}</span>
                        <span class="value">{{ $value }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="mt-16 pt-8 border-t border-slate-200 flex items-center justify-between text-slate-400 text-[10px] font-bold uppercase tracking-widest">
                    <div class="flex gap-6">
                        <span class="flex items-center gap-2"><i class="fas fa-shield-halved"></i> 2Y Warranty</span>
                        <span class="flex items-center gap-2"><i class="fas fa-truck-bolt"></i> Global Ship</span>
                    </div>
                    
                    <div class="flex gap-4">
                        <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($product['name']) }}" 
                           target="_blank" rel="noopener noreferrer"
                           class="w-12 h-12 rounded-full bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-[#0088cc] hover:border-[#0088cc] hover:bg-sky-50 transition-all duration-300 shadow-sm" title="Share on Telegram">
                            <i class="fab fa-telegram-plane text-xl"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                           target="_blank" rel="noopener noreferrer"
                           class="w-12 h-12 rounded-full bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-[#1877f2] hover:border-[#1877f2] hover:bg-blue-50 transition-all duration-300 shadow-sm" title="Share on Facebook">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>


    </main>

    <div class="zoom-stage" id="zoomStage">
        <img src="{{ asset($product['image']) }}" alt="Zoomed">
    </div>

    <script>
        const mainImg = document.getElementById('mainImg');
        const zoomStage = document.getElementById('zoomStage');

        if (mainImg && zoomStage) {
            mainImg.addEventListener('click', () => {
                zoomStage.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });

            zoomStage.addEventListener('click', () => {
                zoomStage.style.display = 'none';
                document.body.style.overflow = 'auto';
            });
        }

        // Restored Original Notification Process
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-10 right-10 z-[2000] min-w-[320px] p-5 rounded-2xl shadow-2xl border border-slate-100 flex items-center gap-4 bg-white/80 backdrop-blur-xl animate-in slide-in-from-right duration-300`;
            
            const icon = type === 'success' ? 'fa-check-circle text-emerald-500' : 'fa-info-circle text-indigo-500';
            
            notification.innerHTML = `
                <i class="fas ${icon} text-xl"></i>
                <div>
                    <p class="text-xs font-black uppercase tracking-widest text-slate-400 mb-0.5">${type === 'success' ? 'Success' : 'Information'}</p>
                    <p class="text-sm font-bold text-slate-900">${message}</p>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.classList.add('animate-out', 'fade-out', 'slide-out-to-right');
                setTimeout(() => notification.remove(), 500);
            }, 3500);
        }

        // Restored Wishlist Process
        const wishlistTrigger = document.getElementById('wishlistTrigger');
        if (wishlistTrigger) {
            wishlistTrigger.addEventListener('click', function() {
                const icon = this.querySelector('i');
                const isActive = icon.classList.contains('fa-solid');
                
                if (isActive) {
                    icon.classList.remove('fa-solid', 'text-rose-500');
                    icon.classList.add('fa-regular');
                    showNotification('Removed from collection share');
                } else {
                    icon.classList.remove('fa-regular');
                    icon.classList.add('fa-solid', 'text-rose-500');
                    showNotification('Added to your collection share', 'success');
                }
            });
        }
    </script>
</body>
</html>