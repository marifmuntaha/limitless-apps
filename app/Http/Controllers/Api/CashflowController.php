<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCashflowRequest;
use App\Http\Requests\UpdateCashflowRequest;
use App\Http\Resources\CashflowResource;
use App\Models\Cashflow;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class CashflowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cashflow = new Cashflow();
        $cashflow = $request->type ? $cashflow->whereType($request->type) : $cashflow;
        $cashflow = ($request->start || $request->end)
            ? $cashflow->whereBetween('created_at', [$request->start, $request->end])
            : $cashflow;
        $cashflow = $cashflow->orderBy('created_at', 'DESC');
        return response([
            'message' => null,
            'result' => CashflowResource::collection($cashflow->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCashflowRequest $request)
    {
        $this->authorize('create', Cashflow::class);
        try {
            return ($cashflow = Cashflow::create($request->all())) ?
                response([
                    'message' => 'Data arus kas berhasil ditambahkan.',
                    'result' => $cashflow
                ]) : throw new Exception('Terjadi kesalahan server');
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
    public function show(Cashflow $cashflow)
    {

        return response([
            'message' => null,
            'result' => new CashflowResource($cashflow)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCashflowRequest $request, Cashflow $cashflow)
    {
        $this->authorize('update', $cashflow);
        try {
            return $cashflow->update(array_filter($request->all())) ?
                response([
                    'message' => 'Data arus kas berhasil diperbarui.',
                    'result' => $cashflow
                ]) : throw new Exception('Terjadi kesalahan server');
        }
        catch (Exception $exception){
            return response([
                'message' => $exception->getMessage(),
                'result' => null
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cashflow $cashflow)
    {
        $this->authorize('delete', $cashflow);
        try {
            return $cashflow->delete() ?
                response([
                    'message' => 'Data arus kas berhasil dihapus.',
                    'result' => $cashflow
                ]) : throw new Exception($cashflow);
        }
        catch (Exception $exception){
            return response([
                'message' => $exception->getMessage(),
                'result' => null
            ], 422);
        }
    }
}
