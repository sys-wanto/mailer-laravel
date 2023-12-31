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
                        <h4 class="card-title">Detail <b>{{$surat_masuk->asal_surat_masuk}}</b></h4>
                        <form class="forms-sample">

                            <div class="form-group{{ $errors->has('asal_surat_masuk') ? ' has-error' : '' }}">
                                <label for="asal_surat_masuk" class="col-md-4 control-label">Asal Surat Masuk</label>
                                <div class="col-md-6">
                                    <input id="asal_surat_masuk" type="text" class="form-control"
                                        name="asal_surat_masuk" value="{{ $surat_masuk->asal_surat_masuk }}" readonly>
                                    @if ($errors->has('asal_surat_masuk'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('asal_surat_masuk') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('nomor_surat_masuk') ? ' has-error' : '' }}">
                                <label for="nomor_surat_masuk" class="col-md-4 control-label">Nomor Surat Masuk</label>
                                <div class="col-md-6">
                                    <input id="nomor_surat_masuk" type="number" class="form-control"
                                        name="nomor_surat_masuk" value="{{ $surat_masuk->nomor_surat_masuk }}"
                                        readonly>
                                    @if ($errors->has('nomor_surat_masuk'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nomor_surat_masuk') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('tanggal_surat_masuk') ? ' has-error' : '' }}">
                                <label for="tanggal_surat_masuk" class="col-md-4 control-label">Tanggal Surat
                                    Masuk</label>
                                <div class="col-md-6">
                                    <input id="tanggal_surat_masuk" type="text" class="form-control"
                                        name="tanggal_surat_masuk" value="{{ $surat_masuk->tanggal_surat_masuk }}"
                                        readonly>
                                    @if ($errors->has('tanggal_surat_masuk'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tanggal_surat_masuk') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('lampiran_surat_masuk') ? ' has-error' : '' }}">
                                <label for="lampiran_surat_masuk" class="col-md-4 control-label">Lampiran Surat
                                    Masuk</label>
                                <div class="col-md-6">
                                    <input id="lampiran_surat_masuk" type="text" class="form-control"
                                        name="lampiran_surat_masuk" value="{{ $surat_masuk->lampiran_surat_masuk }}"
                                        readonly>
                                    @if ($errors->has('lampiran_surat_masuk'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lampiran_surat_masuk') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('perihal_surat_masuk') ? ' has-error' : '' }}">
                                <label for="perihal_surat_masuk" class="col-md-4 control-label">Perihal Surat
                                    Masuk</label>
                                <div class="col-md-6">
                                    <input id="perihal_surat_masuk" type="text" class="form-control"
                                        name="perihal_surat_masuk" value="{{ $surat_masuk->perihal_surat_masuk }}"
                                        readonly>
                                    @if ($errors->has('perihal_surat_masuk'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('perihal_surat_masuk') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('sifat_surat_masuk') ? ' has-error' : '' }}">
                                <label for="sifat_surat_masuk" class="col-md-4 control-label">Sifat Surat
                                    Masuk</label>
                                <div class="col-md-6">
                                    <input id="sifat_surat_masuk" type="text" class="form-control"
                                        name="sifat_surat_masuk" value="{{ $surat_masuk->sifat_surat_masuk }}"
                                        readonly>
                                    @if ($errors->has('sifat_surat_masuk'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sifat_surat_masuk') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('keamanan_surat_masuk') ? ' has-error' : '' }}">
                                <label for="keamanan_surat_masuk" class="col-md-4 control-label">Keamanan Surat
                                    Masuk</label>
                                <div class="col-md-6">
                                    <input id="keamanan_surat_masuk" type="text" class="form-control"
                                        name="keamanan_surat_masuk" value="{{ $surat_masuk->keamanan_surat_masuk }}"
                                        readonly>
                                    @if ($errors->has('keamanan_surat_masuk'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('keamanan_surat_masuk') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('file_surat_masuk') ? ' has-error' : '' }}">
                                <label for="file_surat_masuk" class="col-md-4 control-label">File Surat
                                    Masuk</label>
                                <div class="col-md-6">
                                    <input id="file_surat_masuk" type="text" class="form-control"
                                        name="file_surat_masuk" value="{{ $surat_masuk->file_surat_masuk }}"
                                        readonly>
                                    @if ($errors->has('file_surat_masuk'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('file_surat_masuk') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{route('disposisi_kepala_kantor.index')}}" class="btn btn-light pull-right">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection