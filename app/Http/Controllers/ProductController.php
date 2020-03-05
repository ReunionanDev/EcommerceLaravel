<?php

namespace App\Http\Controllers;

use App\Domain\ProductDomain;
use Illuminate\Http\Request; 
use App\Product;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->productDomain = new ProductDomain();
    }

    public function index()
    {
        if(request()->categorie){
            $products = $this->productDomain->getProductsByCategory(request()->categorie);
            
        } else{
            $products = $this->productDomain->getProducts();
        }  
        return view('products.index')->with('products', $products);
    }

    public function show($slug)
    {
        $product = $this->productDomain->getProductBySlug($slug);

        return view('products.show')->with('product', $product);
    }

    public function search()
    {
        request()->validate([
            'search'=> 'required|min:3'
        ]);
        
        $search = request()->input('search');

        $products = $this->productDomain->getProductsByTitleOrDescription($search);

        return view('products.search')->with('products', $products);
    }
}
