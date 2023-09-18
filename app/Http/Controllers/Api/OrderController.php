<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        sleep(3);
        $order = new Order();
        $order = $request->member ? $order->whereMember($request->member) : $order;
        return response([
            'message' => null,
            'result' => OrderResource::collection($order->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        try {
            return ($order = Order::create($request->all())) ?
                response([
                    'message' => 'Data Pesanan berhasil dibuat.',
                    'result' => $order
                ], 201) : throw new Exception('Terjadi kesalahan server.');
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
    public function show(Order $order)
    {
        return response([
            'message' => null,
            'result' => new OrderResource($order)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        try {
            return ($order->update(array_filter($request->all()))) ?
                response([
                    'message' => 'Data Pesanan berhasil diperbarui..',
                    'result' => $order
                ]) : throw new Exception('Terjadi kesalahan server.');
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
    public function destroy(Order $order)
    {
        try {
            return $order->delete() ?
                response([
                    'message' => 'Data Pesanan berhasil dihapus.'
                ]) : throw new Exception('Terjadi kesalahan server.');
        }
        catch (Exception $exception){
            return response([
                'message' => $exception->getMessage(),
                'result' => null
            ], 422);
        }
    }
}
