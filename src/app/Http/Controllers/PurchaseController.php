<?php

namespace App\Http\Controllers;

use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Stripe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use App\Models\Order;
use App\Models\Item;

class PurchaseController extends Controller
{
    /**
     * 商品購入画面の表示
     */
    public function index(Item $item)
    {
        return view('dashboard.purchase', compact('item'));
    }

    /**
     * 商品配送先住所の変更画面の表示
     */
    public function create(Item $item)
    {
        return view('dashboard.address', compact('item'));
    }

    /**
     * 配送先住所を確定後、
     * 商品購入画面に入力内容を反映して表示
     */
    public function confirm(AddressRequest $request, Item $item)
    {
        $shipping = $request->validated();
        session(['shipping' => $shipping]);

        return redirect()->route('buy', $item);
    }

    /**
     * 支払い処理後、stripeのチェックアウト画面へリダイレクト
     */
    public function checkout(PurchaseRequest $request, Item $item)
    {
        // ユーザー情報と配送先情報の取り出し
        $profile = Auth::user()->profile;
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
            $lockedItem = Item::lockForUpdate()->findOrFail($item->id);

            //sold, my_item購入不可
            if ($lockedItem->status === '2') {
                abort(409, '売り切れです');
            }
            if ($lockedItem->user_id === Auth::id()) {
                abort(403, 'あなたの出品商品です');
            }

            $order = Order::where('item_id', $lockedItem->id)->first();

            // orderの作成
            if (!$order) {
                $order = Order::create([
                    'buyer_id' => Auth::id(),
                    'item_id' => $item->id,
                    'payment_method' => $request->payment_method,
                    'amount' => $item->price,
                    'zip_code' => $zip_code,
                    'address' => $address,
                    'building' => $building,
                    'status' => 'pending',
            ]);
            }

            // 購入処理(stripe)
            $checkout_session = CheckoutSession::create([
                'mode' => 'payment',
                'payment_method_types' => [$request->payment_method],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => ['name' => $item->item_name,],
                        'unit_amount' => $item->price,
                    ],
                    'quantity' => 1,
                ]],
                'metadata' => [
                    'order_id' => $order->id,
                    'item_id' => $item->id,
                    'user_id' => Auth::id(),
                ],

                'success_url' => $successUrl,
                'cancel_url'  => $cancelUrl,
            ]);

            // orderの更新
            $order->update([
                'stripe_checkout_session_id' => $checkout_session->id,
            ]);

            // item statusの変更
            $lockedItem->update(['status' => '2']);

            return redirect()->away($checkout_session->url);
        });
    }
}
