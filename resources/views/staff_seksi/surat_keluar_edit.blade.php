@section('js')

<script type="text/javascript">
$(document).ready(function() {
    $(".users").select2();
});
</script>
@stop

@extends('layouts.app')

@section('content')

<form action="{{ route('surat_keluar_staff_seksi.update', $surat_keluar->id) }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('put') }}
    <div class="row">
        <div class="col-md-12 d-flex align-items-stretch grid-margin">
            <div class="row flex-grow">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Edit Surat Keluar</h4>
                            <div class="form-group{{ $errors->has('seksi_id') ? ' has-error' : '' }} "
                                style="margin-bottom: 20px;">
                                <label for="seksi_id" class="col-md-4 control-label">Kode Seksi</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="seksi_id" required="">
                                        <option value="">-- Pilih Kode Seksi --</option>
                                        @foreach($seksi as $seksis)
                                        <option value="{{$seksis->id}}"
                                            {{$surat_keluar->seksi_id == $seksis->id ? "selected":""}}>
                                            {{$seksis->nama_seksi}}
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
                                            {{$surat_keluar->klasifikasi_surat_id == $klasifikasi_surats->id ? "selected":""}}>
                                            {{$klasifikasi_surats->nama_klasifikasi}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('tanggal_surat_keluar') ? ' has-error' : '' }}">
                                <label for="tanggal_surat_keluar" class="col-md-4 control-label">Tanggal Surat
                                    Keluar</label>
                                <div class="col-md-6">
                                    <input id="tanggal_surat_keluar" type="date" class="form-control"
                                        name="tanggal_surat_keluar" value="{{ $surat_keluar->tanggal_surat_keluar }}"
                                        required>
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
                                        required>
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
                                        required>
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
                                    <select class="form-control" name="sifat_surat_keluar" required="">
                                        <option value="">--Pilih Sifat Surat Keluar--</option>
                                        <option value="Sangat Segera"
                                            {{$surat_keluar->sifat_surat_keluar === "Sangat Segera" ? "selected" : ""}}>
                                            Sangat Segera
                                        </option>
                                        <option value="Segera"
                                            {{$surat_keluar->sifat_surat_keluar === "Segera" ? "selected" : ""}}>Segera
                                        </option>
                                        <option value="Biasa"
                                            {{$surat_keluar->sifat_surat_keluar === "Biasa" ? "selected" : ""}}>Biasa
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('keamanan_surat_keluar') ? ' has-error' : '' }}">
                                <label for="keamanan_surat_keluar" class="col-md-4 control-label">Keamanan Surat
                                    Keluar</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="keamanan_surat_keluar" required="">
                                        <option value="">--Pilih Keamanan Surat Keluar--</option>
                                        <option value="Sangat Rahasia"
                                            {{$surat_keluar->sifat_surat_keluar === "Sangat Rahasia" ? "selected" : ""}}>
                                            Sangat Rahasia
                                        </option>
                                        <option value="Rahasia"
                                            {{$surat_keluar->keamanan_surat_keluar === "Rahasia" ? "selected" : ""}}>
                                            Rahasia
                                        </option>
                                        <option value="Biasa"
                                            {{$surat_keluar->keamanan_surat_keluar === "Biasa" ? "selected" : ""}}>Biasa
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="file_surat_keluar" class="col-md-4 col-form-label-text-md-right">File Surat
                                    Keluar</label>
                                <div class="col-md-6">
                                    <input id="file_surat_keluar" type="text" class="form-control"
                                        name="file_surat_keluar" value="{{ $surat_keluar->file_surat_keluar }}"
                                        readonly>
                                    @if ($errors->has('file_surat_keluar'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('file_surat_keluar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="file_surat_keluar"
                                        value="{{ old('file_surat_keluar') }}">

                                    @error('file_surat_keluar')
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
                            <a href="{{route('surat_keluar_staff_seksi.index')}}" class="btn btn-light pull-right">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection