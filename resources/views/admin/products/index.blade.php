<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Products</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #0f172a;
            color: #e2e8f0;
        }

        .glass-panel {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #1e293b; 
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #475569; 
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #64748b; 
        }
    </style>
</head>
<body class="min-h-screen bg-slate-900 overflow-x-hidden">

    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 glass-panel border-b border-slate-700/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-indigo-500/20">
                        TP
                    </div>
                    <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-white to-slate-400">
                        TechPremium Admin
                    </span>
                </div>
                <div class="flex items-center gap-6">
                     <a href="{{ route('home') }}" class="text-sm font-medium text-slate-400 hover:text-white transition-colors">
                        View Store
                    </a>
                    <div class="h-6 w-px bg-slate-700"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="flex items-center gap-2 text-sm font-medium text-rose-400 hover:text-rose-300 transition-colors">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-28 pb-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Product Management</h1>
                <p class="text-slate-400">Manage your catalog, prices, and inventory.</p>
            </div>
            <a href="{{ route('admin.products.create') }}" class="group relative px-6 py-3 rounded-2xl bg-indigo-600 text-white font-semibold shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:-translate-y-0.5 transition-all overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <span class="relative flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    Add New Product
                </span>
            </a>
        </div>

        @if(session('success'))
        <div class="mb-8 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center gap-3 animate-fade-in-up">
            <i class="fas fa-check-circle text-xl"></i>
            {{ session('success') }}
        </div>
        @endif

        <!-- Products Table Card -->
        <div class="glass-panel rounded-3xl overflow-hidden shadow-2xl">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-700/50 bg-slate-800/30 text-xs uppercase tracking-wider text-slate-400 font-semibold">
                            <th class="px-8 py-6">Product Info</th>
                            <th class="px-6 py-6">Category</th>
                            <th class="px-6 py-6 text-right">Price</th>
                            <th class="px-6 py-6 text-center">Stock</th>
                            <th class="px-8 py-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        @foreach($products as $product)
                        <tr class="group hover:bg-slate-800/30 transition-colors">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="relative w-16 h-16 rounded-xl overflow-hidden bg-slate-800 border border-slate-700 flex-shrink-0">
                                        @if($product->image)
                                            <img src="{{ asset($product->image) }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-600">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-white group-hover:text-indigo-400 transition-colors">{{ $product->name }}</h3>
                                        <p class="text-xs text-slate-500 mt-0.5 w-48 truncate">{{ $product->desc }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-800 text-slate-300 border border-slate-700">
                                    {{ $product->category }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-right font-mono text-slate-300">
                                {{ number_format($product->price, 2) }} <span class="text-xs text-slate-500">KHR</span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                @php
                                    $stockClass = match($product->stock) {
                                        'in-stock' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                        'low-stock' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                        'out-of-stock' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                        default => 'bg-slate-500/10 text-slate-400 border-slate-500/20'
                                    };
                                    $stockIcon = match($product->stock) {
                                        'in-stock' => 'fa-check',
                                        'low-stock' => 'fa-exclamation',
                                        'out-of-stock' => 'fa-times',
                                        default => 'fa-box'
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold border {{ $stockClass }}">
                                    <i class="fas {{ $stockIcon }} text-[10px]"></i>
                                    {{ ucfirst(str_replace('-', ' ', $product->stock)) }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-400 hover:bg-indigo-500 hover:text-white transition-all" title="Edit">
                                        <i class="fas fa-pen text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-rose-500/10 flex items-center justify-center text-rose-400 hover:bg-rose-500 hover:text-white transition-all" title="Delete">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                @if($products->isEmpty())
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-600">
                        <i class="fas fa-box-open text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">No Products Found</h3>
                    <p class="text-slate-400 mb-6 max-w-sm mx-auto">Get started by adding your first product to the catalog.</p>
                    <a href="{{ route('admin.products.create') }}" class="text-indigo-400 font-medium hover:text-indigo-300">
                        Create Product &rarr;
                    </a>
                </div>
                @endif
            </div>
        </div>
    </main>

</body>
</html>
