<x-app-layout>
    <x-slot name="header">Manajemen Retribusi</x-slot>

    <div x-data="leviesPage()">
        <!-- Header Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4>Daftar Retribusi</h4>
                <p class="text-muted">Kelola retribusi pedagang dan pembayaran</p>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                    data-bs-target="#generateLevyModal">
                    <i class="bi bi-plus-circle"></i> Generate Retribusi
                </button>
                @role('SuperAdmin')
                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                    data-bs-target="#regenerateLevyModal">
                    <i class="bi bi-arrow-repeat"></i> Regenerate
                </button>
                @endrole
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" class="form-control" placeholder="Cari pedagang..." x-model="search"
                            @input="filterLevies()">
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" x-model="statusFilter" @change="filterLevies()">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="partial">Sebagian</option>
                            <option value="paid">Lunas</option>
                            <option value="overdue">Overdue</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" x-model="periodFilter" @change="filterLevies()">
                            <option value="">Semua Periode</option>
                            @for($i = 0; $i < 12; $i++) @php $period=now()->subMonths($i)->format('Ym') @endphp
                                <option value="{{ $period }}">{{ now()->subMonths($i)->format('M Y') }}</option>
                                @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="date" class="form-control" x-model="dueDateFrom" @change="filterLevies()">
                            <span class="input-group-text">s/d</span>
                            <input type="date" class="form-control" x-model="dueDateTo" @change="filterLevies()">
                        </div>
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
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Total Retribusi</h5>
                        <h3 x-text="formatCurrency(summary.total)"></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-success">Sudah Dibayar</h5>
                        <h3 x-text="formatCurrency(summary.paid)"></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-warning">Pending</h5>
                        <h3 x-text="formatCurrency(summary.pending)"></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-danger">Overdue</h5>
                        <h3 x-text="formatCurrency(summary.overdue)"></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Levies Table -->
        <div class="card">
            <div class="card-body">
                <x-table :headers="['Pedagang', 'Kios', 'Periode', 'Jatuh Tempo', 'Jumlah', 'Status', 'Aksi']">
                    <template x-for="levy in filteredLevies" :key="levy.id">
                        <tr>
                            <td x-text="levy.trader_kiosk?.trader?.name"></td>
                            <td>
                                <span x-text="levy.trader_kiosk?.kiosk?.kiosk_no"></span>
                                <br>
                                <small class="text-muted" x-text="levy.trader_kiosk?.kiosk?.market?.name"></small>
                            </td>
                            <td x-text="formatPeriod(levy.period_month)"></td>
                            <td x-text="formatDate(levy.due_date)"></td>
                            <td x-text="formatCurrency(levy.amount)"></td>
                            <td>
                                <span class="badge status-badge" :class="getStatusClass(levy.status)"
                                    x-text="getStatusText(levy.status)">
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <template x-if="levy.status !== 'paid'">
                                        <button type="button" class="btn btn-outline-success btn-action"
                                            @click="recordPayment(levy)">
                                            <i class="bi bi-credit-card"></i>
                                        </button>
                                    </template>
                                    <button type="button" class="btn btn-outline-info btn-action"
                                        @click="viewDetails(levy)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </x-table>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        Menampilkan <span x-text="filteredLevies.length"></span> dari <span
                            x-text="levies.length"></span> retribusi
                    </div>
                    {{ $levies->links() }}
                </div>
            </div>
        </div>

        <!-- Generate Levy Modal -->
        <x-modal id="generateLevyModal" title="Generate Retribusi Bulanan">
            <form @submit.prevent="generateLevies()">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i>
                    Generate retribusi untuk semua pedagang aktif pada periode yang dipilih.
                </div>

                <x-form.input name="period_month" label="Periode (YYYYMM)" :value="now()->format('Ym')" required
                    x-model="generateForm.period_month" />

                <x-form.input name="due_date" label="Tanggal Jatuh Tempo" type="date"
                    :value="now()->addDays(10)->format('Y-m-d')" required x-model="generateForm.due_date" />

                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success" :disabled="loading">
                        <span x-show="loading" class="spinner-border spinner-border-sm me-2"></span>
                        Generate
                    </button>
                </div>
            </form>
        </x-modal>

        <!-- Record Payment Modal -->
        <x-modal id="recordPaymentModal" title="Catat Pembayaran">
            <form @submit.prevent="submitPayment()">
                <div class="mb-3">
                    <label class="form-label">Pedagang</label>
                    <input type="text" class="form-control" :value="selectedLevy?.trader_kiosk?.trader?.name" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah Retribusi</label>
                    <input type="text" class="form-control" :value="formatCurrency(selectedLevy?.amount)" readonly>
                </div>

                <x-form.input name="amount" label="Jumlah Dibayar" type="number" required x-model="paymentForm.amount"
                    min="1" />

                <x-form.input name="paid_at" label="Tanggal Bayar" type="date" required x-model="paymentForm.paid_at" />

                <x-form.select name="method" label="Metode Pembayaran" required
                    :options="['cash' => 'Tunai', 'transfer' => 'Transfer', 'qris' => 'QRIS']"
                    x-model="paymentForm.method" />

                <x-form.input name="collector_name" label="Nama Petugas" :value="auth()->user()->name"
                    x-model="paymentForm.collector_name" />

                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success" :disabled="loading">
                        <span x-show="loading" class="spinner-border spinner-border-sm me-2"></span>
                        Catat Pembayaran
                    </button>
                </div>
            </form>
        </x-modal>
    </div>

    @push('scripts')
    <script>
        function leviesPage() {
            return {
                levies: @json($levies->items()),
                filteredLevies: [],
                search: '',
                statusFilter: '',
                periodFilter: '',
                dueDateFrom: '',
                dueDateTo: '',
                loading: false,
                selectedLevy: null,
                summary: {
                    total: 0,
                    paid: 0,
                    pending: 0,
                    overdue: 0
                },
                generateForm: {
                    period_month: '{{ now()->format("Ym") }}',
                    due_date: '{{ now()->addDays(10)->format("Y-m-d") }}'
                },
                paymentForm: {
                    amount: '',
                    paid_at: '{{ now()->format("Y-m-d") }}',
                    method: 'cash',
                    collector_name: '{{ auth()->user()->name }}'
                },

                init() {
                    this.filteredLevies = [...this.levies];
                    this.calculateSummary();
                },

                filterLevies() {
                    this.filteredLevies = this.levies.filter(levy => {
                        const matchesSearch = !this.search ||
                            levy.trader_kiosk?.trader?.name.toLowerCase().includes(this.search.toLowerCase());

                        const matchesStatus = !this.statusFilter || levy.status === this.statusFilter;
                        const matchesPeriod = !this.periodFilter || levy.period_month === this.periodFilter;

                        let matchesDateRange = true;
                        if (this.dueDateFrom || this.dueDateTo) {
                            const dueDate = new Date(levy.due_date);
                            if (this.dueDateFrom) {
                                matchesDateRange = matchesDateRange && dueDate >= new Date(this.dueDateFrom);
                            }
                            if (this.dueDateTo) {
                                matchesDateRange = matchesDateRange && dueDate <= new Date(this.dueDateTo);
                            }
                        }

                        return matchesSearch && matchesStatus && matchesPeriod && matchesDateRange;
                    });
                    this.calculateSummary();
                },

                calculateSummary() {
                    this.summary = this.filteredLevies.reduce((acc, levy) => {
                        acc.total += levy.amount;
                        if (levy.status === 'paid') acc.paid += levy.amount;
                        else if (levy.status === 'overdue') acc.overdue += levy.amount;
                        else acc.pending += levy.amount;
                        return acc;
                    }, { total: 0, paid: 0, pending: 0, overdue: 0 });
                },

                resetFilters() {
                    this.search = '';
                    this.statusFilter = '';
                    this.periodFilter = '';
                    this.dueDateFrom = '';
                    this.dueDateTo = '';
                    this.filterLevies();
                },

                recordPayment(levy) {
                    this.selectedLevy = levy;
                    this.paymentForm.amount = levy.amount;
                    new bootstrap.Modal(document.getElementById('recordPaymentModal')).show();
                },

                async generateLevies() {
                    this.loading = true;
                    try {
                        const response = await fetch('{{ route("admin.levies.store") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(this.generateForm)
                        });

                        if (response.ok) {
                            location.reload();
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    } finally {
                        this.loading = false;
                    }
                },

                async submitPayment() {
                    this.loading = true;
                    try {
                        const response = await fetch('{{ route("admin.payments.store") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                ...this.paymentForm,
                                levy_id: this.selectedLevy.id
                            })
                        });

                        if (response.ok) {
                            location.reload();
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    } finally {
                        this.loading = false;
                    }
                },

                formatCurrency(amount) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
                },

                formatDate(date) {
                    return new Date(date).toLocaleDateString('id-ID');
                },

                formatPeriod(period) {
                    const year = period.substring(0, 4);
                    const month = period.substring(4, 6);
                    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                                       'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                    return monthNames[parseInt(month) - 1] + ' ' + year;
                },

                getStatusClass(status) {
                    const classes = {
                        'pending': 'bg-warning',
                        'partial': 'bg-info',
                        'paid': 'bg-success',
                        'overdue': 'bg-danger'
                    };
                    return classes[status] || 'bg-secondary';
                },

                getStatusText(status) {
                    const texts = {
                        'pending': 'Pending',
                        'partial': 'Sebagian',
                        'paid': 'Lunas',
                        'overdue': 'Overdue'
                    };
                    return texts[status] || status;
                }
            }
        }
    </script>
    @endpush
</x-app-layout>