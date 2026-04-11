<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::with('barangay');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('barangay_id')) {
            $query->where('barangay_id', $request->barangay_id);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $clients = $query->orderBy('created_at', 'desc')->paginate(15);
        $barangays = Barangay::orderBy('barangay_name')->get();

        return view('admin-staff.clients.index', compact('clients', 'barangays'));
    }

    public function show(Client $client)
    {
        $client->load(['barangay', 'pets', 'livestock']);

        return view('admin-staff.clients.show', compact('client'));
    }

    public function create()
    {
        $barangays = Barangay::orderBy('barangay_name')->get();

        return view('admin-staff.clients.create', compact('barangays'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'suffix' => 'nullable|string|max:20',
            'email' => 'required|email|unique:clients,email',
            'phone_number' => 'required|string|size:11',
            'alternate_phone' => 'nullable|string|size:11',
            'house_no' => 'nullable|string|max:50',
            'street' => 'nullable|string|max:100',
            'subdivision' => 'nullable|string|max:100',
            'barangay_id' => 'nullable|exists:barangays,barangay_id',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'password' => 'required|string|min:8',
            'status' => 'nullable|in:active,inactive,suspended',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $client = Client::create(array_merge(
            $request->validated(),
            ['password' => Hash::make($request->password)]
        ));

        return redirect()->route('clients.show', $client)
            ->with('success', 'Client created successfully.');
    }

    public function edit(Client $client)
    {
        $client->load('barangay');
        $barangays = Barangay::orderBy('barangay_name')->get();

        return view('admin-staff.clients.edit', compact('client', 'barangays'));
    }

    public function update(Request $request, Client $client)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'suffix' => 'nullable|string|max:20',
            'email' => 'required|email|unique:clients,email,' . $client->client_id . ',client_id',
            'phone_number' => 'required|string|size:11',
            'alternate_phone' => 'nullable|string|size:11',
            'house_no' => 'nullable|string|max:50',
            'street' => 'nullable|string|max:100',
            'subdivision' => 'nullable|string|max:100',
            'barangay_id' => 'nullable|exists:barangays,barangay_id',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'status' => 'nullable|in:active,inactive,suspended',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $client->update($request->validated());

        return redirect()->route('clients.show', $client)
            ->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }
}