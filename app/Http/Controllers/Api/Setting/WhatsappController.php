<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsappController extends Controller
{
    public function init(Request $request)
    {
        try {
            $whatsapp = Http::asForm()
                ->get(config('whatsapp.host') . '/instance/init?key=' . $request->key)
                ->json();
            return response([
                'message' => 'Instance whatsapp berhasil, silahkan scan QRCode.',
                'result' => $whatsapp
            ]);
        }
        catch (Exception $exception){
            return response([
                'message' => $exception->getMessage(),
                'result' => null
            ], 422);
        }
    }
    public function qr64(Request $request)
    {
        try {
            $whatsapp = Http::asForm()
                ->get(config('whatsapp.host') . '/instance/qrbase64?key=' . $request->key)
                ->json();
            return response([
                'message' => null,
                'result' => $whatsapp
            ]);
        }
        catch (Exception $exception){
            return response([
                'message' => $exception->getMessage(),
                'result' => null
            ], 422);
        }
    }
    public function info(Request $request)
    {
        return response([
            'message' => null,
            'result' => Http::asForm()
                ->get(config('whatsapp.host') . '/instance/info?key=' . $request->key)
                ->json()
        ]);
    }
    public function delete(Request $request)
    {
        try {
            $whatsapp = Http::asForm()
                ->delete(config('whatsapp.host') . '/instance/delete?key=' . $request->key)
                ->json();
            return response([
                'message' => 'Instance whatsapp berhasil dihapus.',
                'result' => $whatsapp
            ]);
        }
        catch (Exception $exception){
            return response([
                'message' => $exception->getMessage(),
                'result' => null
            ], 422);
        }
    }

}
