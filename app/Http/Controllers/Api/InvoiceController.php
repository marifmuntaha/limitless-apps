<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
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
            return ($invoice = Invoice::create($request->all())) ? response([
                'message' => 'Data Tagihan berhasil dibuat.',
                'result' => $invoice
            ], 201) : throw new Exception('Terjadi Kesalahan Server');
        }
        catch (Exception $exception){
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
            return $invoice->update($request->all()) ?
                response([
                    'message' => 'Data Tagihan berhasil diperbarui.',
                    'result' => $invoice
                ]) : throw new Exception('Terjadi kesalahan server');
        }
        catch (Exception $exception)
        {
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
        }
        catch (Exception $exception){
            return response([
                'message' => $exception->getMessage(),
                'result' => null
            ], 422);
        }
    }
}
