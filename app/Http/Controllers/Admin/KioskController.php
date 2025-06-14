<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kiosk;
use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class KioskController extends Controller
{
    public function index()
    {
        $kiosks = Kiosk::with(['market', 'currentAssignment.trader'])
            ->latest()
            ->paginate(25);

        // Perbaikan: gunakan get() bukan pluck() untuk mendapatkan objek dengan property id
        $markets = Cache::remember('active_markets', 3600, function () {
            return Market::where('status', 'active')
                ->orderBy('name'); // Menggunakan get() bukan pluck()
        });

        return view('admin.kiosks.index', compact('kiosks', 'markets'));
    }

    public function create()
    {
        $markets = Market::where('status', 'active')
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('admin.kiosks.create', compact('markets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'market_id' => 'required|exists:markets,id',
            'kiosk_no' => 'required|string|max:10|unique:kiosks,kiosk_no,NULL,id,market_id,' . $request->market_id,
            'category' => 'required|string|max:50',
            'area_m2' => 'required|numeric|min:1|max:1000',
            'status' => 'required|in:available,occupied,inactive',
        ]);

        Kiosk::create($validated);

        return response()->json(['success' => true]);
    }

    public function show(Kiosk $kiosk)
    {
        $kiosk->load(['market', 'currentAssignment.trader', 'assignments.trader']);
        return view('admin.kiosks.show', compact('kiosk'));
    }

    public function edit(Kiosk $kiosk)
    {
        $markets = Market::where('status', 'active')
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('admin.kiosks.edit', compact('kiosk', 'markets'));
    }

    public function update(Request $request, Kiosk $kiosk)
    {
        $validated = $request->validate([
            'market_id' => 'required|exists:markets,id',
            'kiosk_no' => 'required|string|max:10|unique:kiosks,kiosk_no,' . $kiosk->id . ',id,market_id,' . $request->market_id,
            'category' => 'required|string|max:50',
            'area_m2' => 'required|numeric|min:1|max:1000',
            'status' => 'required|in:available,occupied,inactive',
        ]);

        $kiosk->update($validated);

        return response()->json(['success' => true]);
    }

    public function destroy(Kiosk $kiosk)
    {
        if ($kiosk->status === 'occupied') {
            return response()->json(['error' => 'Tidak dapat menghapus kios yang sedang ditempati'], 400);
        }

        $kiosk->delete();

        return response()->json(['success' => true]);
    }
}
