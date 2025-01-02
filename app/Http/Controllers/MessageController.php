<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function sendMessagesTest()
    {
        $session = 'AGOES';
        $to = '6289519750202';
        $text = 'Hello, this is a test message from your API Gateway. System time: ' . now();

        for ($i = 0; $i < 10; $i++) {
            // Send HTTP GET request
            $response = Http::get("http://localhost:5001/message/send-text", [
                'session' => $session,
                'to' => $to,
                'text' => $text,
            ]);

            // Log response
            if ($response->successful()) {
                Log::info('Message sent successfully: ' . $response->body());
            } else {
                Log::error('Failed to send message: ' . $response->body());
            }

            // Delay for 5 seconds (adjust as needed)
            sleep(5);
        }

        return response()->json(['status' => 'Messages sent']);
    }
    
    public function sendText(Request $request)
    {
        $request->validate([
            'session' => 'required|string',
            'to' => 'required|string',
            'text' => 'required|string',
        ]);

        $session = $request->input('session');
        $to = $request->input('to');
        $text = $request->input('text');

        // Send message to the specified number
        $response = Http::post("http://localhost:5001/message/send-text", [
            'session' => $session,
            'to' => $to,
            'text' => $text,
        ]);

        // Log response
        if ($response->successful()) {
            Log::info('Message sent successfully: ' . $response->body());
        } else {
            Log::error('Failed to send message: ' . $response->body());
            return response()->json(['error' => 'Failed to send message'], 500);
        }


        return response()->json(['status' => 'Message sent']);
    }
}
