<x-app-layout>
    <x-slot name="header">Riwayat Pembayaran</x-slot>

    <div x-data="paymentsPage()">
        <!-- Header Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4>Daftar Pembayaran</h4>
                <p class="text-muted">Riwayat pembayaran retribusi pedagang</p>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-success" onclick="window.print()">
                    <i class="bi bi-printer"></i> Cetak
                </button>
                <button type="button" class="btn btn-primary" @click="exportData()">
                    <i class="bi bi-download"></i> Export
                </button>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" class="form-control" placeholder="Cari pedagang atau nomor resi..."
                            x-model="search" @input="filterPayments()">
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" x-model="methodFilter" @change="filterPayments()">
                            <option value="">Semua Metode</option>
                            <option value="cash">Tunai</option>
                            <option value="transfer">Transfer</option>
                            <option value="qris">QRIS</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="date" class="form-control" x-model="dateFrom" @change="filterPayments()">
                            <span class="input-group-text">s/d</span>
                            <input type="date" class="form-control" x-model="dateTo" @change="filterPayments()">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" placeholder="Min. jumlah" x-model="minAmount"
                            @input="filterPayments()">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-secondary w-100" @click="resetFilters()">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-success">Total Pembayaran</h5>
                        <h3 x-text="formatCurrency(summary.total)"></h3>
                        <small class="text-muted" x-text="summary.count + ' transaksi'"></small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-info">Hari Ini</h5>
                        <h3 x-text="formatCurrency(summary.today)"></h3>
                        <small class="text-muted" x-text="summary.todayCount + ' transaksi'"></small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-warning">Rata-rata</h5>
                        <h3 x-text="formatCurrency(summary.average)"></h3>
                        <small class="text-muted">per transaksi</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payments Table -->
        <div class="card">
            <div class="card-body">
                <x-table
                    :headers="['No. Resi', 'Pedagang', 'Kios', 'Periode', 'Tanggal Bayar', 'Jumlah', 'Metode', 'Petugas', 'Aksi']">
                    <template x-for="payment in filteredPayments" :key="payment.id">
                        <tr>
                            <td>
                                <strong x-text="payment.receipt_no"></strong>
                            </td>
                            <td x-text="payment.levy?.trader_kiosk?.trader?.name"></td>
                            <td>
                                <span x-text="payment.levy?.trader_kiosk?.kiosk?.kiosk_no"></span>
                                <br>
                                <small class="text-muted"
                                    x-text="payment.levy?.trader_kiosk?.kiosk?.market?.name"></small>
                            </td>
                            <td x-text="formatPeriod(payment.levy?.period_month)"></td>
                            <td x-text="formatDate(payment.paid_at)"></td>
                            <td>
                                <strong x-text="formatCurrency(payment.amount)"></strong>
                                <template x-if="payment.amount < payment.levy?.amount">
                                    <br><small class="text-warning">Sebagian</small>
                                </template>
                            </td>
                            <td>
                                <span class="badge" :class="getMethodClass(payment.method)"
                                    x-text="getMethodText(payment.method)">
                                </span>
                            </td>
                            <td x-text="payment.collector_name"></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-info btn-action"
                                        @click="viewReceipt(payment)">
                                        <i class="bi bi-receipt"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-action"
                                        @click="downloadReceipt(payment)">
                                        <i class="bi bi-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </x-table>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        Menampilkan <span x-text="filteredPayments.length"></span> dari <span
                            x-text="payments.length"></span> pembayaran
                    </div>
                    {{ $payments->links() }}
                </div>
            </div>
        </div>

        <!-- Receipt Modal -->
        <x-modal id="receiptModal" title="Tanda Bukti Pembayaran" size="lg">
            <div x-show="selectedPayment" class="receipt-preview">
                <div class="text-center mb-4">
                    <h4>TANDA BUKTI RETRIBUSI PASAR</h4>
                    <hr>
                </div>

                <div class="row">
                    <div class="col-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>No. Resi:</strong></td>
                                <td x-text="selectedPayment?.receipt_no"></td>
                            </tr>
                            <tr>
                                <td><strong>Pedagang:</strong></td>
                                <td x-text="selectedPayment?.levy?.trader_kiosk?.trader?.name"></td>
                            </tr>
                            <tr>
                                <td><strong>Kios:</strong></td>
                                <td x-text="selectedPayment?.levy?.trader_kiosk?.kiosk?.kiosk_no"></td>
                            </tr>
                            <tr>
                                <td><strong>Pasar:</strong></td>
                                <td x-text="selectedPayment?.levy?.trader_kiosk?.kiosk?.market?.name"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Periode:</strong></td>
                                <td x-text="formatPeriod(selectedPayment?.levy?.period_month)"></td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Bayar:</strong></td>
                                <td x-text="formatDate(selectedPayment?.paid_at)"></td>
                            </tr>
                            <tr>
                                <td><strong>Metode:</strong></td>
                                <td x-text="getMethodText(selectedPayment?.method)"></td>
                            </tr>
                            <tr>
                                <td><strong>Jumlah:</strong></td>
                                <td><strong x-text="formatCurrency(selectedPayment?.amount)"></strong></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>
                <div class="text-end">
                    <p><strong>Petugas:</strong> <span x-text="selectedPayment?.collector_name"></span></p>
                    <p><small class="text-muted">Dicetak pada: {{ now()->format('d/m/Y H:i') }}</small></p>
                </div>
            </div>
        </x-modal>
    </div>

    @push('scripts')
    <script>
        function paymentsPage() {
            return {
                payments: @json($payments->items()),
                filteredPayments: [],
                search: '',
                methodFilter: '',
                dateFrom: '',
                dateTo: '',
                minAmount: '',
                selectedPayment: null,
                summary: {
                    total: 0,
                    count: 0,
                    today: 0,
                    todayCount: 0,
                    average: 0
                },

                init() {
                    this.filteredPayments = [...this.payments];
                    this.calculateSummary();
                },

                filterPayments() {
                    this.filteredPayments = this.payments.filter(payment => {
                        const matchesSearch = !this.search ||
                            payment.receipt_no.toLowerCase().includes(this.search.toLowerCase()) ||
                            payment.levy?.trader_kiosk?.trader?.name.toLowerCase().includes(this.search.toLowerCase());

                        const matchesMethod = !this.methodFilter || payment.method === this.methodFilter;

                        let matchesDateRange = true;
                        if (this.dateFrom || this.dateTo) {
                            const paymentDate = new Date(payment.paid_at);
                            if (this.dateFrom) {
                                matchesDateRange = matchesDateRange && paymentDate >= new Date(this.dateFrom);
                            }
                            if (this.dateTo) {
                                matchesDateRange = matchesDateRange && paymentDate <= new Date(this.dateTo);
                            }
                        }

                        const matchesAmount = !this.minAmount || payment.amount >= parseInt(this.minAmount);

                        return matchesSearch && matchesMethod && matchesDateRange && matchesAmount;
                    });
                    this.calculateSummary();
                },

                calculateSummary() {
                    const today = new Date().toISOString().split('T')[0];

                    this.summary = this.filteredPayments.reduce((acc, payment) => {
                        acc.total += payment.amount;
                        acc.count++;

                        if (payment.paid_at === today) {
                            acc.today += payment.amount;
                            acc.todayCount++;
                        }

                        return acc;
                    }, { total: 0, count: 0, today: 0, todayCount: 0 });

                    this.summary.average = this.summary.count > 0 ? this.summary.total / this.summary.count : 0;
                },

                resetFilters() {
                    this.search = '';
                    this.methodFilter = '';
                    this.dateFrom = '';
                    this.dateTo = '';
                    this.minAmount = '';
                    this.filterPayments();
                },

                viewReceipt(payment) {
                    this.selectedPayment = payment;
                    new bootstrap.Modal(document.getElementById('receiptModal')).show();
                },

                downloadReceipt(payment) {
                    // Implementation for PDF download
                    window.open(`/admin/payments/${payment.id}/receipt`, '_blank');
                },

                exportData() {
                    // Implementation for data export
                    const params = new URLSearchParams({
                        search: this.search,
                        method: this.methodFilter,
                        date_from: this.dateFrom,
                        date_to: this.dateTo,
                        min_amount: this.minAmount
                    });

                    window.open(`/admin/payments/export?${params}`, '_blank');
                },

                formatCurrency(amount) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
                },

                formatDate(date) {
                    return new Date(date).toLocaleDateString('id-ID');
                },

                formatPeriod(period) {
                    if (!period) return '';
                    const year = period.substring(0, 4);
                    const month = period.substring(4, 6);
                    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                                       'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                    return monthNames[parseInt(month) - 1] + ' ' + year;
                },

                getMethodClass(method) {
                    const classes = {
                        'cash': 'bg-success',
                        'transfer': 'bg-primary',
                        'qris': 'bg-info'
                    };
                    return classes[method] || 'bg-secondary';
                },

                getMethodText(method) {
                    const texts = {
                        'cash': 'Tunai',
                        'transfer': 'Transfer',
                        'qris': 'QRIS'
                    };
                    return texts[method] || method;
                }
            }
        }
    </script>
    @endpush

    <style>
        @media print {

            .btn,
            .card-header,
            .pagination,
            nav {
                display: none !important;
            }

            .receipt-preview {
                font-size: 12px;
            }
        }
    </style>
</x-app-layout>