<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Client;
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

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
