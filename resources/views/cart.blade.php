<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Premium Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
</head>
<body class="min-h-screen pb-20">

    <!-- Header -->
    <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 py-6 sticky top-0 z-40 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 flex items-center justify-between">
            <a href="{{ route('home') }}" class="group flex items-center gap-4 text-slate-900">
                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-all">
                    <i class="fas fa-arrow-left text-sm"></i>
                </div>
                <div>
                    <span class="block text-xs font-bold uppercase tracking-wider text-slate-400 group-hover:text-indigo-500 transition-colors">Back to Market</span>
                    <span class="text-xl font-extrabold tracking-tight">Tech<span class="text-indigo-600">Premium</span></span>
                </div>
            </a>
            
            <div class="flex items-center gap-6">
                <div class="hidden md:flex flex-col items-end">
                    <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest">Secure Shopping</span>
                    <div class="flex gap-1 mt-1">
                        <i class="fas fa-star text-[10px] text-amber-400"></i>
                        <i class="fas fa-star text-[10px] text-amber-400"></i>
                        <i class="fas fa-star text-[10px] text-amber-400"></i>
                        <i class="fas fa-star text-[10px] text-amber-400"></i>
                        <i class="fas fa-star text-[10px] text-amber-400"></i>
                    </div>
                </div>
                <div class="h-10 w-px bg-slate-200"></div>
                <div class="relative">
                    <i class="fas fa-shopping-bag text-2xl text-slate-800"></i>
                    <span class="absolute -top-2 -right-2 w-5 h-5 bg-indigo-600 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white">{{ $cartCount }}</span>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-6 pt-12">
        @if(count($cart) > 0)
        <form id="checkoutForm" action="{{ route('checkout') }}" method="GET">
            <div class="grid lg:grid-cols-12 gap-10">
                <!-- Left Column: Cart Items -->
                <div class="lg:col-span-8 space-y-6">
                    <div class="flex items-center justify-between mb-2 px-2">
                        <h2 class="text-2xl font-black text-slate-800 flex items-center gap-3">
                            Your Selection
                            <span class="px-2.5 py-0.5 bg-slate-100 text-slate-500 text-sm rounded-full font-bold">{{ count($cart) }}</span>
                        </h2>
                        
                        <div class="flex items-center gap-3 bg-white border border-slate-200 px-4 py-2 rounded-xl shadow-sm">
                            <input type="checkbox" id="selectAll" checked class="custom-checkbox w-5 h-5 rounded-md border-slate-300 text-indigo-600 focus:ring-indigo-500/20 transition-all cursor-pointer">
                            <label for="selectAll" class="text-sm font-bold text-slate-600 cursor-pointer select-none">Select All</label>
                        </div>
                    </div>

                    @foreach($cart as $id => $item)
                    <div class="cart-item-card bg-white rounded-[2rem] border-2 border-slate-100 p-6 flex flex-col sm:flex-row items-center gap-8 relative overflow-hidden group shadow-sm selected" data-id="{{ $id }}" data-price="{{ $item['price'] }}" data-qty="{{ $item['qty'] }}">
                        
                        <!-- Checkbox Overlay -->
                        <div class="absolute left-6 top-1/2 -translate-y-1/2 z-10">
                            <input type="checkbox" name="selected_items[]" value="{{ $id }}" checked class="item-checkbox w-6 h-6 rounded-lg border-2 border-slate-200 text-indigo-600 focus:ring-indigo-500/30 transition-all cursor-pointer bg-white">
                        </div>

                        <div class="sm:ml-12 flex flex-col sm:flex-row items-center gap-8 w-full">
                            <div class="relative group">
                                <div class="absolute inset-0 bg-indigo-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity blur-xl"></div>
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="relative w-32 h-32 rounded-2xl object-cover bg-slate-50 border border-slate-100 shadow-inner group-hover:scale-105 transition-transform duration-500">
                            </div>
                            
                            <div class="flex-1 text-center sm:text-left space-y-2">
                                <div class="inline-flex px-2 py-0.5 bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-widest rounded-md mb-1">In Stock</div>
                                <h3 class="font-extrabold text-slate-800 text-xl tracking-tight leading-tight group-hover:text-indigo-600 transition-colors">{{ $item['name'] }}</h3>
                                <div class="flex items-center justify-center sm:justify-start gap-4">
                                    <span class="text-indigo-600 font-black text-2xl tracking-tighter">{{ number_format($item['price'], 2) }} <small class="text-sm font-bold">KHR</small></span>
                                    <div class="h-4 w-px bg-slate-200"></div>
                                    <span class="text-slate-400 text-sm font-medium">Single Price</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-6 scale-110 sm:scale-100">
                                <div class="bg-slate-50 border border-slate-200 p-1.5 rounded-2xl flex items-center gap-1 shadow-inner">
                                    <button type="button" onclick="updateQtyDirectly('{{ $id }}', -1)" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:border-indigo-100 hover:shadow-sm transition-all">-</button>
                                    <span class="w-10 text-center font-black text-slate-700 text-lg">{{ $item['qty'] }}</span>
                                    <button type="button" onclick="updateQtyDirectly('{{ $id }}', 1)" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:border-indigo-100 hover:shadow-sm transition-all">+</button>
                                </div>

                                <button type="button" onclick="confirmRemove('{{ $id }}', '{{ $item['name'] }}')" class="w-12 h-12 rounded-2xl border-2 border-transparent hover:border-rose-100 text-slate-300 hover:text-rose-500 hover:bg-rose-50 transition-all flex items-center justify-center">
                                    <i class="fas fa-trash-alt text-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Right Column: Summary -->
                <div class="lg:col-span-4">
                    <div class="glass-card rounded-[2.5rem] shadow-2xl shadow-indigo-500/10 p-10 sticky top-32 border-t border-l border-white/60">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/40">
                                <i class="fas fa-file-invoice text-xl"></i>
                            </div>
                            <h2 class="text-2xl font-black text-slate-800 tracking-tight leading-none">Order<br><span class="text-slate-400 text-base font-bold tracking-normal">Summary</span></h2>
                        </div>
                        
                        <div class="space-y-5 mb-8">
                            <!-- Shipping goal indicator -->
                            <div class="bg-indigo-50/50 rounded-2xl p-4 border border-indigo-100/50">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs font-black text-indigo-600 uppercase tracking-widest">Free Shipping Status</span>
                                    <span class="text-xs font-bold text-indigo-600">Reached!</span>
                                </div>
                                <div class="h-2 w-full bg-slate-200 rounded-full overflow-hidden relative">
                                    <div class="absolute inset-0 bg-indigo-600 w-full rounded-full transition-all duration-1000">
                                        <div class="progress-shimmer w-full h-full"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between items-center px-2">
                                <span class="text-slate-500 font-bold">Selected Items</span>
                                <span id="selectedCount" class="text-slate-800 font-black">0</span>
                            </div>
                            <div class="flex justify-between items-center px-2">
                                <span class="text-slate-500 font-bold">Subtotal</span>
                                <span id="dynamicSubtotal" class="text-slate-800 font-black">0.00 KHR</span>
                            </div>
                            <div class="flex justify-between items-center px-2">
                                <span class="text-slate-500 font-bold">Delivery Fee</span>
                                <span class="text-emerald-500 font-black tracking-widest uppercase text-xs bg-emerald-50 px-3 py-1.5 rounded-lg">Complimentary</span>
                            </div>
                            
                            <div class="pt-6 border-t border-slate-200 flex justify-between items-center px-2">
                                <div class="flex flex-col">
                                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Grand Total</span>
                                    <span class="text-3xl font-black text-slate-900 tracking-tighter" id="dynamicTotal">0.00 KHR</span>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" id="checkoutBtn" class="group block w-full bg-indigo-600 hover:bg-slate-900 text-white font-black py-5 rounded-2xl transition-all shadow-xl shadow-indigo-500/20 active:scale-[0.98] disabled:opacity-40 disabled:grayscale disabled:cursor-not-allowed">
                            <span class="flex items-center justify-center gap-3">
                                <span>Proceed to Payment</span>
                                <i class="fas fa-chevron-right text-xs transition-transform group-hover:translate-x-1"></i>
                            </span>
                        </button>

                        <div class="mt-8 grid grid-cols-3 gap-4">
                            <div class="flex flex-col items-center gap-2 grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition-all cursor-default">
                                <i class="fab fa-cc-visa text-2xl"></i>
                                <span class="text-[8px] font-black uppercase text-slate-400">Visa</span>
                            </div>
                            <div class="flex flex-col items-center gap-2 grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition-all cursor-default">
                                <i class="fab fa-cc-mastercard text-2xl"></i>
                                <span class="text-[8px] font-black uppercase text-slate-400">Mastercard</span>
                            </div>
                            <div class="flex flex-col items-center gap-2 grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition-all cursor-default">
                                <i class="fas fa-shield-halved text-2xl"></i>
                                <span class="text-[8px] font-black uppercase text-slate-400">Verified</span>
                            </div>
                        </div>

                        <button type="button" onclick="confirmClear()" class="w-full mt-8 text-slate-400 hover:text-rose-500 text-xs font-black uppercase tracking-widest transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-broom"></i>
                            Clear Entire Selection
                        </button>
                    </div>
                </div>
            </div>
        </form>
        @else
        <div class="glass-card rounded-[3rem] border-2 border-slate-100 p-20 text-center shadow-inner">
            <div class="w-32 h-32 bg-slate-50 text-slate-300 rounded-[2rem] flex items-center justify-center mx-auto mb-10 shadow-inner group transition-all hover:scale-110">
                <i class="fas fa-shopping-basket text-6xl group-hover:text-indigo-600 transition-colors"></i>
            </div>
            <h2 class="text-4xl font-black text-slate-800 mb-4 tracking-tighter">Your cart is currently empty</h2>
            <p class="text-slate-400 max-w-sm mx-auto mb-12 font-medium">Elevate your digital life with our premium selection of technology. Discover something new today.</p>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-4 bg-indigo-600 hover:bg-slate-900 text-white font-black px-10 py-5 rounded-2xl transition-all shadow-xl shadow-indigo-500/20 group">
                <i class="fas fa-arrow-left group-hover:-translate-x-2 transition-transform"></i>
                Start Curating your Collection
            </a>
        </div>
        @endif
    </div>

    <!-- Hidden Forms & Modals same as before but refined styles -->
    <form id="updateForm" method="POST" class="hidden">@csrf <input type="hidden" name="qty" id="updateQty"></form>
    <form id="removeForm" method="POST" class="hidden">@csrf</form>
    <form id="clearForm" action="{{ route('cart.clear') }}" method="POST" class="hidden">@csrf</form>

    <div id="customModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-md transition-opacity duration-300">
        <div class="bg-white rounded-[2.5rem] shadow-2xl max-w-sm w-full p-10 transform transition-all scale-90 opacity-0 duration-300 border border-slate-100" id="modalContent">
            <div class="w-20 h-20 bg-rose-50 text-rose-500 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-inner">
                <i class="fas fa-trash-can-arrow-up text-3xl"></i>
            </div>
            <h3 class="text-2xl font-black text-center text-slate-800 mb-3 tracking-tight" id="modalTitle">Confirm Action</h3>
            <p class="text-slate-500 text-center mb-10 font-medium leading-relaxed px-2" id="modalMessage">Are you sure you want to proceed with this action?</p>
            <div class="flex gap-4">
                <button onclick="closeModal()" class="flex-1 py-4 px-6 rounded-2xl border-2 border-slate-100 text-slate-500 font-black text-sm uppercase tracking-widest hover:bg-slate-50 transition-all">Cancel</button>
                <button id="modalConfirmBtn" class="flex-1 py-4 px-6 rounded-2xl bg-rose-500 text-white font-black text-sm uppercase tracking-widest hover:bg-rose-600 transition-all shadow-lg shadow-rose-500/20">Remove</button>
            </div>
        </div>
    </div>

    <script>
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const selectAll = document.getElementById('selectAll');
        const checkoutBtn = document.getElementById('checkoutBtn');
        const selectedCountEl = document.getElementById('selectedCount');
        const dynamicSubtotalEl = document.getElementById('dynamicSubtotal');
        const dynamicTotalEl = document.getElementById('dynamicTotal');

        function calculateDynamicTotal() {
            let total = 0;
            let count = 0;
            document.querySelectorAll('.cart-item-card').forEach(item => {
                const checkbox = item.querySelector('.item-checkbox');
                if (checkbox.checked) {
                    item.classList.add('selected');
                    const price = parseFloat(item.dataset.price);
                    const qty = parseInt(item.dataset.qty);
                    total += price * qty;
                    count++;
                } else {
                    item.classList.remove('selected');
                }
            });

            selectedCountEl.textContent = count;
            const formattedTotal = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(total) + ' KHR';
            dynamicSubtotalEl.textContent = formattedTotal;
            dynamicTotalEl.textContent = formattedTotal;
            
            checkoutBtn.disabled = count === 0;
        }

        if (selectAll) {
            selectAll.addEventListener('change', (e) => {
                checkboxes.forEach(cb => cb.checked = e.target.checked);
                calculateDynamicTotal();
            });

            checkboxes.forEach(cb => {
                cb.addEventListener('change', () => {
                    const allChecked = Array.from(checkboxes).every(c => c.checked);
                    selectAll.checked = allChecked;
                    selectAll.indeterminate = !allChecked && Array.from(checkboxes).some(c => c.checked);
                    calculateDynamicTotal();
                });
            });
        }

        function updateQtyDirectly(id, change) {
            const item = document.querySelector(`.cart-item-card[data-id="${id}"]`);
            const currentQty = parseInt(item.dataset.qty);
            const newQty = currentQty + change;
            if (newQty < 1) return;

            const form = document.getElementById('updateForm');
            form.action = `/cart/update/${id}`;
            document.getElementById('updateQty').value = newQty;
            form.submit();
        }

        const modal = document.getElementById('customModal');
        const modalContent = document.getElementById('modalContent');
        const modalConfirmBtn = document.getElementById('modalConfirmBtn');

        function showModal(title, message, confirmAction, btnClass = 'bg-rose-500 hover:bg-rose-600 shadow-rose-500/20') {
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalMessage').textContent = message;
            
            modalConfirmBtn.className = `flex-1 py-4 px-6 rounded-2xl text-white font-black text-sm uppercase tracking-widest transition-all shadow-lg ${btnClass}`;
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-90', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);

            modalConfirmBtn.onclick = () => {
                confirmAction();
                closeModal();
            };
        }

        function closeModal() {
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-90', 'opacity-0');
            setTimeout(() => { modal.classList.add('hidden'); }, 300);
        }

        function confirmRemove(id, name) {
            showModal('Remove Item?', `Remove "${name}" from your curated selection?`, () => {
                const form = document.getElementById('removeForm');
                form.action = `/cart/remove/${id}`;
                form.submit();
            });
        }

        function confirmClear() {
            showModal('Clear Selection?', 'Are you sure you want to completely clear your current shopping session?', () => {
                document.getElementById('clearForm').submit();
            }, 'bg-indigo-600 hover:bg-slate-900 shadow-indigo-500/20');
        }

        if (selectAll) calculateDynamicTotal();
    </script>

</body>
</html>


