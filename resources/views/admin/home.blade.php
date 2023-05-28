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
                        <div class="card-icon" style='background-color: #007bff'>
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
                            <h4 style="color: #6c757d !important">Komposisi Penduduk Berdasarkan Usia</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="card gradient-bottom">
                        <div class="card-header">
                          <h4 style="color: #6c757d !important">Agenda Sosial</h4>
                          <div class="card-header-action dropdown">
                            <a href="/agenda-management/agenda" data-toggle="" class="btn btn-danger">More</a>
                            <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                              <li class="dropdown-title">Select Period</li>
                              <li><a href="#" class="dropdown-item">Today</a></li>
                              <li><a href="#" class="dropdown-item">Week</a></li>
                              <li><a href="#" class="dropdown-item active">Month</a></li>
                              <li><a href="#" class="dropdown-item">This Year</a></li>
                            </ul>
                          </div>
                        </div>
                        <div class="card-body" id="top-5-scroll">
                          <ul class="list-unstyled list-unstyled-border">
                            <li class="media">
                              <img class="mr-3 rounded" width="55" src="../assets/img/products/product-3-50.png" alt="product">
                              <div class="media-body">
                                <div class="float-right"><div class="font-weight-600 text-muted text-small">86 Sales</div></div>
                                <div class="media-title">oPhone S9 Limited</div>
                                <div class="mt-1">
                                  <div class="budget-price">
                                    <div class="budget-price-square bg-primary" data-width="64%"></div>
                                    <div class="budget-price-label">$68,714</div>
                                  </div>
                                  <div class="budget-price">
                                    <div class="budget-price-square bg-danger" data-width="43%"></div>
                                    <div class="budget-price-label">$38,700</div>
                                  </div>
                                </div>
                              </div>
                            </li>
                            <li class="media">
                              <img class="mr-3 rounded" width="55" src="../assets/img/products/product-4-50.png" alt="product">
                              <div class="media-body">
                                <div class="float-right"><div class="font-weight-600 text-muted text-small">67 Sales</div></div>
                                <div class="media-title">iBook Pro 2018</div>
                                <div class="mt-1">
                                  <div class="budget-price">
                                    <div class="budget-price-square bg-primary" data-width="84%"></div>
                                    <div class="budget-price-label">$107,133</div>
                                  </div>
                                  <div class="budget-price">
                                    <div class="budget-price-square bg-danger" data-width="60%"></div>
                                    <div class="budget-price-label">$91,455</div>
                                  </div>
                                </div>
                              </div>
                            </li>
                            <li class="media">
                              <img class="mr-3 rounded" width="55" src="../assets/img/products/product-1-50.png" alt="product">
                              <div class="media-body">
                                <div class="float-right"><div class="font-weight-600 text-muted text-small">63 Sales</div></div>
                                <div class="media-title">Headphone Blitz</div>
                                <div class="mt-1">
                                  <div class="budget-price">
                                    <div class="budget-price-square bg-primary" data-width="34%"></div>
                                    <div class="budget-price-label">$3,717</div>
                                  </div>
                                  <div class="budget-price">
                                    <div class="budget-price-square bg-danger" data-width="28%"></div>
                                    <div class="budget-price-label">$2,835</div>
                                  </div>
                                </div>
                              </div>
                            </li>
                            <li class="media">
                              <img class="mr-3 rounded" width="55" src="../assets/img/products/product-3-50.png" alt="product">
                              <div class="media-body">
                                <div class="float-right"><div class="font-weight-600 text-muted text-small">28 Sales</div></div>
                                <div class="media-title">oPhone X Lite</div>
                                <div class="mt-1">
                                  <div class="budget-price">
                                    <div class="budget-price-square bg-primary" data-width="45%"></div>
                                    <div class="budget-price-label">$13,972</div>
                                  </div>
                                  <div class="budget-price">
                                    <div class="budget-price-square bg-danger" data-width="30%"></div>
                                    <div class="budget-price-label">$9,660</div>
                                  </div>
                                </div>
                              </div>
                            </li>
                            <li class="media">
                              <img class="mr-3 rounded" width="55" src="../assets/img/products/product-5-50.png" alt="product">
                              <div class="media-body">
                                <div class="float-right"><div class="font-weight-600 text-muted text-small">19 Sales</div></div>
                                <div class="media-title">Old Camera</div>
                                <div class="mt-1">
                                  <div class="budget-price">
                                    <div class="budget-price-square bg-primary" data-width="35%"></div>
                                    <div class="budget-price-label">$7,391</div>
                                  </div>
                                  <div class="budget-price">
                                    <div class="budget-price-square bg-danger" data-width="28%"></div>
                                    <div class="budget-price-label">$5,472</div>
                                  </div>
                                </div>
                              </div>
                            </li>
                          </ul>
                        </div>
                        <div class="card-footer pt-3 d-flex justify-content-center">
                          <div class="budget-price justify-content-center">
                            <div class="budget-price-square bg-primary" data-width="20"></div>
                            <div class="budget-price-label">Selling Price</div>
                          </div>
                          <div class="budget-price justify-content-center">
                            <div class="budget-price-square bg-danger" data-width="20"></div>
                            <div class="budget-price-label">Budget Price</div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                  <div class="col-lg-12 col-md-12" style="padding: 0">
                    <div class="card">
                      <div class="card-header">
                        <h4 style="color: #6c757d !important">Komposisi Penduduk Berdasarkan RT</h4>
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
                </div>
                <div class="col-lg-6">
                  <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 style="color: #6c757d !important">Penduduk Berdasarkan Gol. Darah</h4>
                            </div>
                            <div class="card-body" style="padding: 0 10px 25px 0">
                                <canvas id="myChart5"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 style="color: #6c757d !important">Penduduk Berdasarkan Agama</h4>
                            </div>
                            <div class="card-body" style="padding: 0 10px 25px 0">
                                <canvas id="myChart4"></canvas>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>

            <div class="row">
              <div class="col-lg-6 col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h4 style="color: #6c757d !important">Organisasi Masyarakat</h4>
                  </div>
                  <div class="card-body">
                  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-6">
                  <div class="card card-hero">
                    <div class="card-header">
                      <div class="card-icon">
                        <i class="far fa-handshake"></i>
                      </div>
                      <h4>6</h4>
                      <div class="card-description">Bantuan Sosial</div>
                    </div>
                    <div class="card-body p-0">
                      <div class="tickets-list">
                        <a href="#" class="ticket-item">
                          <div class="ticket-title">
                            <h4>My order hasn't arrived yet</h4>
                          </div>
                          <div class="ticket-info">
                            <div>Laila Tazkiah</div>
                            <div class="bullet"></div>
                            <div class="text-primary">1 min ago</div>
                          </div>
                        </a>
                        <a href="#" class="ticket-item">
                          <div class="ticket-title">
                            <h4>Please cancel my order</h4>
                          </div>
                          <div class="ticket-info">
                            <div>Rizal Fakhri</div>
                            <div class="bullet"></div>
                            <div>2 hours ago</div>
                          </div>
                        </a>
                        <a href="#" class="ticket-item">
                          <div class="ticket-title">
                            <h4>Do you see my mother?</h4>
                          </div>
                          <div class="ticket-info">
                            <div>Syahdan Ubaidillah</div>
                            <div class="bullet"></div>
                            <div>6 hours ago</div>
                          </div>
                        </a>
                        <a href="/sosial-management/sosial" class="ticket-item ticket-more">
                          View All <i class="fas fa-chevron-right"></i>
                        </a>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
        </div>
    </section>
@endsection