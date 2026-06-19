<?php

namespace App\Http\Controllers;
use App\Exceptions\Controller;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;

class HotspotController extends Controller
{
        public function hotspot(Request $request): JsonResponse
    {
        // 1. Process your logic here (e.g., fetch database records or compute information)
        $data = [
            'status' => 'success',
            'message' => 'Function initiated successfully!',
            'timestamp' => now()
        ];

        // 2. Return the response as JSON
        return response()->json($data, 200);
    }
}
