<!-- Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kirim Email ke Kelurahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" id="send-email-form">
                @csrf
                <input type="hidden" name="pdf" id="input-pdf">
                <div class="modal-body">
                    <div class="row mb-2">
                        <label class="col-md-2 col-12 col-form-label">Penerima</label>
                        <div class="col-md-10 col-12 ">
                            <input type="email" name="email" id="email" class="form-control"
                                value="salwalabibah04@gmail.com" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-md-2 col-12 col-form-label">Subjek</label>
                        <div class="col-md-10 col-12 ">
                            <input type="text" name="subjek" id="subjek" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-12 col-form-label">Pesan</label>
                        <div class="col-12 ">
                            <textarea name="pesan" id="pesan" class="form-control" style="height: 33vh" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success" type="submit">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>


@push('customScript')
    <script>
        $('#emailModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget); // tombol yang buka modal
            const rw = button.data('rw');
            const namaPemohon = button.data('nama-pemohon');
            const pdf = button.data('pdf-path');
            const id = button.data('id-pengajuan');

            const url = "{{ route('pengajuan-surat.send-email-kelurahan', ':id') }}".replace(':id', id);
            $('#send-email-form').attr('action', url);

            $('#subjek').val(`Pengajuan Surat Pengantar Warga RW ${rw} - ${namaPemohon}`);
            $('#pesan').val(
                `Yth. Bapak/Ibu Kelurahan,\n\nBersama email ini kami sampaikan surat pengantar atas nama ${namaPemohon} yang telah disetujui oleh Ketua RT dan Ketua RW.\nSurat pengantar terlampir dalam bentuk PDF untuk dapat ditindaklanjuti sebagaimana mestinya.\n\nAtas perhatian dan kerjasamanya, kami ucapkan terima kasih.\n\nHormat kami,\nKetua RW ${rw}`
            );

            $('#input-pdf').val(pdf);
        });
    </script>
@endpush
