<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kiosk;
use App\Models\Market;
use App\Http\Requests\StoreKioskRequest;
use App\Http\Requests\UpdateKioskRequest;
use App\Services\KioskService;
use Illuminate\Support\Facades\Cache;

class KioskController extends Controller
{
    public function index()
    {
        $kiosks = Kiosk::with('market')->latest()->paginate(25);

        $markets = Cache::remember('active_markets', 3600, function () {
            return Market::where('status', 'active')
                ->orderBy('name')
                ->pluck('name', 'id');
        });

        return view('admin.kiosks.index', compact('kiosks', 'markets'));
    }

    public function store(StoreKioskRequest $request, KioskService $service)
    {
        $service->store($request->validated());
        return back()->with('success', 'Kiosk created');
    }

    public function update(
        UpdateKioskRequest $request,
        Kiosk $kiosk,
        KioskService $service
    ) {
        $service->update($kiosk, $request->validated());
        return back()->with('success', 'Kiosk updated');
    }

    public function destroy(Kiosk $kiosk, KioskService $service)
    {
        $service->delete($kiosk);
        return back()->with('success', 'Kiosk deleted');
    }
}
