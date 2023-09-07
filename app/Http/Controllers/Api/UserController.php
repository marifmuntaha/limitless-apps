<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = new User();
        $users = $request->role ? $users->whereRole($request->role) : $users;
        return response([
            'message' => null,
            'result' => UserResource::collection($users->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            return ($user = User::create($request->all())) ?
                response([
                    'message' => 'Data pengguna berhasil ditambahkan.',
                    'result' => $user
                ], 201) : throw new Exception('Terjadi kesalahan server');
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
    public function show(User $user)
    {
        return response([
            'message' => null,
            'result' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            return $user->update(array_filter($request->all())) ?
                response([
                    'message' => 'Data pengguna berhasil diperbarui.',
                    'result' => $user
                ]) : throw new Exception('Terjadi kesalahan server.');
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
    public function destroy(User $user)
    {
        try {
            return $user->delete() ?
                response([
                    'message' => 'Data pengguna berhasil dihapus.',
                    'result' => $user
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
