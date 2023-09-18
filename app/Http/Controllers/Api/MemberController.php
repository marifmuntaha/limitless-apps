<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use Exception;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $members = new Member();
        $members = $request->status ? $members->whereStatus($request->status) : $members;
        $members = $request->order ? $members->orderBy('installation', $request->order) : $members;
        $members = $request->month ? $members->whereMonth('installation', $request->month) : $members;
        $members = $request->year ? $members->whereYear('installation', $request->year) : $members;
        $members = $request->category ? $members->whereCategory($request->category) : $members;
        $members = $request->limit ? $members->limit($request->limit) : $members;
        return response([
            'message' => null,
            'result' => MemberResource::collection($members->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberRequest $request)
    {
        $this->authorize('create', Member::class);
        try {
            return ($member = Member::create($request->all())) ?
                response([
                    'message' => 'Data Pelanggan berhasil ditambahkan',
                    'result' => $member
                ], 201) : throw new Exception('Terjadi kesalahan server');
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
    public function show(Member $member)
    {
        return response([
            'message' => null,
            'result' => new MemberResource($member)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $request, Member $member)
    {
        try {
            return $member->update(array_filter($request->except('user'))) ?
                response([
                    'message' => 'Data Pelanggan berhasil diperbarui',
                    'result' => $member
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
    public function destroy(Member $member)
    {
        try {
            return $member->delete() ?
                response([
                    'message' => 'Data Pelanggan berhasil dihapus',
                    'result' => $member
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
