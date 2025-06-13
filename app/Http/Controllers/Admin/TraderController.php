<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trader;
use App\Models\Kiosk;
use App\Http\Requests\StoreTraderRequest;
use App\Http\Requests\AssignKioskRequest;
use App\Services\TraderService;

class TraderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Admin|SuperAdmin']);
    }

    public function index()
    {
        $traders = Trader::with([
            'kiosks' => fn($q) => $q->wherePivotNull('end_date')->with('market')
        ])->paginate(20);

        return view('admin.traders.index', compact('traders'));
    }

    public function store(StoreTraderRequest $request, TraderService $service)
    {
        $service->store($request->validated());
        return back()->with('success', 'Trader created');
    }

    public function assignKiosk(AssignKioskRequest $req, Trader $trader, TraderService $service)
    {
        $kiosk = Kiosk::findOrFail($req->kiosk_id);
        $service->assignKiosk($trader, $kiosk, $req->start_date);
        return back()->with('success', 'Kiosk assigned');
    }
}
