<div id="pertumbuhan" class="card">
    <div class="card-header" style="padding: .75rem 25px; background-color: #2a5788; min-height: unset;">
        <h5 class="card-title text-white" style="font-weight: 400;">Data Batita</h5>
    </div>
    <div class="card-body" style="padding-bottom: 25px;">
        <form action="{{ route('posyandu.update', $posyandu->id) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="imunisasi" value="1">
            <div class="mb-4 row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6 mb-4">
                            <label for="" class="">Usia</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="usia"
                                    value="{{ $posyandu->usia }}">
                                <span class="input-group-text" id="basic-addon2" style="background-color: #e9ecef;">bulan</span>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label for="" class="">Berat Badan</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="berat_badan"
                                    value="{{ $posyandu->berat_badan }}">
                                <span class="input-group-text" id="basic-addon2" style="background-color: #e9ecef;">kg</span>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label for="" class="">Panjang Badan</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="tinggi_badan"
                                    value="{{ $posyandu->tinggi_badan }}">
                                <span class="input-group-text" id="basic-addon2" style="background-color: #e9ecef;">cm</span>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label for="" class="">Lingkar Lengan Atas</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="lingkar_lengan_atas"
                                    value="{{ $posyandu->lingkar_lengan_atas }}">
                                <span class="input-group-text" id="basic-addon2" style="background-color: #e9ecef;">cm</span>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label for="" class="">Lingkar Lengan Bawah</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="lingkar_lengan_bawah"
                                    value="{{ $posyandu->lingkar_lengan_bawah }}">
                                <span class="input-group-text" id="basic-addon2" style="background-color: #e9ecef;">cm</span>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label for="" class="">Lingkar Dada</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="lingkar_dada"
                                    value="{{ $posyandu->lingkar_dada }}">
                                <span class="input-group-text" id="basic-addon2" style="background-color: #e9ecef;">cm</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="" class="">Lingkar Perut</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="lingkar_perut"
                                    value="{{ $posyandu->lingkar_perut }}">
                                <span class="input-group-text" id="basic-addon2" style="background-color: #e9ecef;">cm</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="" class="">Lingkar Kepala</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="lingkar_kepala"
                                    value="{{ $posyandu->lingkar_kepala }}">
                                <span class="input-group-text" id="basic-addon2" style="background-color: #e9ecef;">cm</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end d-flex justify-content-end">
                <a href="{{ route('posyandu.index') }}" class="btn btn-secondary mx-2">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
