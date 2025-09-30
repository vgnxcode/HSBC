<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use vgn\KaleyraSmsLogs;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class KaleyraController extends Controller
{

public function smsCallback(Request $request)
{
    try {
        Log::info('Kaleyra SMS Callback:', $request->all());

        // Parse and format datetime values
        $sentTime = $request->get('sent_time') 
            ? Carbon::parse($request->get('sent_time'))->format('Y-m-d H:i:s') 
            : null;

        $deliveredTime = $request->get('delivered_time') 
            ? Carbon::parse($request->get('delivered_time'))->format('Y-m-d H:i:s') 
            : null;

        KaleyraSmsLogs::create([
            'status'          => $request->get('status'),
            'message_id'      => $request->get('message_id'),
            'recipient'       => $request->get('to'),
            'sent_time'       => $sentTime,
            'delivered_time'  => $deliveredTime,
            'full_payload'    => json_encode($request->all()),
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        return response()->json(['success' => true]);

    } catch (\Exception $e) {
        Log::error('Kaleyra Callback Error: ' . $e->getMessage());
        return response()->json(['success' => false], 500);
    }
}

public function gupshup(Request $request)
{
    try
    {
        Log::info('gupshup SMS Callback:', $request->all());        
        return response()->json(['success' => true]);

    } 
    catch (\Exception $e)
    {
        Log::error('gupshup Callback Error: ' . $e->getMessage());
        return response()->json(['success' => false], 500);
    }
}



}
