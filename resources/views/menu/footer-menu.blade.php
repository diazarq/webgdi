@extends('layout.app', ['active' => $active])
@section('title', ($pageTitle ?? 'CMS'))

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin/dashboard"><i class="bi-house"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Menu Footer</li>
    </ol>
@endsection

@section('content')
<div class="container-fluid px-3">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-1 mt-2">Kelola Menu Footer</h4>
            <p class="text-muted mb-0 small">Atur daftar menu/tautan yang tampil pada kolom <strong>Quick Links</strong> dan <strong>Program</strong> di bagian kanan footer website.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Card with Tabs -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white border-bottom-0 pt-3 px-3">
            <ul class="nav nav-tabs card-header-tabs" id="footerTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-semibold" id="tab-quick-btn" data-bs-toggle="tab" data-bs-target="#tab-quick" type="button" role="tab">
                        <i class="bi-link-45deg me-1"></i> Quick Links (Kolom 2)
                        <span class="badge bg-primary ms-1">{{ count($quickLinks) }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold" id="tab-program-btn" data-bs-toggle="tab" data-bs-target="#tab-program" type="button" role="tab">
                        <i class="bi-grid-fill me-1"></i> Link Program (Kolom 3)
                        <span class="badge bg-primary ms-1">{{ count($programLinks) }}</span>
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body p-4">
            <div class="tab-content" id="footerTabContent">
                
                {{-- TAB 1: QUICK LINKS (KOLOM 2) --}}
                <div class="tab-pane fade show active" id="tab-quick" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small">Daftar tautan cepat yang tampil di kolom <strong>Quick Links</strong>.</span>
                        <button type="button" class="btn btn-primary btn-sm px-3 btn-add-link" data-category="quick_link">
                            <i class="bi-plus-lg me-1"></i> Tambah Quick Link
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle w-100 mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="6%" class="text-center">No</th>
                                    <th width="10%" class="text-center">Urutan</th>
                                    <th width="30%">Nama Tautan</th>
                                    <th>URL / Path Tujuan</th>
                                    <th width="15%" class="text-center">Status</th>
                                    <th class="text-center" width="18%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($quickLinks as $idx => $m)
                                <tr>
                                    <td class="text-center">{{ $idx + 1 }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border px-2 py-1">{{ $m->order }}</span>
                                    </td>
                                    <td><strong>{{ $m->title }}</strong></td>
                                    <td>
                                        <code>{{ $m->url }}</code>
                                        @if(Str::startsWith($m->url, ['http://', 'https://']))
                                            <span class="badge bg-secondary ms-1">External</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($m->status == 'A')
                                            <span class="badge bg-success"><i class="bi-check-circle me-1"></i> Aktif</span>
                                        @else
                                            <span class="badge bg-secondary"><i class="bi-x-circle me-1"></i> Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-primary me-1 btn-edit-link" 
                                            data-id="{{ $m->id }}"
                                            data-title="{{ $m->title }}"
                                            data-url="{{ $m->url }}"
                                            data-order="{{ $m->order }}"
                                            data-status="{{ $m->status }}"
                                            data-category="quick_link">
                                            <i class="bi-pencil-square"></i> Edit
                                        </button>
                                        <a href="/admin/footer-menu/{{ $m->id }}/delete" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus tautan ini?')">
                                            <i class="bi-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        Belum ada tautan di Quick Links.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- TAB 2: LINK PROGRAM (KOLOM 3) --}}
                <div class="tab-pane fade" id="tab-program" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small">Daftar tautan program yang tampil di kolom <strong>Program</strong>.</span>
                        <button type="button" class="btn btn-primary btn-sm px-3 btn-add-link" data-category="program_link">
                            <i class="bi-plus-lg me-1"></i> Tambah Link Program
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle w-100 mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="6%" class="text-center">No</th>
                                    <th width="10%" class="text-center">Urutan</th>
                                    <th width="30%">Nama Program</th>
                                    <th>URL / Path Tujuan</th>
                                    <th width="15%" class="text-center">Status</th>
                                    <th class="text-center" width="18%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($programLinks as $idx => $m)
                                <tr>
                                    <td class="text-center">{{ $idx + 1 }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border px-2 py-1">{{ $m->order }}</span>
                                    </td>
                                    <td><strong>{{ $m->title }}</strong></td>
                                    <td>
                                        <code>{{ $m->url }}</code>
                                        @if(Str::startsWith($m->url, ['http://', 'https://']))
                                            <span class="badge bg-secondary ms-1">External</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($m->status == 'A')
                                            <span class="badge bg-success"><i class="bi-check-circle me-1"></i> Aktif</span>
                                        @else
                                            <span class="badge bg-secondary"><i class="bi-x-circle me-1"></i> Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-primary me-1 btn-edit-link" 
                                            data-id="{{ $m->id }}"
                                            data-title="{{ $m->title }}"
                                            data-url="{{ $m->url }}"
                                            data-order="{{ $m->order }}"
                                            data-status="{{ $m->status }}"
                                            data-category="program_link">
                                            <i class="bi-pencil-square"></i> Edit
                                        </button>
                                        <a href="/admin/footer-menu/{{ $m->id }}/delete" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus tautan program ini?')">
                                            <i class="bi-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        Belum ada tautan program di footer.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal Form Link Footer -->
<div class="modal fade" id="modalFooterMenu" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admin.footer-menu.save') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="formId">
                <input type="hidden" name="category" id="formCategory" value="quick_link">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalTitle">Tambah Link Footer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul / Nama Tautan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" id="formTitle" placeholder="Contoh: Tentang Zakat, Budaya" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">URL / Halaman Tujuan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="url" id="formUrl" placeholder="Contoh: /tentang-zakat, /budaya, https://..." required>
                        <div class="form-text text-muted small">Gunakan tanda slash untuk path lokal (contoh: <code>/tentang-zakat</code>) atau URL lengkap.</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Urutan Tampil</label>
                            <input type="number" class="form-control" name="order" id="formOrder" min="1" placeholder="1, 2, 3...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select" name="status" id="formStatus">
                                <option value="A">Aktif</option>
                                <option value="NA">Non-Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4"><i class="bi-save me-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var modal = new bootstrap.Modal(document.getElementById('modalFooterMenu'));

        $('.btn-add-link').click(function() {
            var cat = $(this).data('category');
            var catLabel = (cat === 'program_link') ? 'Program (Kolom 3)' : 'Quick Link (Kolom 2)';
            $('#modalTitle').text('Tambah Tautan ' + catLabel);
            $('#formId').val('');
            $('#formCategory').val(cat);
            $('#formTitle').val('');
            $('#formUrl').val('');
            $('#formOrder').val('');
            $('#formStatus').val('A');
            modal.show();
        });

        $('.btn-edit-link').click(function() {
            var btn = $(this);
            var cat = btn.data('category');
            var catLabel = (cat === 'program_link') ? 'Program (Kolom 3)' : 'Quick Link (Kolom 2)';
            $('#modalTitle').text('Edit Tautan ' + catLabel);
            $('#formId').val(btn.data('id'));
            $('#formCategory').val(cat);
            $('#formTitle').val(btn.data('title'));
            $('#formUrl').val(btn.data('url'));
            $('#formOrder').val(btn.data('order'));
            $('#formStatus').val(btn.data('status'));
            modal.show();
        });
    });
</script>
@endpush
