<div class="modal fade" id="detail-riwayat">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="padding: 1rem 1.25rem; background-color: #2a5788;">
                <h5 class="modal-title" style="color: white; font-weight: 400;"><span id="nama_batita"></span></h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 15px;">
                <div class="table-responsive">
                    <table class="table table-bordered m-0">
                        <thead>
                            <tr style="background-color: rgba(0, 0, 0, 0.02);">
                                <th class="p-col">No</th>
                                <th class="p-col">Tanggal</th>
                                <th class="p-col">Usia</th>
                                <th class="p-col">Berat Badan</th>
                                <th class="p-col">Panjang Badan</th>
                                <th class="p-col">Lingkar Lengan Atas</th>
                                <th class="p-col">Lingkar Lengan Bawah</th>
                                <th class="p-col">Lingkar Dada</th>
                                <th class="p-col">Lingkar Perut</th>
                                <th class="p-col">Lingkar Kepala</th>
                            </tr>
                        </thead>
                        <tbody id="data-riwayat" class="position-relative"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).off('click', '.open-riwayat').on('click', '.open-riwayat', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '/posyandu-management/posyandu/riwayat/' + id,
            type: 'GET',
            success: function(response) {
                $('#nama_batita').text(response.nama_batita);

                if (response.data && response.data.length > 0) {
                    displayDataInTable(response.data);
                } else {
                    $('#noData').removeClass('d-none');
                }
            },
            error: function(xhr) {                
                let errorMessage = 'Terjadi kesalahan saat memuat data';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                $('#errorMessage').html(`
                    <i class="fas fa-exclamation-circle me-2"></i>
                    ${errorMessage}
                `).removeClass('d-none');
            }
        });
    });
    
    function formatDate(dateString) {
        const date = new Date(dateString);
        const options = { day: 'numeric', month: 'long', year: 'numeric' };
        return date.toLocaleDateString('id-ID', options);
    }

    function displayDataInTable(data) {
        const tbody = $('#data-riwayat');
        tbody.empty();
        
        data.forEach((item, index) => {
            const posyandu = item.posyandu;
            const pemeriksaans = item.data_pemeriksaan || [];
            const vaksins = item.data_vaksin || [];
            const vitamins = item.data_vitamin || [];
            
            // Calculate total rows needed (1 base row + max of pemeriksaan, vaksin, vitamin counts)
            const totalRows = 3 + Math.max(pemeriksaans.length, vaksins.length, vitamins.length, 1);
            
            let rowHTML = `
                <tr>
                    <td class="p-col align-top" rowspan="${totalRows}">${index + 1}</td>
                    <td class="p-col align-top" width="12.5%" rowspan="${totalRows}">
                        <b>Posyandu</b> <br>
                        <small>${formatDate(posyandu.created_at)}</small>
                    </td>
                    <td class="p-col align-top text-nowrap">${posyandu.usia} bulan</td>
                    <td class="p-col align-top">${posyandu.berat_badan} kg</td>
                    <td class="p-col align-top">${posyandu.tinggi_badan} cm</td>
                    <td class="p-col align-top">${posyandu.lingkar_lengan_atas} cm</td>
                    <td class="p-col align-top">${posyandu.lingkar_lengan_bawah} cm</td>
                    <td class="p-col align-top">${posyandu.lingkar_dada} cm</td>
                    <td class="p-col align-top">${posyandu.lingkar_perut} cm</td>
                    <td class="p-col align-top position-relative" rowspan="${totalRows}">
                        ${posyandu.lingkar_kepala} cm
                        <div class="form-group" style="position: absolute;left: 50%;transform: translateX(-50%);margin: 0 auto;bottom: 15px;">
                            <a href="/posyandu-management/posyandu/${posyandu.id}/imunisasi" class="btn btn-info form-control btn-sm mb-2 d-flex align-items-center justify-content-center" style="height: unset; padding: 5px 15px">Ubah</a>
                            <button class="btn btn-danger form-control btn-sm d-flex align-items-center justify-content-center" style="height: unset; padding: 5px 15px">Hapus</button>
                        </div>
                    </td>
                </tr>
            `;

            // Add pemeriksaan rows
            if (pemeriksaans.length > 0) {
                pemeriksaans.forEach((pemeriksaan, pIndex) => {
                    rowHTML += `
                        <tr>
                            <td class="p-col" colspan="2">${pIndex === 0 ? '<b>Pemeriksaan</b>' : ''}</td>
                            <td class="p-col align-top" colspan="5">
                                <div class="row">
                                    <div class="col-3">
                                        <span>${pemeriksaan.pemeriksaan || 'Pemeriksaan'}</span>
                                    </div>
                                    <div class="col-4">
                                        <span><span><b>Hasil</b> : </span>${pemeriksaan.hasil || '-'}</span>
                                    </div>
                                    <div class="col-5">
                                        <span><span><b>Catatan</b> : </span>${pemeriksaan.catatan || '-'}</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `;
                });
            } else {
                rowHTML += `
                    <tr>
                        <td class="p-col" colspan="2"><b>Pemeriksaan</b></td>
                        <td class="p-col align-top" colspan="5">-</td>
                    </tr>
                `;
            }

            // Add vaksin rows
            if (vaksins.length > 0) {
                vaksins.forEach((vaksin, vIndex) => {
                    rowHTML += `
                        <tr>
                            <td class="p-col" colspan="2">${vIndex === 0 ? '<b>Vaksinasi</b>' : ''}</td>
                            <td class="p-col align-top" colspan="5">
                                <div class="row">
                                    <div class="col-3">
                                        <span>${vaksin.nama_vaksin || 'Vaksin'}</span>
                                    </div>
                                    <div class="col-3">
                                        <span><span><b>Dosis ke</b> : </span>${vaksin.dosis_ke || '-'}</span>
                                    </div>
                                    <div class="col-3">
                                        <span><span><b>Dosis Total</b> : </span>${vaksin.dosis_total || '-'}</span>
                                    </div>
                                    <div class="col-3">
                                        <span><span><b>Interval</b> : </span>${vaksin.interval || '-'}</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `;
                });
            } else {
                rowHTML += `
                    <tr>
                        <td class="p-col" colspan="2"><b>Vaksinasi</b></td>
                        <td class="p-col align-top" colspan="5">-</td>
                    </tr>
                `;
            }

            // Add vitamin rows
            if (vitamins.length > 0) {
                vitamins.forEach((vitamin, vtIndex) => {
                    rowHTML += `
                        <tr>
                            <td class="p-col" colspan="2">${vtIndex === 0 ? '<b>Vitamin</b>' : ''}</td>
                            <td class="p-col align-top" colspan="5">
                                <div class="row">
                                    <div class="col-4">
                                        <span>${vitamin.nama_vitamin || 'Vitamin'}</span>
                                    </div>
                                    <div class="col-3">
                                        <span><span><b>Dosis</b> : </span>${vitamin.dosis || '-'}</span>
                                    </div>
                                    <div class="col-5">
                                        <span><span><b>Catatan</b> : </span>${vitamin.catatan || '-'}</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `;
                });
            } else {
                rowHTML += `
                    <tr>
                        <td class="p-col" colspan="2"><b>Vitamin</b></td>
                        <td class="p-col align-top" colspan="5">-</td>
                    </tr>
                `;
            }

            tbody.append(rowHTML);
        });
        
        $('#results').removeClass('d-none');
    }
</script>

<style>
    .table-bordered {
        border-collapse: collapse;
        border-spacing: 0;
    }
    .table-bordered td,
    .table-bordered th {
        border: 1px solid #dee2e6 !important;
    }
    .p-col.d-none {
        display: none !important;
        visibility: hidden !important;
        width: 0 !important;
        height: 0 !important;
        padding: 0 !important;
        margin: 0 !important;
        border: none !important;
    }
</style>