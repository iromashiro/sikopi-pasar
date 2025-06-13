<x-app-layout>
    <x-slot name="header">Manajemen Kios</x-slot>

    <div x-data="kiosksPage()">
        <!-- Header Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4>Daftar Kios</h4>
                <p class="text-muted">Kelola data kios di seluruh pasar</p>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKioskModal">
                <i class="bi bi-plus-circle"></i> Tambah Kios
            </button>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" class="form-control" placeholder="Cari nomor kios..." x-model="search"
                            @input="filterKiosks()">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" x-model="marketFilter" @change="filterKiosks()">
                            <option value="">Semua Pasar</option>
                            @foreach($markets as $market)
                            <option value="{{ $market->id }}">{{ $market->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" x-model="statusFilter" @change="filterKiosks()">
                            <option value="">Semua Status</option>
                            <option value="available">Tersedia</option>
                            <option value="occupied">Terisi</option>
                            <option value="inactive">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" x-model="categoryFilter" @change="filterKiosks()">
                            <option value="">Semua Kategori</option>
                            <option value="Sayuran">Sayuran</option>
                            <option value="Buah-buahan">Buah-buahan</option>
                            <option value="Daging">Daging</option>
                            <option value="Ikan">Ikan</option>
                            <option value="Bumbu">Bumbu</option>
                            <option value="Kue">Kue</option>
                            <option value="Pakaian">Pakaian</option>
                            <option value="Elektronik">Elektronik</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kiosks Grid -->
        <div class="row">
            <template x-for="kiosk in filteredKiosks" :key="kiosk.id">
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0" x-text="kiosk.kiosk_no"></h6>
                            <span class="badge" :class="{
                                      'bg-success': kiosk.status === 'available',
                                      'bg-warning': kiosk.status === 'occupied',
                                      'bg-secondary': kiosk.status === 'inactive'
                                  }" x-text="getStatusText(kiosk.status)">
                            </span>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                <strong>Pasar:</strong> <span x-text="kiosk.market?.name"></span><br>
                                <strong>Kategori:</strong> <span x-text="kiosk.category"></span><br>
                                <strong>Luas:</strong> <span x-text="kiosk.area_m2"></span> m²
                            </p>

                            <template x-if="kiosk.current_trader">
                                <div class="alert alert-info py-2">
                                    <small>
                                        <strong>Pedagang:</strong> <span x-text="kiosk.current_trader.name"></span>
                                    </small>
                                </div>
                            </template>
                        </div>
                        <div class="card-footer">
                            <div class="btn-group w-100">
                                <button type="button" class="btn btn-outline-primary btn-sm" @click="editKiosk(kiosk)">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" @click="deleteKiosk(kiosk)">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $kiosks->links() }}
        </div>

        <!-- Add/Edit Kiosk Modal -->
        <x-modal id="addKioskModal" title="Tambah Kios Baru">
            <form @submit.prevent="submitKiosk()">
                <x-form.select name="market_id" label="Pasar" required
                    :options="$markets->pluck('name', 'id')->toArray()" x-model="form.market_id" />

                <x-form.input name="kiosk_no" label="Nomor Kios" required x-model="form.kiosk_no" />

                <x-form.select name="category" label="Kategori" required :options="[
                                   'Sayuran' => 'Sayuran',
                                   'Buah-buahan' => 'Buah-buahan',
                                   'Daging' => 'Daging',
                                   'Ikan' => 'Ikan',
                                   'Bumbu' => 'Bumbu',
                                   'Kue' => 'Kue',
                                   'Pakaian' => 'Pakaian',
                                   'Elektronik' => 'Elektronik'
                               ]" x-model="form.category" />

                <x-form.input name="area_m2" label="Luas (m²)" type="number" required x-model="form.area_m2" min="1"
                    max="100" />

                <x-form.select name="status" label="Status" required :options="[
                                   'available' => 'Tersedia',
                                   'occupied' => 'Terisi',
                                   'inactive' => 'Tidak Aktif'
                               ]" x-model="form.status" />

                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" :disabled="loading">
                        <span x-show="loading" class="spinner-border spinner-border-sm me-2"></span>
                        Simpan
                    </button>
                </div>
            </form>
        </x-modal>
    </div>

    @push('scripts')
    <script>
        function kiosksPage() {
            return {
                kiosks: @json($kiosks->items()),
                filteredKiosks: [],
                search: '',
                marketFilter: '',
                statusFilter: '',
                categoryFilter: '',
                loading: false,
                editMode: false,
                form: {
                    id: null,
                    market_id: '',
                    kiosk_no: '',
                    category: '',
                    area_m2: '',
                    status: 'available'
                },

                init() {
                    this.filteredKiosks = [...this.kiosks];
                },

                filterKiosks() {
                    this.filteredKiosks = this.kiosks.filter(kiosk => {
                        const matchesSearch = !this.search ||
                            kiosk.kiosk_no.toLowerCase().includes(this.search.toLowerCase());

                        const matchesMarket = !this.marketFilter ||
                            kiosk.market_id == this.marketFilter;

                        const matchesStatus = !this.statusFilter ||
                            kiosk.status === this.statusFilter;

                        const matchesCategory = !this.categoryFilter ||
                            kiosk.category === this.categoryFilter;

                        return matchesSearch && matchesMarket && matchesStatus && matchesCategory;
                    });
                },

                getStatusText(status) {
                    const statusMap = {
                        'available': 'Tersedia',
                        'occupied': 'Terisi',
                        'inactive': 'Tidak Aktif'
                    };
                    return statusMap[status] || status;
                },

                editKiosk(kiosk) {
                    this.editMode = true;
                    this.form = { ...kiosk };
                    document.getElementById('addKioskModal').querySelector('.modal-title').textContent = 'Edit Kios';
                    new bootstrap.Modal(document.getElementById('addKioskModal')).show();
                },

                resetForm() {
                    this.editMode = false;
                    this.form = {
                        id: null,
                        market_id: '',
                        kiosk_no: '',
                        category: '',
                        area_m2: '',
                        status: 'available'
                    };
                    document.getElementById('addKioskModal').querySelector('.modal-title').textContent = 'Tambah Kios Baru';
                },

                async submitKiosk() {
                    this.loading = true;
                    try {
                        const url = this.editMode
                            ? `/admin/kiosks/${this.form.id}`
                            : '{{ route("admin.kiosks.store") }}';

                        const method = this.editMode ? 'PUT' : 'POST';

                        const response = await fetch(url, {
                            method: method,
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

                deleteKiosk(kiosk) {
                    if (confirm(`Hapus kios ${kiosk.kiosk_no}?`)) {
                        // Implementation
                    }
                }
            }
        }

        // Reset form when modal is hidden
        document.getElementById('addKioskModal').addEventListener('hidden.bs.modal', function() {
            Alpine.store('kiosksPage').resetForm();
        });
    </script>
    @endpush
</x-app-layout>