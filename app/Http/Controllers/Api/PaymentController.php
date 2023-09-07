<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Exception;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $payment = new Payment();
        $payment = $request->invoice ? $payment->whereInvoice($request->invoice) : $payment;
        return response([
            'message' => null,
            'result' => PaymentResource::collection($payment->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        try {
            return ($payment = Payment::create($request->all())) ?
                response([
                    'message' => 'Data Pembayaran berhasil disimpan.',
                    'result' => $payment
                ], 201) : throw new Exception('Terjadi kesalahan server.');
        }
        catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage(),
                'result' => null
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        return response([
            'message' => null,
            'result' => new PaymentResource($payment)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        try {
            return $payment->update(array_filter($request->all())) ?
                response([
                    'message' => 'Data Pembayaran berhasil diperbarui.',
                    'result' => $request
                ]) : throw new Exception('Terjadi kesalahan server');
        }
        catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage(),
                'result' => null
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        try {
            return $payment->delete() ?
                response([
                    'message' => 'Data Pembayaran berhasil dihapus.',
                    'result' => $payment
                ]) : throw new Exception('Terjadi kesalahan server.');
        }
        catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage(),
                'result' => null
            ], 422);
        }
    }
}
