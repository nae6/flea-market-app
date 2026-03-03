<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;

class PurchaseController extends Controller
{
    public function index(Item $item)
    {
        return view('dashboard.purchase', compact('item'));
    }

    public function create(Item $item)
    {
        return view('dashboard.address', compact('item'));
    }

    public function confirm(AddressRequest $request, Item $item)
    {
        $shipping = $request->validated();
        session(['shipping' => $shipping]);
        return redirect()->route('buy', $item);
    }

    public function checkout(PurchaseRequest $request, Item $item)
    {
        /**
         * sold購入不可
         * my_item購入不可
         */
        if ($item->status === 'sold')
        {
            abort(409, '売り切れです');
        }
        if ($item->user_id === auth()->id())
        {
            abort(403, 'あなたの出品商品です');
        }

        // ユーザー情報と配送先情報
        $profile = auth()->user()->profile;
        $shipping = session('shipping', []);

        $zip_code = $shipping['zip_code'] ?? $profile?->zip_code;
        $address = $shipping['address'] ?? $profile?->address;
        $building = $shipping['building'] ?? $profile?->building;

        Stripe::setApiKey(config('services.stripe.secret'));

        $baseUrl = rtrim(config('app.url'), '/');
        $successUrl = $baseUrl . route('index', [], false) . '?session_id={CHECKOUT_SESSION_ID}';
        $cancelUrl  = $baseUrl . route('index', [], false);

        return DB::transaction(function () use ($request, $item, $zip_code, $address, $building, $successUrl, $cancelUrl)
        {
            // orderの作成
            $order = Order::create([
                'buyer_id' => auth()->id(),
                'item_id' => $item->id,
                'payment_method' => $request->payment_method,
                'amount' => $item->price,
                'zip_code' => $zip_code,
                'address' => $address,
                'building' => $building,
                'status' => 'pending',
            ]);

            // 
            $checkout_session = CheckoutSession::create([
                'mode' => 'payment',
                'payment_method_types' => [$request->payment_method],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => $item->item_name,
                        ],
                        'unit_amount' => $item->price,
                    ],
                    'quantity' => 1,
                ]],
                'metadata' => [
                    'order_id' => $order->id,
                    'item_id' => $item->id,
                    'user_id' => auth()->id(),
                ],

                'success_url' => $successUrl,
                'cancel_url'  => $cancelUrl,
            ]);

            // orderの更新
            $order->update([
                'stripe_checkout_session_id' => $checkout_session->id,
            ]);

            // 
            $item = Item::lockForUpdate()->find($order->item_id);
            if ($item && $item->status !== '1') {
                $item->update(['status' => '2']);
            }

            return redirect()->away($checkout_session->url);
        });
    }
}
