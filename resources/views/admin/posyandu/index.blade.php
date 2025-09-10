@extends('admin.layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Data Batita</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Posyandu</a></div>
                <div class="breadcrumb-item"><a href="#">Manajemen</a></span>
                </div>
                <div class="breadcrumb-item">Tabel</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Posyandu <span id="bulan-terakhir"></h2>
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
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Daftar Batita</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary" href="{{ route('posyandu.create') }}">Tambah
                                    Batita</a>
                                <a class="btn btn-primary btn-color-blue text-white" data-toggle="modal"
                                    data-target="#importModal">
                                    <i class="fa fa-download" aria-hidden="true"></i> Import Data
                                </a>
                                {{-- <a class="btn btn-primary btn-color-blue" href="{{ route('posyandu.export') }}">
                                    <i class="fa fa-upload" aria-hidden="true"></i> Export Data
                                </a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-md" id="posyandu" style="width: 100%;">
                                    <thead>
                                        <tr style="background-color: rgba(0, 0, 0, 0.02);">
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th class="text-nowrap">Tgl Lahir</th>
                                            <th>JK</th>
                                            <th>Alamat</th>
                                            <th>Usia</th>
                                            <th class="text-nowrap">Berat Badan</th>
                                            <th class="text-nowrap">Panjang Badan</th>
                                            <th>Keterangan</th>
                                            <th>Status</th>
                                            <th>Action</th>
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

    @include('admin.posyandu.riwayat')

    {{-- ANTRONOMETRI --}}
    <div id="detail-antronometri" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" style="height: 100vh; width: 100vw; transform: scale(1)">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex justify-content-between w-100 align-items-center">
                        <h5 class="modal-title"><span id="nama"></span></h5>
                        <span id="status-gizi" class="text-capitalize"></span>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col col-lg-7 col-sm-12">
                            <table>
                                <tr>
                                    <td>Usia</td>
                                    <td>:</td>
                                    <td><span id="usia"></span></td>
                                </tr>
                                <tr>
                                    <td>Berat Badan (kg)</td>
                                    <td>:</td>
                                    <td><span id="berat-badan"></span></td>
                                </tr>
                                <tr>
                                    <td>Panjang Badan (cm)</td>
                                    <td>:</td>
                                    <td><span id="tinggi-badan"></span></td>
                                </tr>
                                <tr>
                                    <td>Lingkar Lengan Atas (cm)</td>
                                    <td>:</td>
                                    <td><span id="lingkar-lengan-atas"></span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col col-lg-5 col-sm-12">
                            <table>
                                <tr>
                                    <td>Lingkar Lengan Bawah (cm)</td>
                                    <td>:</td>
                                    <td><span id="lingkar-lengan-bawah"></span></td>
                                </tr>
                                <tr>
                                    <td>Lingkar Dada (cm)</td>
                                    <td>:</td>
                                    <td><span id="lingkar-dada"></span></td>
                                </tr>
                                <tr>
                                    <td>Lingkar Perut (cm)</td>
                                    <td>:</td>
                                    <td><span id="lingkar-perut"></span></td>
                                </tr>
                                <tr>
                                    <td>Lingkar Kepala (cm)</td>
                                    <td>:</td>
                                    <td><span id="lingkar-kepala"></span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <canvas id="line-chart-berat-badan"></canvas>
                        </div>
                        <div class="col-lg-12 col-12">
                            <canvas id="line-chart-tinggi-badan"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Import --}}
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('posyandu.import') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="bulan_posyandu">Posyandu Bulan</label>
                            <input id="bulan_posyandu" name="bulan_posyandu" type="month" spellcheck="false"
                                autocomplete="off" class="form-control @error('bulan_posyandu') is-invalid @enderror"
                                value="{{ old('bulan_posyandu') }}" required>
                            @error('bulan_posyandu')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="file" name="file" class="form-control" accept=".xls,.xlsx,.csv" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    @endsection
    @push('customScript')
        <script>
            $(document).ready(function() {
                $('#posyandu').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ route('posyandu.index') }}",
                        "dataType": "json",
                        "type": "GET",
                        "data": {
                            _token: "{{ csrf_token() }}"
                        }
                    },
                    "pageLength": 25,
                    "columns": [{
                            "data": "id",
                            "orderable": true,
                            "render": function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            "data": "nama",
                            "orderable": true,
                        },
                        {
                            "data": "tanggal_lahir",
                            "orderable": true,
                        },
                        {
                            "data": "jenis_kelamin",
                            "orderable": true,
                        },
                        {
                            "data": "alamat",
                            "orderable": true,
                        },
                        {
                            "data": "usia_str",
                            "orderable": true,
                        },
                        {
                            "data": "berat_badan_str",
                            "orderable": true,
                        },
                        {
                            "data": "tinggi_badan_str",
                            "orderable": true,
                        },
                        {
                            "data": "keterangan",
                            "orderable": false,
                        },
                        {
                            "data": "status_vaksin",
                            "orderable": true,
                        },
                        {
                            "data": "action",
                            "orderable": false,
                            "searchable": false
                        }
                    ],
                    "columnDefs": [
                        { "targets": 2, "className": "text-nowrap" }, // tglLahir
                        { "targets": 5, "className": "text-nowrap" }, // Usia
                        {
                            "targets": 9,
                            "orderable": true,
                            "searchable": false,
                            "render": function(data, type, row, meta) {
                                return data;
                            }
                        }
                    ],
                    "initComplete": function(settings, json) {
                        if (json.bulan_terakhir) {
                            $('.section-title #bulan-terakhir').text(json.bulan_terakhir);
                        }
                    }
                });
            });

            $(document).on("click", ".open-antronometri", function() {
                const nama = $(this).data('nama');
                const usia = $(this).data('usia');
                const berat_badan = $(this).data('berat-badan');
                const tinggi_badan = $(this).data('tinggi-badan');
                const lingkar_lengan_atas = $(this).data('lingkar-lengan-atas');
                const lingkar_lengan_bawah = $(this).data('lingkar-lengan-bawah');
                const lingkar_dada = $(this).data('lingkar-dada');
                const lingkar_perut = $(this).data('lingkar-perut');
                const lingkar_kepala = $(this).data('lingkar-kepala');

                $(".modal-content #nama").text(nama);
                $(".modal-content #usia").text(usia ? (usia + ' bulan') : '-');
                $(".modal-content #berat-badan").text(berat_badan ? berat_badan.toString().padStart(3, '0') : '-');
                $(".modal-content #tinggi-badan").text(tinggi_badan ? tinggi_badan.toString().padStart(3, '0') : '-');
                $(".modal-content #lingkar-lengan-atas").text(lingkar_lengan_atas ? lingkar_lengan_atas : '-');
                $(".modal-content #lingkar-lengan-bawah").text(lingkar_lengan_bawah ? lingkar_lengan_bawah : '-');
                $(".modal-content #lingkar-dada").text(lingkar_dada ? lingkar_dada : '-');
                $(".modal-content #lingkar-perut").text(lingkar_perut ? lingkar_perut : '-');
                $(".modal-content #lingkar-kepala").text(lingkar_kepala ? lingkar_kepala : '-');

                const id_posyandu = $(this).attr("data-value");

                $.ajax({
                    url: '{{ route('posyandu.detail') }}',
                    method: 'POST',
                    data: {
                        id_posyandu: id_posyandu
                    },
                    success: function(response) {
                        $(".modal-content #status-gizi").text(response.status_gizi ? response.status_gizi :
                            '-');
                        $(".modal-content #status-gizi").addClass('badge badge-' + getBadgeStatusGizi(
                            response.status_gizi));

                        renderLineChart({
                            datas: response.data_berat_badan,
                            canvasId: 'line-chart-berat-badan',
                            label: 'Berat Badan (kg)',
                            borderColor: '#36b9cc',
                            bgColor: 'rgba(54, 185, 204, 0.2)',
                            title: 'Perkembangan Berat Badan'
                        });

                        renderLineChart({
                            datas: response.data_tinggi_badan,
                            canvasId: 'line-chart-tinggi-badan',
                            label: 'Panjang Badan (cm)',
                            borderColor: '#f6c23e',
                            bgColor: 'rgba(246, 194, 62, 0.2)',
                            title: 'Perkembangan Panjang Badan'
                        });

                        console.log(response)
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                })

            });

            function renderLineChart({
                datas,
                canvasId,
                label,
                borderColor = '#4e73df',
                bgColor = 'rgba(78, 115, 223, 0.2)',
                title = 'Perkembangan'
            }) {
                const sortedData = datas.sort((a, b) => {
                    const keyA = parseInt(Object.keys(a)[0]);
                    const keyB = parseInt(Object.keys(b)[0]);
                    return keyA - keyB;
                });

                const labels = sortedData.map(obj => `Bulan ke-${Object.keys(obj)[0]}`);
                const data = sortedData.map(obj => Object.values(obj)[0]);

                const chartData = {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: data,
                        fill: true,
                        borderColor: borderColor,
                        backgroundColor: bgColor,
                        pointBackgroundColor: borderColor,
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: borderColor,
                        tension: 0.4
                    }]
                };

                const ctx = document.getElementById(canvasId)?.getContext('2d');
                if (!ctx) {
                    console.error(`Canvas dengan id "${canvasId}" tidak ditemukan.`);
                    return;
                }

                window[canvasId] = new Chart(ctx, {
                    type: 'line',
                    data: chartData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                labels: {
                                    color: '#333',
                                    font: {
                                        size: 10
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: title,
                                color: '#111',
                                font: {
                                    size: 16
                                }
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                            }
                        },
                        interaction: {
                            mode: 'nearest',
                            axis: 'x',
                            intersect: false
                        },
                        scales: {
                            x: {
                                ticks: {
                                    color: '#555'
                                },
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                ticks: {
                                    color: '#555',
                                    stepSize: 1
                                },
                                grid: {
                                    color: 'rgba(200,200,200,0.1)'
                                }
                            }
                        }
                    }
                });
            }


            function getBadgeStatusGizi(kategori) {
                if (kategori === "Gizi baik/normal") {
                    return 'success';
                } else if (kategori === "Gizi buruk/stunting") {
                    return 'danger';
                } else {
                    return 'warning';
                }
            }

            $(document).ready(function(){
                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
            });
        </script>
    @endpush

    @push('customStyle')
    @endpush
