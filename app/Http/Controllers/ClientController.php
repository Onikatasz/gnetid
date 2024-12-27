<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
                $subscription->decrypted_password = decrypt($subscription->password);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                $subscription->decrypted_password = 'Invalid encryption';
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
        return view('client.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        // The request is already validated by StoreClientRequest
    
        // Create the new client and store in the database
        Client::create([
            'name' => $request->input('name'),
            'nik' => $request->input('nik'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
        ]);
    
        // Redirect to the clients index page with a success message
        return redirect()->route('client.index')->with('success', 'Client created successfully.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return view('client.show', compact(var_name: 'client'));
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
    
        // Update the client with the new data
        $client->update([
            'name' => $request->input('name'),
            'nik' => $request->input('nik'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
        ]);
        
    
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
