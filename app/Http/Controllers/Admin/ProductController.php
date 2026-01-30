<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|string',
            'stock' => 'required|string',
            'specifications' => 'nullable|array'
        ]);

        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            \Log::info('Image found in request', [
                'mime' => $file->getMimeType(),
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize()
            ]);
            
            $extension = $file->extension() ?: $file->getClientOriginalExtension() ?: 'png';
            $imageName = time().'.'.$extension;  
            $path = public_path('img/products');
            
            try {
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $file->move($path, $imageName);
                $data['image'] = '/img/products/' . $imageName;
                \Log::info('Image moved successfully', ['path' => $data['image']]);
            } catch (\Exception $e) {
                \Log::error('Failed to move image', ['error' => $e->getMessage()]);
                return back()->withInput()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()]);
            }
        } else {
            \Log::warning('No image file found in request');
        }
        $data['name'] = trim($data['name']);
        if (isset($data['desc'])) $data['desc'] = trim($data['desc']);
        $data['category'] = trim($data['category']);
        $data['stock'] = trim($data['stock']);

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|string',
            'stock' => 'required|string',
            'specifications' => 'nullable|array'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            \Log::info('Image found in request (update)', [
                'mime' => $file->getMimeType(),
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize()
            ]);
            
            $extension = $file->extension() ?: $file->getClientOriginalExtension() ?: 'png';
            $imageName = time().'.'.$extension;  
            $path = public_path('img/products');
            
            try {
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $file->move($path, $imageName);
                $data['image'] = '/img/products/' . $imageName;
                \Log::info('Update image successfully', ['path' => $data['image']]);
            } catch (\Exception $e) {
                \Log::error('Update image failed', ['error' => $e->getMessage()]);
                return back()->withInput()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()]);
            }
        }

        // Clean string fields
        $data['name'] = trim($data['name']);
        if (isset($data['desc'])) $data['desc'] = trim($data['desc']);
        $data['category'] = trim($data['category']);
        $data['stock'] = trim($data['stock']);

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
