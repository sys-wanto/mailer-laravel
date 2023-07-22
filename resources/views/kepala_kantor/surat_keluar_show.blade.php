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
                        <h4 class="card-title">Detail <b>{{$surat_keluar->perihal_surat_keluar}}</b></h4>
                        <form class="forms-sample">
                            <div class="form-group{{ $errors->has('nama_seksi') ? ' has-error' : '' }}">
                                <label for="nama_seksi" class="col-md-4 control-label">Kode Seksi</label>
                                <div class="col-md-6">
                                    <input id="nama_seksi" type="text" class="form-control" name="nama_seksi"
                                        value="{{ $surat_keluar->seksi->nama_seksi }}" readonly="">
                                    @if ($errors->has('nama_seksi'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama_seksi') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('nama_klasifikasi') ? ' has-error' : '' }}">
                                <label for="nama_klasifikasi" class="col-md-4 control-label">Klasifikasi Surat</label>
                                <div class="col-md-6">
                                    <input id="nama_klasifikasi" type="text" class="form-control" name="nama_klasifikasi"
                                        value="{{ $surat_keluar->klasifikasi_surat->nama_klasifikasi }}" readonly="">
                                    @if ($errors->has('nama_klasifikasi'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama_klasifikasi') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('nomor_surat') ? ' has-error' : '' }}">
                                <label for="nomor_surat" class="col-md-4 control-label">Nomor Surat
                                    Keluar</label>
                                <div class="col-md-6">
                                    <input id="nomor_surat" type="text" class="form-control"
                                        name="nomor_surat" value="{{ $surat_keluar->nomor_surat }}"
                                        readonly>
                                    @if ($errors->has('nomor_surat'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nomor_surat') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('tanggal_surat_keluar') ? ' has-error' : '' }}">
                                <label for="tanggal_surat_keluar" class="col-md-4 control-label">Tanggal Surat
                                    Keluar</label>
                                <div class="col-md-6">
                                    <input id="tanggal_surat_keluar" type="text" class="form-control"
                                        name="tanggal_surat_keluar" value="{{ $surat_keluar->tanggal_surat_keluar }}"
                                        readonly>
                                    @if ($errors->has('tanggal_surat_keluar'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tanggal_surat_keluar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('tujuan_surat_keluar') ? ' has-error' : '' }}">
                                <label for="tujuan_surat_keluar" class="col-md-4 control-label">Tujuan Surat
                                    Keluar</label>
                                <div class="col-md-6">
                                    <input id="tujuan_surat_keluar" type="text" class="form-control"
                                        name="tujuan_surat_keluar" value="{{ $surat_keluar->tujuan_surat_keluar }}"
                                        readonly>
                                    @if ($errors->has('tujuan_surat_keluar'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tujuan_surat_keluar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('perihal_surat_keluar') ? ' has-error' : '' }}">
                                <label for="perihal_surat_keluar" class="col-md-4 control-label">Perihal Surat
                                    Keluar</label>
                                <div class="col-md-6">
                                    <input id="perihal_surat_keluar" type="text" class="form-control"
                                        name="perihal_surat_keluar" value="{{ $surat_keluar->perihal_surat_keluar }}"
                                        readonly>
                                    @if ($errors->has('perihal_surat_keluar'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('perihal_surat_keluar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('sifat_surat_keluar') ? ' has-error' : '' }}">
                                <label for="sifat_surat_keluar" class="col-md-4 control-label">Sifat Surat
                                    Keluar</label>
                                <div class="col-md-6">
                                    <input id="sifat_surat_keluar" type="text" class="form-control"
                                        name="sifat_surat_keluar" value="{{ $surat_keluar->sifat_surat_keluar }}"
                                        readonly>
                                    @if ($errors->has('sifat_surat_keluar'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sifat_surat_keluar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('keamanan_surat_keluar') ? ' has-error' : '' }}">
                                <label for="keamanan_surat_keluar" class="col-md-4 control-label">Keamanan Surat
                                    Keluar</label>
                                <div class="col-md-6">
                                    <input id="keamanan_surat_keluar" type="text" class="form-control"
                                        name="keamanan_surat_keluar" value="{{ $surat_keluar->keamanan_surat_keluar }}"
                                        readonly>
                                    @if ($errors->has('keamanan_surat_keluar'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('keamanan_surat_keluar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('file_surat_keluar') ? ' has-error' : '' }}">
                                <label for="file_surat_keluar" class="col-md-4 control-label">File Surat
                                    Keluar</label>
                                <div class="col-md-6">
                                    <input id="file_surat_keluar" type="text" class="form-control" name="file_surat_keluar"
                                        value="{{ $surat_keluar->file_surat_keluar }}" readonly>
                                    @if ($errors->has('file_surat_keluar'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('file_surat_keluar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('file_surat_keluar') ? ' has-error' : '' }}">
                                <label for="file_surat_keluar" class="col-md-4 control-label">Surat Keluar</label>
                                <div class="col-md-6">
                                    {!! QrCode::size(250)->backgroundColor(255,255,255)->generate(asset('files/surat_keluar/' . $surat_keluar->file_surat_keluar)) !!}
                                    @if ($errors->has('file_surat_keluar'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('file_surat_keluar') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{route('surat_keluar_kepala_kantor.index')}}" class="btn btn-light pull-right">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection