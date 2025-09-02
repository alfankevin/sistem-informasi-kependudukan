@extends('main.layouts.main')

@section('content')
    <section id="pengajuan-surat" class="p-5 bg">
        <h2 class="text-center mb-3 blue-title fw-bold">Form Pengajuan Surat</h2>
        <div class="d-flex justify-content-center">
            <div class="row w-75 ">
                <div class="stepper col-md-12 w-100">
                    <ul class="nav nav-pills mb-4">
                        <li class="nav-item"><a class="nav-link active bg-transparent d-flex gap-3 align-items-center"
                                data-bs-toggle="pill" href="#step1">
                                <span class="d-flex align-items-center justify-content-center rounded-circle step-number">
                                    1
                                </span>
                                <span class="step-desc">
                                    Lengkapi Data Diri
                                </span>
                            </a>
                        </li>
                        <li class="nav-item"><a class="nav-link bg-transparent d-flex gap-3 align-items-center"
                                data-bs-toggle="pill" href="#step2">
                                <span class="d-flex align-items-center justify-content-center rounded-circle step-number">
                                    2
                                </span>
                                <span class="step-desc">
                                    Data Domisili & Surat
                                </span>
                            </a>
                        </li>
                        <li class="nav-item"><a class="nav-link bg-transparent d-flex gap-3 align-items-center"
                                data-bs-toggle="pill" href="#step3">
                                <span class="d-flex align-items-center justify-content-center rounded-circle step-number">
                                    3
                                </span>
                                <span class="step-desc">
                                    Dokumen & Tanda Tangan
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card w-100 p-4 rounded-4 shadow border-0">
            <div class="card-body">
                <p class="text-muted"><span class="text-danger">*</span> wajib diisi / required</p>

                <form action="{{ route('pelayanan.pengajuan_surat.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="step-container" id="step-1">
                        <!-- NIK -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-12 col-form-label">NIK <span class="text-danger">*</span></label>
                            <div class="col-md-10 col-12 ">
                                <input type="text" name="nik" id="nik" class="form-control"
                                    placeholder="Masukkan 16 digit NIK sesuai KTP" value="{{ old('nik') }}" required>
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- No KK -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-12 col-form-label">No KK <span class="text-danger">*</span></label>
                            <div class="col-md-10 col-12">
                                <input type="text" class="form-control" name="no_kk" value="{{ old('no_kk') }}"
                                    placeholder="Masukkan 16 digit No KK sesuai Kartu Keluarga" required>
                                @error('no_kk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Nama -->
                        <div class="row mb-3">
                            <label for="nama" class="col-md-2 col-12 col-form-label">Nama <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10 col-12">
                                <input type="text" class="form-control" name="nama" value="{{ old('nama') }}"
                                    placeholder="Masukkan Nama Lengkap sesuai KTP" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="row mb-3">
                            <label for="email" class="col-md-2 col-12 col-form-label">Email <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10 col-12">
                                <input type="text" class="form-control" name="email" value="{{ old('email') }}"
                                    placeholder="Masukkan Email" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-12 col-form-label">Jenis Kelamin <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10 col-12">
                                <select name="jenis_kelamin" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan
                                    </option>
                                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki
                                    </option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tempat/Tanggal Lahir -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-12 col-form-label">Tempat/Tanggal Lahir <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10 col-12">
                                <div class="row g-2">
                                    <div class="col-md-6 col-12">
                                        <input type="text" class="form-control" name="tempat_lahir"
                                            value="{{ old('tempat_lahir') }}" placeholder="Masukkan Tempat Lahir" required>
                                        @error('tempat_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <input type="date" class="form-control" name="tanggal_lahir"
                                            value="{{ old('tanggal_lahir') }}" required>
                                        @error('tanggal_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Agama -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-12 col-form-label">Agama <span class="text-danger">*</span></label>
                            <div class="col-md-10 col-12">
                                <select name="agama" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih Agama --</option>
                                    <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Protestan" {{ old('agama') == 'Protestan' ? 'selected' : '' }}>Kristen
                                        Protestan</option>
                                    <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik
                                    </option>
                                    <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Budha" {{ old('agama') == 'Budha' ? 'selected' : '' }}>Budha</option>
                                    <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu
                                    </option>
                                    <option value="Kepercayaan Kepada Tuhan YME"
                                        {{ old('agama') == 'Kepercayaan Kepada Tuhan YME' ? 'selected' : '' }}>Kepercayaan
                                        Kepada Tuhan YME</option>
                                </select>
                                @error('agama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Status Perkawinan -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-12 col-form-label">Status Perkawinan <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10 col-12">
                                <select name="status_perkawinan" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Status Perkawinan --</option>
                                    <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>
                                        Kawin
                                    </option>
                                    <option value="Belum Kawin"
                                        {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin
                                    </option>
                                    <option value="Cerai Mati"
                                        {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati
                                    </option>
                                    <option value="Cerai Hidup"
                                        {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup
                                    </option>
                                </select>
                                @error('status_perkawinan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Pekerjaan -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-12 col-form-label">Pekerjaan <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10 col-12">
                                <input type="text" class="form-control" name="pekerjaan"
                                    value="{{ old('pekerjaan') }}" placeholder="Masukkan Pekerjaan" required>
                                @error('pekerjaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Pendidikan -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-12 col-form-label">Pendidikan <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10 col-12">
                                <select name="pendidikan"
                                    class="form-select select2 @error('pendidikan') is-invalid @enderror" required>
                                    <option value="" disabled selected>-- Pilih Pendidikan Terakhir --</option>
                                    <option value="SD" {{ old('pendidikan') == 'SD' ? 'selected' : '' }}>SD</option>
                                    <option value="SMP" {{ old('pendidikan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                    <option value="SMA" {{ old('pendidikan') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                    <option value="Akademi" {{ old('pendidikan') == 'Akademi' ? 'selected' : '' }}>Akademi
                                    </option>
                                    <option value="Perguruan Tinggi"
                                        {{ old('pendidikan') == 'Perguruan Tinggi' ? 'selected' : '' }}>Perguruan Tinggi
                                    </option>
                                </select>
                                @error('pendidikan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Next -->
                        <div class="d-flex justify-content-end mt-5">
                            <button class="next-btn btn btn-primary" style="width: 15%" type="button">
                                Selanjutnya <i class="fa fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Step 2 --}}
                    <div class="step-container" id="step-2">
                        <!-- Alamat -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-12 col-form-label">Alamat <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10 col-12">
                                <input type="text" class="form-control" name="alamat" value="{{ old('alamat') }}"
                                    placeholder="Masukkan alamat lengkap sesuai domisili" required>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- RT/RW -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-12 col-form-label">RT/RW <span class="text-danger">*</span></label>
                            <div class="col-md-10 col-12">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="rt"
                                            value="{{ old('rt') }}" placeholder="Contoh: 001" required
                                            pattern="\d{3}" inputmode="numeric">
                                        @error('rt')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="rw"
                                            value="{{ old('rw') }}" placeholder="Contoh: 005" required
                                            pattern="\d{3}" inputmode="numeric">
                                        @error('rw')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Jenis Surat -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-12 col-form-label">Jenis Surat <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10 col-12">
                                <select name="jenis_surat" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Keperluan --</option>
                                    <option value="sktm" {{ old('jenis_surat') == 'sktm' ? 'selected' : '' }}>
                                        Surat Keterangan Tidak Mampu
                                    </option>
                                    <option value="sku" {{ old('jenis_surat') == 'sku' ? 'selected' : '' }}>
                                        Surat Keterangan Usaha
                                    </option>
                                    <option value="skd" {{ old('jenis_surat') == 'skd' ? 'selected' : '' }}>
                                        Surat Keterangan Domisili
                                    </option>
                                    <option value="skck" {{ old('jenis_surat') == 'skck' ? 'selected' : '' }}>
                                        Surat Keterangan Catatan Kepolisian (pengantar RT/RW ke Polsek)
                                    </option>
                                    <option value="ska" {{ old('jenis_surat') == 'ska' ? 'selected' : '' }}>
                                        Surat Izin Acara/Keramaian
                                    </option>
                                    <option value="sktp" {{ old('jenis_surat') == 'sktp' ? 'selected' : '' }}>
                                        Surat Pengantar KTP
                                    </option>
                                    <option value="spkk" {{ old('jenis_surat') == 'spkk' ? 'selected' : '' }}>
                                        Surat Pengantar Kartu Keluarga
                                    </option>
                                    <option value="skk" {{ old('jenis_surat') == 'skk' ? 'selected' : '' }}>
                                        Surat Keterangan Kematian
                                    </option>
                                    <option value="spaw" {{ old('jenis_surat') == 'spaw' ? 'selected' : '' }}>
                                        Surat Pengantar Ahli Waris
                                    </option>
                                    <option value="skp" {{ old('jenis_surat') == 'skp' ? 'selected' : '' }}>
                                        Surat Keterangan Pindah
                                    </option>
                                    <option value="skbk" {{ old('jenis_surat') == 'skbk' ? 'selected' : '' }}>
                                        Surat Keterangan Boro Kerja
                                    </option>

                                </select>
                                @error('jenis_surat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Keperluan -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-12 col-form-label">Deskripsi Keperluan</label>
                            <div class="col-md-10 col-12">
                                <input type="text" class="form-control" name="keperluan"
                                    placeholder="Masukkan Deskripsi Keperluan" value="{{ old('keperluan') }}">
                                @error('keperluan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Pengikut -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-12 col-form-label">Pengikut (opsional)</label>
                            <div class="col-md-10 col-12">
                                <input type="text" class="form-control"
                                    placeholder="Masukkan nama pengikut (opsional, khusus pindah)" name="pengikut">
                                @error('pengikut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-5">
                            <button class="prev-btn btn btn-secondary" style="width: 15%" type="button">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </button>
                            <button class="next-btn btn btn-primary" style="width: 15%" type="button">
                                Selanjutnya <i class="fa fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Step 3 --}}
                    <div class="step-container" id="step-3">
                        <!-- Upload KTP -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-12 col-form-label" for="ktp">Upload KTP <span
                                    class="text-danger d-none">*</span></label>
                            <div class="col-md-10 col-12">
                                <input type="file" name="ktp" class="form-control"
                                    accept="image/*,application/pdf" required>
                                <small class="text-muted" style="font-size: 0.75em">Format: JPG, PNG, atau PDF. Maksimal
                                    5MB.</small>

                                @error('ktp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Upload KK -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-12 col-form-label" for="kk">Upload KK <span
                                    class="text-danger d-none">*</span></label>
                            <div class="col-md-10 col-12">
                                <input type="file" name="kk" class="form-control"
                                    accept="image/*,application/pdf" required>
                                <small class="text-muted" style="font-size: 0.75em">Format: JPG, PNG, atau PDF. Maksimal
                                    5MB.</small>

                                @error('kk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Attachment File -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-12 col-form-label" for="attachment_file">Lampiran
                                <span class="text-danger d-none">*</span></label>
                            <div class="col-md-10 col-12">
                                <input type="file" name="attachment_file" class="form-control"
                                    accept="image/*,application/pdf">
                                <small class="text-muted" style="font-size: 0.75em">Format: JPG, PNG, atau PDF. Maksimal
                                    5MB.</small>
                                @error('attachment_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!--  Tangan Digital -->
                        <div class="row mb-3">
                            <label class="col-md-2 col-12 col-form-label"> Tangan Digital <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10 col-12">
                                <canvas id="signature-pad" width="400" height="150"
                                    class="border rounded mb-2 d-block"
                                    style="max-width: 100%; height: auto; width: auto;"></canvas>

                                <small class="text-muted d-block" style="font-size: .75rem;">
                                    Silakan tanda tangan di kotak di atas menggunakan mouse atau sentuhan layar.
                                </small>

                                <button type="button" id="clear-signature" class="btn btn-outline-danger btn-sm mt-2">
                                    Hapus Tanda Tangan
                                </button>

                                <input type="hidden" name="signature" id="signature-data" required>
                                @error('signature')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="d-flex justify-content-between mt-5">
                            <button class="prev-btn btn btn-secondary" style="width: 15%" type="button">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </button>
                            <button type="submit" class="btn btn-success" style="width: 15%">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @if (session('success'))
        @include('main.page.pengajuan_surat.partials.modal_persuratan', [
            'trackingToken' => session('trackingToken'),
            'pdfPath' => session('pdfPath'),
        ])

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var myModal = new bootstrap.Modal(document.getElementById('successModal'));
                myModal.show();
            });
        </script>
    @endif
@endsection

@push('customScript')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let currentStep = 1;
            const totalStep = $(".step-container").length;

            function showStep(step) {
                $(".step-container").addClass("d-none");
                $(`#step-${step}`).removeClass("d-none");

                // update nav pills
                $(".stepper .nav-link").removeClass("active");
                $(`.stepper .nav-link[href='#step${step}']`).addClass("active");

                if (step === 3) {
                    resizeCanvas();
                    window.addEventListener("resize", resizeCanvas);

                    const jenis_surat = $("select[name='jenis_surat']").val();
                    showInputFile(jenis_surat);
                }
            }

            $(document).on("click", ".next-btn", function() {
                if (requiredCheck()) {
                    if (currentStep < totalStep) {
                        $('.stepper .nav-link[href="#step' + currentStep + '"] .step-number').html(
                            `<i class="fas fa-check"></i>`);
                        $('.stepper .nav-link[href="#step' + currentStep + '"]').parent().addClass(
                            'completed');

                        currentStep++;
                        showStep(currentStep);
                    }
                }
            });

            $(document).on("click", ".prev-btn", function() {
                if (currentStep !== 1) {
                    currentStep--;
                    showStep(currentStep)
                }
            });

            // klik langsung step di nav pills
            $(".stepper .nav-link").on("click", function(event) {
                event.preventDefault();

                const stepTarget = $(this).attr("href").replace("#step", "");
                const stepTargetInt = parseInt(stepTarget);

                if (currentStep < stepTargetInt) {
                    if (requiredCheck()) {
                        currentStep = stepTargetInt;
                        showStep(currentStep);
                    } else {
                        $(".stepper .nav-link").removeClass("active");
                        $('.stepper .nav-link[href="#step' + currentStep + '"]').addClass("active");
                    }
                } else {
                    currentStep = stepTargetInt;
                    showStep(currentStep);
                }
            });

            // awal load
            showStep(currentStep);

            function requiredCheck() {
                const inputs = $(
                    `#step-${currentStep} input, #step-${currentStep} select, #step-${currentStep} textarea`);
                let valid = true;

                inputs.each(function() {
                    if (!this.checkValidity()) {
                        this.reportValidity();
                        valid = false;
                        return false
                    }
                });

                return valid;
            }

            function showInputFile(jenis_surat) {
                // aturan per jenis surat
                const rules = {
                    spaw: {
                        attachment_file: true,
                        kk: true,
                        ktp: true
                    },
                    sktp: {
                        attachment_file: false,
                        kk: true,
                        ktp: false
                    },
                    spkk: {
                        attachment_file: false,
                        kk: false,
                        ktp: true
                    },
                    default: {
                        attachment_file: false,
                        kk: true,
                        ktp: true
                    }
                };

                // ambil aturan sesuai jenis_surat, kalau ga ada pakai default
                const setting = rules[jenis_surat] || rules.default;

                // apply ke tiap field
                Object.entries(setting).forEach(([field, required]) => {
                    $(`input[name='${field}']`).attr("required", required);
                    $(`label[for='${field}'] span`).toggleClass("d-none", !required);
                });
            }

            // Fetch data using AJAX based on the NIK
            $(document).on('change', '#nik', function() {
                const nik = $(this).val();

                $.ajax({
                    url: '/pelayanan/pengajuan-surat/find-nik',
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
            });

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
                $('input[name="rt"]').val(data.rt.padStart(3, "0"));
                $('input[name="rw"]').val(data.rw.padStart(3, "0"));
            }

            // Canvas signature logic
            const canvas = document.getElementById('signature-pad');
            const ctx = canvas.getContext('2d');
            let isDrawing = false;

            function resizeCanvas() {
                canvas.width = 400;
                canvas.height = 150;
                ctx.fillStyle = "#ffffff";
                ctx.fillRect(0, 0, canvas.width, canvas.height);
            }

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
                ctx.fillStyle = "#ffffff";
                ctx.fillRect(0, 0, canvas.width, canvas.height); // biar balik putih
            });

            // Handle form submission to include signature data
            $("form").on("submit", function() {
                const signatureInput = document.getElementById("signature-data");
                signatureInput.value = canvas.toDataURL("image/png");
            });
        });
    </script>
@endpush

@push('customStyle')
    <style>
        .stepper .nav {
            display: flex;
            justify-content: space-between;
            position: relative;
        }

        .stepper .nav-item {
            flex: 1;
            position: relative;
            text-align: center;
        }

        .stepper .nav-link {
            display: flex;
            flex-direction: column;
            /* angka di kiri, text di kanan */
            align-items: center;
            background: transparent !important;
            border: none;
            position: relative;
            z-index: 1;
        }

        /* lingkaran angka */
        .stepper .step-number {
            background: white;
            border: 3px solid #00214763;
            color: #002147;
            width: 40px;
            height: 40px;
            font-size: 14px;
            font-weight: 800;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            z-index: 2;
            flex-shrink: 0;
            /* Biar lingkaran nggak gepeng */
        }

        /* lingkaran aktif */
        .stepper .nav-link.active .step-number,
        .stepper .nav-item.completed .step-number {
            background: #002147;
            color: white;
        }

        .stepper .nav-item::after {
            content: "";
            position: absolute;
            top: 25%;
            /* sejajar dengan lingkaran */
            left: 50%;
            width: 100%;
            height: 4px;
            background-color: #00214763;
            z-index: 0;
        }

        .stepper .nav-item.nav-item.completed::after {
            background: #002147;
        }

        .stepper .nav-item:last-child::after {
            display: none;
            /* garis terakhir dihilangin */
        }

        /* kalau step completed, warnanya ikut biru */
        .stepper .nav-link.active~.nav-item::after {
            background-color: #002147;
        }
    </style>
@endpush
