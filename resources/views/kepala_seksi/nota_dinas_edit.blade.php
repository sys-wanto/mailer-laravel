@section('js')

<script type="text/javascript">
$(document).ready(function() {
    $(".users").select2();
});
</script>
@stop

@extends('layouts.app')

@section('content')

<form action="{{ route('nota_dinas_kepala_seksi.update', $nota_dinas->id) }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('put') }}
    <div class="row">
        <div class="col-md-12 d-flex align-items-stretch grid-margin">
            <div class="row flex-grow">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Edit Nota Dinas</h4>
                            <div class="form-group{{ $errors->has('seksi_id') ? ' has-error' : '' }} "
                                style="margin-bottom: 20px;">
                                <label for="seksi_id" class="col-md-4 control-label">Kode Seksi</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="seksi_id" required="">
                                        <option value="">-- Pilih Kode Seksi --</option>
                                        @foreach($seksi as $seksis)
                                        <option value="{{$seksis->id}}"
                                            {{$nota_dinas->seksi_id == $seksis->id ? "selected":""}}>
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
                                            {{$nota_dinas->klasifikasi_surat_id == $klasifikasi_surats->id ? "selected":""}}>
                                            {{$klasifikasi_surats->nama_klasifikasi}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('tanggal_nota_dinas') ? ' has-error' : '' }}">
                                <label for="tanggal_nota_dinas" class="col-md-4 control-label">Tanggal Nota
                                    Dinas</label>
                                <div class="col-md-6">
                                    <input id="tanggal_nota_dinas" type="date" class="form-control"
                                        name="tanggal_nota_dinas" value="{{ $nota_dinas->tanggal_nota_dinas }}"
                                        required>
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
                                        required>
                                    @if ($errors->has('tujuan_nota_dinas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tujuan_nota_dinas') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('perihal_nota_dinas') ? ' has-error' : '' }}">
                                <label for="perihal_nota_dinas" class="col-md-4 control-label">Perihal Nota
                                    Dinas</label>
                                <div class="col-md-6">
                                    <input id="perihal_nota_dinas" type="text" class="form-control"
                                        name="perihal_nota_dinas" value="{{ $nota_dinas->perihal_nota_dinas }}"
                                        required>
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
                                    <select class="form-control" name="sifat_nota_dinas" required="">
                                        <option value="">--Pilih Sifat Nota Dinas--</option>
                                        <option value="Sangat Segera"
                                            {{$nota_dinas->sifat_nota_dinas === "Sangat Segera" ? "selected" : ""}}>
                                            Sangat Segera
                                        </option>
                                        <option value="Segera"
                                            {{$nota_dinas->sifat_nota_dinas === "Segera" ? "selected" : ""}}>Segera
                                        </option>
                                        <option value="Biasa"
                                            {{$nota_dinas->sifat_nota_dinas === "Biasa" ? "selected" : ""}}>Biasa
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('keamanan_nota_dinas') ? ' has-error' : '' }}">
                                <label for="keamanan_nota_dinas" class="col-md-4 control-label">Keamanan Nota
                                    Dinas</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="keamanan_nota_dinas" required="">
                                        <option value="">--Pilih Keamanan Nota Dinas--</option>
                                        <option value="Sangat Rahasia"
                                            {{$nota_dinas->sifat_nota_dinas === "Sangat Rahasia" ? "selected" : ""}}>
                                            Sangat Rahasia
                                        </option>
                                        <option value="Rahasia"
                                            {{$nota_dinas->keamanan_nota_dinas === "Rahasia" ? "selected" : ""}}>
                                            Rahasia
                                        </option>
                                        <option value="Biasa"
                                            {{$nota_dinas->keamanan_nota_dinas === "Biasa" ? "selected" : ""}}>Biasa
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="file_nota_dinas" class="col-md-4 col-form-label-text-md-right">File Nota
                                    Dinas</label>
                                <div class="col-md-6">
                                    <input id="file_nota_dinas" type="text" class="form-control" name="file_nota_dinas"
                                        value="{{ $nota_dinas->file_nota_dinas }}" readonly>
                                    @if ($errors->has('file_nota_dinas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('file_nota_dinas') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="file_nota_dinas"
                                        value="{{ old('file_nota_dinas') }}">

                                    @error('file_nota_dinas')
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
                            <a href="{{route('nota_dinas_kepala_seksi.index')}}" class="btn btn-light pull-right">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection