<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\InventoryItem;
use App\Models\StockMovement;

class InventoryController extends Controller
{
    /**
     * Show inventory dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        $items = InventoryItem::count();
        $lowStock = InventoryItem::lowStock()->count();
        $expiringSoon = InventoryItem::expiringSoon()->count();
        $expired = InventoryItem::expired()->count();
        
        $recentItems = InventoryItem::latest()->take(5)->get();
        $recentMovements = StockMovement::latest()->take(5)->get();
        
        return view('dashboard.inventory', compact('items', 'lowStock', 'expiringSoon', 'expired', 'recentItems', 'recentMovements'));
    }

    /**
     * List all inventory items.
     */
    public function index(Request $request)
    {
        $query = InventoryItem::query();

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Search by name
        if ($request->has('search') && $request->search) {
            $query->where('item_name', 'like', '%' . $request->search . '%');
        }

        // Show low stock only
        if ($request->has('low_stock') && $request->low_stock) {
            $query->lowStock();
        }

        $items = $query->latest()->paginate(10);
        return view('inventory.index', compact('items'));
    }

    /**
     * Show create inventory item form.
     */
    public function create()
    {
        return view('inventory.create');
    }

    /**
     * Store new inventory item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'item_code' => 'nullable|string|unique:inventory_items,item_code',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'unit' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'min_stock_level' => 'nullable|integer|min:0',
            'expiry_date' => 'nullable|date',
            'supplier' => 'nullable|string|max:255',
            'cost_per_unit' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:active,inactive,discontinued',
        ]);

        $validated['user_id'] = Auth::id();

        $item = InventoryItem::create($validated);

        // Create initial stock movement for stock-in
        if ($validated['quantity'] > 0) {
            StockMovement::create([
                'inventory_item_id' => $item->id,
                'user_id' => Auth::id(),
                'movement_type' => 'stock_in',
                'quantity' => $validated['quantity'],
                'previous_quantity' => 0,
                'new_quantity' => $validated['quantity'],
                'reference_number' => 'INITIAL_STOCK',
                'remarks' => 'Initial stock entry',
                'movement_date' => now(),
            ]);
        }

        return redirect()->route('inventory.index')
            ->with('success', 'Inventory item created successfully!');
    }

    /**
     * Show inventory item details.
     */
    public function show(InventoryItem $item)
    {
        $movements = StockMovement::where('inventory_item_id', $item->id)
            ->latest()
            ->paginate(10);
        return view('inventory.show', compact('item', 'movements'));
    }

    /**
     * Show edit inventory item form.
     */
    public function edit(InventoryItem $item)
    {
        return view('inventory.edit', compact('item'));
    }

    /**
     * Update inventory item.
     */
    public function update(Request $request, InventoryItem $item)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'item_code' => 'nullable|string|unique:inventory_items,item_code,' . $item->id,
            'category' => 'required|string',
            'description' => 'nullable|string',
            'unit' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'min_stock_level' => 'nullable|integer|min:0',
            'expiry_date' => 'nullable|date',
            'supplier' => 'nullable|string|max:255',
            'cost_per_unit' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:active,inactive,discontinued',
        ]);

        $item->update($validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Inventory item updated successfully!');
    }

    /**
     * Delete inventory item.
     */
    public function destroy(InventoryItem $item)
    {
        $item->delete();
        return redirect()->route('inventory.index')
            ->with('success', 'Inventory item deleted successfully!');
    }

    /**
     * Show stock-in form.
     */
    public function showStockIn(InventoryItem $item)
    {
        return view('inventory.stock_in', compact('item'));
    }

    /**
     * Process stock-in.
     */
    public function stockIn(Request $request, InventoryItem $item)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'reference_number' => 'nullable|string',
            'remarks' => 'nullable|string',
            'movement_date' => 'nullable|date',
        ]);

        $previousQuantity = $item->quantity;
        $newQuantity = $previousQuantity + $validated['quantity'];

        // Update item quantity
        $item->update(['quantity' => $newQuantity]);

        // Create stock movement
        StockMovement::create([
            'inventory_item_id' => $item->id,
            'user_id' => Auth::id(),
            'movement_type' => 'stock_in',
            'quantity' => $validated['quantity'],
            'previous_quantity' => $previousQuantity,
            'new_quantity' => $newQuantity,
            'reference_number' => $validated['reference_number'] ?? null,
            'remarks' => $validated['remarks'] ?? 'Stock in',
            'movement_date' => $validated['movement_date'] ?? now(),
        ]);

        return redirect()->route('inventory.show', $item->id)
            ->with('success', 'Stock added successfully!');
    }

    /**
     * Show stock-out form.
     */
    public function showStockOut(InventoryItem $item)
    {
        return view('inventory.stock_out', compact('item'));
    }

    /**
     * Process stock-out.
     */
    public function stockOut(Request $request, InventoryItem $item)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $item->quantity,
            'reference_number' => 'nullable|string',
            'remarks' => 'nullable|string',
            'movement_date' => 'nullable|date',
        ]);

        $previousQuantity = $item->quantity;
        $newQuantity = $previousQuantity - $validated['quantity'];

        // Update item quantity
        $item->update(['quantity' => $newQuantity]);

        // Create stock movement
        StockMovement::create([
            'inventory_item_id' => $item->id,
            'user_id' => Auth::id(),
            'movement_type' => 'stock_out',
            'quantity' => $validated['quantity'],
            'previous_quantity' => $previousQuantity,
            'new_quantity' => $newQuantity,
            'reference_number' => $validated['reference_number'] ?? null,
            'remarks' => $validated['remarks'] ?? 'Stock out',
            'movement_date' => $validated['movement_date'] ?? now(),
        ]);

        return redirect()->route('inventory.show', $item->id)
            ->with('success', 'Stock removed successfully!');
    }

    /**
     * Show stock adjustment form.
     */
    public function showAdjustment(InventoryItem $item)
    {
        return view('inventory.adjustment', compact('item'));
    }

    /**
     * Process stock adjustment.
     */
    public function adjustment(Request $request, InventoryItem $item)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer',
            'reference_number' => 'nullable|string',
            'remarks' => 'nullable|string',
            'movement_date' => 'nullable|date',
        ]);

        $previousQuantity = $item->quantity;
        $newQuantity = $validated['quantity'];

        // Update item quantity
        $item->update(['quantity' => $newQuantity]);

        // Create stock movement
        StockMovement::create([
            'inventory_item_id' => $item->id,
            'user_id' => Auth::id(),
            'movement_type' => 'adjustment',
            'quantity' => abs($newQuantity - $previousQuantity),
            'previous_quantity' => $previousQuantity,
            'new_quantity' => $newQuantity,
            'reference_number' => $validated['reference_number'] ?? null,
            'remarks' => $validated['remarks'] ?? 'Stock adjustment',
            'movement_date' => $validated['movement_date'] ?? now(),
        ]);

        return redirect()->route('inventory.show', $item->id)
            ->with('success', 'Stock adjusted successfully!');
    }

    /**
     * View all stock movements.
     */
    public function movements(Request $request)
    {
        $query = StockMovement::query();

        // Filter by item
        if ($request->has('item_id') && $request->item_id) {
            $query->where('inventory_item_id', $request->item_id);
        }

        // Filter by movement type
        if ($request->has('movement_type') && $request->movement_type) {
            $query->where('movement_type', $request->movement_type);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('movement_date', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('movement_date', '<=', $request->end_date);
        }

        $movements = $query->latest()->paginate(10);
        $items = InventoryItem::pluck('item_name', 'id');
        return view('inventory.movements', compact('movements', 'items'));
    }

    /**
     * View low stock alerts.
     */
    public function lowStock()
    {
        $items = InventoryItem::lowStock()->get();
        return view('inventory.low_stock', compact('items'));
    }

    /**
     * View expiring items.
     */
    public function expiring()
    {
        $items = InventoryItem::expiringSoon()->get();
        return view('inventory.expiring', compact('items'));
    }

    /**
     * Export inventory report.
     */
    public function export()
    {
        // Implementation for export
        return redirect()->back()->with('info', 'Export feature coming soon!');
    }
}
