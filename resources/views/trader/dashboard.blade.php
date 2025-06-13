<x-app-layout>
    <x-slot name="header">Dashboard Pedagang</x-slot>

    <div x-data="traderDashboard()">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h4>Selamat datang, {{ Auth::user()->name }}!</h4>
                        <p class="mb-0">Kelola retribusi dan pembayaran Anda dengan mudah</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Assignment -->
        @php
        $trader = \App\Models\Trader::where('name', Auth::user()->name)->first();
        $activeAssignment = $trader?->activeKiosks()->with('market')->first();
        @endphp

        @if($activeAssignment)
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Kios Aktif</h5>
                    </div>
                    <div class="card-body">
                        <h4>{{ $activeAssignment->kiosk_no }}</h4>
                        <p class="text-muted mb-2">{{ $activeAssignment->market->name }}</p>
                        <div class="row">
                            <div class="col-6">
                                <small class="text-muted">Kategori:</small><br>
                                <strong>{{ $activeAssignment->category }}</strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Luas:</small><br>
                                <strong>{{ $activeAssignment->area_m2 }} m²</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Status Retribusi</h5>
                    </div>
                    <div class="card-body">
                        @php
                        $currentLevy = \App\Models\Levy::whereHas('traderKiosk', function($q) use ($trader) {
                        $q->where('trader_id', $trader->id)->whereNull('end_date');
                        })->where('period_month', now()->format('Ym'))->first();
                        @endphp

                        @if($currentLevy)
                        <h4>Rp {{ number_format($currentLevy->amount, 0, ',', '.') }}</h4>
                        <p class="mb-2">
                            <span
                                class="badge {{ $currentLevy->status === 'paid' ? 'bg-success' : ($currentLevy->status === 'overdue' ? 'bg-danger' : 'bg-warning') }}">
                                {{ ucfirst($currentLevy->status) }}
                            </span>
                        </p>
                        <small class="text-muted">
                            Jatuh tempo: {{ $currentLevy->due_date->format('d/m/Y') }}
                        </small>
                        @else
                        <p class="text-muted">Belum ada retribusi bulan ini</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Levies -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Riwayat Retribusi</h5>
                    </div>
                    <div class="card-body">
                        @php
                        $recentLevies = \App\Models\Levy::whereHas('traderKiosk', function($q) use ($trader) {
                        $q->where('trader_id', $trader->id);
                        })->with('payment')->latest()->take(6)->get();
                        @endphp

                        <x-table :headers="['Periode', 'Jumlah', 'Jatuh Tempo', 'Status', 'Dibayar']">
                            @forelse($recentLevies as $levy)
                            <tr>
                                <td>
                                    @php
                                    $year = substr($levy->period_month, 0, 4);
                                    $month = substr($levy->period_month, 4, 2);
                                    $monthName = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                                    'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'][intval($month)];
                                    @endphp
                                    {{ $monthName }} {{ $year }}
                                </td>
                                <td><strong>Rp {{ number_format($levy->amount, 0, ',', '.') }}</strong></td>
                                <td>{{ $levy->due_date->format('d/m/Y') }}</td>
                                <td>
                                    <span
                                        class="badge status-badge {{ $levy->status === 'paid' ? 'bg-success' : ($levy->status === 'overdue' ? 'bg-danger' : 'bg-warning') }}">
                                        {{ ucfirst($levy->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($levy->payment)
                                    {{ $levy->payment->paid_at->format('d/m/Y') }}
                                    <br><small class="text-muted">{{ $levy->payment->receipt_no }}</small>
                                    @else
                                    <span class="text-muted">Belum dibayar</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data retribusi</td>
                            </tr>
                            @endforelse
                        </x-table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Summary -->
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="bi bi-check-circle fs-1 text-success"></i>
                        <h5 class="card-title">Total Dibayar</h5>
                        @php
                        $totalPaid = \App\Models\Payment::whereHas('levy.traderKiosk', function($q) use ($trader) {
                        $q->where('trader_id', $trader->id);
                        })->sum('amount');
                        @endphp
                        <h3 class="text-success">Rp {{ number_format($totalPaid, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="bi bi-clock fs-1 text-warning"></i>
                        <h5 class="card-title">Pending</h5>
                        @php
                        $pendingCount = \App\Models\Levy::whereHas('traderKiosk', function($q) use ($trader) {
                        $q->where('trader_id', $trader->id);
                        })->whereIn('status', ['pending', 'partial'])->count();
                        @endphp
                        <h3 class="text-warning">{{ $pendingCount }}</h3>
                        <small class="text-muted">retribusi</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="bi bi-exclamation-triangle fs-1 text-danger"></i>
                        <h5 class="card-title">Overdue</h5>
                        @php
                        $overdueCount = \App\Models\Levy::whereHas('traderKiosk', function($q) use ($trader) {
                        $q->where('trader_id', $trader->id);
                        })->where('status', 'overdue')->count();
                        @endphp
                        <h3 class="text-danger">{{ $overdueCount }}</h3>
                        <small class="text-muted">retribusi</small>
                    </div>
                </div>
            </div>
        </div>

        @else
        <!-- No Active Assignment -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-shop fs-1 text-muted mb-3"></i>
                        <h4>Belum Ada Penugasan Kios</h4>
                        <p class="text-muted">Anda belum ditugaskan ke kios manapun. Silakan hubungi administrator untuk
                            penugasan kios.</p>
                        <button type="button" class="btn btn-primary">
                            <i class="bi bi-telephone"></i> Hubungi Admin
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    @push('scripts')
    <script>
        function traderDashboard() {
            return {
                init() {
                    // Initialize any trader-specific functionality
                }
            }
        }
    </script>
    @endpush
</x-app-layout>