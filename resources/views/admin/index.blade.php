@extends('admin.layouts.app')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Penduduk</h4>
                        </div>
                        <div class="card-body">
                            1,201
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="far fa-building"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah RW</h4>
                        </div>
                        <div class="card-body">
                            5
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-building"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah RT</h4>
                        </div>
                        <div class="card-body">
                            11
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah KK</h4>
                        </div>
                        <div class="card-body">
                            47
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="card card-statistic-1">
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Komposisi Penduduk Berdasarkan Jenis Kelamin</h4>
                        </div>
                        <div class="card-body">
                            <br><br><br><br><br><br><br><br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="card card-statistic-1">
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Komposisi Penduduk Berdasarkan Agama</h4>
                        </div>
                        <div class="card-body">
                            <br><br><br><br><br><br><br><br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="card card-statistic-1">
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Komposisi Penduduk Berdasarkan Golongan Darah</h4>
                        </div>
                        <div class="card-body">
                            <br><br><br><br><br><br><br><br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="card card-statistic-1">
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Komposisi Penduduk Berdasarkan Status Perkawinan</h4>
                        </div>
                        <div class="card-body">
                            <br><br><br><br><br><br><br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-body">

        </div>
    </section>
@endsection
