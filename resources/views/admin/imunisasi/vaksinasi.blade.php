<!-- Vaksinasi Card -->
<div id="vaksinasi" class="card" style="display: none;">
    <div class="card-header" style="padding: .75rem 25px; background-color: #2a5788; min-height: unset;">
        <h5 class="card-title text-white" style="font-weight: 400;">Vaksinasi</h5>
    </div>
    <div class="card-body">
        <form id="formTambahVaksin">
            @csrf
            <div class="row mb-3">
                <div class="col-4" style="padding-right: .75rem;">
                    <input type="hidden" name="posyandu_id" value="{{ $posyandu->id }}">
                    <label for="vaksinSelect" class="form-label"><b>Vaksin</b></label>
                    <select id="vaksinSelect" name="vaksin_id" class="form-control select2" style="padding: 0.1rem 0.4rem;" required>
                        <option value="" disabled selected>--Pilih Vaksin--</option>
                        @foreach ($vaksins as $vaksin)
                            <option value="{{ $vaksin->id }}" data-dosis-total="{{ $vaksin->dosis_total }}" data-usia-pemberian="{{ $vaksin->usia_pemberian }}" data-interval="{{ $vaksin->interval }}">
                                {{ $vaksin->nama_vaksin }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4" style="padding: 0 .75rem;">
                    <label for="dosis_ke" class="form-label"><b>Dosis ke-</b></label>
                    <input type="text" id="dosis_ke" name="dosis_ke" pattern="[0-9]*" inputmode="numeric" class="form-control" spellcheck="false" autocomplete="off" placeholder="0"/>
                </div>
                <div class="col-4" style="padding: 0 .75rem;">
                    <label for="dosis_total" class="form-label"><b>Dosis Total</b></label>
                    <span class="input-group-text" id="dosis_total" style="background-color: #e9ecef;"></span>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-5" style="padding-right: .75rem;">
                    <label for="usia_pemberian" class="form-label"><b>Usia Pemberian</b></label>
                    <span class="input-group-text" id="usia_pemberian" style="background-color: #e9ecef;"></span>
                </div>
                <div class="col-5" style="padding: 0 .75rem;">
                    <label for="interval" class="form-label"><b>Interval</b></label>
                    <span class="input-group-text" id="interval" style="background-color: #e9ecef;"></span>
                </div>
                <div class="col-2 d-flex align-items-end" style="padding-left: .75rem;">
                    <button class="btn btn-primary btn-sm form-control d-flex align-items-center justify-content-center" style="padding: 0.1rem 0.4rem;" type="submit">
                        <i class="fas fa-plus"></i> <span class="d-none d-lg-block">&nbsp;Tambah</span>
                    </button>
                </div>
            </div>
        </form>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="p-col text-center" width="5%">No</th>
                    <th class="p-col">Vaksin</th>
                    <th class="p-col" width="20%">Dosis ke-</th>
                    <th class="p-col" width="5%"></th>
                </tr>
            </thead>
            <tbody id="vaksinTableBody">
                @if ($posyandu->posyanduVaksin->isEmpty()) 
                    <tr id="vaksinEmpty">
                        <td class="p-col text-center" colspan="4">Belum ada data vaksinasi.</td>
                    </tr>
                @else
                    @foreach ($posyandu->posyanduVaksin as $key => $data)
                        <tr id="vaksin-{{ $data->id }}">
                            <td class="p-col align-top text-center">{{ $key + 1 }}</td>
                            <td class="p-col align-top">{{ $data->vaksin->nama_vaksin }}</td>
                            <td class="p-col align-top">{{ $data->dosis_ke ?? '-' }}</td>
                            <td class="p-col align-top"><button class="btn btn-sm btn-danger delete-vaksin" data-id="{{ $data->id }}"><i class="fas fa-trash"></i></button></td>
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
            // Update detail vaksin
            $('#vaksinSelect').on('change', function() {
                const selectedOption = $(this).find(':selected');
                const dosis_total = selectedOption.data('dosis-total');
                const usia_pemberian = selectedOption.data('usia-pemberian');
                const interval = selectedOption.data('interval');

                $('#dosis_total').text(dosis_total);
                $('#usia_pemberian').text(usia_pemberian);
                $('#interval').text(interval);
            });

            $('#dosis_ke').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            // Handle form submission
            $('#formTambahVaksin').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('posyandu-vaksin.store') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        const dataRows = $('#vaksinTableBody tr').not('#vaksinEmpty');
                        const rowNumber = dataRows.length + 1;
                        const vaksinOption = $('#vaksinSelect').find(':selected');
                        const vaksin = vaksinOption.text();
                        const dosis_ke = $('#dosis_ke').val();

                        if (vaksin) {
                            const newRow = `
                                <tr id="vaksin-${response.no}">
                                    <td class="p-col align-top text-center">${rowNumber}</td>
                                    <td class="p-col align-top">${vaksin}</td>
                                    <td class="p-col align-top">${dosis_ke ? dosis_ke : '-'}</td>
                                    <td class="p-col align-top"><button class="btn btn-sm btn-danger delete-vaksin" data-id="` + response.no + `"><i class="fas fa-trash"></i></button></td>
                                </tr>
                            `;

                            $('#vaksinEmpty').remove();
                            $('#vaksinTableBody').append(newRow);
                            $('#modalTambahVaksin').modal('hide');
                            $('#formTambahVaksin')[0].reset();
                            $('#vaksinSelect').val(null).trigger('change');
                            $('#dosis_ke').val('');
                            $('#dosis_total').text('');
                            $('#usia_pemberian').text('');
                            $('#interval').text('');
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
        $(document).on('click', '.delete-vaksin', function() {
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
                        url: "{{ route('posyandu-vaksin.destroy', '') }}/" + id,
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        type: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                // Hapus baris dari tampilan
                                $('#vaksin-' + id).remove();

                                checkIfVaksinEmpty();
                            }
                        },
                        error: function(xhr) {
                            alert('Something went wrong!');
                        }
                    });
            //     }
            // });

            function checkIfVaksinEmpty() {
                const vaksinRows = $('tr[id^="vaksin-"]');
                const emptyRow = $('#vaksinEmpty');
                
                if (vaksinRows.length === 0) {
                    // Jika tidak ada data, tampilkan row kosong
                    if (emptyRow.length === 0) {
                        $('#vaksinTableBody').append(`
                            <tr id="vaksinEmpty">
                                <td class="p-col text-center" colspan="4">Belum ada data vaksinasi.</td>
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