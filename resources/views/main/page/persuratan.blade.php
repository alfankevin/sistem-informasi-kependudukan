@extends('main.layouts.main')

@section('content')
    <section class="p-3">
        <form action="{{ route('persuratan.generatePDF') }}" method="post">
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="nama">Nama</label>
                <input type="text" class="form-control" name="nama">
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="jenis_kelamin">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                    <option value="P">Perempuan</option>
                    <option value="L">Laki-laki</option>
                </select>
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="tempat">Tempat</label>
                <input type="text" class="form-control" name="tempat_lahir">
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="tanggal">Tanggal Lahir</label>
                <input type="date" class="form-control" name="tanggal_lahir">
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="agama">Agama</label>
                <select name="agama" id="agama" class="form-select">
                    <option value="" disabled selected>Pilih Agama</option>
                    <option value="Islam">Islam</option>
                    <option value="Protestan">Kristen Protestan</option>
                    <option value="Katolik">Katolik</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Budha">Budha</option>
                    <option value="Konghucu">Konghucu</option>
                    <option value="Kepercayaan Kepada Tuhan YME">Kepercayaan Kepada Tuhan YME</option>
                </select>
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="status_perkawinan">Status Perkawinan</label>
                <select name="status_perkawinan" id="status_perkawinan" class="form-select">
                    <option value="" disabled selected>Pilih Status Perkawinan</option>
                    <option value="Kawin">Kawin</option>
                    <option value="Belum Kawin">Belum Kawin</option>
                    <option value="Cerai Mati">Cerai Mati</option>
                    <option value="Cerai Hidup">Cerai Hidup</option>
                </select>
            </div>
            {{-- <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="no_nik">No NIK</label>
                <input type="text" class="form-control" name="no_nik">
            </div> --}}
            <div id="nik-input" class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="nik-digit">No NIK</label>
                @for ($i = 0; $i < 16; $i++)
                    <input type="number" step="1" min="0" max="9" maxlength="1" class="nik-digit" />
                @endfor
                <input type="hidden" name="nik" id="nik-hidden" />
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="no_kk">No KK</label>
                <input type="text" class="form-control" name="no_kk">
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="pekerjaan">Pekerjaan</label>
                <input type="text" class="form-control" name="pekerjaan">
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="pendidikan">Pendidikan</label>
                <select name="pendidikan" id="pendidikan" required
                    class="form-select select2 @error('pendidikan') is-invalid @enderror">
                    <option value="" disabled selected>Pilih Pendidikan</option>
                    <option value="SD">SD</option>
                    <option value="SMP">SMP</option>
                    <option value="SMA">SMA</option>
                    <option value="Akademi">Akademi</option>
                    <option value="Perguruan Tinggi">Peguruan Tinggi</option>
                </select>
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="Alamat">Alamat</label>
                <input type="text" class="form-control" name="alamat">
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="jenis_surat">Jenis Surat</label>
                <select name="jenis_surat" id="jenis_surat" class="form-select">
                    <option value="" disabled selected>Pilih Jenis Surat</option>
                    <option value="spaw">Surat Pengantar Ahli Waris</option>
                    <option value="spdu">Surat Pengantar Dokumen Usaha</option>
                    <option value="sktm">Surat Keterangan Tidak Mampu</option>
                    <option value="spkdpolsek">Surat Kehilangan Dokumen</option>
                    <option value="sa">Surat Pengantar Keramaian/Acara</option>
                    <option value="sktp">Surat Pengantar KTP</option>
                    <option value="skk">Surat Pengantar Kartu Keluarga</option>
                    <option value="sktp">Surat Pengantar Akta Kematian</option>
                    <option value="skk">Surat Keterangan Boro Kerja</option>
                </select>
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="Keperluan">Keperluan</label>
                <textarea name="keperluan" class="form-control" id="" rows="2"></textarea>
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="Pengikut">Pengikut (khusus pindah)</label>
                <input type="text" class="form-control" name="pengikut">
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const nikDigits = document.querySelectorAll('#nik-input input.nik-digit');
            const nikHidden = document.getElementById("nik-hidden");

            nikDigits.forEach((e, idx) => {
                e.addEventListener("input", function() {
                    if (e.value.length === 1 && idx + 1 < nikDigits.length) {
                        nikDigits[idx + 1].focus();
                    }

                    updateNikHidden();
                    if (areAllInputsFilled()) {
                        $.ajax({
                            url: '/pelayanan/findNik',
                            method: 'POST',
                            data: {
                                data: nikHidden.value
                            },
                            success: function(response) {
                                console.log(response);
                                $('input[name="nama"]').val(response.data.nama);
                                $('select[name="jenis_kelamin"]').val(response.data
                                    .jenis_kelamin);
                                $('input[name="tempat_lahir"]').val(response.data
                                    .tempat_lahir);
                                $('input[name="tanggal_lahir"]').val(response.data
                                    .tanggal_lahir);
                                $('select[name="agama"]').val(response.data.agama);
                                $('select[name="status_perkawinan"]').val(response.data
                                    .status_perkawinan);
                                $('input[name="no_kk"]').val(response.data.no_kk);
                                $('input[name="pekerjaan"]').val(response.data
                                    .pekerjaan);
                                $('input[name="alamat"]').val(response.data.alamat);
                            }
                        });
                    };

                });

                e.addEventListener("keydown", (e) => {
                    if (e.key === "Backspace" && e.target.value === "" && idx > 0) {
                        nikDigits[idx - 1].focus();
                    }
                });

                e.addEventListener("paste", function(event) {
                    const pastedData = event.clipboardData.getData('text').replace(/\D/g,
                        ''); // Hanya angka
                    const chars = pastedData.split('');

                    chars.forEach((char, i) => {
                        if (idx + i < nikDigits.length) {
                            nikDigits[idx + i].value = char;
                        }
                    });

                    updateNikHidden();

                    const nextIndex = idx + chars.length < nikDigits.length ? idx + chars.length :
                        nikDigits.length - 1;
                    nikDigits[nextIndex].focus();

                    event.preventDefault();

                    const eventInput = new Event('input', {
                        bubbles: true
                    });
                    nikDigits.forEach(input => input.dispatchEvent(eventInput));
                });
            });

            function updateNikHidden() {
                nikHidden.value = Array.from(nikDigits).map(input => input.value).join('');
            }

            function areAllInputsFilled() {
                return Array.from(nikDigits).every(input => /^[0-9]$/.test(input.value));
            }
        })
    </script>
@endsection
