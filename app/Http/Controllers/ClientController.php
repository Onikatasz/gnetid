<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Subscription;
use Carbon\Carbon;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentDate = Carbon::now();

        // Retrieve all clients with subscriptions (if any)
        $clients = Client::with(['subscriptions' => function($query) {
            $query->select('id', 'client_id', 'subscription_plan_id', 'username', 'password', 'start_date', 'end_date');
        }])->get();

        // Filter clients with valid subscriptions
        $clientsWithValidSubscriptions = Client::whereHas('subscriptions', function($query) use ($currentDate) {
            $query->where('end_date', '>', $currentDate);
        })->get();

        // Retrieve all subscriptions
        $subscriptionsClient = Subscription::all();

        // Decrypt passwords
        foreach ($subscriptionsClient as $subscription) {
            try {
                $subscription->decrypted_password = Crypt::decryptString($subscription->password);
                } catch (\Exception $e) {
                $subscription->decrypted_password = "Error decrypting password";
                }
        }

        return view('client.index', [
            'clients' => $clients,
            'clientsWithValidSubscriptions' => $clientsWithValidSubscriptions,
            'subscriptionsClient' => $subscriptionsClient
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $plans = SubscriptionPlan::all();
        return view('client.create', compact('plans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        // Validate data from StoreClientRequest
        
        // Check for duplicate phone
        if($request->input('phone')) {
            $client = Client::where('phone', $request->input('phone'))->first();
            if ($client) {
                return back()->withInput($request->only('name', 'nik', 'phone', 'address'))
                    ->with('error', 'Phone number already registered.');
            }
        }
    
        // Check for duplicate NIK
        if($request->input('nik')) {
            $client = Client::where('nik', $request->input('nik'))->first();
            if ($client) {
                return back()->withInput($request->only('name', 'nik', 'phone', 'address'))
                    ->with('error', 'NIK already registered.');
            }
        }
    
        // Create the client
        $client = Client::create([
            'name' => $request->input('name'),
            'nik' => $request->input('nik'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
        ]);
    
        // Compute end_date based on the start_date and $day
        
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = $startDate->copy()->addMonthNoOverflow();
    
        // Create subscription
        $subscription = Subscription::create([
            'client_id' => $client->id,
            'subscription_plan_id' => $request->input('subscription_plan_id'),
            'username' => "{$client->id}@netgpusat.com",
            'password' => Crypt::encryptString(Str::password(8)),
            'start_date' => $request->input('start_date'),
            'end_date' => $endDate,
        ]);

        $subscription->update([
            'username' => $subscription->id .'@netgpusat.com',
        ]);
    
        // Handle subscription creation failure
        if (!$subscription) {
            $client->delete();
            return back()->withInput($request->only('name', 'nik', 'phone', 'address'))
                ->with('error', 'Failed to create subscription.');
        }
    
        // Redirect with success message
        return redirect()->route('client.index')->with('success', 'Client created successfully.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $plans = SubscriptionPlan::all();
        $subscription = Subscription::where('client_id', $client->id)->first();

        $subscription->decrypted_password = Crypt::decryptString($subscription->password);

        return view('client.show', compact('client', 'subscription', 'plans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('client.edit', compact(var_name: 'client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        // The request is already validated by UpdateClientRequest

        // Update the client
        $client->update([
            'name' => $request->input('name'),
            'nik' => $request->input('nik'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
        ]);

        $subscription = Subscription::where('client_id', $client->id)->first();

        if ($request->input('password')) {
            $encrypted_password = Crypt::encryptString($request->input('password'));
        } else {
            $encrypted_password = $subscription->password;
        }

        if ($subscription) {
            $subscription->update([
                'subscription_plan_id' => $request->input('subscription_plan_id'),
                'username' => $request->input('username'),
                'password' => $encrypted_password,
            ]);
        }
        
    
        // Redirect to the clients index page with a success message
        return redirect()->route('client.index')->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        // Delete the client
        $client->delete();
    
        // Redirect to the clients index page with a success message
        return redirect()->route('client.index')->with('success', 'Client deleted successfully.');
    }

    public function searchByPhoneOrName(Request $request)
    {
        $query = $request->input('q');

        // Search for clients by phone or name
        $clients = Client::where('phone', 'like', "%$query%")
            ->orWhere('name', 'like', "%$query%")
            ->get(['id', 'name', 'phone']);

        return response()->json($clients);
    }


    public function showLoginClientForm()
    {
        if (Auth::guard('client')->check()) {
            return redirect()->route('client.dashboard');
        }

        return view('client.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20,phone',
        ]);

        // Find client by phone
        $client = Client::where('phone', $request->input('phone'))->first();

        if ($client) {
            // Log in manually without password
            Auth::guard('client')->login($client); // Logs in the client directly

            // Create session data
            $request->session()->put('client_id', $client->id);
    
            return redirect()->route('client.dashboard');
        }

        // Return error if phone number does not exist
        return back()->withInput($request->only('phone'))->withErrors([
            'phone' => 'Invalid phone number.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('client')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('showLoginClientForm');
    }

    public function dashboard()
    {
        // Check if the client is not logged in using the 'client' guard
        if (!Auth::guard('client')->check()) {
            return redirect()->route('showLoginClientForm');
        }

        // Get the authenticated client
        $client = Auth::guard('client')->user();

        return view('client.dashboard', compact('client'));
    }
}
