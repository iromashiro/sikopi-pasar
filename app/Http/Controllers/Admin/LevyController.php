<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Levy\LevyService;
use App\Http\Requests\StoreLevyRequest;
use App\Http\Requests\RegenerateLevyRequest;
use App\Models\Levy;
use App\Models\TraderKiosk;
use Illuminate\Support\Facades\Gate;

class LevyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Admin|SuperAdmin']);
    }

    public function index()
    {
        $levies = Levy::with('traderKiosk.trader', 'traderKiosk.kiosk')
            ->latest()->paginate(30);
        return view('admin.levies.index', compact('levies'));
    }

    public function store(StoreLevyRequest $req, LevyService $service)
    {
        $tk = TraderKiosk::findOrFail($req->trader_kiosk_id);
        $service->generateFor($tk, $req->period_month, $req->due_date);
        return back()->with('success', 'Levy added');
    }

    public function regenerate(RegenerateLevyRequest $req, LevyService $svc)
    {
        $kiosks = TraderKiosk::whereIn('kiosk_id', $req->kiosk_ids)
            ->whereNull('end_date')->get();
        foreach ($kiosks as $tk) {
            $svc->generateFor($tk, $req->month, now()->startOfMonth()->addDays(10));
        }
        return back()->with('success', 'Regenerate done');
    }
}
