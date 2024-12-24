<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use Carbon\Carbon;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the current date and time
        $currentDate = Carbon::now();
    
        // Retrieve all clients
        $clients = Client::all();
    
        // Retrieve clients with valid subscriptions (not expired)
        $clientsWithValidSubscriptions = Client::whereHas('subscriptions', function($query) use ($currentDate) {
            $query->where('end_date', '>', $currentDate); // Check if the subscription is still valid
        })->get();
    
        // Return the data to a view
        return view('client.index', [
            'clients' => $clients,
            'clientsWithValidSubscriptions' => $clientsWithValidSubscriptions,
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
}
