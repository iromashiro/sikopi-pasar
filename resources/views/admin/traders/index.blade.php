<x-app-layout>
    <x-slot name="header">Manajemen Pedagang</x-slot>

    <div x-data="tradersPage()">
        <!-- Header Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4>Daftar Pedagang</h4>
                <p class="text-muted">Kelola data pedagang dan penugasan kios</p>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTraderModal">
                <i class="bi bi-plus-circle"></i> Tambah Pedagang
            </button>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Cari nama atau NIK..." x-model="search"
                            @input="filterTraders()">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" x-model="statusFilter" @change="filterTraders()">
                            <option value="">Semua Status</option>
                            <option value="active">Aktif</option>
                            <option value="inactive">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" x-model="assignmentFilter" @change="filterTraders()">
                            <option value="">Semua Penugasan</option>
                            <option value="assigned">Sudah Ditugaskan</option>
                            <option value="unassigned">Belum Ditugaskan</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-secondary w-100" @click="resetFilters()">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Traders Table -->
        <div class="card">
            <div class="card-body">
                <x-table :headers="['NIK', 'Nama', 'Alamat', 'Telepon', 'Status', 'Kios', 'Aksi']">
                    <template x-for="trader in filteredTraders" :key="trader.id">
                        <tr>
                            <td x-text="trader.nik_masked"></td>
                            <td x-text="trader.name"></td>
                            <td x-text="trader.address || '-'"></td>
                            <td x-text="trader.phone || '-'"></td>
                            <td>
                                <span class="badge status-badge"
                                    :class="trader.status === 'active' ? 'bg-success' : 'bg-secondary'"
                                    x-text="trader.status === 'active' ? 'Aktif' : 'Tidak Aktif'">
                                </span>
                            </td>
                            <td>
                                <template x-if="trader.active_kiosks && trader.active_kiosks.length > 0">
                                    <div>
                                        <template x-for="kiosk in trader.active_kiosks">
                                            <span class="badge bg-info me-1" x-text="kiosk.kiosk_no"></span>
                                        </template>
                                    </div>
                                </template>
                                <template x-if="!trader.active_kiosks || trader.active_kiosks.length === 0">
                                    <span class="text-muted">Belum ditugaskan</span>
                                </template>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-primary btn-action"
                                        @click="editTrader(trader)">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-success btn-action"
                                        @click="assignKiosk(trader)">
                                        <i class="bi bi-shop"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-action"
                                        @click="deleteTrader(trader)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </x-table>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        Menampilkan <span x-text="filteredTraders.length"></span> dari <span
                            x-text="traders.length"></span> pedagang
                    </div>
                    {{ $traders->links() }}
                </div>
            </div>
        </div>

        <!-- Add Trader Modal -->
        <x-modal id="addTraderModal" title="Tambah Pedagang Baru">
            <form @submit.prevent="submitTrader()">
                <x-form.input name="nik" label="NIK" required x-model="form.nik" />
                <x-form.input name="name" label="Nama Lengkap" required x-model="form.name" />
                <x-form.textarea name="address" label="Alamat" x-model="form.address" />
                <x-form.input name="phone" label="Nomor Telepon" x-model="form.phone" />

                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" :disabled="loading">
                        <span x-show="loading" class="spinner-border spinner-border-sm me-2"></span>
                        Simpan
                    </button>
                </div>
            </form>
        </x-modal>

        <!-- Assign Kiosk Modal -->
        <x-modal id="assignKioskModal" title="Tugaskan Kios">
            <form @submit.prevent="submitAssignment()">
                <div class="mb-3">
                    <label class="form-label">Pedagang</label>
                    <input type="text" class="form-control" :value="selectedTrader?.name" readonly>
                </div>

                <x-form.select name="kiosk_id" label="Pilih Kios" required :options="[]"
                    x-model="assignmentForm.kiosk_id" />

                <x-form.input name="start_date" label="Tanggal Mulai" type="date" required
                    x-model="assignmentForm.start_date" />

                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success" :disabled="loading">
                        <span x-show="loading" class="spinner-border spinner-border-sm me-2"></span>
                        Tugaskan
                    </button>
                </div>
            </form>
        </x-modal>
    </div>

    @push('scripts')
    <script>
        function tradersPage() {
            return {
                traders: @json($traders->items()),
                filteredTraders: [],
                search: '',
                statusFilter: '',
                assignmentFilter: '',
                loading: false,
                selectedTrader: null,
                form: {
                    nik: '',
                    name: '',
                    address: '',
                    phone: ''
                },
                assignmentForm: {
                    kiosk_id: '',
                    start_date: new Date().toISOString().split('T')[0]
                },

                init() {
                    this.filteredTraders = [...this.traders];
                },

                filterTraders() {
                    this.filteredTraders = this.traders.filter(trader => {
                        const matchesSearch = !this.search ||
                            trader.name.toLowerCase().includes(this.search.toLowerCase()) ||
                            trader.nik_masked.includes(this.search);

                        const matchesStatus = !this.statusFilter || trader.status === this.statusFilter;

                        const hasAssignment = trader.active_kiosks && trader.active_kiosks.length > 0;
                        const matchesAssignment = !this.assignmentFilter ||
                            (this.assignmentFilter === 'assigned' && hasAssignment) ||
                            (this.assignmentFilter === 'unassigned' && !hasAssignment);

                        return matchesSearch && matchesStatus && matchesAssignment;
                    });
                },

                resetFilters() {
                    this.search = '';
                    this.statusFilter = '';
                    this.assignmentFilter = '';
                    this.filterTraders();
                },

                editTrader(trader) {
                    this.form = { ...trader };
                    new bootstrap.Modal(document.getElementById('addTraderModal')).show();
                },

                assignKiosk(trader) {
                    this.selectedTrader = trader;
                    // Load available kiosks via AJAX
                    this.loadAvailableKiosks();
                    new bootstrap.Modal(document.getElementById('assignKioskModal')).show();
                },

                async loadAvailableKiosks() {
                    // Implementation would fetch available kiosks
                },

                async submitTrader() {
                    this.loading = true;
                    try {
                        const response = await fetch('{{ route("admin.traders.store") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(this.form)
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

                async submitAssignment() {
                    this.loading = true;
                    try {
                        const response = await fetch(`/admin/traders/${this.selectedTrader.id}/assign-kiosk`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(this.assignmentForm)
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

                deleteTrader(trader) {
                    if (confirm(`Hapus pedagang ${trader.name}?`)) {
                        // Implementation
                    }
                }
            }
        }
    </script>
    @endpush
</x-app-layout>