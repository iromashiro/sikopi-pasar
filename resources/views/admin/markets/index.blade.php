<x-app-layout>
    <x-slot name="header">Manajemen Pasar</x-slot>

    <div x-data="marketsPage()">
        <!-- Header Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4>Daftar Pasar</h4>
                <p class="text-muted">Kelola data pasar dan lokasi</p>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMarketModal">
                <i class="bi bi-plus-circle"></i> Tambah Pasar
            </button>
        </div>

        <!-- Markets Table -->
        <div class="card">
            <div class="card-body">
                <x-table :headers="['Nama Pasar', 'Lokasi', 'Status', 'Jumlah Kios', 'Aksi']">
                    @foreach($markets as $market)
                    <tr>
                        <td>{{ $market->name }}</td>
                        <td>{{ $market->location ?: '-' }}</td>
                        <td>
                            <span
                                class="badge status-badge {{ $market->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $market->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $market->kiosks_count ?? 0 }} kios</span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-primary btn-action"
                                    @click="editMarket({{ $market->toJson() }})">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                @can('delete', $market)
                                <form method="POST" action="{{ route('admin.markets.destroy', $market) }}"
                                    class="d-inline" onsubmit="return confirm('Hapus pasar {{ $market->name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-action">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </x-table>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $markets->links() }}
                </div>
            </div>
        </div>

        <!-- Add/Edit Market Modal -->
        <x-modal id="addMarketModal" title="Tambah Pasar Baru">
            <form @submit.prevent="submitMarket()">
                <x-form.input name="name" label="Nama Pasar" required x-model="form.name" />
                <x-form.textarea name="location" label="Lokasi" x-model="form.location" />
                <x-form.select name="status" label="Status" required
                    :options="['active' => 'Aktif', 'inactive' => 'Tidak Aktif']" x-model="form.status" />

                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" :disabled="loading">
                        <span x-show="loading" class="spinner-border spinner-border-sm me-2"></span>
                        <span x-text="editMode ? 'Update' : 'Simpan'"></span>
                    </button>
                </div>
            </form>
        </x-modal>
    </div>

    @push('scripts')
    <script>
        function marketsPage() {
            return {
                loading: false,
                editMode: false,
                form: {
                    id: null,
                    name: '',
                    location: '',
                    status: 'active'
                },

                editMarket(market) {
                    this.editMode = true;
                    this.form = { ...market };
                    document.getElementById('addMarketModal').querySelector('.modal-title').textContent = 'Edit Pasar';
                    new bootstrap.Modal(document.getElementById('addMarketModal')).show();
                },

                resetForm() {
                    this.editMode = false;
                    this.form = {
                        id: null,
                        name: '',
                        location: '',
                        status: 'active'
                    };
                    document.getElementById('addMarketModal').querySelector('.modal-title').textContent = 'Tambah Pasar Baru';
                },

                async submitMarket() {
                    this.loading = true;
                    try {
                        const url = this.editMode
                            ? `/admin/markets/${this.form.id}`
                            : '{{ route("admin.markets.store") }}';

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
                        } else {
                            const error = await response.json();
                            alert('Error: ' + (error.message || 'Terjadi kesalahan'));
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menyimpan data');
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }

        // Reset form when modal is hidden
        document.getElementById('addMarketModal').addEventListener('hidden.bs.modal', function() {
            // Reset form via Alpine.js
            const component = Alpine.$data(document.querySelector('[x-data="marketsPage()"]'));
            if (component) {
                component.resetForm();
            }
        });
    </script>
    @endpush
</x-app-layout>