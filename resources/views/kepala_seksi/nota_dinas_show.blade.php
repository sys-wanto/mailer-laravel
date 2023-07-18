@section('js')

<script type="text/javascript">
$(document).ready(function() {
    $(".users").select2();
});
</script>
@stop

@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12 d-flex align-items-stretch grid-margin">
        <div class="row flex-grow">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Detail <b>{{$nota_dinas->perihal_nota_dinas}}</b></h4>
                        <form class="forms-sample">
                            <div class="form-group{{ $errors->has('nama_seksi') ? ' has-error' : '' }}">
                                <label for="nama_seksi" class="col-md-4 control-label">Kode Seksi</label>
                                <div class="col-md-6">
                                    <input id="nama_seksi" type="text" class="form-control" name="nama_seksi"
                                        value="{{ $nota_dinas->seksi->nama_seksi }}" readonly="">
                                    @if ($errors->has('nama_seksi'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama_seksi') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('nomor_surat') ? ' has-error' : '' }}">
                                <label for="nomor_surat" class="col-md-4 control-label">Nomor Nota Dinas</label>
                                <div class="col-md-6">
                                    <input id="nomor_surat" type="text" class="form-control"
                                        name="nomor_surat" value="{{ $nota_dinas->nomor_surat }}"
                                        readonly>
                                    @if ($errors->has('nomor_surat'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nomor_surat') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('nama_klasifikasi') ? ' has-error' : '' }}">
                                <label for="nama_klasifikasi" class="col-md-4 control-label">Klasifikasi Surat</label>
                                <div class="col-md-6">
                                    <input id="nama_klasifikasi" type="text" class="form-control" name="nama_klasifikasi"
                                        value="{{ $nota_dinas->klasifikasi_surat->nama_klasifikasi }}" readonly="">
                                    @if ($errors->has('nama_klasifikasi'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama_klasifikasi') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('tanggal_nota_dinas') ? ' has-error' : '' }}">
                                <label for="tanggal_nota_dinas" class="col-md-4 control-label">Tanggal Nota Dinas</label>
                                <div class="col-md-6">
                                    <input id="tanggal_nota_dinas" type="text" class="form-control"
                                        name="tanggal_nota_dinas" value="{{ $nota_dinas->tanggal_nota_dinas }}"
                                        readonly>
                                    @if ($errors->has('tanggal_nota_dinas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tanggal_nota_dinas') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('tujuan_nota_dinas') ? ' has-error' : '' }}">
                                <label for="tujuan_nota_dinas" class="col-md-4 control-label">Tujuan Nota Dinas</label>
                                <div class="col-md-6">
                                    <input id="tujuan_nota_dinas" type="text" class="form-control"
                                        name="tujuan_nota_dinas" value="{{ $nota_dinas->tujuan_nota_dinas }}"
                                        readonly>
                                    @if ($errors->has('tujuan_nota_dinas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tujuan_nota_dinas') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('perihal_nota_dinas') ? ' has-error' : '' }}">
                                <label for="perihal_nota_dinas" class="col-md-4 control-label">Perihal Nota Dinas</label>
                                <div class="col-md-6">
                                    <input id="perihal_nota_dinas" type="text" class="form-control"
                                        name="perihal_nota_dinas" value="{{ $nota_dinas->perihal_nota_dinas }}"
                                        readonly>
                                    @if ($errors->has('perihal_nota_dinas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('perihal_nota_dinas') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('sifat_nota_dinas') ? ' has-error' : '' }}">
                                <label for="sifat_nota_dinas" class="col-md-4 control-label">Sifat Nota Dinas</label>
                                <div class="col-md-6">
                                    <input id="sifat_nota_dinas" type="text" class="form-control"
                                        name="sifat_nota_dinas" value="{{ $nota_dinas->sifat_nota_dinas }}"
                                        readonly>
                                    @if ($errors->has('sifat_nota_dinas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sifat_nota_dinas') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('keamanan_nota_dinas') ? ' has-error' : '' }}">
                                <label for="keamanan_nota_dinas" class="col-md-4 control-label">Keamanan Nota Dinas</label>
                                <div class="col-md-6">
                                    <input id="keamanan_nota_dinas" type="text" class="form-control"
                                        name="keamanan_nota_dinas" value="{{ $nota_dinas->keamanan_nota_dinas }}"
                                        readonly>
                                    @if ($errors->has('keamanan_nota_dinas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('keamanan_nota_dinas') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('file_nota_dinas') ? ' has-error' : '' }}">
                                <label for="file_nota_dinas" class="col-md-4 control-label">File Surat
                                    Keluar</label>
                                <div class="col-md-6">
                                    <input id="file_nota_dinas" type="text" class="form-control" name="file_nota_dinas"
                                        value="{{ $nota_dinas->file_nota_dinas }}" readonly>
                                    @if ($errors->has('file_nota_dinas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('file_nota_dinas') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{route('nota_dinas_kepala_seksi.index')}}" class="btn btn-light pull-right">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection