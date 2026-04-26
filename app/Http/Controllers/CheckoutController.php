<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Cart;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($request->has('product_id')) {
            $product = \App\Models\Product::findOrFail($request->product_id);
            $rental_days = max(1, (int) $request->rental_days);

            $subtotal = $product->product_price * $rental_days;
            $shipping = 30;
            $grand_total = $subtotal + $shipping;

            session([
                'grand_total' => $grand_total,
                'book_now' => [
                    'product_id' => $product->id,
                    'rental_days' => $rental_days,
                ]
            ]);

            // Pass as a single-item array to reuse the same checkout blade
            $items = collect([
                (object) [
                    'product' => $product,
                    'rental_days' => $rental_days,
                ]
            ]);

            return view('checkout.index', compact('user', 'items', 'subtotal', 'shipping', 'grand_total'));
        }
        session()->forget('book_now');
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $items = $cart->items()->with('product')->get();

        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item->product->product_price * $item->rental_days;
        }

        $shipping = 30;
        $grand_total = $subtotal + $shipping;

        session(['grand_total' => $grand_total]);

        return view('checkout.index', compact('user', 'items', 'subtotal', 'shipping', 'grand_total'));
    }

    public function done()
    {
        $user = Auth::user();
        $orderGroupId = time();
        //Book now flow
        if (session()->has('book_now')) {
            $bookNow = session()->pull('book_now'); // reads AND deletes it
            $product = \App\Models\Product::findOrFail($bookNow['product_id']);
            $days = $bookNow['rental_days'];

            DB::table('checkout')->insert([
                'user_id' => $user->id,
                'drone_id' => $product->id,
                'order_group_id' => $orderGroupId,
                'rental_date' => Carbon::now()->addDay(),
                'return_date' => Carbon::now()->addDay()->addDays($days),
                'status' => 'paid',
                'total_price' => $product->product_price * $days,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return view('checkout.done');
        }

        //Add to cart flow
        $cart = Cart::where('user_id', $user->id)->first();

        if ($cart) {

            $items = $cart->items()->with('product')->get();

            $orderGroupId = time();

            foreach ($items as $item) {

                $days = $item->rental_days;

                DB::table('checkout')->insert([
                    'user_id' => $user->id,
                    'drone_id' => $item->product->id,
                    'order_group_id' => $orderGroupId,

                    'rental_date' => Carbon::now()->addDay(),
                    'return_date' => Carbon::now()->addDay()->addDays($days),

                    'status' => 'paid',
                    'total_price' => $item->product->product_price * $days,

                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $cart->items()->delete();
        }

        return view('checkout.done');
    }
}