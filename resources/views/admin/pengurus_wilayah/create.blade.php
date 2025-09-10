@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Pengurus Wilayah</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('pengurus-wilayah.index') }}">Pengurus Wilayah</a></div>
                <div class="breadcrumb-item"><a href="#">Manajemen</a></div>
                <div class="breadcrumb-item">Tambah</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Pengurus Wilayah</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Pengurus</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('pengurus-wilayah.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label><br>
                            <input type="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" placeholder="Masukkan Email Pengurus" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="penduduk_id">Nama</label><br>
                            <select id="penduduk-id" name="penduduk_id"
                                class="form-control @error('penduduk_id') is-invalid @enderror" required>
                                @if (old('penduduk_id'))
                                    <option value="{{ old('penduduk_id') }}" selected>{{ old('penduduk_id') }}</option>
                                @endif
                            </select>
                            @error('penduduk_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jabatan">Jabatan</label><br>
                            <select id="jabatan" name="jabatan"
                                class="form-control @error('jabatan') is-invalid @enderror" required>
                                <option value=""></option>
                                <option value="ketua-rt" {{ old('jabatan') == 'ketua-rt' ? 'selected' : '' }}>Ketua RT
                                </option>
                                <option value="ketua-rw" {{ old('jabatan') == 'ketua-rw' ? 'selected' : '' }}>Ketua RW
                                </option>
                                {{-- <option value="pengurs posyandu"
                                    {{ old('jabatan') == 'pengurs posyandu' ? 'selected' : '' }}>Pengurus Posyandu
                                </option> --}}
                            </select>
                            @error('jabatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            {{-- input wilayah RT --}}
                            <div class="form-group d-none" id="form-rt">
                                <label for="rt">Wilayah RT</label>
                                <input type="text" min="1" id="rt" name="rt"
                                    class="form-control @error('rt') is-invalid @enderror" value="{{ old('rt') }}"
                                    placeholder="Masukkan Wilayah RT">
                                @error('rt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- input wilayah RW --}}
                            <div class="form-group d-none" id="form-rw">
                                <label for="rw">Wilayah RW</label>
                                <input type="text" min="1" id="rw" name="rw"
                                    class="form-control @error('rw') is-invalid @enderror" value="{{ old('rw') }}"
                                    placeholder="Masukkan WIlayah RW">
                                @error('rw')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label><br>
                                <div class="input-group input-group-md mb-3">
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="Masukkan Password Pengurus" value="{{ old('password') }}" required>
                                    <div class="input-group-append" id="show-pass">
                                        <button class="input-group-text btn btn-outline-secondary border-start-0"
                                            type="button"><i class="fa fa-eye"></i></button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Password</label><br>
                                <div class="input-group input-group-md mb-3">
                                    <input type="password" id="password-confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation" placeholder="Konfirmasi Password Pengurus" required>
                                    <div class="input-group-append" id="show-pass">
                                        <button class="input-group-text btn btn-outline-secondary border-start-0"
                                            type="button"><i class="fa fa-eye"></i></button>
                                    </div>
                                </div>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="signature">Tanda Tangan</label><br>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ttd_type" id="ttd_foto"
                                        value="foto" checked>
                                    <label class="form-check-label" for="ttd_foto">Upload Foto</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ttd_type" id="ttd_canvas"
                                        value="canvas">
                                    <label class="form-check-label" for="ttd_canvas">Tanda Tangan Digital</label>
                                </div>

                                <!-- Upload Foto -->
                                <div id="foto-container" class="mt-2">
                                    <input id="foto" name="foto" type="file"
                                        class="form-control @error('foto') is-invalid @enderror">
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Canvas Signature -->
                                <div id="canvas-container" class="mt-2 d-none">
                                    <canvas id="signature-pad" width="400" height="150"
                                        class="border rounded mb-2 d-block"
                                        style="max-width: 100%; height: auto; width: auto;"></canvas>

                                    <small class="text-muted d-block" style="font-size: .75rem;">
                                        Silakan tanda tangan di kotak di atas menggunakan mouse atau sentuhan layar.
                                    </small>

                                    <input type="hidden" name="signature" id="signature-data">

                                    <button type="button" id="clear-signature"
                                        class="btn btn-outline-danger btn-sm mt-2">
                                        Hapus Tanda Tangan
                                    </button>
                                </div>
                            </div>


                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                            <a class="btn btn-secondary" href="{{ route('pengurus-wilayah.index') }}">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
    </section>
@endsection

@push('customScript')
    <script src="/assets/js/select2.min.js"></script>

    {{-- Handle Select2 --}}
    <script>
        $(document).ready(function() {
            $('#penduduk-id').select2({
                placeholder: "Masukkan Nama Pengurus",
                allowClear: false,
                ajax: {
                    url: '{{ route('pengurus-wilayah.create') }}', // ganti dengan route kamu
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term // kata yang diketik
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(item => ({
                                id: item.id,
                                text: item.nama
                            }))
                        };
                    },
                    cache: true
                }
            });

            $('#jabatan').select2({
                placeholder: "Masukkan Jabatan",
            });
        });
    </script>

    {{-- Handle Jabatan Change --}}
    <script>
        $(document).on("change", '#jabatan', function() {
            const value = $(this).val();
            if (value === "ketua-rt") {
                $("#form-rt").removeClass('d-none');
                $("#form-rw").removeClass('d-none');
                $('#rt').prop('required', true).closest('.form-group').show();
                $('#rw').prop('required', true).closest('.form-group').show();
            } else if (value === "ketua-rw") {
                $("#form-rt").addClass('d-none');
                $("#form-rw").removeClass('d-none');
                $('#rt').prop('required', false).closest('.form-group').show();
                $('#rw').prop('required', true).closest('.form-group').show();
            } else {
                $("#form-rt").addClass('d-none');
                $("#form-rw").addClass('d-none');
                $('#rt').prop('required', false).closest('.form-group').show();
                $('#rw').prop('required', false).closest('.form-group').show();
            }

        });
    </script>

    {{-- Handle Show/Hide Password --}}
    <script>
        $(document).on("click", "#show-pass", function() {
            const passwordField = $(this).siblings();

            if (passwordField.attr("type") === "password") {
                passwordField.attr("type", "text");
                $(this).find("i").removeClass("fa-eye");
                $(this).find("i").addClass("fa-eye-slash");
            } else {
                passwordField.attr("type", "password");
                $(this).find("i").addClass("fa-eye");
                $(this).find("i").removeClass("fa-eye-slash");
            }
        });
    </script>

    {{-- Handle Confirm Password --}}
    <script>
        $(document).on("keyup", "#password-confirmation", function() {
            const password = $('#password').val();
            const confirm = $(this).val();

            if (confirm.length > 0) {
                if (password === confirm) {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                } else {
                    $(this).removeClass('is-valid').addClass('is-invalid');
                }
            } else {
                $(this).removeClass('is-valid').removeClass('is-invalid');
            }
        });
    </script>

    {{-- Handle Tanda Tangan Digital --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fotoContainer = document.getElementById("foto-container");
            const canvasContainer = document.getElementById("canvas-container");
            const canvas = document.getElementById('signature-pad');
            const ctx = canvas.getContext('2d');

            document.querySelectorAll("input[name='ttd_type']").forEach((radio) => {
                radio.addEventListener("change", function() {
                    if (this.value === "foto") {
                        fotoContainer.classList.remove("d-none");
                        canvasContainer.classList.add("d-none");
                    } else {
                        fotoContainer.classList.add("d-none");
                        canvasContainer.classList.remove("d-none");
                        resizeCanvas();
                        window.addEventListener("resize", resizeCanvas);
                    }
                });
            });

            let isDrawing = false;
            ctx.strokeStyle = "#000";
            ctx.lineWidth = 2;

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
    <link href="/assets/css/select2.min.css" rel="stylesheet" />
@endpush
