<?php

namespace App\Http\Controllers\AdminAsst;

use App\Http\Controllers\Controller;
use App\Models\InventoryControl;
use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = InventoryControl::query();

        if ($request->filled('barangay_id')) {
            $query->where('barangay_id', $request->barangay_id);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('item_name', 'like', '%' . $request->search . '%');
        }

        $items = $query->orderBy('item_name')->paginate(15);
        $barangays = Barangay::orderBy('barangay_name')->get();

        $lowStockCount = InventoryControl::whereRaw('quantity <= minimum_stock')->count();

        return view('admin-asst.inventory.index', compact('items', 'barangays', 'lowStockCount'));
    }

    public function create()
    {
        $barangays = Barangay::orderBy('barangay_name')->get();
        return view('admin-asst.inventory.create', compact('barangays'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'unit' => 'required|string|max:50',
            'quantity' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'expiry_date' => 'nullable|date',
            'barangay_id' => 'required|exists:barangays,barangay_id',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['status'] = 'active';

        InventoryControl::create($validated);

        return redirect()->route('admin-asst.inventory.index')
            ->with('success', 'Inventory item created successfully.');
    }

    public function show(InventoryControl $inventory)
    {
        return view('admin-asst.inventory.show', compact('inventory'));
    }

    public function edit(InventoryControl $inventory)
    {
        $barangays = Barangay::orderBy('barangay_name')->get();
        return view('admin-asst.inventory.edit', compact('inventory', 'barangays'));
    }

    public function update(Request $request, InventoryControl $inventory)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'unit' => 'required|string|max:50',
            'quantity' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'expiry_date' => 'nullable|date',
            'barangay_id' => 'required|exists:barangays,barangay_id',
        ]);

        $inventory->update($validated);

        return redirect()->route('admin-asst.inventory.show', $inventory)
            ->with('success', 'Inventory item updated successfully.');
    }

    public function destroy(InventoryControl $inventory)
    {
        $inventory->delete();

        return redirect()->route('admin-asst.inventory.index')
            ->with('success', 'Inventory item deleted successfully.');
    }

    public function lowStock()
    {
        $items = InventoryControl::whereRaw('quantity <= minimum_stock')
            ->orderBy('quantity')
            ->get();

        return view('admin-asst.inventory.low-stock', compact('items'));
    }
}