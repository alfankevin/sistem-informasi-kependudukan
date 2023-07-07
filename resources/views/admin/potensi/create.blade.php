@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Potensi UMKM</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('potensi.index') }}">Potensi</a></div>
                <div class="breadcrumb-item"><a href="#">Manajemen</a></div>
                <div class="breadcrumb-item">Tambah</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Potensi UMKM</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah UMKM</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('potensi.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nama_umkm">Nama UMKM</label>
                            <input id="nama_umkm" name="nama_umkm" type="text" spellcheck="false" autocomplete="off"
                            class="form-control @error('nama_umkm') is-invalid @enderror" value="{{ old('nama_umkm') }}">
                            @error('nama_umkm')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="harga_umkm">Harga UMKM</label>
                            <input id="harga_umkm" name="harga_umkm" type="text" spellcheck="false" autocomplete="off"
                            class="form-control @error('harga_umkm') is-invalid @enderror" value="{{ old('harga_umkm') }}">
                            @error('harga_umkm')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="deskripsi_umkm">Deskripsi UMKM</label>
                            <input id="deskripsi_umkm" name="deskripsi_umkm" type="text" spellcheck="false" autocomplete="off"
                                class="form-control @error('deskripsi_umkm') is-invalid @enderror" value="{{ old('deskripsi_umkm') }}">
                            @error('deskripsi_umkm')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="sosial_media">Sosial Media</label>
                            <input id="sosial_media" name="sosial_media" type="text" spellcheck="false" autocomplete="off"
                                class="form-control @error('sosial_media') is-invalid @enderror" value={{ old('sosial_media') }}>
                            @error('sosial_media')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="gambar_umkm">Gambar UMKM</label><br>
                            <img src="/assets/img/news/img.png" class="prevGambar img-preview img-fluid mb-2" id="image-preview" style="height: 180px; width: 320px">
                            <input id="gambar_umkm" name="gambar_umkm" type="file" spellcheck="false" autocomplete="off"
                                class="form-control @error('gambar_umkm') is-invalid @enderror"
                                value="{{ old('gambar_umkm') }}">
                            @error('gambar_umkm')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Simpan</button>
                    <a class="btn btn-secondary" href="{{ route('potensi.index') }}">Batal</a>
                </div>
                </form>
            </div>
        </div>
    </section>

    <script>
		const inputImage = document.querySelector("#gambar_umkm");
		const previewImage = document.querySelector("#image-preview.img-preview");

		const displayInputImage = () => {	
			const oFReader = new FileReader();
			oFReader.readAsDataURL(inputImage.files[0]);

			oFReader.onload = function (oFREvent) {
				previewImage.src = oFREvent.target.result;
			}
		}

		if (inputImage.files[0] != null) {	
			displayInputImage()
		}

		inputImage.addEventListener("change", displayInputImage) 
	</script>
@endsection
