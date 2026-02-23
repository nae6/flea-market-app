<?php

namespace App\Listeners;

use Laravel\Cashier\Events\WebhookReceived;
use Illuminate\Support\Facades\Log;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class HandleStripeWebhookReceived
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        Log::info('WEBHOOK FIRED', [
            'type' => data_get($event->payload, 'type'),
            'event_id' => data_get($event->payload, 'id'),
        ]);

        if (data_get($event->payload, 'type') !== 'checkout.session.completed') {
            return;
        }

        $sessionId = data_get($event->payload, 'data.object.id');
        $paymentIntentId = data_get($event->payload, 'data.object.payment_intent');

        Log::info('checkout.session.completed received', [
            'event_id' => data_get($event->payload, 'id'),
            'session_id' => $sessionId,
            'payment_intent_id' => $paymentIntentId,
        ]);

        if (!$sessionId) {
            return;
        }

        DB::transaction(function () use ($sessionId, $paymentIntentId) {
            $order = Order::lockForUpdate()
                ->where('stripe_checkout_session_id', $sessionId)
                ->first();

            if (!$order) {
                return;
            }

            if ($order->status === 'paid') {
                return;
            }

            $order->update([
                'status' => 'paid',
                'stripe_payment_intent_id' => $paymentIntentId,
            ]);
        });
    }
}