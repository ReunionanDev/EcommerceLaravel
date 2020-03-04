<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cart.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Search if the item in the request is already in the cart and didn't add it again
        $duplicata = Cart::search(function ($cartItem, $rowId) use ($request) {
            return $cartItem->id == $request->id;
        });

        if($duplicata->isNotEmpty()){
            return redirect('/boutique')->with('success', "L'article a déjà été ajouté au panier");
        }

        // If the product is not already in the cart then we can add it
        $product = Product::find($request->id);

        Cart::add($product->id, $product->title, 1, $product->price)
            ->associate('App\Product');
        
        return redirect('/boutique')->with('success', "L'article a bien été ajouté au panier");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $rowId)
    {
        $validator = Validator::make($request->all(), [
            'qty' => 'required|numeric|between:1,5'
        ]);

        if($validator->fails()) {
            Session::flash('danger', 'Quantité invalide');
            return response()->json(['error' => 'Cart quantity has not been updated']);
        }

        Cart::update($rowId, $request->qty);

        Session::flash('success', 'Quantité mise à jour');

        return response()->json(['success' => 'Cart quantity has been updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($rowId)
    {
        Cart::remove($rowId);

        return back()->with('success', "L'article a été supprimé du panier");
    }
}
