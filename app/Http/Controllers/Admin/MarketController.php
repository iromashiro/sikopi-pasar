<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Market;
use App\Http\Requests\StoreMarketRequest;
use App\Http\Requests\UpdateMarketRequest;
use App\Services\MarketService;

class MarketController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Admin|SuperAdmin']);
    }

    public function index(MarketService $service)
    {
        $markets = $service->paginate();
        return view('admin.markets.index', compact('markets'));
    }

    public function store(StoreMarketRequest $request, MarketService $service)
    {
        $service->store($request->validated());
        return back()->with('success', 'Market added');
    }

    public function update(
        UpdateMarketRequest $request,
        Market $market,
        MarketService $service
    ) {
        $service->update($market, $request->validated());
        return back()->with('success', 'Market updated');
    }

    public function destroy(Market $market, MarketService $service)
    {
        $service->delete($market);
        return back()->with('success', 'Market deleted');
    }
}
