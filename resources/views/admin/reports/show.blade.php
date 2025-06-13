<x-app-layout>
    <x-slot name="header">Laporan {{ ucfirst($type) }}</x-slot>

    <div x-data="reportsPage()">
        <!-- Header Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4>Laporan {{ ucfirst($type) }}</h4>
                <p class="text-muted">Analisis data pembayaran retribusi</p>
            </div>
            <div class="btn-group">
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-calendar"></i> {{ ucfirst($type) }}
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.reports.show', 'daily') }}">Harian</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.reports.show', 'monthly') }}">Bulanan</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('admin.reports.show', 'overdue') }}">Overdue</a>
                        </li>
                    </ul>
                </div>
                <a href="{{ route('admin.reports.export', [$type, 'xlsx']) }}" class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i> Excel
                </a>
                <a href="{{ route('admin.reports.export', [$type, 'csv']) }}" class="btn btn-primary">
                    <i class="bi bi-file-earmark-text"></i> CSV
                </a>
                <button type="button" class="btn btn-info" onclick="window.print()">
                    <i class="bi bi-printer"></i> Cetak
                </button>
            </div>
        </div>

        <!-- Report Content -->
        @if($type === 'daily')
        <!-- Daily Report -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Grafik Harian - {{ now()->format('M Y') }}</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="dailyChart" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Ringkasan Bulan Ini</h5>
                    </div>
                    <div class="card-body">
                        @php
                        $monthlyTotal = $data->sum('total');
                        $avgDaily = $data->avg('total');
                        $maxDaily = $data->max('total');
                        $daysWithPayment = $data->where('total', '>', 0)->count();
                        @endphp
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <h4 class="text-primary">{{ number_format($monthlyTotal, 0, ',', '.') }}</h4>
                                <small class="text-muted">Total Bulan Ini</small>
                            </div>
                            <div class="col-6 mb-3">
                                <h4 class="text-success">{{ number_format($avgDaily, 0, ',', '.') }}</h4>
                                <small class="text-muted">Rata-rata Harian</small>
                            </div>
                            <div class="col-6">
                                <h4 class="text-warning">{{ number_format($maxDaily, 0, ',', '.') }}</h4>
                                <small class="text-muted">Tertinggi</small>
                            </div>
                            <div class="col-6">
                                <h4 class="text-info">{{ $daysWithPayment }}</h4>
                                <small class="text-muted">Hari Ada Pembayaran</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daily Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Detail Harian</h5>
            </div>
            <div class="card-body">
                <x-table :headers="['Tanggal', 'Total Pembayaran', 'Jumlah Transaksi', 'Rata-rata']">
                    @foreach($data as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->day)->format('d/m/Y') }}</td>
                        <td><strong>Rp {{ number_format($item->total, 0, ',', '.') }}</strong></td>
                        <td>
                            @php
                            $count = \App\Models\Payment::whereDate('paid_at', $item->day)->count();
                            @endphp
                            {{ $count }} transaksi
                        </td>
                        <td>
                            @if($count > 0)
                            Rp {{ number_format($item->total / $count, 0, ',', '.') }}
                            @else
                            -
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </x-table>
            </div>
        </div>

        @elseif($type === 'monthly')
        <!-- Monthly Report -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Grafik Bulanan - {{ now()->year }}</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="monthlyChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Detail Bulanan {{ now()->year }}</h5>
            </div>
            <div class="card-body">
                <x-table :headers="['Bulan', 'Total Pembayaran', 'Target', 'Persentase', 'Status']">
                    @foreach($data as $item)
                    @php
                    $target = config('levy.target_monthly', 100000000);
                    $percentage = $target > 0 ? ($item->total / $target) * 100 : 0;
                    $monthName = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                    'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'][$item->m];
                    @endphp
                    <tr>
                        <td>{{ $monthName }} {{ now()->year }}</td>
                        <td><strong>Rp {{ number_format($item->total, 0, ',', '.') }}</strong></td>
                        <td>Rp {{ number_format($target, 0, ',', '.') }}</td>
                        <td>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar {{ $percentage >= 100 ? 'bg-success' : ($percentage >= 75 ? 'bg-warning' : 'bg-danger') }}"
                                    style="width: {{ min($percentage, 100) }}%">
                                    {{ number_format($percentage, 1) }}%
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($percentage >= 100)
                            <span class="badge bg-success">Target Tercapai</span>
                            @elseif($percentage >= 75)
                            <span class="badge bg-warning">Mendekati Target</span>
                            @else
                            <span class="badge bg-danger">Di Bawah Target</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </x-table>
            </div>
        </div>

        @else
        <!-- Overdue Report -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-danger">Total Overdue</h5>
                        <h3>{{ $data->count() }}</h3>
                        <small class="text-muted">retribusi</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-warning">Nilai Overdue</h5>
                        <h3>Rp {{ number_format($data->sum('amount'), 0, ',', '.') }}</h3>
                        <small class="text-muted">total</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-info">Rata-rata</h5>
                        <h3>Rp {{ number_format($data->avg('amount'), 0, ',', '.') }}</h3>
                        <small class="text-muted">per retribusi</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overdue Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Daftar Retribusi Overdue</h5>
            </div>
            <div class="card-body">
                <x-table :headers="['Pedagang', 'Kios', 'Periode', 'Jatuh Tempo', 'Jumlah', 'Hari Terlambat', 'Aksi']">
                    @foreach($data as $item)
                    @php
                    $daysOverdue = \Carbon\Carbon::parse($item->due_date)->diffInDays(now());
                    @endphp
                    <tr>
                        <td>{{ $item->trader }}</td>
                        <td>{{ $item->kiosk_no }}</td>
                        <td>
                            @php
                            $year = substr($item->period_month, 0, 4);
                            $month = substr($item->period_month, 4, 2);
                            $monthName = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                            'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'][intval($month)];
                            @endphp
                            {{ $monthName }} {{ $year }}
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->due_date)->format('d/m/Y') }}</td>
                        <td><strong>Rp {{ number_format($item->amount, 0, ',', '.') }}</strong></td>
                        <td>
                            <span class="badge {{ $daysOverdue > 30 ? 'bg-danger' : 'bg-warning' }}">
                                {{ $daysOverdue }} hari
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.levies.index') }}?levy_id={{ $item->id }}"
                                    class="btn btn-outline-success btn-action">
                                    <i class="bi bi-credit-card"></i> Bayar
                                </a>
                                <button type="button" class="btn btn-outline-info btn-action">
                                    <i class="bi bi-telephone"></i> Hubungi
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </x-table>
            </div>
        </div>
        @endif
    </div>

    @push('scripts')
    <script>
        function reportsPage() {
            return {
                init() {
                    @if($type === 'daily')
                        this.initDailyChart();
                    @elseif($type === 'monthly')
                        this.initMonthlyChart();
                    @endif
                },

                initDailyChart() {
                    const ctx = document.getElementById('dailyChart');
                    const data = @json($data);

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.map(item => new Date(item.day).getDate()),
                            datasets: [{
                                label: 'Pembayaran Harian',
                                data: data.map(item => item.total),
                                borderColor: 'rgb(75, 192, 192)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                tension: 0.1
                            }]
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
                                            return 'Pembayaran: Rp ' + context.parsed.y.toLocaleString('id-ID');
                                        }
                                    }
                                }
                            }
                        }
                    });
                },

                initMonthlyChart() {
                    const ctx = document.getElementById('monthlyChart');
                    const data = @json($data);
                    const target = {{ config('levy.target_monthly', 100000000) }};

                    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                                       'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.map(item => monthNames[item.m - 1]),
                            datasets: [
                                {
                                    label: 'Target',
                                    data: Array(12).fill(target),
                                    backgroundColor: 'rgba(108, 117, 125, 0.5)',
                                    borderColor: 'rgba(108, 117, 125, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Realisasi',
                                    data: (() => {
                                        const result = Array(12).fill(0);
                                        data.forEach(item => {
                                            result[item.m - 1] = item.total;
                                        });
                                        return result;
                                    })(),
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

    <style>
        @media print {

            .btn,
            .btn-group,
            .card-header .dropdown {
                display: none !important;
            }

            .card {
                border: 1px solid #dee2e6 !important;
            }

            .table {
                font-size: 12px;
            }
        }
    </style>
</x-app-layout>