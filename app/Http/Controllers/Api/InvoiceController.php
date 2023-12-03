<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Models\User;
use App\Notifications\InvoiceStoreNotification;
use App\Notifications\InvoiceUpdateNotification;
use App\Notifications\PaymentCreate;
use Exception;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $invoice = new Invoice();
        $invoice = $request->member ? $invoice->whereMember($request->member) : $invoice;
        $invoice = $request->product ? $invoice->whereProduct($request->product) : $invoice;
        $invoice = $request->year ? $invoice->whereYear('created_at', '=', $request->year) : $invoice;
        $invoice = $request->month ? $invoice->whereMonth('created_at', '=', $request->month) : $invoice;
        $invoice = $request->status ? $invoice->whereStatus($request->status) : $invoice;
        $invoice = $request->start || $request->end ? $invoice->whereBetween('created_at', [$request->start, $request->end]) : $invoice;
        $invoice = $request->order ? $invoice->orderBy('created_at', $request->order) : $invoice;
        return response([
            'message' => null,
            'result' => InvoiceResource::collection($invoice->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        try {
            if ($invoice = Invoice::create($request->all())) {
                User::find($invoice->members->users->id)->notify(new InvoiceStoreNotification($invoice));
                return response([
                    'message' => 'Data Tagihan berhasil dibuat.',
                    'result' => $invoice
                ], 201);
            } else {
                throw new Exception('Terjadi Kesalahan Server');
            }
        } catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage(),
                'result' => null
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return response([
            'message' => null,
            'result' => new InvoiceResource($invoice)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        try {
            if ($invoice->update(array_filter($request->all()))) {
                $request->exists('amount') && $request->user()->notify(new InvoiceUpdateNotification($invoice));
                return response([
                    'message' => 'Data Tagihan berhasil diperbarui.',
                    'result' => $invoice
                ]);
            } else {
                throw new Exception('Terjadi kesalahan server');
            }
        } catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage(),
                'result' => null
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        try {
            return $invoice->delete() ?
                response([
                    'message' => 'Data tagihan berhasil dihapus.',
                    'result' => $invoice
                ]) : throw new Exception('Terjadi kesalahan server');
        } catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage(),
                'result' => null
            ], 422);
        }
    }

    public function sendNotification(Invoice $invoice)
    {
        try {
            $notify = $invoice->status == '1'
                ? new PaymentCreate($invoice->payments->last())
                : new InvoiceStoreNotification($invoice);
            User::find($invoice->members->users->id)->notify($notify);
            return response([
                'message' => 'Notifikasi berhasil dikirimkan',
                'result' => $invoice
            ]);
        } catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage(),
                'result' => null
            ], 422);
        }
    }
}
