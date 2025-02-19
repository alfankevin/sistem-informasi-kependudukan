<div class="d-flex justify-content-end">
    <button class="btn btn-sm btn-success btn-icon d-flex align-items-center justify-content-center data-link openKK"
        style="height: 30px; width: 30px" data-toggle="modal" data-target="#kk" data-value="{{ $item->no_kk }}"
        data-no_kk="{{ $item->no_kk }}" data-nama="{{ $item->nama }}" data-alamat="{{ $item->alamat }}" data-rt="{{ $item->rt }}"
        data-rw="{{ $item->rw }}" data-kode_pos="{{ $item->kode_pos }}" data-kelurahan="{{ $item->kelurahan }}"
        data-kecamatan="{{ $item->kecamatan }}" data-kabupaten="{{ $item->kabupaten }}" data-provinsi="{{ $item->provinsi }}">
        <i class="fas fa-user"></i>
    </button>
    <a href="{{ route('penduduk.edit', $item->id) }}"
        class="btn btn-sm btn-info btn-icon ml-2 mr-2 d-flex align-items-center justify-content-center"
        style="height: 30px; width: 30px">
        <i class="fas fa-pen"></i>
    </a>
    <form action="{{ route('penduduk.destroy', $item->id) }}" method="POST">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button class="btn btn-sm btn-danger btn-icon confirm-delete d-flex align-items-center justify-content-center"
            style="height: 30px; width: 30px">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>
