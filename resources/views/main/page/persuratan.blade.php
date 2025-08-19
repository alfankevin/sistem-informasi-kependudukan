@extends('main.layouts.main')

@section('content')
    <section class="p-3">
        <form action="{{ route('persuratan.generatePDF') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="nama">Nama <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="nama" value="{{ old('nama') }}" required>
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="jenis_kelamin">Jenis Kelamin <span
                        class="text-danger">*</span></label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                </select>
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="tempat">Tempat <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required>
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="tanggal">Tanggal Lahir <span
                        class="text-danger">*</span></label>
                <input type="date" class="form-control" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="agama">Agama <span class="text-danger">*</span></label>
                <select name="agama" id="agama" class="form-select" required>
                    <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                    <option value="Protestan" {{ old('agama') == 'Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                    <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                    <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                    <option value="Budha" {{ old('agama') == 'Budha' ? 'selected' : '' }}>Budha</option>
                    <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    <option value="Kepercayaan Kepada Tuhan YME"
                        {{ old('agama') == 'Kepercayaan Kepada Tuhan YME' ? 'selected' : '' }}>Kepercayaan Kepada Tuhan YME
                    </option>
                </select>
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="status_perkawinan">Status Perkawinan <span
                        class="text-danger">*</span></label>
                <select name="status_perkawinan" id="status_perkawinan" class="form-select" required>
                    <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                    <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum
                        Kawin</option>
                    <option value="Cerai Mati" {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati
                    </option>
                    <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai
                        Hidup</option>
                </select>
            </div>
            <div id="nik-input" class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="nik-digit">No NIK <span class="text-danger">*</span></label>
                @for ($i = 0; $i < 16; $i++)
                    <input type="number" step="1" min="0" max="9" maxlength="1" class="nik-digit"
                        value="{{ old('nik')[$i] ?? '' }}" required />
                @endfor
                <input type="hidden" name="nik" id="nik-hidden" value="{{ old('nik') }}" />
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="no_kk">No KK <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="no_kk" value="{{ old('no_kk') }}" required>
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="pekerjaan">Pekerjaan <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="pekerjaan" value="{{ old('pekerjaan') }}" required>
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="pendidikan">Pendidikan <span class="text-danger">*</span></label>
                <select name="pendidikan" id="pendidikan" required
                    class="form-select select2 @error('pendidikan') is-invalid @enderror">
                    <option value="SD" {{ old('pendidikan') == 'SD' ? 'selected' : '' }}>SD</option>
                    <option value="SMP" {{ old('pendidikan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                    <option value="SMA" {{ old('pendidikan') == 'SMA' ? 'selected' : '' }}>SMA</option>
                    <option value="Akademi" {{ old('pendidikan') == 'Akademi' ? 'selected' : '' }}>Akademi</option>
                    <option value="Perguruan Tinggi" {{ old('pendidikan') == 'Perguruan Tinggi' ? 'selected' : '' }}>
                        Perguruan Tinggi</option>
                </select>
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="Alamat">Alamat <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="alamat" value="{{ old('alamat') }}" required>
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="rt">RT/RW <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="rt" value="{{ old('rt') }}" required>
                <span class="mx-2">/</span>
                <input type="text" class="form-control" name="rw" value="{{ old('rw') }}" required>
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="jenis_surat">Jenis Surat <span
                        class="text-danger">*</span></label>
                <select name="jenis_surat" id="jenis_surat" class="form-select" required>
                    <option value="spaw" {{ old('jenis_surat') == 'spaw' ? 'selected' : '' }}>Surat Pengantar Ahli Waris
                    </option>
                    <option value="spdu" {{ old('jenis_surat') == 'spdu' ? 'selected' : '' }}>Surat Pengantar Dokumen
                        Usaha</option>
                    <option value="sktm" {{ old('jenis_surat') == 'sktm' ? 'selected' : '' }}>Surat Keterangan Tidak
                        Mampu</option>
                    <option value="spkdpolsek" {{ old('jenis_surat') == 'spkdpolsek' ? 'selected' : '' }}>Surat Kehilangan
                        Dokumen</option>
                    <option value="sa" {{ old('jenis_surat') == 'sa' ? 'selected' : '' }}>Surat Pengantar
                        Keramaian/Acara</option>
                    <option value="sktp" {{ old('jenis_surat') == 'sktp' ? 'selected' : '' }}>Surat Pengantar KTP
                    </option>
                    <option value="spkk" {{ old('jenis_surat') == 'spkk' ? 'selected' : '' }}>Surat Pengantar Kartu
                        Keluarga</option>
                    <option value="sktp" {{ old('jenis_surat') == 'sktp' ? 'selected' : '' }}>Surat Pengantar Akta
                        Kematian</option>
                    <option value="skbk" {{ old('jenis_surat') == 'skbk' ? 'selected' : '' }}>Surat Keterangan Boro
                        Kerja
                    </option>
                </select>
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="Keperluan">Keperluan </label>
                <input type="text" class="form-control" name="keperluan" value="{{ old('keperluan') }}">
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="Pengikut">Pengikut (khusus pindah)</label>
                <input type="text" class="form-control" name="pengikut">
            </div>

            <div class="input-group mb-3">
                <label for="signature" class="input-group-text col-2">Tanda Tangan Digital <span
                        class="text-danger">*</span></label>
                <canvas id="signature-pad" class="form-control"></canvas>
                <input type="hidden" name="signature" id="signature-data" required>
                <button type="button" id="clear-signature" class="btn btn-outline-danger">Clear Signature</button>
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="ktp">Upload KTP</label>
                <input type="file" name="ktp" id="ktp" class="form-control"
                    accept="image/*,application/pdf" required>
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="kk">Upload KK</label>
                <input type="file" name="kk" id="kk" class="form-control"
                    accept="image/*,application/pdf" required>
            </div>
            <div class="input-group input-group-md mb-3">
                <label class="input-group-text col-2" for="attachment_file">Attachment File</label>
                <input type="file" name="attachment_file" id="attachment_file" class="form-control"
                    accept="image/*,application/pdf">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const nikDigits = document.querySelectorAll('#nik-input input.nik-digit');
            const nikHidden = document.getElementById("nik-hidden");

            nikDigits.forEach((input, idx) => {
                input.addEventListener("input", function() {
                    // Move focus to the next input if current one is filled
                    if (input.value.length === 1 && idx + 1 < nikDigits.length) {
                        nikDigits[idx + 1].focus();
                    }

                    updateNikHidden();

                    if (areAllInputsFilled()) {
                        fetchNikData(nikHidden.value);
                    }
                });

                input.addEventListener("keydown", function(e) {
                    // Move focus to previous input if backspace is pressed and the current input is empty
                    if (e.key === "Backspace" && input.value === "" && idx > 0) {
                        nikDigits[idx - 1].focus();
                    }
                });

                input.addEventListener("paste", function(event) {
                    handlePaste(event, idx);
                });
            });

            // Update the hidden field with concatenated NIK
            function updateNikHidden() {
                nikHidden.value = Array.from(nikDigits).map(input => input.value).join('');
            }

            // Check if all input fields are filled
            function areAllInputsFilled() {
                return Array.from(nikDigits).every(input => /^[0-9]$/.test(input.value));
            }

            // Fetch data using AJAX based on the NIK
            function fetchNikData(nik) {
                $.ajax({
                    url: '/pelayanan/findNik',
                    method: 'POST',
                    data: {
                        data: nik
                    },
                    success: function(response) {
                        if (response.data) {
                            populateFormData(response.data);
                        } else {
                            console.error("No data found for the given NIK");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(`Error fetching NIK data: ${status} - ${error}`);
                    }
                });
            }

            // Populate form fields with data from AJAX response
            function populateFormData(data) {
                $('input[name="nama"]').val(data.nama);
                $('select[name="jenis_kelamin"]').val(data.jenis_kelamin);
                $('input[name="tempat_lahir"]').val(data.tempat_lahir);
                $('input[name="tanggal_lahir"]').val(data.tanggal_lahir);
                $('select[name="agama"]').val(data.agama);
                $('select[name="status_perkawinan"]').val(data.status_perkawinan);
                $('input[name="no_kk"]').val(data.no_kk);
                $('input[name="pekerjaan"]').val(data.pekerjaan);
                $('input[name="alamat"]').val(data.alamat);
                $('input[name="rt"]').val(data.rt);
                $('input[name="rw"]').val(data.rw);
            }

            // Handle paste event (pasting only digits into the NIK input fields)
            function handlePaste(event, idx) {
                const pastedData = event.clipboardData.getData('text').replace(/\D/g, ''); // Only digits
                const chars = pastedData.split('');

                chars.forEach((char, i) => {
                    if (idx + i < nikDigits.length) {
                        nikDigits[idx + i].value = char;
                    }
                });

                updateNikHidden();

                const nextIndex = idx + chars.length < nikDigits.length ? idx + chars.length : nikDigits.length - 1;
                nikDigits[nextIndex].focus();

                event.preventDefault();
                dispatchInputEvent();
            }

            // Dispatch input event after paste to trigger form updates
            function dispatchInputEvent() {
                const eventInput = new Event('input', {
                    bubbles: true
                });
                nikDigits.forEach(input => input.dispatchEvent(eventInput));
            }

            // Canvas signature logic
            const canvas = document.getElementById('signature-pad');
            const ctx = canvas.getContext('2d');
            let isDrawing = false;

            function resizeCanvas() {
                canvas.width = canvas.offsetWidth;
                canvas.height = 120;
                ctx.fillStyle = "#ffffff";
                ctx.fillRect(0, 0, canvas.width, canvas.height);
            }

            resizeCanvas();
            window.addEventListener("resize", resizeCanvas);

            canvas.addEventListener('mousedown', function(e) {
                isDrawing = true;
                ctx.beginPath();
                ctx.moveTo(e.offsetX, e.offsetY);
            });

            canvas.addEventListener('mousemove', function(e) {
                if (isDrawing) {
                    ctx.lineTo(e.offsetX, e.offsetY);
                    ctx.stroke();
                }
            });

            canvas.addEventListener('mouseup', function() {
                isDrawing = false;
            });

            $('#clear-signature').on("click", function() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
            });

            // Handle form submission to include signature data
            $("form").on("submit", function() {
                const signatureInput = document.getElementById("signature-data");
                signatureInput.value = canvas.toDataURL("image/png");
            });
        });
    </script>
@endsection
