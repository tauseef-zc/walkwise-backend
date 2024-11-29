<?php

namespace App\Services\Stripe;

use App\Services\BaseService;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeService extends BaseService
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function createPaymentIntent(array $payload): array
    {
        try {
            $metadata = $payload['metadata'];

            if(isset($payload['billing'])){
                $billing = $payload['billing'];
                $metadata = [...$metadata, ...$billing];
            }

            $paymentIntent = PaymentIntent::create([
                'amount' => $payload['amount'] * 100,
                'currency' => 'usd',
                'payment_method_types' => ['card'],
                'statement_descriptor' => 'WalkWise Payment',
                'description' => $payload['description'],
                'metadata' => $metadata,
            ]);

            return ['clientSecret' => $paymentIntent->client_secret];

        } catch (\Exception $e) {
            return [ 'error' => $e->getMessage() ];
        }
    }

    public function getPaymentIntent(string $paymentIntentId): array
    {
        try {
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            return [
                'status' => $paymentIntent->status,
                'amount' => $paymentIntent->amount,
                'metadata' => $paymentIntent->metadata,
                'payment_ref' => [
                    'payment_intent_id' => $paymentIntent->id,
                    'client_secret' => $paymentIntent->client_secret,
                    'statement_descriptor' => $paymentIntent->statement_descriptor,
                    'description' => $paymentIntent->description,
                ]
            ];

        } catch (\Exception $e) {
            return [ 'error' => $e->getMessage() ];
        }
    }
}
