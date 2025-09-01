<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Template</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        {{ file_get_contents('assets/css/bootstrap.min.css') }} .header .logo img {
            max-height: 90px;
            /* Sesuaikan ukuran gambar */
        }

        body {
            text-align: justify;
        }

        table {
            width: 100%;
        }

        .header table {
            border-bottom: 4px double black;
        }

        table .kode-pos {
            text-align: right;
            font-size: 9pt
        }

        .content .title p:first-child {
            border-bottom: 1px solid black;
            letter-spacing: 2px;
            width: 40%;
        }

        .content p.opening,
        .footer p {
            text-indent: 40px;
        }

        .content table.data .kolom-name {
            width: 30%;
        }

        .content table.data .kolom-data {
            width: 70%;
        }

        .content table.data td {
            vertical-align: top;
        }

        .ttd {
            border-collapse: separate;
            border-spacing: 0 15px;
        }

        .footer table.ttd tr td {
            width: 33.3333%
        }

        .footer table.ttd tr.ttd-nama td {
            vertical-align: bottom;
            height: 20%;
        }

        /*
        .footer table.ttd tr.ttd-nama td:last-child {
            border-bottom: solid 1px black;
        } */
    </style>
</head>

<body class="text-justify">
    {{-- Halaman 1: Surat Utama  --}}
    <div class="" style="">
        <div class="header d-flex justify-content-between">
            <table class="mx-auto">
                <tr>
                    <td style="padding-left: 1.5rem">
                        <div class="logo">
                            <img src="{{ public_path('/assets/img/malang.png') }}" alt="logo" class="img-fluid">
                        </div>
                    </td>
                    <td>
                        <div class="text-center">
                            <p class="text-uppercase h5">rukun tetangga {{ $dataPenduduk['rt'] }} rukun warga
                                {{ $dataPenduduk['rw'] }}</p>
                            <p class="text-uppercase h5">kelurahan tanjungrejo kecamatan sukun</p>
                            <p class="text-uppercase h5">kota malang</p>
                        </div>
                    </td>
                </tr>
                <tr class="kode-pos">
                    <td class="text-uppercase" colspan="2">
                        <p class="fw-bold">kode pos: 65147</p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="content mb-4">
            <div class="title text-center">
                <p class="text-uppercase h5 mt-3 mx-auto">surat pengantar</p>
                <p>Nomor: {{ str_pad($nomor_urut + 1, 2, '0', STR_PAD_LEFT) }}/SP/RT.{{ $dataPenduduk['rt'] }}
                    RW.{{ $dataPenduduk['rw'] }}/{{ $date->format('d') }}{{ $date->format('m') }}/{{ $date->format('Y') }}
                </p>
            </div>

            <p class="opening">Yang bertanda tangan di bawah ini, kami Ketua RT. {{ $dataPenduduk['rt'] }} - RW.
                {{ $dataPenduduk['rw'] }} Kelurahan Tanjungrejo,
                Kecamatan Sukun, Kota
                Malang, menerangkan bahwa:</p>

            <table class="data">
                <tr>
                    <td class="kolom-name">Nama</td>
                    <td class="kolom-equals">:</td>
                    <td class="kolom-data">{{ $dataPenduduk['nama'] }}</td>
                </tr>
                <tr>
                    <td class="kolom-name">Jenis Kelamin</td>
                    <td class="kolom-equals">:</td>
                    <td class="kolom-data">{{ $dataPenduduk['jenis_kelamin'] == 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
                </tr>
                <tr>
                    <td class="kolom-name">Tempat / Tgl Lahir</td>
                    <td class="kolom-equals">:</td>
                    <td class="kolom-data">{{ $dataPenduduk['tempat_lahir'] }}, {{ $dataPenduduk['tanggal_lahir'] }}
                    </td>
                </tr>
                <tr>
                    <td class="kolom-name">Agama</td>
                    <td class="kolom-equals">:</td>
                    <td class="kolom-data">
                        <span
                            class="{{ $dataPenduduk['agama'] === 'Islam' ? '' : 'text-decoration-line-through' }}">Islam</span>
                        /
                        <span
                            class="{{ $dataPenduduk['agama'] === 'Kristen' || $dataPenduduk['agama'] === 'Protestan' ? '' : 'text-decoration-line-through' }}">Kristen</span>
                        /
                        <span
                            class="{{ $dataPenduduk['agama'] === 'Katholik' ? '' : 'text-decoration-line-through' }}">Katholik</span>
                        /
                        <span
                            class="{{ $dataPenduduk['agama'] === 'Hindu' ? '' : 'text-decoration-line-through' }}">Hindu</span>
                        /
                        <span
                            class="{{ $dataPenduduk['agama'] === 'Budha' ? '' : 'text-decoration-line-through' }}">Budha</span>
                        /
                        <span
                            class="{{ $dataPenduduk['agama'] === 'Konghucu' ? '' : 'text-decoration-line-through' }}">Konghucu</span>
                        /
                        <span
                            class="{{ $dataPenduduk['agama'] === 'Kepercayaan Kepada Tuhan Yang Maha Esa' ? '' : 'text-decoration-line-through' }}">Kepercayaan
                            Kepada Tuhan Yang Maha Esa</span>
                    </td>
                </tr>
                <tr>
                    <td class="kolom-name">Status Perkawinan</td>
                    <td class="kolom-equals">:</td>
                    <td class="kolom-data">
                        <span
                            class="{{ $dataPenduduk['status_perkawinan'] === 'Kawin' ? '' : 'text-decoration-line-through' }}">Kawin</span>
                        /
                        <span
                            class="{{ $dataPenduduk['status_perkawinan'] === 'Belum Kawin' ? '' : 'text-decoration-line-through' }}">Belum
                            Kawin</span> /
                        <span
                            class="{{ $dataPenduduk['status_perkawinan'] === 'Cerai Mati' ? '' : 'text-decoration-line-through' }}">Cerai
                            Mati</span> /
                        <span
                            class="{{ $dataPenduduk['status_perkawinan'] === 'Cerai Hidup' ? '' : 'text-decoration-line-through' }}">Cerai
                            Hidup</span>
                    </td>
                </tr>
                <tr>
                    <td class="kolom-name">No. NIK</td>
                    <td class="kolom-equals">:</td>
                    <td class="kolom-data">{{ $dataPenduduk['nik'] }}</td>
                </tr>
                <tr>
                    <td class="kolom-name">No. KK</td>
                    <td class="kolom-equals">:</td>
                    <td class="kolom-data">{{ $dataPenduduk['no_kk'] }}</td>
                </tr>
                <tr>
                    <td class="kolom-name">Pekerjaan</td>
                    <td class="kolom-equals">:</td>
                    <td class="kolom-data">{{ $dataPenduduk['pekerjaan'] }}</td>
                </tr>
                <tr>
                    <td class="kolom-name">Pendidikan</td>
                    <td class="kolom-equals">:</td>
                    <td class="kolom-data">
                        <span
                            class="{{ $dataPenduduk['pendidikan'] === 'SD' ? '' : 'text-decoration-line-through' }}">SD</span>
                        /
                        <span
                            class="{{ $dataPenduduk['pendidikan'] === 'SMP' ? '' : 'text-decoration-line-through' }}">SMP</span>
                        /
                        <span
                            class="{{ $dataPenduduk['pendidikan'] === 'SMA' ? '' : 'text-decoration-line-through' }}">SMA</span>
                        /
                        <span
                            class="{{ $dataPenduduk['pendidikan'] === 'Akademi' ? '' : 'text-decoration-line-through' }}">Akademi</span>
                        /
                        <span
                            class="{{ $dataPenduduk['pendidikan'] === 'Perguruan Tinggi' ? '' : 'text-decoration-line-through' }}">Perguruan
                            Tinggi</span>
                    </td>
                </tr>
                <tr>
                    <td class="kolom-name">Alamat Rumah</td>
                    <td class="kolom-equals">:</td>
                    <td class="kolom-data">{{ $dataPenduduk['alamat'] }}</td>
                </tr>
                <tr>
                    <td class="kolom-name">Keperluan</td>
                    <td class="kolom-equals">:</td>
                    <td class="kolom-data">
                        @switch($dataPenduduk['jenis_surat'])
                            @case('sktm')
                                Surat Keterangan Tidak Mampu
                            @break

                            @case('sku')
                                Surat Keterangan Usaha
                            @break

                            @case('skd')
                                Surat Keterangan Domisili
                            @break

                            @case('skck')
                                Surat Keterangan Catatan Kepolisian (pengantar RT/RW ke Polsek)
                            @break

                            @case('ska')
                                Surat Izin Acara/Keramaian
                            @break

                            @case('sktp')
                                Surat Pengantar KTP
                            @break

                            @case('spkk')
                                Surat Pengantar Kartu Keluarga
                            @break

                            @case('skk')
                                Surat Keterangan Kematian
                            @break

                            @case('spaw')
                                Surat Pengantar Ahli Waris
                            @break

                            @case('skp')
                                Surat Keterangan Pindah
                            @break

                            @case('skbk')
                                Surat Keterangan Boro Kerja
                            @break

                            @default
                                -
                        @endswitch
                    </td>
                </tr>
                <tr>
                    <td class="kolom-name">Deskripsi Keperluan</td>
                    <td class="kolom-equals">:</td>
                    <td class="kolom-data">{{ $dataPenduduk['keperluan'] === null ? '-' : $dataPenduduk['keperluan'] }}
                    </td>
                </tr>
                <tr>
                    <td class="kolom-name">
                        Pengikut <br>
                        (Khusus Pindah)
                    </td>
                    <td class="kolom-equals">:</td>
                    <td class="kolom-data">{{ $dataPenduduk['pengikut'] === null ? '-' : $dataPenduduk['pengikut'] }}
                    </td>
                </tr>
            </table>
        </div>
        <div class="ket">
            <p class="mb-1">Keterangan:</p>
            <p>Bahwa orang tersebut adalah benar-benar penduduk RT. {{ $dataPenduduk['rt'] }} RW.
                {{ $dataPenduduk['rw'] }} Kelurahan Tanjungrejo, Kecamatan Sukun, Kota
                Malang dan sepanjang pengetahuan kami selama ini orang tersebut berkelakuan baik dan belum pernah
                tersangkut
                perkara hukum atau kriminal.
            </p>
        </div>
        <div class="footer">
            <p>Demikian Surat Pengantar ini dibuat dipergunakan sebagaimana semestinya.</p>
            <table class="ttd mt-4">
                <tr>
                    <td colspan="2" class="pb-1">No.
                        {{ str_pad($nomor_urut + 1, 2, '0', STR_PAD_LEFT) }}/SP/{{ $date->format('m') }}/{{ $date->format('Y') }}
                    </td>
                    <td class="text-end pb-1">Malang, {{ $date->locale('id')->isoFormat('D MMMM Y') }}</td>
                </tr>
                <tr class="text-center">
                    <td>
                        Ketua RW. {{ $dataPenduduk['rw'] }} <br>
                        Kelurahan Tanjungrejo
                    </td>
                    <td>
                        @if ($ketua_rt !== null)
                            Ketua RT. {{ $dataPenduduk['rt'] }}
                        @endif
                    </td>
                    <td>Pemohon</td>
                </tr>
                <tr class="text-center ttd-nama">
                    <td class="fw-bold text-uppercase text-decoration-underline">{{ $ketua_rw->penduduk->nama }}</td>
                    <td class="fw-bold text-uppercase text-decoration-underline">
                        @if ($ketua_rt !== null)
                            {{ $ketua_rt->penduduk->nama }}
                        @endif
                    </td>
                    <td class="fw-bold text-uppercase text-decoration-underline">
                        <img src="{{ $signature }}" alt="Tanda Tangan" width="100%"
                            style="display: block; margin: -10px auto 0;">
                        {{ $dataPenduduk['nama'] }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
