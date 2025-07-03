@extends('admin.layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Data Risiko Stunting</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Posyandu</a></div>
                <div class="breadcrumb-item"><a href="#">Manajemen</a></div>
                <div class="breadcrumb-item">Tabel</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Posyandu</h2>
            <div class="row">
                <div class="col-12">
                    @include('admin.layouts.alert')
                    @if ($errors->has('file'))
                        <div class="text-danger">
                            {{ $errors->first('file') }}
                        </div>
                    @endif
                </div>
            </div>
             <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Grafik Status Gizi Batita</h4>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="position: relative; height: 300px; width: 100%;">
                                <canvas id="stuntingChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Daftar Risiko Stunting</h4>
                        </div>
                        <div class="card-body">
                            <div class="card-header-action">
                                <form method="POST" action="{{ route('perankingan-risiko.recalculate') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-sync-alt"></i> Hitung Ulang Data
                                    </button>
                                </form>
                            </div>
                        </div>
                         <div class="card-body pb-2">
                            <div class="section-title mt-0 mb-3">Filter Data</div>
                            <div class="row">
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label text-primary small">Jenis Kelamin</label>
                                        <select id="jenisKelamin" name="jenisKelamin" class="form-control">
                                            <option value="" selected disabled>Pilih Jenis Kelamin</option>
                                            @foreach (\App\Enums\GenderEnum::cases() as $item)
                                                <option value="{{ $item->value }}">{{ $item->value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label text-primary small">&nbsp;</label>
                                        <button id="btn-reset" class="btn btn-primary btn-block">
                                            <i class="fas fa-undo"></i> Reset Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-md" id="ranking" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>JK</th>
                                            <th>Tgl Lahir</th>
                                            <th>Usia (Bulan)</th>
                                            <th>Alamat</th>
                                            <th>Status Gizi</th>
                                            <th>Nilai Perankingan</th>
                                            <th>Kategori Risiko</th>
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody class="show-data">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('customScript')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            var stuntingChart; // Store chart instance globally

            var table = $('#ranking').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('perankingan-risiko.index') }}",
                    "dataType": "json",
                    "type": "GET",
                    "data": function(d) {
                        d.jenisKelamin = $('#jenisKelamin').val();
                    }
                },
                "pageLength": 25,
                "columns": [
                    {
                        "data": "DT_RowIndex",
                        "orderable": false,
                        "searchable": false,
                        "name": "rank"
                    },
                    {
                        "data": "nama",
                        "orderable": true,
                    },
                    {
                        "data": "jenis_kelamin",
                        "orderable": true,
                    },
                    {
                        "data": "tanggal_lahir",
                        "orderable": true,
                    },
                    {
                        "data": "usia",
                        "orderable": true,
                    },
                    {
                        "data": "alamat",
                        "orderable": true,
                    },
                    {
                        "data": "status_gizi",
                        "orderable": true,
                    },
                    {
                        "data": "nilai_topsis",
                        "orderable": true,
                    },
                    {
                        "data": "kategori_risiko",
                        "orderable": true,
                        "render": function(data, type, row) {
                            return '<span class="badge ' + data.class + '">' + data.text + '</span>';
                        }
                    },
                ],
                "initComplete": function(settings, json) {
                    if (json.stuntingStats) {
                        createOrUpdateChart(json.stuntingStats);
                    }
                }
            });

            $('#jenisKelamin').change(function() {
                table.ajax.reload(function(json) {
                    // Update chart with filtered data after table reload
                    if (json.stuntingStats) {
                        createOrUpdateChart(json.stuntingStats);
                    }
                }, false);
            });

            // Reset filter button
            $('#btn-reset').click(function() {
                $('#jenisKelamin').val('').trigger('change');
                table.ajax.reload(function(json) {
                    // Update chart with reset data after table reload
                    if (json.stuntingStats) {
                        createOrUpdateChart(json.stuntingStats);
                    }
                }, false);
            });

            // Function to create or update chart
            function createOrUpdateChart(stuntingStats) {
                if (stuntingChart) {
                    // Update existing chart
                    stuntingChart.data.labels = stuntingStats.labels;
                    stuntingChart.data.datasets[0].data = stuntingStats.data;
                    stuntingChart.data.datasets[0].backgroundColor = stuntingStats.colors;
                    stuntingChart.update();
                } else {
                    // Create new chart
                    stuntingChart = new Chart(document.getElementById('stuntingChart'), {
                        type: 'bar',
                        data: {
                            labels: stuntingStats.labels,
                            datasets: [{
                                label: 'Jumlah Kasus',
                                data: stuntingStats.data,
                                backgroundColor: stuntingStats.colors,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 10
                                    }
                                }
                            },
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Distribusi Status Gizi Batita'
                                },
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });
                }
            }

            // Handle the recalculate button click
            $(document).on('submit', 'form[action="{{ route('perankingan-risiko.recalculate') }}"]', function(e) {
                e.preventDefault();

                var $form = $(this);
                var $button = $form.find('button[type="submit"]');

                // Show loading state
                // $button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menghitung...');

                // Send AJAX request
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        // Reload the DataTable to show fresh data
                        if ($.fn.DataTable.isDataTable('#ranking')) {
                            $('#ranking').DataTable().ajax.reload(function(json) {
                                // Update chart with new data after table reload
                                if (json.stuntingStats) {
                                    createOrUpdateChart(json.stuntingStats);
                                }
                            }, false);
                        }

                        // Show success message
                        var message = response.message || 'Data stunting berhasil dihitung ulang';
                        toastr.success(message);
                    },
                    error: function(xhr) {
                        var errorMsg = xhr.responseJSON && xhr.responseJSON.message
                            ? xhr.responseJSON.message
                            : 'Terjadi kesalahan saat menghitung ulang data';
                        toastr.error(errorMsg);
                    },
                    complete: function() {
                        // Always reset button state regardless of success or error
                        $button.prop('disabled', false).html('<i class="fas fa-sync-alt"></i> Hitung Ulang Data');
                    }
                });
            });
        });
    </script>
@endpush

@push('customStyle')
@endpush
