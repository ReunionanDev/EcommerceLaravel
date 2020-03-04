<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Arr;
use Session;
use App\Order;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Cart::count() <= 0){
            return redirect('/boutique');
        }

        Stripe::setApiKey('sk_test_ZLpFspOnXpfu35gZ953EvfHL00Zu8ZKtVj');

        $intent = PaymentIntent::create([
            'amount' => round(Cart::total()),
            'currency' => 'eur',
        ]);

        $clientSecret = Arr::get($intent, 'client_secret');

        return view('checkout.index', ['clientSecret' => $clientSecret ]);
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
        $payment = $request->json()->all();

        $order = new Order();
        $order->payment_intent_id = $payment['paymentIntent']['id'];
        $order->amount = $payment['paymentIntent']['amount'];
        $order->payment_created_at = (new DateTime())
            ->setTimestamp($payment['paymentIntent']['created'])
            ->format('Y-m-d H:i:s');

        $products= [];
        $i = 0;

        foreach(Cart::content() as $product){
            $products['product_' . $i][] = $product->model->title;
            $products['product_' . $i][] = $product->model->price;
            $products['product_' . $i][] = $product->qty;
            $i++;
        }

        $order->products = serialize($products);
        $order->user_id = 15;
        $order->save();

        if($payment['paymentIntent']['status'] === 'succeeded'){
            //delete the cart
            Cart::destroy();
            Session::flash('success', 'Votre commande a été traitée avec succès');
            return response()->json(['success' => 'Payment Intent Succeeded']);
        } else{
            return response()->json(['error' => 'Payment Intent Failed']);
        }
    }

    public function thankyou()
    {
        return Session::has('success') ? view('checkout.thankyou') : redirect()->route('products.index');
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
