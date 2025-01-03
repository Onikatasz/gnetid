<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use PhpParser\Builder\Function_;
use App\Models\Subscription;

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
        // Validate incoming request
        $request->validate([
            'session' => 'required|string',
            'phone' => 'required|string',
            'text' => 'required|string',
        ]);

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

    public function showSendBroadcastForm()
    {
        $response = Http::get("http://localhost:5001/session");

        return view('message.sendBroadcast', json_decode($response->body(), true));
    }

    public function sendBroadcast(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'session' => 'required|string',
            'phones' => 'required|array',
            'text' => 'required|string',
            'delay' => 'nullable|integer|min:1', // Optional delay (default 5 seconds)
        ]);

        // Check if phone number doesn have country code then change the first example is 0 to default is 62
        $phones = $request->input('phones');
        foreach ($phones as $key => $phone) {
            if (substr($phone, 0, 1) == '0') {
                $phones[$key] = '62' . substr($phone, 1);
            }
        }

        $session = $request->input('session');
        $text = $request->input('text');
        $delay = $request->input('delay', 5); // Default delay is 5 seconds

        foreach ($phones as $phone) {
            try {
                // Send HTTP GET request
                $response = Http::post("http://localhost:5001/message/send-text", [
                    'session' => $session,
                    'to' => $phone,
                    'text' => $text,
                ]);

                // Log the response
                if ($response->successful()) {
                    Log::info("Message sent to $phone: " . $response->body());
                } else {
                    Log::error("Failed to send message to $phone: " . $response->body());
                }

                // Delay before sending the next message
                sleep($delay);

            } catch (\Exception $e) {
                Log::error("Error sending message to $phone: " . $e->getMessage());
            }
        }

        return response()->json(['status' => 'Broadcast completed']);
    }

    public function sendBillingByText(Request $request)
    {
        $phoneParam = $request->route('phone');
        $phone = $phoneParam;

        
        // Check if phone number doesn have country code then change the first example is 0 to default is 62
        if (substr($phone, 0, 1) == '0') {
            $updatedPhone = '62' . substr($phone, 1);
        }

        $subscription = Subscription::whereHas('client', function ($query) use ($phone, $updatedPhone) {
            $query->where('phone', $phone)->orWhere('phone', $updatedPhone);
        })->first();

        $session = 'AGOES';
        if (!$subscription) {
            return response()->json(['error' => 'Subscription not found'], 404);
        }

        $amount = $subscription->subscriptionPlan->price;
        $plan = $subscription->subscriptionPlan->title;
        $encryptedId = Crypt::encryptString($subscription->id);
        $payUrl = route('subscription.payment', ['id' => $encryptedId]);
        $text = "Your $plan subscription fee of Rp " . number_format($amount, 0, ',', '.') . 
                " has been billed to your account. Please make your payment using the following link: $payUrl. " . 
                "Thank you for using our service.";

        // Send billing request to the specified number
        $response = Http::post("http://localhost:5001/message/send-text", [
            'session' => $session,
            'to' => $updatedPhone,
            'text' => $text,
        ]);

        // Log response
        if ($response->successful()) {
            Log::info('Billing request sent successfully: ' . $response->body());
        } else {
            Log::error('Failed to send billing request: ' . $response->body());
            return response()->json(['error' => 'Failed to send billing request'], 500);
        }

        return response()->json(['status' => 'Billing request sent'], 200);
    }
}
