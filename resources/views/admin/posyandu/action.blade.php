<div class="d-flex justify-content-end">
    <button
        class="btn btn-sm btn-success btn-icon d-flex align-items-center justify-content-center data-link open-antronometri"
        style="height: 30px; width: 30px" data-toggle="modal" data-target="#detail-antronometri"
        data-value="{{ $item->id }}" data-nama="{{ $item->nama }}" data-usia="{{ $item->usia }}"
        data-berat-badan="{{ $item->berat_badan }}" data-tinggi-badan="{{ $item->tinggi_badan }}"
        data-lingkar-lengan-atas="{{ $item->lingkar_lengan_atas }}" data-lingkar-lengan-bawah="{{ $item->lingkar_lengan_bawah }}"
        data-lingkar-dada="{{ $item->lingkar_dada }}" data-lingkar-perut="{{ $item->lingkar_perut }}"
        data-lingkar-kepala="{{ $item->lingkar_kepala }}">
        <i class="fas fa-eye"></i>
    </button>
    <a href="{{ route('posyandu.edit', $item->id) }}"
        class="btn btn-sm btn-info btn-icon ml-2 mr-2 d-flex align-items-center justify-content-center"
        style="height: 30px; width: 30px">
        <i class="fas fa-pen"></i>
    </a>
    <form action="{{ route('posyandu.destroy', $item->id) }}" method="POST">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button class="btn btn-sm btn-danger btn-icon confirm-delete d-flex align-items-center justify-content-center"
            style="height: 30px; width: 30px">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>
