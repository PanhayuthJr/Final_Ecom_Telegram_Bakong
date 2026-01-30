<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | New Product</title>
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
    </style>
</head>
<body class="min-h-screen bg-slate-900 pb-20">

    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 glass-panel border-b border-slate-700/50">
        <div class="max-w-4xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 text-slate-400 hover:text-white transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span class="font-medium">Back to Products</span>
            </a>
            <span class="font-bold text-white">Create Product</span>
        </div>
    </nav>

    <main class="pt-28 max-w-4xl mx-auto px-6">
        @if ($errors->any())
            <div class="mb-8 p-4 bg-red-500/10 border border-red-500/50 rounded-2xl text-red-500 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-8" enctype="multipart/form-data">
            @csrf

            <!-- Product Details Card -->
            <div class="glass-panel p-8 rounded-3xl space-y-8">
                <h2 class="text-xl font-bold text-white flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-indigo-500 flex items-center justify-center text-sm"><i class="fas fa-info"></i></span>
                    Basic Information
                </h2>

                <div class="grid md:grid-cols-2 gap-8">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-400 mb-2">Product Name</label>
                        <input type="text" name="name" required class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all placeholder-slate-600" placeholder="e.g. Asus ROG Strix G16">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-2">Category</label>
                        <select name="category" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all cursor-pointer">
                            <option value="Gaming">Gaming</option>
                            <option value="Business">Business</option>
                            <option value="Ultrabook">Ultrabook</option>
                            <option value="Creative">Creative</option>
                            <option value="Accessory">Accessory</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-2">Price (KHR)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-slate-500">KHR</span>
                            <input type="number" name="price" required step="0.01" class="w-full bg-slate-800 border border-slate-700 rounded-xl pl-14 pr-4 py-3 text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" placeholder="0.00">
                        </div>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-400 mb-2">Product Image</label>
                        <div class="space-y-4">
                            <div id="image-preview" class="hidden w-full max-w-sm aspect-video rounded-2xl border-2 border-dashed border-slate-700 overflow-hidden bg-slate-800/50 flex items-center justify-center">
                                <img id="preview-img" src="#" alt="Preview" class="w-full h-full object-cover">
                            </div>
                            <div class="flex gap-4">
                                <input type="file" name="image" id="image-input" accept="image/*" class="flex-1 bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700">
                            </div>
                        </div>
                    </div>

                    <script>
                        document.getElementById('image-input').onchange = function (evt) {
                            const [file] = this.files
                            if (file) {
                                const preview = document.getElementById('image-preview');
                                const img = document.getElementById('preview-img');
                                preview.classList.remove('hidden');
                                img.src = URL.createObjectURL(file);
                            }
                        }
                    </script>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-400 mb-2">Description</label>
                        <textarea name="desc" rows="4" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all placeholder-slate-600" placeholder="Detailed product description..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-2">Stock Status</label>
                        <select name="stock" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all cursor-pointer">
                            <option value="in-stock">In Stock</option>
                            <option value="low-stock">Low Stock</option>
                            <option value="out-of-stock">Out of Stock</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Specifications Card -->
            <div class="glass-panel p-8 rounded-3xl space-y-8">
                <h2 class="text-xl font-bold text-white flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-emerald-500 flex items-center justify-center text-sm"><i class="fas fa-microchip"></i></span>
                    Technical Specifications
                </h2>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Processor / CPU</label>
                        <input type="text" name="specifications[Processor]" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500 transition-all" placeholder="e.g. Intel Core i9-13900H">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Graphics / GPU</label>
                        <input type="text" name="specifications[GPU]" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500 transition-all" placeholder="e.g. NVIDIA RTX 4080">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Memory / RAM</label>
                        <input type="text" name="specifications[RAM]" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500 transition-all" placeholder="e.g. 32GB DDR5">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Storage</label>
                        <input type="text" name="specifications[Storage]" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500 transition-all" placeholder="e.g. 1TB NVMe SSD">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Display</label>
                        <input type="text" name="specifications[Display]" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500 transition-all" placeholder="e.g. 16-inch QHD+ 240Hz">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Weight</label>
                        <input type="text" name="specifications[Weight]" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-2.5 text-white focus:outline-none focus:border-indigo-500 transition-all" placeholder="e.g. 2.4 kg">
                    </div>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="flex items-center justify-end gap-4 pt-4 border-t border-slate-700/50">
                <a href="{{ route('admin.products.index') }}" class="px-6 py-3 rounded-xl border border-slate-600 text-slate-300 font-medium hover:bg-slate-800 transition-colors">Cancel</a>
                <button type="submit" class="px-8 py-3 rounded-xl bg-indigo-600 text-white font-bold shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:-translate-y-0.5 transition-all">
                    Create Product
                </button>
            </div>

        </form>
    </main>

</body>
</html>
