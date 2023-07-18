@section('js')

<script type="text/javascript">
$(document).ready(function() {
    $(".users").select2();
});
</script>
@stop

@extends('layouts.app')

@section('content')

<form action="{{ route('surat_masuk.update', $surat_masuk->id) }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('put') }}
    <div class="row">
        <div class="col-md-12 d-flex align-items-stretch grid-margin">
            <div class="row flex-grow">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Edit Surat Masuk</h4>

                            <div class="form-group{{ $errors->has('asal_surat_masuk') ? ' has-error' : '' }}">
                                <label for="asal_surat_masuk" class="col-md-4 control-label">Asal Surat Masuk</label>
                                <div class="col-md-6">
                                    <input id="asal_surat_masuk" type="text" class="form-control"
                                        name="asal_surat_masuk" value="{{ $surat_masuk->asal_surat_masuk }}" required>
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
                                    <input id="nomor_surat_masuk" type="text" class="form-control"
                                        name="nomor_surat_masuk" value="{{ $surat_masuk->nomor_surat_masuk }}" required>
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
                                    <input id="tanggal_surat_masuk" type="date" class="form-control"
                                        name="tanggal_surat_masuk" value="{{ $surat_masuk->tanggal_surat_masuk }}"
                                        required>
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
                                        required>
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
                                        required>
                                    @if ($errors->has('perihal_surat_masuk'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('perihal_surat_masuk') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('sifat_surat_masuk') ? ' has-error' : '' }}">
                                <label for="sifat_surat_masuk" class="col-md-4 control-label">Sifat Surat Masuk</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="sifat_surat_masuk" required="">
                                        <option value="">--Pilih Sifat Surat Masuk--</option>
                                        <option value="Sangat Segera"
                                            {{$surat_masuk->sifat_surat_masuk === "Sangat Segera" ? "selected" : ""}}>
                                            Sangat Segera
                                        </option>
                                        <option value="Segera"
                                            {{$surat_masuk->sifat_surat_masuk === "Segera" ? "selected" : ""}}>Segera
                                        </option>
                                        <option value="Biasa"
                                            {{$surat_masuk->sifat_surat_masuk === "Biasa" ? "selected" : ""}}>Biasa
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('keamanan_surat_masuk') ? ' has-error' : '' }}">
                                <label for="keamanan_surat_masuk" class="col-md-4 control-label">Keamanan Surat
                                    Masuk</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="keamanan_surat_masuk" required="">
                                        <option value="">--Pilih Keamanan Surat Masuk--</option>
                                        <option value="Rahasia"
                                            {{$surat_masuk->keamanan_surat_masuk === "Rahasia" ? "selected" : ""}}>
                                            Rahasia
                                        </option>
                                        <option value="Biasa"
                                            {{$surat_masuk->keamanan_surat_masuk === "Biasa" ? "selected" : ""}}>Biasa
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('rak_penyimpanan_id') ? ' has-error' : '' }} "
                                style="margin-bottom: 20px;">
                                <label for="rak_penyimpanan_id" class="col-md-4 control-label">Rak
                                    Penyimpanan</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="rak_penyimpanan_id" required="">
                                        <option value="">-- Pilih Rak Penyimpanan --</option>
                                        @foreach($rak_penyimpanan as $rak_penyimpanans)
                                        <option value="{{$rak_penyimpanans->id}}"
                                            {{$surat_masuk->rak_penyimpanan_id == $rak_penyimpanans->id ? "selected":""}}>
                                            {{$rak_penyimpanans->kode_klasifikasi}} | {{$rak_penyimpanans->nama_klasifikasi}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="file_surat_masuk" class="col-md-4 col-form-label-text-md-right">File Surat
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
                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="file_surat_masuk"
                                        value="{{ old('file_surat_masuk') }}">
                                    
                                    @error('file_surat_masuk')
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
                            <a href="{{route('surat_masuk.index')}}" class="btn btn-light pull-right">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection