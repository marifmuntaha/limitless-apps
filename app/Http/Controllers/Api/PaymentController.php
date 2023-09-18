<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Models\User;
use App\Notifications\PaymentCreate;
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
        $payment = $request->start || $request->end ? $payment->whereBetween('at', [$request->start, $request->end]) : $payment;
        $payment = $request->account ? $payment->whereMethod($request->account) : $payment;
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
            if ($payment = Payment::create($request->all())){
                User::find($payment->invoices->members->users->id)->notify(new PaymentCreate($payment));
                return response([
                    'message' => 'Data Pembayaran berhasil disimpan.',
                    'result' => $payment
                ], 201);
            }
            else {
                throw new Exception('Terjadi kesalahan server.');
            }
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
