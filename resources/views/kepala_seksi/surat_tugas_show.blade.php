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
                        <h4 class="card-title">Detail <b>{{$surat_tugas->perihal_surat_tugas}}</b></h4>
                        <form class="forms-sample">
                            <div class="form-group{{ $errors->has('nama_seksi') ? ' has-error' : '' }}">
                                <label for="nama_seksi" class="col-md-4 control-label">Kode Seksi</label>
                                <div class="col-md-6">
                                    <input id="nama_seksi" type="text" class="form-control" name="nama_seksi"
                                        value="{{ $surat_tugas->seksi->nama_seksi }}" readonly="">
                                    @if ($errors->has('nama_seksi'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama_seksi') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                                <label for="nama" class="col-md-4 control-label">Pegawai</label>
                                <div class="col-md-6">
                                    <input id="nama" type="text" class="form-control" name="nama"
                                        value="{{ $surat_tugas->pegawai->nama }}" readonly="">
                                    @if ($errors->has('nama'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('nama_klasifikasi') ? ' has-error' : '' }}">
                                <label for="nama_klasifikasi" class="col-md-4 control-label">Klasifikasi Surat</label>
                                <div class="col-md-6">
                                    <input id="nama_klasifikasi" type="text" class="form-control" name="nama_klasifikasi"
                                        value="{{ $surat_tugas->klasifikasi_surat->nama_klasifikasi }}" readonly="">
                                    @if ($errors->has('nama_klasifikasi'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama_klasifikasi') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('nomor_surat') ? ' has-error' : '' }}">
                                <label for="nomor_surat" class="col-md-4 control-label">Nomor Surat
                                    Tugas</label>
                                <div class="col-md-6">
                                    <input id="nomor_surat" type="text" class="form-control"
                                        name="nomor_surat" value="{{ $surat_tugas->nomor_surat }}"
                                        readonly>
                                    @if ($errors->has('nomor_surat'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nomor_surat') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('tanggal_surat_tugas') ? ' has-error' : '' }}">
                                <label for="tanggal_surat_tugas" class="col-md-4 control-label">Tanggal Surat
                                    Tugas</label>
                                <div class="col-md-6">
                                    <input id="tanggal_surat_tugas" type="text" class="form-control"
                                        name="tanggal_surat_tugas" value="{{ $surat_tugas->tanggal_surat_tugas }}"
                                        readonly>
                                    @if ($errors->has('tanggal_surat_tugas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tanggal_surat_tugas') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('jenis_surat_tugas') ? ' has-error' : '' }}">
                                <label for="jenis_surat_tugas" class="col-md-4 control-label">Jenis Surat
                                    Tugas</label>
                                <div class="col-md-6">
                                    <input id="jenis_surat_tugas" type="text" class="form-control"
                                        name="jenis_surat_tugas" value="{{ $surat_tugas->jenis_surat_tugas }}"
                                        readonly>
                                    @if ($errors->has('jenis_surat_tugas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('jenis_surat_tugas') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('perihal_surat_tugas') ? ' has-error' : '' }}">
                                <label for="perihal_surat_tugas" class="col-md-4 control-label">Perihal Surat
                                    Tugas</label>
                                <div class="col-md-6">
                                    <input id="perihal_surat_tugas" type="text" class="form-control"
                                        name="perihal_surat_tugas" value="{{ $surat_tugas->perihal_surat_tugas }}"
                                        readonly>
                                    @if ($errors->has('perihal_surat_tugas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('perihal_surat_tugas') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('tempat_tugas') ? ' has-error' : '' }}">
                                <label for="tempat_tugas" class="col-md-4 control-label">Tempat Tugas</label>
                                <div class="col-md-6">
                                    <input id="tempat_tugas" type="text" class="form-control"
                                        name="tempat_tugas" value="{{ $surat_tugas->tempat_tugas }}"
                                        readonly>
                                    @if ($errors->has('tempat_tugas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tempat_tugas') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('tanggal_tugas') ? ' has-error' : '' }}">
                                <label for="tanggal_tugas" class="col-md-4 control-label">Tanggal
                                    Tugas</label>
                                <div class="col-md-6">
                                    <input id="tanggal_tugas" type="text" class="form-control"
                                        name="tanggal_tugas" value="{{ $surat_tugas->tanggal_tugas }}"
                                        readonly>
                                    @if ($errors->has('tanggal_tugas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tanggal_tugas') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('tanggal_selesai_tugas') ? ' has-error' : '' }}">
                                <label for="tanggal_selesai_tugas" class="col-md-4 control-label">Tanggal Selesai
                                    Tugas</label>
                                <div class="col-md-6">
                                    <input id="tanggal_selesai_tugas" type="text" class="form-control"
                                        name="tanggal_selesai_tugas" value="{{ $surat_tugas->tanggal_selesai_tugas }}"
                                        readonly>
                                    @if ($errors->has('tanggal_selesai_tugas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tanggal_selesai_tugas') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('file_surat_tugas') ? ' has-error' : '' }}">
                                <label for="file_surat_tugas" class="col-md-4 control-label">File Surat
                                    Tugas</label>
                                <div class="col-md-6">
                                    <input id="file_surat_tugas" type="text" class="form-control" name="file_surat_tugas"
                                        value="{{ $surat_tugas->file_surat_tugas }}" readonly>
                                    @if ($errors->has('file_surat_tugas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('file_surat_tugas') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('file_surat_tugas') ? ' has-error' : '' }}">
                                <label for="file_surat_tugas" class="col-md-4 control-label">Surat Tugas</label>
                                <div class="col-md-6">
                                    {!! QrCode::size(250)->backgroundColor(255,255,255)->generate(asset('files/surat_tugas/' . $surat_tugas->file_surat_tugas)) !!}
                                    @if ($errors->has('file_surat_tugas'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('file_surat_tugas') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{route('surat_tugas_kepala_seksi.index')}}" class="btn btn-light pull-right">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection