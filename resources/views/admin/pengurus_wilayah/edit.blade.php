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
                    <h4>Validasi Ubah Pengurus</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('pengurus-wilayah.update', $pengurus->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label><br>
                            <input type="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" placeholder="Masukkan Email Pengurus" value="{{ $pengurus->user->email }}"
                                required>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="penduduk_id">Nama</label><br>
                            <input type="text" id="penduduk_id"
                                class="form-control @error('penduduk_id') is-invalid @enderror" name="penduduk_id"
                                value="{{ $pengurus->penduduk_id }}" hidden>
                            <input type="text" id="penduduk_id"
                                class="form-control @error('penduduk_id') is-invalid @enderror" name="nama"
                                value="{{ $pengurus->penduduk->nama }}" readonly>
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
                                <option value="ketua-rt" {{ $pengurus->jabatan == 'ketua-rt' ? 'selected' : '' }}>Ketua RT
                                </option>
                                <option value="ketua-rw" {{ $pengurus->jabatan == 'ketua-rw' ? 'selected' : '' }}>Ketua RW
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
                            <div class="form-group {{ $pengurus->jabatan === 'ketua-rt' ? '' : 'd-none' }}" id="form-rt">
                                <label for="rt">Wilayah RT</label>
                                <input type="text" min="1" id="rt" name="rt"
                                    class="form-control @error('rt') is-invalid @enderror"
                                    value="{{ $pengurus->wilayah_rt }}" placeholder="Masukkan Wilayah RT">
                                @error('rt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- input wilayah RW --}}
                            <div class="form-group {{ $pengurus->jabatan === 'ketua-rw' || $pengurus->jabatan === 'ketua-rt' ? '' : 'd-none' }}"
                                id="form-rw">
                                <label for="rw">Wilayah RW</label>
                                <input type="text" min="1" id="rw" name="rw"
                                    class="form-control @error('rw') is-invalid @enderror"
                                    value="{{ $pengurus->wilayah_rw }}" placeholder="Masukkan WIlayah RW">
                                @error('rw')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label><br>
                                <div class="input-group input-group-md mb-3">
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="Masukkan Password Pengurus">
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
                                        name="password_confirmation" placeholder="Konfirmasi Password Pengurus">
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
                                <!-- Upload Foto -->
                                <div id="foto-container" class="mt-2">
                                    <input id="foto" name="foto" type="file"
                                        class="form-control @error('foto') is-invalid @enderror">
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Simpan</button>
                            <a class="btn btn-secondary" href="{{ route('galeri.index') }}">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
    </section>
@endsection

@push('customStyle')
    <link href="/assets/css/select2.min.css" rel="stylesheet" />
@endpush


@push('customScript')
    <script src="/assets/js/select2.min.js"></script> {{-- tambahkan ini --}}

    {{-- Handle Select2 --}}
    <script>
        $(document).ready(function() {
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
@endpush
