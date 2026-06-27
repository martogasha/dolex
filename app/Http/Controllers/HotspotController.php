<?php

namespace App\Http\Controllers;
use App\Exceptions\Controller;
use Illuminate\Http\JsonResponse;
use RouterOS\Client;
use RouterOS\Query;
use RouterOS\Config;
use Illuminate\Support\Facades\Log;

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
    public function storeHotspotUser(Request $request){
    Log::info($request->all());
    dd($request->all());
        
              try {
            // 2. Initialize the MikroTik API Client
            $client = new Client([
                'host' => '192.168.0.106',
                'user' => 'admin',
                'pass' => 'admin',
                'port' => 8728,
            ]);

            // 3. Build the query payload targeting /ip/hotspot/user/add
            $query = new Query('/ip/hotspot/user/add');
            $query->equal('name', $request['phone']);
            $query->equal('password', $request['phone']);
            
            if (!empty($validated['profile'])) {
                $query->equal('profile', $validated['profile']);
            }
            
            if (!empty($validated['comment'])) {
                $query->equal('comment', $validated['comment']);
            }

            // 4. Send the request and read the response
            $response = $client->query($query)->read();

            // Check if MikroTik returned an error array
            if (isset($response['after']['message'])) {
                Log::info('error');
                return response()->json([
                    'status' => 'error',
                    'message' => $response['after']['message']
                ], 400);
            }

                 Log::info('Hotspot user successfully created on MikroTik.');
         

        } catch (Exception $e) {
             Log::info('catch error');
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to connect to MikroTik Router: ' . $e->getMessage()
            ], 500);
        }


             // 2. MikroTik Connection Details
        $config = [
                'host' => '192.168.0.106',
                'user' => 'admin',
                'pass' => 'admin',
                'port' => 8728,
        ];

        try {
            $client = new Client($config);

            // 3. Build the Hotspot Active Login Query
            $query = (new Query('/ip/hotspot/active/login'))
                ->equal('user', $request->phone)
                ->equal('password', $request->phone)
                ->equal('mac-address', $request->mac)
                ->equal('ip', $request->ip);

            // 4. Send Query to RouterOS
            $response = $client->query($query)->read();

            return response()->json([
                'status' => 'success',
                'message' => 'User logged in successfully',
                'data' => $response
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to connect to MikroTik: ' . $e->getMessage()
            ], 500);
        }
        
    }
}
