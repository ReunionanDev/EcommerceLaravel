<?php

namespace App\Domain;
use App\Product;

class ProductDomain
{
    public function getProducts()
    {
        return Product::with('categories')->orderBy('created_at', 'DESC')->paginate(6);
    }

    public function getProductsByCategory()
    {
        return Product::with('categories')->whereHas('categories', function($query) {
                    $query->where('slug', request()->categorie);
                    })->orderBy('created_at', 'DESC')->paginate(6);                
    }

    public function getProductBySlug($slug)
    {
        return Product::where('slug', $slug)->firstOrFail();
    }

    public function getProductsByTitleOrDescription($search)
    {
        return Product::where('title', 'like', "%$search%")
            ->orWhere('description', 'like', "%$search%")
            ->paginate(6);
    }
}