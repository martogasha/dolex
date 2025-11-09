<?php

namespace App\Http\Controllers;

use App\Cat;
use App\Exceptions\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Session;

class IndexController extends Controller
{
    public function index(){
        $oldCart = Session::get('cat');
        $cart = new Cat($oldCart);
        $prods  = Product::all();
        return view('client.index',[
            'prods'=>$prods,
            'products'=>$cart->item,
            'totalPrice'=>$cart->totalPrice
        ]);
    }
    public function cart(){
        if (!Session::has('cat')){
            return view('client.cart');
        }
        $oldCart = Session::get('cat');
        $cart = new Cat($oldCart);
        return view('client.cart', [
            'products'=>$cart->item,
            'totalPrice'=>$cart->totalPrice
        ]);
    }
    public function storeCart(Request $request){
        $product = Product::find($request->productId);
        $oldCart = Session::has('cat') ? Session::get('cat') : null;
        $cart = new Cat($oldCart);
        $cart->add($product , $product->id);
        $request->session()->put('cat',$cart);
    }
    public function addByOne($id){
        $oldCart = Session::has('cat') ? Session::get('cat'):null;
        $cart = new Cat($oldCart);
        $cart->addByOne($id);
        if (count($cart->item)>0) {
            Session::put('cat', $cart);
        }
        else{
            Session::forget('cat');
        }
        return redirect()->back()->with('success','ITEM SUCCESSFULLY ADDED TO CART');
    }
    public function getReduceByOne($id){
        $oldCart = Session::has('cat') ? Session::get('cat'):null;
        $cart = new Cat($oldCart);
        $cart->reduceByOne($id);
        if (count($cart->item)>0) {
            Session::put('cat', $cart);
        }
        else{
            Session::forget('cat');
        }
        return redirect()->back()->with('success','ITEM SUCCESSFULLY REMOVED FROM CART');
    }
    public function removeItem($id){
        $oldCart = Session::has('cat') ? Session::get('cat'):null;
        $cart = new Cat($oldCart);
        $cart->removeItem($id);
        if (count($cart->item)>0) {
            Session::put('cat', $cart);
        }
        else{
            Session::forget('cat');
        }
        return redirect()->back()->with('success','ITEM SUCCESSFULLY REMOVED FROM CART');
    }
        public function checkout(){
            $oldCart = Session::get('cat');
            $cart = new Cat($oldCart);
            return view('client.checkout',[
                'products'=>$cart->item,
                'totalPrice'=>$cart->totalPrice,
            ]);
        }
    public function account(){
        return view('client.account');
    }
}
