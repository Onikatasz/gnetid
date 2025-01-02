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
        $text = 'Hello, this is a test message from your API Gateway. System time: ' . now()->setTimezone('Asia/Jakarta');

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

    public function showSendTextForm()
    {
        $response = Http::get("http://localhost:5001/session");

        return view('message.sendText', json_decode($response->body(), true));
    }
    
    public function sendText(Request $request)
    {
        // Check if phone number doesn have country code then change the first example is 0 to default is 62
        $phone = $request->input('phone');
        if (substr($phone, 0, 1) == '0') {
            $phone = '62' . substr($phone, 1);
        }

        $session = $request->input('session');
        $text = $request->input('text');

        // Send message to the specified number
        $response = Http::post("http://localhost:5001/message/send-text", [
            'session' => $session,
            'to' => $phone,
            'text' => $text,
        ]);

        // Log response
        if ($response->successful()) {
            Log::info('Message sent successfully: ' . $response->body());
        } else {
            Log::error('Failed to send message: ' . $response->body());
            return response()->json(['error' => 'Failed to send message'], 500);
        }


        return response()->json(['status' => 'Message sent'], 200);
    }
}
