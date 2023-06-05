@extends('admin.layouts.app')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                      <div class="card-icon bg-info">
                      <i class="fas fa-users"></i>
                    </div>
                    <div class="card-header">
                      <h4>Penduduk</h4>
                      </div>
                        <div class="card-body">
                          {{ $countPenduduk }}
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                      <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                          <i class="fas fa-user"></i>
                    </div>
                    <div class="card-header">
                      <h4>Laki-laki</h4>
                    </div>
                        <div class="card-body">
                          {{ $countLaki }}
                        </div>
                      </div>
                      </div>
                      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                          <div class="card-icon bg-warning">
                        <i class="fas fa-user"></i>
                      </div>
                      <div class="card-header">
                        <h4>Perempuan</h4>
                      </div>
                      <div class="card-body">
                            {{ $countPerempuan }}
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                          <div class="card-icon bg-success">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="card-header">
                            <h4>Kepala Keluarga</h4>
                        </div>
                        <div class="card-body">
                            {{ $countKK }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Komposisi Penduduk Berdasarkan Usia</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="usia"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="card gradient-bottom" style="height: 500px">
                        <div class="card-header">
                          <h5>Agenda Sosial</h5>
                        </div>
                        <div class="card-body" id="top-5-scroll">
                          <ul class="list-unstyled list-unstyled-border">
                            @foreach ($agenda as $key => $item)
                            <li class="media">
                              <span class="image mr-3 rounded" style="height: 55px; width: 55px; background-image: url(/assets/img/agenda/{{ $item->gambar_agenda }})"></span>
                              <div class="media-body" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                <div class="float-right mt-1"><span class="font-weight-600 text-muted text-small">{{ $item->tanggal_agenda }}</span></div>
                                <div class="media-title mt-1 mb-1">{{ $item->judul_agenda }}</div>
                                <span>{{ $item->deskripsi_agenda }}</span>
                              </div>
                            </li>
                            @endforeach
                          </ul>
                        </div>
                        <div class="card-footer pt-3 d-flex justify-content-center">
                          <a href="/agenda-management/agenda" class="btn btn-info btn-md btn-round" style="z-index: 1">Details</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                  <div class="col-lg-12 col-md-12" style="padding: 0">
                    <div class="card">
                      <div class="card-header">
                        <h5>Komposisi Penduduk Berdasarkan Pekerjaan</h5>
                      </div>
                      <div class="card-body">
                        <canvas id="pekerjaan"></canvas>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12" style="padding: 0">
                    <div class="card">
                      <div class="card-header">
                        <h5>Organisasi Masyarakat</h5>
                      </div>
                      <div class="card-body">
                        <div class="owl-carousel owl-theme" id="organisasi">
                          @foreach ($organisasi as $key => $item)
                          <div>
                            <div class="product-item pb-3">
                              <span class="product-image image" style="background-image: url(/assets/img/organisasi/{{ $item->gambar_organisasi }})"></span>
                              <div class="product-details">
                                <div class="product-name">{{ $item->nama_organisasi }}</div>
                                <div class="product-review text-muted">{{ $item->deskripsi_organisasi }}</div>
                                <div class="product-cta"><a href="/organisasi-management/organisasi" class="btn btn-info">Detail</a></div>
                              </div>
                            </div>
                          </div>
                          @endforeach
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Penduduk Berdasarkan Gol. Darah</h5>
                            </div>
                            <div class="card-body" style="padding: 0 10px 20px 10px">
                                <canvas id="darah"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Penduduk Berdasarkan Agama</h5>
                            </div>
                            <div class="card-body" style="padding: 0 10px 20px 10px">
                                <canvas id="agama"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                      <div class="card">
                        <div class="card-header">
                          <h5>Komposisi Penduduk Berdasarkan RT</h5>
                        </div>
                        <div class="card-body">
                          <div class="mb-4">
                            <div class="text-small float-right font-weight-bold text-muted">2,100</div>
                            <div class="font-weight-bold mb-1">RT 01</div>
                            <div class="progress" data-height="3">
                              <div class="progress-bar" role="progressbar" data-width="80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </div>
  
                          <div class="mb-4">
                            <div class="text-small float-right font-weight-bold text-muted">1,880</div>
                            <div class="font-weight-bold mb-1">RT 02</div>
                            <div class="progress" data-height="3">
                              <div class="progress-bar" role="progressbar" data-width="67%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </div>
  
                          <div class="mb-4">
                            <div class="text-small float-right font-weight-bold text-muted">1,521</div>
                            <div class="font-weight-bold mb-1">RT 03</div>
                            <div class="progress" data-height="3">
                              <div class="progress-bar" role="progressbar" data-width="58%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </div>
  
                          <div class="mb-4">
                            <div class="text-small float-right font-weight-bold text-muted">884</div>
                            <div class="font-weight-bold mb-1">RT 04</div>
                            <div class="progress" data-height="3">
                              <div class="progress-bar" role="progressbar" data-width="36%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </div>
  
                          <div class="mb-4">
                            <div class="text-small float-right font-weight-bold text-muted">473</div>
                            <div class="font-weight-bold mb-1">RT 05</div>
                            <div class="progress" data-height="3">
                              <div class="progress-bar" role="progressbar" data-width="28%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                      <div class="card card-hero">
                        <div class="card-header">
                          <div class="card-icon">
                            <a href="/penduduk-management/bantuan" style="color: inherit"><i class="far fa-handshake"></i></a>
                          </div>
                          <h4>{{ $countSosial }}</h4>
                          <div class="card-description">Penerima Bantuan Sosial</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        var dataPekerjaan = <?php echo json_encode($dataPekerjaan); ?>;
        var labelPekerjaan = <?php echo json_encode($labelPekerjaan); ?>;
        var dataDarah = <?php echo json_encode($dataDarah); ?>;
        var labelDarah = <?php echo json_encode($labelDarah); ?>;
        var dataAgama = <?php echo json_encode($dataAgama); ?>;
        var labelAgama = <?php echo json_encode($labelAgama); ?>;
        var labelUmurL = <?php echo json_encode($labelUmurL); ?>;
        var dataUmurL = <?php echo json_encode($dataUmurL); ?>;
        var labelUmurP = <?php echo json_encode($labelUmurP); ?>;
        var dataUmurP = <?php echo json_encode($dataUmurP); ?>;
    </script>

    <script>
      $("#organisasi").owlCarousel({
        items: 3,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 2000,
        loop: true,
        dots: false,
        responsive: {
          0: {
            items: 2
          },
          768: {
            items: 2
          },
          1200: {
            items: 3
          }
        }
      });
    </script>
@endsection