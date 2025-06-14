<x-app-layout>
    <x-slot name="header">Dashboard Admin</x-slot>

    <div x-data="dashboardData()">
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Total Kios</h6>
                                <h3 class="mb-0">{{ number_format($totalKiosks) }}</h3>
                                <small>{{ $overallOccupancyRate }}% Terisi</small>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-shop fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Kios Terisi</h6>
                                <h3 class="mb-0">{{ number_format($occupiedKiosks) }}</h3>
                                <small>dari {{ number_format($totalKiosks) }} total</small>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-check-circle fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Kios Tersedia</h6>
                                <h3 class="mb-0">{{ number_format($availableKiosks) }}</h3>
                                <small>Siap ditempati</small>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-circle fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Pedagang Aktif</h6>
                                <h3 class="mb-0">{{ number_format($activeTraders) }}</h3>
                                <small>Terdaftar</small>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-people fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-4">
            <!-- Kiosk Occupancy per Market -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Tingkat Hunian Kios per Pasar</h5>
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-primary active"
                                @click="switchOccupancyView('bar')">
                                <i class="bi bi-bar-chart"></i> Bar
                            </button>
                            <button type="button" class="btn btn-outline-primary"
                                @click="switchOccupancyView('doughnut')">
                                <i class="bi bi-pie-chart"></i> Pie
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="kioskOccupancyChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Market Comparison -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Perbandingan Jumlah Kios</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="marketComparisonChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Market Statistics -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Detail Statistik per Pasar</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama Pasar</th>
                                        <th>Total Kios</th>
                                        <th>Terisi</th>
                                        <th>Tersedia</th>
                                        <th>Tidak Aktif</th>
                                        <th>Tingkat Hunian</th>
                                        <th>Progress</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kioskOccupancy as $market)
                                    <tr>
                                        <td><strong>{{ $market['name'] }}</strong></td>
                                        <td>{{ number_format($market['total']) }}</td>
                                        <td>
                                            <span
                                                class="badge bg-success">{{ number_format($market['occupied']) }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-warning">{{ number_format($market['available']) }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-secondary">{{ number_format($market['inactive']) }}</span>
                                        </td>
                                        <td><strong>{{ $market['occupancy_rate'] }}%</strong></td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-success"
                                                    style="width: {{ $market['occupancy_rate'] }}%"
                                                    title="Terisi: {{ $market['occupancy_rate'] }}%">
                                                    {{ $market['occupancy_rate'] }}%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Trend (existing) -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Tren Penerimaan Retribusi {{ $year }}</h5>
                        <select class="form-select w-auto" onchange="window.location.href='?year='+this.value">
                            @for($y = now()->year; $y >= now()->year - 3; $y--)
                            <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Aktivitas Terbaru (7 hari terakhir)</h5>
                    </div>
                    <div class="card-body">
                        @if($recentPayments->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentPayments as $payment)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $payment->levy->traderKiosk->trader->name }}</h6>
                                    <p class="mb-1">
                                        <small class="text-muted">
                                            {{ $payment->levy->traderKiosk->kiosk->market->name }} -
                                            Kios {{ $payment->levy->traderKiosk->kiosk->kiosk_no }}
                                        </small>
                                    </p>
                                    <small class="text-muted">{{ $payment->paid_at->diffForHumans() }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-success fs-6">
                                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                    </span>
                                    <br>
                                    <small class="text-muted">{{ ucfirst($payment->method) }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="bi bi-clock-history fs-1 text-muted"></i>
                            <h6 class="text-muted mt-2">Belum ada aktivitas dalam 7 hari terakhir</h6>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function dashboardData() {
            return {
                kioskOccupancyChart: null,
                marketComparisonChart: null,
                revenueChart: null,
                occupancyViewType: 'bar',

                init() {
                    this.initKioskOccupancyChart();
                    this.initMarketComparisonChart();
                    this.initRevenueChart();
                },

                initKioskOccupancyChart() {
                    const ctx = document.getElementById('kioskOccupancyChart').getContext('2d');
                    const data = @json($kioskOccupancy);

                    this.kioskOccupancyChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.map(item => item.name),
                            datasets: [
                                {
                                    label: 'Terisi',
                                    data: data.map(item => item.occupied),
                                    backgroundColor: 'rgba(40, 167, 69, 0.8)',
                                    borderColor: 'rgba(40, 167, 69, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Tersedia',
                                    data: data.map(item => item.available),
                                    backgroundColor: 'rgba(255, 193, 7, 0.8)',
                                    borderColor: 'rgba(255, 193, 7, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Tidak Aktif',
                                    data: data.map(item => item.inactive),
                                    backgroundColor: 'rgba(108, 117, 125, 0.8)',
                                    borderColor: 'rgba(108, 117, 125, 1)',
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: {
                                    stacked: true,
                                },
                                y: {
                                    stacked: true,
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        afterLabel: function(context) {
                                            const dataIndex = context.dataIndex;
                                            const market = data[dataIndex];
                                            return `Tingkat Hunian: ${market.occupancy_rate}%`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                },

                initMarketComparisonChart() {
                    const ctx = document.getElementById('marketComparisonChart').getContext('2d');
                    const data = @json($marketComparison);

                    const colors = [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 205, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(199, 199, 199, 0.8)',
                        'rgba(83, 102, 255, 0.8)'
                    ];

                    this.marketComparisonChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: data.map(item => item.name),
                            datasets: [{
                                data: data.map(item => item.total_kiosks),
                                backgroundColor: colors.slice(0, data.length),
                                borderColor: colors.slice(0, data.length).map(color => color.replace('0.8', '1')),
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                                            return `${context.label}: ${context.parsed} kios (${percentage}%)`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                },

                initRevenueChart() {
                    const ctx = document.getElementById('revenueChart').getContext('2d');
                    const trendData = @json($trend);

                    const monthNames = [
                        'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                        'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
                    ];

                    this.revenueChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: trendData.map(item => monthNames[item.month - 1]),
                            datasets: [
                                {
                                    label: 'Realisasi',
                                    data: trendData.map(item => item.collected),
                                    borderColor: 'rgba(40, 167, 69, 1)',
                                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                                    tension: 0.4,
                                    fill: true
                                },
                                {
                                    label: 'Target',
                                    data: trendData.map(item => item.target),
                                    borderColor: 'rgba(220, 53, 69, 1)',
                                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                                    borderDash: [5, 5],
                                    tension: 0.4,
                                    fill: false
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return 'Rp ' + (value / 1000000).toFixed(0) + 'M';
                                        }
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.dataset.label + ': Rp ' +
                                                   new Intl.NumberFormat('id-ID').format(context.parsed.y);
                                        }
                                    }
                                }
                            }
                        }
                    });
                },

                switchOccupancyView(type) {
                    this.occupancyViewType = type;

                    // Update active button
                    document.querySelectorAll('.btn-group .btn').forEach(btn => {
                        btn.classList.remove('active');
                    });
                    event.target.closest('button').classList.add('active');

                    // Destroy existing chart
                    if (this.kioskOccupancyChart) {
                        this.kioskOccupancyChart.destroy();
                    }

                    // Recreate chart with new type
                    const ctx = document.getElementById('kioskOccupancyChart').getContext('2d');
                    const data = @json($kioskOccupancy);

                    if (type === 'doughnut') {
                        // Show total occupied vs available for all markets combined
                        const totalOccupied = data.reduce((sum, item) => sum + item.occupied, 0);
                        const totalAvailable = data.reduce((sum, item) => sum + item.available, 0);
                        const totalInactive = data.reduce((sum, item) => sum + item.inactive, 0);

                        this.kioskOccupancyChart = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: ['Terisi', 'Tersedia', 'Tidak Aktif'],
                                datasets: [{
                                    data: [totalOccupied, totalAvailable, totalInactive],
                                    backgroundColor: [
                                        'rgba(40, 167, 69, 0.8)',
                                        'rgba(255, 193, 7, 0.8)',
                                        'rgba(108, 117, 125, 0.8)'
                                    ],
                                    borderColor: [
                                        'rgba(40, 167, 69, 1)',
                                        'rgba(255, 193, 7, 1)',
                                        'rgba(108, 117, 125, 1)'
                                    ],
                                    borderWidth: 2
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                    }
                                }
                            }
                        });
                    } else {
                        // Recreate bar chart
                        this.initKioskOccupancyChart();
                    }
                }
            }
        }
    </script>
    @endpush
</x-app-layout>