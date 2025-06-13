<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Levy;
use App\Services\PaymentService;
use App\Http\Requests\StorePaymentRequest;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Collector|Admin|SuperAdmin']);
    }

    public function index()
    {
        $payments = \App\Models\Payment::with('levy.traderKiosk.trader', 'levy.traderKiosk.kiosk')
            ->latest()->paginate(30);
        return view('admin.payments.index', compact('payments'));
    }

    public function store(StorePaymentRequest $req, PaymentService $svc)
    {
        $levy = Levy::findOrFail($req->levy_id);

        if ($levy->status === 'paid') {
            throw ValidationException::withMessages(['levy_id' => 'Levy already paid']);
        }

        $svc->record($levy, $req->validated());
        return back()->with('success', 'Payment recorded');
    }
}
