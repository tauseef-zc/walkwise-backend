<?php

namespace App\Http\Controllers\V1\Api\Stripe;

use App\Http\Controllers\Controller;
use App\Http\Resources\Payments\PaymentResource;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\Stripe\StripeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as JsonCollection;
use Illuminate\Http\Response;

class PaymentController extends Controller
{
    private StripeService $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    public function index(): JsonCollection
    {
        $payments = request()->user()->payments()->paginate(10);
        $payments->load('booking', 'booking.tour', 'booking.tour.images');

        return PaymentResource::collection($payments);
    }

    public function getPayment(Payment $payment): JsonResponse
    {
        if(request()->user()->id !== $payment->user_id) return response()->json([], JsonResponse::HTTP_FORBIDDEN);

        $payment->load(['booking', 'booking.tour', 'booking.tour.images', 'booking.tour.category', 'booking.tour.user', 'booking.tour.user.guide']);
        return response()->json(new PaymentResource($payment));
    }
    public function createPaymentIntent(Request $request): JsonResponse
    {
        $payload = $request->toArray();
        $payload['metadata'] = json_decode($payload['metadata'], true);
        $payload['billing'] = json_decode($payload['billing'], true);

        if(isset($payload['amount']) && isset($payload['metadata'])){
            $bookingFields = $this->prepareBookingFields($payload);
            $booking = Booking::create($bookingFields);

            $payload['metadata']['booking_id'] = $booking->id;
        }

        $data = $this->stripeService->createPaymentIntent($payload);

        return response()->json($data, !isset($data['error']) ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function confirmPayment(string $paymentId): JsonResponse
    {
        $data = $this->stripeService->getPaymentIntent($paymentId);

        if(isset($data['status']) && $data['status'] === 'succeeded') {

            $booking = Booking::find($data['metadata']['booking_id']);
            $booking->update(['status' => 1]);

            $payment = $this->createPayment($booking, $data);

            return response()->json([
                'status' => 'success',
                'booking_id' => $booking->id,
                'payment_id' => $payment->id,
            ]);
        }

        return response()->json([], Response::HTTP_BAD_REQUEST);
    }

    private function prepareBookingFields(array $payload): array
    {
        $metadata = $payload['metadata'];
        $billing = $payload['billing'];

        return [
            'tour_id' => $metadata['tourId'],
            'user_id' => $metadata['userId'],
            'booking_date' => now()->setDateFrom($metadata['startDate'])->format('Y-m-d'),
            'total' => $payload['amount'],
            'adults' => $metadata['guestAdults'],
            'children' => $metadata['guestChildren'],
            'infants' => $metadata['guestInfants'],
            ...$billing
        ];
    }

    private function createPayment(Booking $booking, array $data): Payment
    {
        return Payment::create([
            'booking_id' => $booking->id,
            'user_id' => $booking->user_id,
            'payment_date' => now(),
            'amount' => $data['amount'] / 100,
            'payment_method' => 1,
            'transaction_id' => $data['payment_ref']['payment_intent_id'],
            'transaction_ref' => json_encode($data['payment_ref']),
            'status' => 1,
        ]);
    }

}
