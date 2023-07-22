@section('js')
<script type="text/javascript">
$(document).ready(function() {
    $('#table').DataTable({
        "iDisplayLength": 50
    });

});
</script>
@stop
@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-account-box text-info icon-lg"></i>
                    </div>
                    <div class="float-right">
                        <p class="mb-0 text-right">User</p>
                        <div class="fluid-container">
                            <h3 class="font-weight-medium text-right mb-0">{{$users->count()}}</h3>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3 mb-0">
                    <i class="mdi mdi-account mr-1" aria-hidden="true"></i> Total Seluruh User
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-package text-success icon-lg" style="width: 40px;height: 40px;"></i>
                    </div>
                    <div class="float-right">
                        <p class="mb-0 text-right">Seksi</p>
                        <div class="fluid-container">
                            <h3 class="font-weight-medium text-right mb-0">{{$seksi->count()}}</h3>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3 mb-0">
                    <i class="mdi mdi-package mr-1" aria-hidden="true"></i> Total Seksi
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-table-of-contents text-warning icon-lg" style="width: 40px;height: 40px;"></i>
                    </div>
                    <div class="float-right">
                        <p class="mb-0 text-right">Jabatan</p>
                        <div class="fluid-container">
                            <h3 class="font-weight-medium text-right mb-0">{{$jabatan->count()}}</h3>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3 mb-0">
                    <i class="mdi mdi-table-of-contents mr-1" aria-hidden="true"></i> Total Jabatan
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-contacts text-danger icon-lg" style="width: 40px;height: 40px;"></i>
                    </div>
                    <div class="float-right">
                        <p class="mb-0 text-right">Pegawai</p>
                        <div class="fluid-container">
                            <h3 class="font-weight-medium text-right mb-0">{{$pegawai->count()}}</h3>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3 mb-0">
                    <i class="mdi mdi-contacts mr-1" aria-hidden="true"></i> Total Pegawai
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-book-multiple text-danger icon-lg"></i>
                    </div>
                    <div class="float-right">
                        <p class="mb-0 text-right">Surat Masuk</p>
                        <div class="fluid-container">
                            <h3 class="font-weight-medium text-right mb-0">{{$surat_masuk->count()}}</h3>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3 mb-0">
                    <i class="mdi mdi-book-multiple mr-1" aria-hidden="true"></i> Total Surat Masuk
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-book-open text-warning icon-lg"></i>
                    </div>
                    <div class="float-right">
                        <p class="mb-0 text-right">Surat Keluar</p>
                        <div class="fluid-container">
                            <h3 class="font-weight-medium text-right mb-0">{{$surat_keluar->count()}}</h3>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3 mb-0">
                    <i class="mdi mdi-book-open mr-1" aria-hidden="true"></i> Total Surat Keluar
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-file-document text-success icon-lg"></i>
                    </div>
                    <div class="float-right">
                        <p class="mb-0 text-right">Nota Dinas</p>
                        <div class="fluid-container">
                            <h3 class="font-weight-medium text-right mb-0">{{$nota_dinas->count()}}</h3>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3 mb-0">
                    <i class="mdi mdi-file-document mr-1" aria-hidden="true"></i> Total Nota Dinas
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-file-multiple text-info icon-lg"></i>
                    </div>
                    <div class="float-right">
                        <p class="mb-0 text-right">Surat Tugas</p>
                        <div class="fluid-container">
                            <h3 class="font-weight-medium text-right mb-0">{{$surat_tugas->count()}}</h3>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3 mb-0">
                    <i class="mdi mdi-file-multiple mr-1" aria-hidden="true"></i> Total Surat Tugas
                </p>
            </div>
        </div>
    </div>
</div>

@endsection