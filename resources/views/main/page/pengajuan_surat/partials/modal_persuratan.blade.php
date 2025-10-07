<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header border-0 d-flex justify-content-between">
                <h5 class="modal-title fw-bold text-success">
                    ✅ Pengajuan Berhasil
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="mb-3">
                    Terima kasih! Pengajuan surat pengantar Anda telah <strong>berhasil diterima</strong>.
                </p>

                <p class="mb-2">
                    Simpan <strong>Nomor Token</strong> berikut untuk melacak status pengajuan:
                </p>
                <h4 class="fw-bold text-primary">{{ $trackingToken ?? 'ABC123XYZ' }}</h4>

                <div class="mt-3">
                    <a href="{{ '/pelayanan/lacak-pengajuan?token=' . $trackingToken }}" class="btn btn-primary btn-sm">
                        🔍 Lacak Pengajuan
                    </a>
                </div>

                <hr class="my-4">

                <p class="small text-muted mb-2">Unduh bukti pengajuan:</p>
                <a href="{{ '/pelayanan/pengajuan-surat/download/' . $trackingToken }}"
                    class="btn btn-outline-primary btn-sm" target="_blank">
                    📄 Unduh Surat Pengantar
                </a>

                <p class="mt-3">Salinan dokumen juga telah dikirim ke email Anda.</p>

                <div class="alert alert-info mt-4 text-start">
                    <strong>Catatan:</strong> Pengajuan Anda akan diverifikasi terlebih dahulu oleh RT (jika diperlukan)
                    kemudian oleh RW. Setelah disetujui, surat akan diteruskan ke kelurahan.
                </div>
            </div>
        </div>
    </div>
</div>
