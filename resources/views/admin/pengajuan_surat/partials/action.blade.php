 <div class="d-flex align-items-end">
     <button class="btn btn-success d-flex align-items-center justify-content-center" id="open-pdf" data-toggle="modal"
         style="height: 30px; width: 30px" data-target="#pdfModal"
         data-pdf="{{ asset('/storage/files/form_pengajuan/' . $item->pdf_path) }}" data-idxPengajuan="{{ $item->id }}"
         data-status="{{ $item->status }}" data-user-role="{{ auth()->user()->getRoleNames()->first() }}"
         data-lampiran="{{ !empty($item->lampiran) ? asset('/storage/files/lampiran/' . $item->lampiran) : '' }}"
         title="Lihat File">
         <i class="fas fa-file-pdf"></i></button>
     @if (auth()->user()->getRoleNames()->first() === 'ketua-rw')
         <button
             class="btn d-flex align-items-center justify-content-center ml-2 {{ $item->status === 'disetujui_rw' ? 'btn-primary' : 'btn-secondary disabled' }}"
             style="height: 30px; width: 30px" {{ $item->status === 'disetujui_rw' ? '' : 'disabled' }} id="send-email"
             data-toggle="modal" data-target="#emailModal" data-nama-pemohon="{{ $item->nama_pemohon }}"
             data-id-pengajuan="{{ $item->id }}" data-rw="{{ $item->rw }}"
             data-pdf-path="{{ $item->pdf_path }}" title="Kirim ke Kelurahan">
             <i class="fas fa-paper-plane"></i></button>
     @endif
 </div>
