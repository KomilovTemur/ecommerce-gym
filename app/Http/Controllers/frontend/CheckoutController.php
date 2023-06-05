<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $old_cartitem = Cart::where('user_id', Auth::id())->get();
        foreach ($old_cartitem as $item) {
            if (!Product::where('id', $item->prod_id)->where('qty', '>=', $item->prod_qty)->exists()) {
                $removeItem = Cart::where('user_id', Auth::id())->where('prod_id', $item->prod_id)->first();
                $removeItem->delete();
            }
        }
        $cartitem = Cart::where('user_id', Auth::id())->get();
        return view('frontend.checkout', compact('cartitem'));
    }

    public function placeOrder(Request $request)
    {
        $order  = new Order();
        $order->user_id = Auth::id();
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $total = 0;

        $cartitems_total = Cart::where('user_id', Auth::id())->get();
        foreach ($cartitems_total as $prod) {
            $total += $prod->products->selling_price * $prod->prod_qty;
        }

        $order->total_price = $total;

        $order->tracking_no = 'ecomerce' . rand(1111, 9999);
        $order->save();
        $order->id;
        $cartitem = Cart::where('user_id', Auth::id())->get();

        foreach ($cartitem as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'prod_id' => $item->prod_id,
                'qty' => $item->prod_qty,
                'price' => $item->products->selling_price,
            ]);

            $prod = Product::where('id', $item->prod_id)->first();
            $prod->qty = $prod->qty - $item->prod_qty;
            $prod->update();
        }

        // if (Auth::user()->address1 == NULL) {
        //     $user = User::where('id', Auth::id())->first();
        //     $user->name = $request->input('lname');
        //     $user->phoneno = $request->input('phoneno');
        //     $user->address1 = $request->input('address1');
        //     $user->address2 = $request->input('address2');
        //     $user->city = $request->input('city');
        //     $user->state = $request->input('state');
        //     $user->country = $request->input('country');
        //     $user->pincode = $request->input('pincode');
        //     $user->update();
        // }
        $cartitems = Cart::where('user_id', Auth::id());
        Cart::destroy($cartitem);


        return redirect('/')->with('status', "Order Placed successfully");
    }
}
