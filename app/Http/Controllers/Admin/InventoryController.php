<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarcodeMapping;
use App\Models\InventoryMovement;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(): View
    {
        $recentMovements = InventoryMovement::with(['product', 'barcodeMapping', 'user'])
            ->latest()
            ->take(20)
            ->get();

        $todayIn = InventoryMovement::where('type', 'in')
            ->whereDate('created_at', today())
            ->sum('total_quantity');

        $todayOut = InventoryMovement::where('type', 'out')
            ->whereDate('created_at', today())
            ->sum('total_quantity');

        $todayScans = InventoryMovement::whereDate('created_at', today())->count();

        $products = Product::orderBy('name')->get(['id', 'name']);

        return view('admin.inventory.index', compact(
            'recentMovements', 'todayIn', 'todayOut', 'todayScans', 'products'
        ));
    }

    public function scan(Request $request): JsonResponse
    {
        $request->validate(['barcode' => 'required|string|max:100']);

        $barcode = trim($request->barcode);
        $mapping = BarcodeMapping::with('product')->where('barcode', $barcode)->first();

        if (!$mapping) {
            return response()->json([
                'status' => 'unknown',
                'barcode' => $barcode,
                'products' => Product::orderBy('name')->get(['id', 'name']),
            ]);
        }

        return response()->json([
            'status' => 'known',
            'barcode' => $barcode,
            'mapping' => [
                'id' => $mapping->id,
                'product_name' => $mapping->product->name,
                'product_id' => $mapping->product_id,
                'unit_type' => $mapping->unit_type,
                'unit_label' => BarcodeMapping::unitTypeLabels()[$mapping->unit_type],
                'quantity_per_unit' => $mapping->quantity_per_unit,
                'label' => $mapping->label,
                'current_stock' => $mapping->product->stock,
                'product_image' => $mapping->product->image ? asset('storage/'.$mapping->product->image) : null,
            ],
        ]);
    }

    public function registerBarcode(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'barcode' => 'required|string|max:100|unique:barcode_mappings,barcode',
            'product_id' => 'required|exists:products,id',
            'unit_type' => 'required|in:unite,pack,carton,palette',
            'quantity_per_unit' => 'required|integer|min:1',
            'label' => 'nullable|string|max:255',
            'product_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $mapping = BarcodeMapping::create([
            'barcode' => $validated['barcode'],
            'product_id' => $validated['product_id'],
            'unit_type' => $validated['unit_type'],
            'quantity_per_unit' => $validated['quantity_per_unit'],
            'label' => $validated['label'] ?? null,
        ]);
        $mapping->load('product');

        // Save photo to the product if provided
        $photoSaved = false;
        if ($request->hasFile('product_photo')) {
            $photoSaved = $this->saveProductPhoto($mapping->product, $request->file('product_photo'));
        }

        return response()->json([
            'status' => 'registered',
            'photo_saved' => $photoSaved,
            'mapping' => [
                'id' => $mapping->id,
                'product_name' => $mapping->product->name,
                'product_id' => $mapping->product_id,
                'unit_type' => $mapping->unit_type,
                'unit_label' => BarcodeMapping::unitTypeLabels()[$mapping->unit_type],
                'quantity_per_unit' => $mapping->quantity_per_unit,
                'label' => $mapping->label,
                'current_stock' => $mapping->product->stock,
                'product_image' => $mapping->product->image ? asset('storage/'.$mapping->product->image) : null,
            ],
        ]);
    }

    /**
     * Upload/replace a product photo (from inventory scanner).
     */
    public function uploadProductPhoto(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $product = Product::findOrFail($request->product_id);
        $saved = $this->saveProductPhoto($product, $request->file('photo'));

        return response()->json([
            'status' => $saved ? 'success' : 'error',
            'message' => $saved ? 'Photo enregistree !' : 'Erreur lors de l\'enregistrement.',
            'product_image' => $product->fresh()->image ? asset('storage/'.$product->fresh()->image) : null,
        ]);
    }

    /**
     * Save/replace a product photo file.
     */
    private function saveProductPhoto(Product $product, \Illuminate\Http\UploadedFile $file): bool
    {
        // Delete old image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $path = $file->store('products', 'public');

        if ($path) {
            $product->update(['image' => $path]);

            return true;
        }

        return false;
    }

    public function addMovement(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'barcode_mapping_id' => 'required|exists:barcode_mappings,id',
            'type' => 'required|in:in,out',
            'unit_count' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
            'dlc' => 'nullable|date',
            'dluo' => 'nullable|date',
            'lot_number' => 'nullable|string|max:100',
        ]);

        $mapping = BarcodeMapping::with('product')->findOrFail($validated['barcode_mapping_id']);
        $totalQty = $validated['unit_count'] * $mapping->quantity_per_unit;

        $movement = InventoryMovement::create([
            'product_id' => $mapping->product_id,
            'barcode_mapping_id' => $mapping->id,
            'type' => $validated['type'],
            'unit_type' => $mapping->unit_type,
            'unit_count' => $validated['unit_count'],
            'quantity_per_unit' => $mapping->quantity_per_unit,
            'total_quantity' => $totalQty,
            'barcode' => $mapping->barcode,
            'note' => $validated['note'] ?? null,
            'dlc' => $validated['dlc'] ?? null,
            'dluo' => $validated['dluo'] ?? null,
            'lot_number' => $validated['lot_number'] ?? null,
            'user_id' => auth()->id(),
        ]);

        // Update product stock
        $product = $mapping->product;
        if ($validated['type'] === 'in') {
            $product->increment('stock', $totalQty);
        } else {
            $product->decrement('stock', min($totalQty, $product->stock));
        }

        // Broadcast stock update for real-time alerts
        $product->refresh();
        event(new \App\Events\StockUpdated($product->id, $product->name, $product->stock));

        return response()->json([
            'status' => 'success',
            'movement' => [
                'id' => $movement->id,
                'type' => $movement->type,
                'unit_count' => $movement->unit_count,
                'unit_type' => $mapping->unit_type,
                'unit_label' => BarcodeMapping::unitTypeLabels()[$mapping->unit_type],
                'total_quantity' => $totalQty,
                'product_name' => $product->name,
                'new_stock' => $product->fresh()->stock,
            ],
        ]);
    }

    public function updateMapping(Request $request, BarcodeMapping $mapping): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'unit_type' => 'required|in:unite,pack,carton,palette',
            'quantity_per_unit' => 'required|integer|min:1',
            'label' => 'nullable|string|max:255',
        ]);

        $mapping->update($validated);
        $mapping->load('product');

        return response()->json(['status' => 'updated', 'mapping' => $mapping]);
    }

    public function deleteMapping(BarcodeMapping $mapping): JsonResponse
    {
        $mapping->delete();
        return response()->json(['status' => 'deleted']);
    }

    public function stats(): View
    {
        $movementsThisMonth = InventoryMovement::with(['product', 'barcodeMapping'])
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->latest()
            ->get();

        $totalInThisMonth = $movementsThisMonth->where('type', 'in')->sum('total_quantity');
        $totalOutThisMonth = $movementsThisMonth->where('type', 'out')->sum('total_quantity');

        // Top products restocked
        $topRestocked = InventoryMovement::where('type', 'in')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->selectRaw('product_id, SUM(total_quantity) as total_in, COUNT(*) as scan_count')
            ->groupBy('product_id')
            ->orderByDesc('total_in')
            ->with('product')
            ->take(10)
            ->get();

        // By unit type
        $byUnitType = InventoryMovement::where('type', 'in')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->selectRaw('unit_type, SUM(unit_count) as total_units, SUM(total_quantity) as total_items')
            ->groupBy('unit_type')
            ->get()
            ->keyBy('unit_type');

        // Daily activity (last 7 days)
        $dailyActivity = InventoryMovement::whereDate('created_at', '>=', now()->subDays(6))
            ->selectRaw('DATE(created_at) as date, type, SUM(total_quantity) as total')
            ->groupBy('date', 'type')
            ->orderBy('date')
            ->get();

        // Products with DLC approaching (within 7 days)
        $expiringDlc = InventoryMovement::where('type', 'in')
            ->whereNotNull('dlc')
            ->whereDate('dlc', '<=', now()->addDays(7))
            ->whereDate('dlc', '>=', today())
            ->with('product')
            ->orderBy('dlc')
            ->get();

        // Products already expired
        $expiredDlc = InventoryMovement::where('type', 'in')
            ->whereNotNull('dlc')
            ->whereDate('dlc', '<', today())
            ->with('product')
            ->orderByDesc('dlc')
            ->take(10)
            ->get();

        $mappings = BarcodeMapping::with('product')->latest()->get();

        return view('admin.inventory.stats', compact(
            'totalInThisMonth', 'totalOutThisMonth', 'topRestocked',
            'byUnitType', 'dailyActivity', 'mappings', 'movementsThisMonth',
            'expiringDlc', 'expiredDlc'
        ));
    }
}
