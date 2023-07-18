@section('js')

<script type="text/javascript">
$(document).ready(function() {
    $(".users").select2();
});
</script>
@stop

@extends('layouts.app')

@section('content')

<form action="{{ route('surat_tugas.update', $surat_tugas->id) }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('put') }}
    <div class="row">
        <div class="col-md-12 d-flex align-items-stretch grid-margin">
            <div class="row flex-grow">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Edit Surat Tugas</h4>
                            <div class="form-group{{ $errors->has('seksi_id') ? ' has-error' : '' }} "
                                style="margin-bottom: 20px;">
                                <label for="seksi_id" class="col-md-4 control-label">Kode Seksi</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="seksi_id" required="">
                                        <option value="">-- Pilih Kode Seksi --</option>
                                        @foreach($seksi as $seksis)
                                        <option value="{{$seksis->id}}"
                                            {{$surat_tugas->seksi_id == $seksis->id ? "selected":""}}>
                                            {{$seksis->kode_seksi}} {{$seksis->nama_seksi}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('pegawai_id') ? ' has-error' : '' }} "
                                style="margin-bottom: 20px;">
                                <label for="pegawai_id" class="col-md-4 control-label">Pegawai</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="pegawai_id" required="">
                                        <option value="">-- Pilih Pegawai --</option>
                                        @foreach($pegawai as $pegawais)
                                        <option value="{{$pegawais->id}}"
                                            {{$surat_tugas->pegawai_id == $pegawais->id ? "selected":""}}>
                                            {{$pegawais->nama}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('klasifikasi_surat_id') ? ' has-error' : '' }} "
                                style="margin-bottom: 20px;">
                                <label for="klasifikasi_surat_id" class="col-md-4 control-label">Klasifikasi
                                    Surat</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="klasifikasi_surat_id" required="">
                                        <option value="">-- Pilih Klasifikasi Surat --</option>
                                        @foreach($klasifikasi_surat as $klasifikasi_surats)
                                        <option value="{{$klasifikasi_surats->id}}"
                                            {{$surat_tugas->klasifikasi_surat_id == $klasifikasi_surats->id ? "selected":""}}>
                                            {{$klasifikasi_surats->kode_klasifikasi}} | {{$klasifikasi_surats->nama_klasifikasi}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('tanggal_surat_tugas') ? ' has-error' : '' }}">
                                <label for="tanggal_surat_tugas" class="col-md-4 control-label">Tanggal Surat
                                    Tugas</label>
                                <div class="col-md-6">
                                    <input id="tanggal_surat_tugas" type="date" class="form-control"
                                        name="tanggal_surat_tugas" value="{{ $surat_tugas->tanggal_surat_tugas }}"
                                        required>
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
                                    <select class="form-control" name="jenis_surat_tugas" required="">
                                        <option value="">--Pilih Jenis Surat Tugas--</option>
                                        <option value="Dengan SPD"
                                            {{$surat_tugas->jenis_surat_tugas === "Dengan SPD" ? "selected" : ""}}>
                                            Dengan SPD
                                        </option>
                                        <option value="Tanpa SPD"
                                            {{$surat_tugas->jenis_surat_tugas === "Tanpa SPD" ? "selected" : ""}}>Tanpa
                                            SPD
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('perihal_surat_tugas') ? ' has-error' : '' }}">
                                <label for="perihal_surat_tugas" class="col-md-4 control-label">Perihal Surat
                                    Tugas</label>
                                <div class="col-md-6">
                                    <input id="perihal_surat_tugas" type="text" class="form-control"
                                        name="perihal_surat_tugas" value="{{ $surat_tugas->perihal_surat_tugas }}"
                                        required>
                                    @if ($errors->has('perihal_surat_tugas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('perihal_surat_tugas') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('tempat_tugas') ? ' has-error' : '' }}">
                                <label for="tempat_tugas" class="col-md-4 control-label">Tempat
                                    Tugas</label>
                                <div class="col-md-6">
                                    <input id="tempat_tugas" type="text" class="form-control" name="tempat_tugas"
                                        value="{{ $surat_tugas->tempat_tugas }}" required>
                                    @if ($errors->has('tempat_tugas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tempat_tugas') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('tanggal_tugas') ? ' has-error' : '' }}">
                                <label for="tanggal_tugas" class="col-md-4 control-label">Tanggal Tugas</label>
                                <div class="col-md-6">
                                    <input id="tanggal_tugas" type="date" class="form-control" name="tanggal_tugas"
                                        value="{{ $surat_tugas->tanggal_tugas }}" required>
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
                                    <input id="tanggal_selesai_tugas" type="date" class="form-control"
                                        name="tanggal_selesai_tugas" value="{{ $surat_tugas->tanggal_selesai_tugas }}"
                                        required>
                                    @if ($errors->has('tanggal_selesai_tugas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tanggal_selesai_tugas') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="file_surat_tugas" class="col-md-4 col-form-label-text-md-right">File Surat
                                    Tugas</label>
                                <div class="col-md-6">
                                    <input id="file_surat_tugas" type="text" class="form-control"
                                        name="file_surat_tugas" value="{{ $surat_tugas->file_surat_tugas }}"
                                        readonly>
                                    @if ($errors->has('file_surat_tugas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('file_surat_tugas') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="file_surat_tugas"
                                        value="{{ old('file_surat_tugas') }}">

                                    @error('file_surat_tugas')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" id="submit">
                                Ubah
                            </button>
                            <button type="reset" class="btn btn-danger">
                                Reset
                            </button>
                            <a href="{{route('surat_tugas.index')}}" class="btn btn-light pull-right">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection