<!-- Vitamin Card -->
<div id="vitamin" class="card" style="display: none;">
    <div class="card-header" style="padding: .75rem 25px; background-color: #2a5788; min-height: unset;">
        <h5 class="card-title text-white" style="font-weight: 400;">Pemberian Vitamin</h5>
    </div>
    <div class="card-body">
        <form id="formTambahVitamin">
            @csrf
            <div class="row mb-3">
                <div class="col-4" style="padding-right: .75rem;">
                    <input type="hidden" name="posyandu_id" value="{{ $posyandu->id }}">
                    <label for="vitaminSelect" class="form-label"><b>Vitamin</b></label>
                    <select id="vitaminSelect" name="vitamin_id" class="form-control select2" style="padding: 0.1rem 0.4rem;" required>
                        <option value="" disabled selected>--Pilih Vitamin--</option>
                        @foreach ($vitamins as $vitamin)
                            <option value="{{ $vitamin->id }}" data-dosis="{{ $vitamin->dosis }}" data-usia-pemberian="{{ $vitamin->usia_pemberian }}"">
                                {{ $vitamin->nama_vitamin }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4" style="padding: 0 .75rem;">
                    <label for="dosis" class="form-label"><b>Dosis</b></label>
                    <span class="input-group-text" id="dosis" style="background-color: #e9ecef;"></span>
                </div>
                <div class="col-4" style="padding: 0 .75rem;">
                    <label for="usia_pemberian" class="form-label"><b>Usia Pemberian</b></label>
                    <span class="input-group-text" id="usia_pemberian_vitamin" style="background-color: #e9ecef;"></span>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-11" style="padding-right: .75rem;">
                    <label for="catatan" class="form-label"><b>Catatan</b></label>
                    <input type="text" class="form-control" id="catatan_vitamin" name="catatan" spellcheck="false" autocomplete="off" placeholder="Catatan (opsional)">
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
                    <th class="p-col" width="30%">Vitamin</th>
                    <th class="p-col" width="20%">Dosis</th>
                    <th class="p-col">Catatan</th>
                    <th class="p-col" width="5%"></th>
                </tr>
            </thead>
            <tbody id="vitaminTableBody">
                @if ($posyandu->posyanduVitamin->isEmpty()) 
                    <tr id="vitaminEmpty">
                        <td class="p-col text-center" colspan="5">Belum ada data pemberian vitamin.</td>
                    </tr>
                @else
                    @foreach ($posyandu->posyanduVitamin as $key => $data)
                        <tr id="vitamin-{{ $data->id }}">
                            <td class="p-col align-top text-center">{{ $key + 1 }}</td>
                            <td class="p-col align-top">{{ $data->vitamin->nama_vitamin }}</td>
                            <td class="p-col align-top">{{ $data->vitamin->dosis ?? '-' }}</td>
                            <td class="p-col align-top">{{ $data->catatan ?? '-' }}</td>
                            <td class="p-col align-top"><button class="btn btn-sm btn-danger delete-vitamin" data-id="{{ $data->id }}"><i class="fas fa-trash"></i></button></td>
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
        $(document).ready(function() {
            // Update detail vitamin
            $('#vitaminSelect').on('change', function() {
                const selectedOption = $(this).find(':selected');
                const dosis = selectedOption.data('dosis');
                const usia_pemberian = selectedOption.data('usia-pemberian');

                $('#dosis').text(dosis);
                $('#usia_pemberian_vitamin').text(usia_pemberian);
            });

            // Handle form submission
            $('#formTambahVitamin').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('posyandu-vitamin.store') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        const dataRows = $('#vitaminTableBody tr').not('#vitaminEmpty');
                        const rowNumber = dataRows.length + 1;
                        const vitaminOption = $('#vitaminSelect').find(':selected');
                        const vitamin = vitaminOption.text();
                        const dosis = vitaminOption.data('dosis');
                        const catatan = $('#catatan_vitamin').val();

                        if (vitamin) {
                            const newRow = `
                                <tr id="vitamin-${response.no}">
                                    <td class="p-col align-top text-center">${rowNumber}</td>
                                    <td class="p-col align-top">${vitamin}</td>
                                    <td class="p-col align-top">${dosis ? dosis : '-'}</td>
                                    <td class="p-col align-top">${catatan ? catatan : '-'}</td>
                                    <td class="p-col align-top"><button class="btn btn-sm btn-danger delete-vitamin" data-id="` + response.no + `"><i class="fas fa-trash"></i></button></td>
                                </tr>
                            `;

                            $('#vitaminEmpty').remove();
                            $('#vitaminTableBody').append(newRow);
                            $('#modalTambahVitamin').modal('hide');
                            $('#formTambahVitamin')[0].reset();
                            $('#vitaminSelect').val(null).trigger('change');
                            $('#dosis').text('');
                            $('#usia_pemberian_vitamin').text('');
                            $('#catatan_vitamin').val('');
                        }
                    },
                    error: function(xhr) {
                        // Tangani error (misal validasi)
                        alert('Something went wrong!');
                    }
                });
            });
        });
    </script>

    <script>
        $(document).on('click', '.delete-vitamin', function() {
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
                        url: "{{ route('posyandu-vitamin.destroy', '') }}/" + id,
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        type: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                // Hapus baris dari tampilan
                                $('#vitamin-' + id).remove();

                                checkIfVitaminEmpty();
                            }
                        },
                        error: function(xhr) {
                            alert('Something went wrong!');
                        }
                    });
            //     }
            // });

            function checkIfVitaminEmpty() {
                const vitaminRows = $('tr[id^="vitamin-"]');
                const emptyRow = $('#vitaminEmpty');
                
                if (vitaminRows.length === 0) {
                    // Jika tidak ada data, tampilkan row kosong
                    if (emptyRow.length === 0) {
                        $('#vitaminTableBody').append(`
                            <tr id="vitaminEmpty">
                                <td class="p-col text-center" colspan="5">Belum ada data pemberian vitamin.</td>
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