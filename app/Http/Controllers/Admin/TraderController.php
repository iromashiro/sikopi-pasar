<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trader;
use App\Models\Kiosk;
use App\Models\TraderKiosk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TraderController extends Controller
{
    public function index()
    {
        $traders = Trader::with(['activeKiosks.market'])
            ->withCount('activeKiosks')
            ->paginate(20);

        return view('admin.traders.index', compact('traders'));
    }

    public function create()
    {
        return view('admin.traders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:traders,nik',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
        ]);

        DB::transaction(function () use ($validated) {
            $trader = Trader::create($validated);

            // Create user account
            $email = strtolower(str_replace(' ', '.', $trader->name)) . '@trader.sikopi.local';
            $user = User::create([
                'name' => $trader->name,
                'email' => $email,
                'password' => Hash::make('trader123'),
                'email_verified_at' => now(),
            ]);
            $user->assignRole('Trader');
        });

        return redirect()->route('admin.traders.index')
            ->with('success', 'Pedagang berhasil ditambahkan');
    }

    public function show(Trader $trader)
    {
        $trader->load(['activeKiosks.market', 'levies.payment']);
        return view('admin.traders.show', compact('trader'));
    }

    public function edit(Trader $trader)
    {
        return view('admin.traders.edit', compact('trader'));
    }

    public function update(Request $request, Trader $trader)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:traders,nik,' . $trader->id,
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        $trader->update($validated);

        return redirect()->route('admin.traders.index')
            ->with('success', 'Data pedagang berhasil diperbarui');
    }

    public function destroy(Trader $trader)
    {
        if ($trader->activeKiosks()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus pedagang yang masih memiliki kios aktif');
        }

        $trader->delete();

        return redirect()->route('admin.traders.index')
            ->with('success', 'Pedagang berhasil dihapus');
    }

    public function assignKiosk(Request $request, Trader $trader)
    {
        $validated = $request->validate([
            'kiosk_id' => 'required|exists:kiosks,id',
            'start_date' => 'required|date',
        ]);

        $kiosk = Kiosk::findOrFail($validated['kiosk_id']);

        if ($kiosk->status !== 'available') {
            return back()->with('error', 'Kios tidak tersedia');
        }

        DB::transaction(function () use ($trader, $kiosk, $validated) {
            TraderKiosk::create([
                'trader_id' => $trader->id,
                'kiosk_id' => $kiosk->id,
                'start_date' => $validated['start_date'],
            ]);

            $kiosk->update(['status' => 'occupied']);
        });

        return back()->with('success', 'Kios berhasil ditugaskan');
    }

    public function unassignKiosk(Trader $trader, Kiosk $kiosk)
    {
        $assignment = TraderKiosk::where('trader_id', $trader->id)
            ->where('kiosk_id', $kiosk->id)
            ->whereNull('end_date')
            ->first();

        if (!$assignment) {
            return back()->with('error', 'Penugasan tidak ditemukan');
        }

        DB::transaction(function () use ($assignment, $kiosk) {
            $assignment->update(['end_date' => now()]);
            $kiosk->update(['status' => 'available']);
        });

        return back()->with('success', 'Penugasan kios berhasil dihentikan');
    }
}
