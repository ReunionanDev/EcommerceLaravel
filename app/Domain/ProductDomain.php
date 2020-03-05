<?php

namespace App\Domain;
use App\Product;

class ProductDomain
{
    public function getProducts()
    {
        $products = Product::with('categories')->orderBy('created_at', 'DESC')->paginate(6);

        return $products;
    }

    public function getProductsByCategory()
    {
        $products = Product::with('categories')->whereHas('categories', function($query) {
                        $query->where('slug', request()->categorie);
                        })->orderBy('created_at', 'DESC')->paginate(6);
                        
        return $products;
    }
}