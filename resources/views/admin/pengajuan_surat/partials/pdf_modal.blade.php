    <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Form Surat Pengantar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <embed id="pdf" src="" type="application/pdf" style="width: 100%; height: 75vh;">
                    <div class="lampiran-container d-noner mt-3">
                        <!-- tombol dropdown -->
                        <p class="font-weight-bold mb-1" style="font-size: 12pt; cursor: pointer;"
                            data-toggle="collapse" data-target="#collapseLampiran" aria-expanded="false"
                            aria-controls="collapseLampiran">
                            <i class="fas fa-caret-down mr-2 toggle-icon"></i>
                            Lihat Lampiran
                        </p>

                        <!-- isi dropdown -->
                        <div id="collapseLampiran" class="collapse">
                            <embed src="" type="application/pdf" id="lampiran"
                                style="width: 100%; height: 75vh;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn-reject" data-pengajuan="" data-toggle="modal"
                        data-target="#rejectModal">Tolak</button>
                    <button class="btn btn-success btn-approve" data-pengajuan="">Setujui</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Keterangan</h5>
                </div>
                <div class="modal-body">
                    <textarea id="rejectReason" class="form-control" rows="3" placeholder="Tuliskan alasan pengolakan..." required></textarea>
                    <div class="invalid-feedback">
                        Keterangan wajib diisi
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-danger btn-confirm-reject" data-pengajuan="">Tolak</button>
                </div>
            </div>
        </div>
    </div>

    @push('customScript')
        <script>
            var hideBtnAction = () => {
                $("#pdfModal .modal-footer").children().addClass("d-none");
            }

            $(document).on("click", "#open-pdf", function() {
                const idPengajuan = $(this).attr("data-idxPengajuan");
                $('#pdf').prop('src', $(this).data('pdf'));

                $(".btn-approve").attr("data-pengajuan", idPengajuan);
                $(".btn-reject").attr("data-pengajuan", idPengajuan);
                const lampiran = $(this).data('lampiran');
                if (lampiran !== "") {
                    // tampilkan tombol lampiran
                    $(".lampiran-container").removeClass('d-none');

                    // reset collapse setiap kali modal dibuka
                    $('#collapseLampiran').collapse('hide');
                    $(".toggle-icon").removeClass("fa-caret-up").addClass("fa-caret-down");

                    $('#lampiran').prop('src', lampiran);
                } else {
                    // sembunyikan kalau gak ada lampiran
                    $(".lampiran-container").addClass('d-none');
                    $('#lampiran').prop('src', '');
                }

                const status = $(this).data('status');
                const role = $(this).data('user-role');

                // reset dulu biar tombol muncul lagi
                $("#pdfModal .modal-footer").children().removeClass("d-none");

                if (status !== 'diajukan' || (role !== 'ketua-rw' && role !== 'ketua-rt')) {
                    hideBtnAction();
                }
            });

            $('#collapseLampiran').on('show.bs.collapse', function() {
                $(".toggle-icon").removeClass("fa-caret-down").addClass("fa-caret-up");
            }).on('hide.bs.collapse', function() {
                $(".toggle-icon").removeClass("fa-caret-up").addClass("fa-caret-down");
            });

            $(document).on("click", ".btn-approve", function() {
                const idPengajuan = $(this).data("pengajuan");

                $.ajax({
                    type: "GET",
                    url: '/pelayanan-management/pengajuan-surat/' + idPengajuan + "/approve",
                    success: function(res) {
                        const pdfUrl = res.pdf + '?v=' + new Date().getTime(); // kasih timestamp unik

                        $("#pdf").attr("src", pdfUrl);

                        $("#pdfModal .modal-body").prepend(`
                            <div class="alert alert-success alert-dismissible show fade mt-2">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert"><span>×</span></button>
                                    <p>Pengajuan surat pengantar berhasil disetujui!</p>
                                </div>
                            </div>
                        `);

                        hideBtnAction();
                        $('#pengajuanTable').DataTable().ajax.reload(null, false);
                    },
                    error: function(res) {
                        $("#pdfModal .modal-body").prepend(`
                            <div class="alert alert-danger alert-dismissible show fade mt-2">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert"><span>×</span></button>
                                    <p>${res.error}!</p>
                                </div>
                            </div>
                        `);
                        console.log(res);
                    }
                });
            });

            $(document).on("click", ".btn-reject", function() {
                const idxPengajuan = $(this).attr("data-pengajuan");
                $(".btn-confirm-reject").attr("data-pengajuan", idxPengajuan);
            });

            $(document).on("click", ".btn-confirm-reject", function() {
                const idPengajuan = $(this).data("pengajuan");
                const reason = $("#rejectReason").val().trim();

                if (reason === "") {
                    $("#rejectReason").addClass("is-invalid"); // munculin invalid-feedback
                    return;
                } else {
                    $("#rejectReason").removeClass("is-invalid"); // reset kalau sudah diisi
                }


                $.ajax({
                    type: "POST",
                    url: '/pelayanan-management/pengajuan-surat/' + idPengajuan + "/tolak",
                    data: {
                        keterangan: $("#rejectReason").val()
                    },
                    success: function(res) {
                        $("#pdf").attr("src", res.pdf);

                        $("#pdfModal .modal-body").prepend(`
                            <div class="alert alert-success alert-dismissible show fade mt-2">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert"><span>×</span></button>
                                    <p>Pengajuan surat pengantar berhasil ditolak!</p>
                                </div>
                            </div>
                        `);

                        $("#rejectModal").modal("hide");
                        hideBtnAction();
                        $('#pengajuanTable').DataTable().ajax.reload(null, false);
                    },
                    error: function(res) {
                        $("#pdfModal .modal-body").prepend(`
                            <div class="alert alert-danger alert-dismissible show fade mt-2">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert"><span>×</span></button>
                                    <p>${res.error}!</p>
                                </div>
                            </div>
                        `);

                        $("#rejectModal").modal("hide"); // tutup modal setelah sukses
                    }
                })
            })
        </script>
    @endpush
