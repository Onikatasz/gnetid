<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::all();

        return view('ticket.index', [
            'tickets' => $tickets
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();

        return view('ticket.create', [
            'clients' => $clients
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {

        $client = Client::find($request->input('client_id'));

        if (!$client) {
            return redirect()->back()->withErrors(['client_id' => 'Client not found.']);
        }

        Ticket::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'status' => $request->input('status'),
            'client_id' => $client->id,
        ]);

        return redirect()->route('ticket.index')->with('success', 'Ticket created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return view('ticket.show', [
            'ticket' => $ticket
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $ticket->update([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'status' => $request->input('status'),
            'client_id' => $request->input('client_id'),
        ]);

        return redirect()->route('ticket.index')->with('success', 'Ticket updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    public function checkMyTicket()
    {
        $client = Auth::guard('client')->user();

        if (!$client) {
            return redirect()->back()->withErrors(['client' => 'Client not found for the authenticated user.']);
        }

        $tickets = Ticket::where('client_id', $client->id)->get();

        return view('ticket.checkMyTicket', [
            'tickets' => $tickets
        ]);
    }

    public function createMyTicket()
    {
        return view('ticket.createMyTicket');
    }

    public function storeMyTicket(Request $request)
    {
        // Get the authenticated client
        $client = Auth::guard('client')->user();

        // Handle unauthorized access if client is not authenticated
        if (!$client) {
            return redirect()->back()->withErrors(['client' => 'Client not found for the authenticated user.']);
        }

        // Validate the request
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'status' => 'in:pending,in_progress,completed',
        ]);

        // Create a new ticket
        Ticket::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'status' => 'pending',
            'client_id' => $client->id,
        ]);

        // Redirect to checkMyTicket with success message
        return redirect()->route('ticket.checkMyTicket')->with('success', 'Ticket created successfully.');
    }

}
