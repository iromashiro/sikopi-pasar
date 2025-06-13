<x-app-layout>
    <x-slot name="header">Dashboard {{ $year }}</x-slot>

    <div x-data="dashboard()">
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="bi bi-currency-dollar fs-1 text-success"></i>
                        <h5 class="card-title">Hari Ini</h5>
                        <h3 class="text-success">Rp {{ number_format($today, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="bi bi-exclamation-triangle fs-1 text-warning"></i>
                        <h5 class="card-title">Retribusi Overdue</h5>
                        <h3 class="text-warning">{{ $overdue }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="bi bi-people fs-1 text-info"></i>
                        <h5 class="card-title">Pedagang Aktif</h5>
                        <h3 class="text-info">{{ \App\Models\Trader::where('status', 'active')->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="bi bi-shop fs-1 text-primary"></i>
                        <h5 class="card-title">Kios Terisi</h5>
                        <h3 class="text-primary">{{ \App\Models\Kiosk::where('status', 'occupied')->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Realisasi vs Target Bulanan {{ $year }}</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="collectionChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Aksi Cepat</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.levies.index') }}" class="btn btn-primary">
                                <i class="bi bi-receipt"></i> Kelola Retribusi
                            </a>
                            <a href="{{ route('admin.payments.index') }}" class="btn btn-success">
                                <i class="bi bi-credit-card"></i> Catat Pembayaran
                            </a>
                            <a href="{{ route('admin.reports.show', 'daily') }}" class="btn btn-info">
                                <i class="bi bi-graph-up"></i> Lihat Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Retribusi Terbaru</h5>
                    </div>
                    <div class="card-body">
                        @php
                        $recentLevies = \App\Models\Levy::with('traderKiosk.trader')
                        ->latest()->take(5)->get();
                        @endphp
                        @forelse($recentLevies as $levy)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <strong>{{ $levy->traderKiosk->trader->name }}</strong><br>
                                <small class="text-muted">{{ $levy->period_month }}</small>
                            </div>
                            <span
                                class="badge bg-{{ $levy->status === 'paid' ? 'success' : ($levy->status === 'overdue' ? 'danger' : 'warning') }}">
                                {{ ucfirst($levy->status) }}
                            </span>
                        </div>
                        @empty
                        <p class="text-muted">Belum ada data retribusi</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function dashboard() {
            return {
                init() {
                    this.initChart();
                },
                initChart() {
                    const ctx = document.getElementById('collectionChart');
                    const trendData = @json($trend);

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: trendData.map(item => `Bulan ${item.month}`),
                            datasets: [
                                {
                                    label: 'Target',
                                    data: trendData.map(item => item.target),
                                    backgroundColor: 'rgba(108, 117, 125, 0.5)',
                                    borderColor: 'rgba(108, 117, 125, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Terkumpul',
                                    data: trendData.map(item => item.collected),
                                    backgroundColor: 'rgba(25, 135, 84, 0.5)',
                                    borderColor: 'rgba(25, 135, 84, 1)',
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return 'Rp ' + value.toLocaleString('id-ID');
                                        }
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.dataset.label + ': Rp ' +
                                                   context.parsed.y.toLocaleString('id-ID');
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            }
        }
    </script>
    @endpush
</x-app-layout>