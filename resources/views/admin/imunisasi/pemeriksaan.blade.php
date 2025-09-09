<!-- Pemeriksaan Card -->
<div id="pemeriksaan" class="card" style="display: none;">
    <div class="card-header" style="padding: .75rem 25px; background-color: #2a5788; min-height: unset;">
        <h5 class="card-title text-white" style="font-weight: 400;">Pemeriksaan Batita</h5>
    </div>
    <div class="card-body">
        <form id="formTambahPemeriksaan">
            @csrf
            <div class="row mb-4">
                <div class="col-4" style="padding-right: .75rem;">
                    <input type="hidden" name="posyandu_id" value="{{ $posyandu->id }}">
                    <label for="pemeriksaan" class="form-label"><b>Jenis Pemeriksaan</b></label>
                    <input type="text" class="form-control" id="jenis_pemeriksaan" name="pemeriksaan" spellcheck="false" autocomplete="off" placeholder="Pemeriksaan mata" required>
                </div>
                <div class="col-3" style="padding: 0 .75rem;">
                    <label for="hasil" class="form-label"><b>Hasil</b></label>
                    <input type="text" class="form-control" id="hasil" name="hasil" spellcheck="false" autocomplete="off" placeholder="Apakah ada kelainan..." required>
                </div>
                <div class="col-4" style="padding: 0 .75rem;">
                    <label for="catatan" class="form-label"><b>Catatan</b></label>
                    <input type="text" class="form-control" id="catatan" name="catatan" spellcheck="false" autocomplete="off" placeholder="Catatan..." required>
                </div>
                <div class="col-1 d-flex align-items-end" style="padding-left: .75rem;">
                    <button class="btn btn-primary btn-sm form-control d-flex align-items-center justify-content-center" style="padding: 0.1rem 0.4rem;" type="submit">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        </form>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="p-col text-center" width="5%">No</th>
                    <th class="p-col" width="30%">Pemeriksaan</th>
                    <th class="p-col" width="20%">Hasil</th>
                    <th class="p-col">Catatan</th>
                    <th class="p-col" width="5%"></th>
                </tr>
            </thead>
            <tbody id="pemeriksaanTableBody">
                @if ($posyandu->posyanduPemeriksaan->isEmpty()) 
                    <tr id="pemeriksaanEmpty">
                        <td class="p-col text-center" colspan="5">Belum ada data pemeriksaan.</td>
                    </tr>
                @else
                    @foreach ($posyandu->posyanduPemeriksaan as $key => $data)
                        <tr id="pemeriksaan-{{ $data->id }}">
                            <td class="p-col align-top text-center">{{ $key + 1 }}</td>
                            <td class="p-col align-top">{{ $data->pemeriksaan }}</td>
                            <td class="p-col align-top">{{ $data->hasil ?? '-' }}</td>
                            <td class="p-col align-top">{{ $data->catatan ?? '-' }}</td>
                            <td class="p-col align-top"><button class="btn btn-sm btn-danger delete-pemeriksaan" data-id="{{ $data->id }}"><i class="fas fa-trash"></i></button></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

@push('customScript')
    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Handle form submission
        $('#formTambahPemeriksaan').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('posyandu-pemeriksaan.store') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    const dataRows = $('#pemeriksaanTableBody tr').not('#pemeriksaanEmpty');
                    const rowNumber = dataRows.length + 1;
                    const pemeriksaan = $('#jenis_pemeriksaan').val();
                    const hasil = $('#hasil').val();
                    const catatan = $('#catatan').val();

                    if (pemeriksaan) {
                        const newRow = `
                            <tr id="pemeriksaan-${response.no}">
                                <td class="p-col align-top text-center">${rowNumber}</td>
                                <td class="p-col align-top">${pemeriksaan}</td>
                                <td class="p-col align-top">${hasil ? hasil : '-'}</td>
                                <td class="p-col align-top">${catatan ? catatan : '-'}</td>
                                <td class="p-col align-top"><button class="btn btn-sm btn-danger delete-pemeriksaan" data-id="` + response.no + `"><i class="fas fa-trash"></i></button></td>
                            </tr>
                        `;

                        $('#pemeriksaanEmpty').remove();
                        $('#pemeriksaanTableBody').append(newRow);
                        $('#modalTambahPemeriksaan').modal('hide');
                        $('#formTambahPemeriksaan')[0].reset();
                    }
                },
                error: function(xhr) {
                    // Tangani error (misal validasi)
                    alert('Something went wrong!');
                }
            });
        });
    </script>

    <script>
        $(document).on('click', '.delete-pemeriksaan', function() {
            var id = $(this).data('id'); // Ambil ID dari data-id tombol

            // Konfirmasi sebelum menghapus
            // Swal.fire({
            //     title: 'Apakah Anda yakin?',
            //     text: "Data yang dihapus tidak dapat dikembalikan!",
            //     icon: 'warning',
            //     showCancelButton: true,
            //     confirmButtonColor: 'danger',
            //     cancelButtonColor: 'info',
            //     confirmButtonText: 'Ya, hapus!',
            //     cancelButtonText: 'Batal'
            // }).then((result) => {
            //     if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('posyandu-pemeriksaan.destroy', '') }}/" + id,
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        type: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                // Hapus baris dari tampilan
                                $('#pemeriksaan-' + id).remove();

                                checkIfPemeriksaanEmpty();
                            }
                        },
                        error: function(xhr) {
                            alert('Something went wrong!');
                        }
                    });
            //     }
            // });

            function checkIfPemeriksaanEmpty() {
                const pemeriksaanRows = $('tr[id^="pemeriksaan-"]');
                const emptyRow = $('#pemeriksaanEmpty');

                if (pemeriksaanRows.length === 0) {
                    // Jika tidak ada data, tampilkan row kosong
                    if (emptyRow.length === 0) {
                        $('#pemeriksaanTableBody').append(`
                            <tr id="pemeriksaanEmpty">
                                <td class="p-col text-center" colspan="5">Belum ada data pemeriksaan.</td>
                            </tr>
                        `);
                    }
                } else {
                    // Jika ada data, hapus row kosong
                    emptyRow.remove();
                }
            }
        });
    </script>
@endpush

@push('customScript')
    <script src="/assets/js/select2.min.js"></script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush