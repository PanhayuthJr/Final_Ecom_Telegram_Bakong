<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Public static method to return all products from Database
    public static function getProducts()
    {
        return \App\Models\Product::latest()->get()->toArray();
    }


    // Show catalog page
    public function index()
    {
        $products = $this->getProducts();
        return view('catelog', compact('products'));
    }

    // Show individual product detail
    public function show($id)
    {
        $products = $this->getProducts();

        // Safe: find product by 'id'
        $product = collect($products)->firstWhere('id', $id);

        if (!$product) {
            abort(404); // product not found
        }

        // Related products logic
        $relatedProducts = collect($products)
            ->filter(function ($item) use ($product) {
                return strtolower($item['category']) === strtolower($product['category']) && $item['id'] !== $product['id'];
            });

        if ($relatedProducts->count() < 4) {
            $otherProducts = collect($products)
                ->filter(function ($item) use ($product, $relatedProducts) {
                    return $item['id'] !== $product['id'] && !$relatedProducts->contains('id', $item['id']);
                })
                ->shuffle()
                ->take(4 - $relatedProducts->count());
            
            $relatedProducts = $relatedProducts->merge($otherProducts);
        }

        $relatedProducts = $relatedProducts->take(4);

        return view('product-detail', compact('product', 'relatedProducts'));
    }
}
