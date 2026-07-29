<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Region;
use Illuminate\Http\Request;

class VehicleMonitoringController extends Controller
{
    /**
     * Display a listing of the vehicles.
     */
    public function index(Request $request)
    {
        $query = Vehicle::with('region');

        // Filter by Region
        if ($request->filled('region')) {
            $query->where('region_id', $request->region);
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by Name or Plate Number
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('plate_number', 'LIKE', "%{$search}%");
            });
        }

        $vehicles = $query->get();
        $regions = Region::all();

        $totalVehicles = Vehicle::count();
        $availableVehicles = Vehicle::where('status', 'available')->count();
        $inUseVehicles = Vehicle::where('status', 'in_use')->count();
        $maintenanceVehicles = Vehicle::where('status', 'maintenance')->count();

        return view('admin.vehicles', compact(
            'vehicles',
            'regions',
            'totalVehicles',
            'availableVehicles',
            'inUseVehicles',
            'maintenanceVehicles'
        ));
    }

    /**
     * Show the form for creating a new vehicle.
     */
    public function create()
    {
        $regions = Region::all();
        return view('admin.vehicle-create', compact('regions'));
    }

    /**
     * Store a newly created vehicle in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'brand' => 'nullable|string|max:50',
            'plate_number' => 'required|string|max:20|unique:vehicles',
            'type' => 'required|in:people,goods',
            'year' => 'nullable|integer|min:2000|max:' . (date('Y') + 1),
            'capacity' => 'nullable|integer|min:1',
            'ownership' => 'required|in:company,rental',
            'status' => 'required|in:available,in_use,maintenance',
            'fuel_consumption' => 'nullable|numeric|min:0|max:99.99',
            'odometer' => 'nullable|integer|min:0',
            'last_service_date' => 'nullable|date',
            'next_service_date' => 'nullable|date',
            'insurance_expiry' => 'nullable|date',
            'region_id' => 'nullable|exists:regions,id',
        ]);

        Vehicle::create($request->all());

        return redirect()->route('admin.vehicles.index')
                         ->with('success', 'Kendaraan berhasil ditambahkan!');
    }

    /**
     * Display the specified vehicle.
     */
    public function show($id)
    {
        $vehicle = Vehicle::with(['region', 'bookings.driver', 'bookings.user'])
                         ->findOrFail($id);
        
        $bookings = $vehicle->bookings()->latest()->take(10)->get();
        
        return view('admin.vehicle-detail', compact('vehicle', 'bookings'));
    }

    /**
     * Show the form for editing the specified vehicle.
     */
    public function edit($id)
    {
        $vehicle = Vehicle::with('region')->findOrFail($id);
        $regions = Region::all();
        
        return view('admin.vehicle-edit', compact('vehicle', 'regions'));
    }

    /**
     * Update the specified vehicle in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'brand' => 'nullable|string|max:50',
            'plate_number' => 'required|string|max:20|unique:vehicles,plate_number,' . $id,
            'type' => 'required|in:people,goods',
            'year' => 'nullable|integer|min:2000|max:' . (date('Y') + 1),
            'capacity' => 'nullable|integer|min:1',
            'ownership' => 'required|in:company,rental',
            'status' => 'required|in:available,in_use,maintenance',
            'fuel_consumption' => 'nullable|numeric|min:0|max:99.99',
            'odometer' => 'nullable|integer|min:0',
            'last_service_date' => 'nullable|date',
            'next_service_date' => 'nullable|date',
            'insurance_expiry' => 'nullable|date',
            'region_id' => 'nullable|exists:regions,id',
        ]);

        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update($request->all());

        return redirect()->route('admin.vehicles.index')
                         ->with('success', 'Kendaraan berhasil diupdate!');
    }

    /**
     * Remove the specified vehicle from storage.
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        
        // Cek apakah kendaraan sedang digunakan
        if ($vehicle->status === 'in_use') {
            return redirect()->route('admin.vehicles.index')
                             ->with('error', 'Kendaraan sedang digunakan, tidak bisa dihapus!');
        }

        // Cek apakah kendaraan punya booking aktif
        $hasActiveBooking = $vehicle->bookings()->whereIn('status', ['pending_l1', 'pending_l2', 'approved'])->exists();
        if ($hasActiveBooking) {
            return redirect()->route('admin.vehicles.index')
                             ->with('error', 'Kendaraan memiliki pemesanan aktif, tidak bisa dihapus!');
        }

        $vehicle->delete();

        return redirect()->route('admin.vehicles.index')
                         ->with('success', 'Kendaraan berhasil dihapus!');
    }
}