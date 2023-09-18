<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use Exception;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $account = new Account();
        return response([
            'message' => null,
            'result' => AccountResource::collection($account->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccountRequest $request)
    {
        try {
            $this->authorize('create', Account::class);
            return ($account = Account::create($request->all())) ?
                response([
                    'message' => 'Data Rekening berhasil ditambahkan.',
                    'result' => $account
                ], 201) : throw new Exception('Data Rekening gagal ditambahkan.');
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
    public function show(Account $account)
    {
        return response([
            'message' => null,
            'result' => new AccountResource($account)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountRequest $request, Account $account)
    {
        $this->authorize('update', $account);
        try {
            return $account->update(array_filter($request->all())) ?
                response([
                    'message' => 'Data Rekening berhasil diperbarui.'
                ]) : throw new Exception('Data Rekening gagal diperbarui');
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
    public function destroy(Account $account)
    {
        try {
            return $account->delete() ?
                response([
                    'message' => 'Data Rekening berhasil dihapus',
                    'result' => $account
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
