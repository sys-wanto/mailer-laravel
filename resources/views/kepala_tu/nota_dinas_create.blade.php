@section('js')

<script type="text/javascript">
$(document).ready(function() {
    $(".users").select2();
});
</script>
@stop

@extends('layouts.app')

@section('content')

<form method="POST" action="{{ route('nota_dinas_kepala_tu.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12 d-flex align-items-stretch grid-margin">
            <div class="row flex-grow">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add New Nota Dinas</h4>

                            <div class="form-group{{ $errors->has('seksi_id') ? ' has-error' : '' }} "
                                style="margin-bottom: 20px;">
                                <label for="seksi_id" class="col-md-4 control-label">Seksi</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="seksi_id" required=""
                                        onchange="getJabatan(this.value)">
                                        <option value="">-- Pilih Seksi --</option>
                                        @foreach ($seksi as $seksis)
                                        <option value="{{ $seksis->id }}">
                                            {{ $seksis->kode_seksi }} | {{ $seksis->nama_seksi }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('klasifikasi_surat_id') ? ' has-error' : '' }} "
                                style="margin-bottom: 20px;">
                                <label for="klasifikasi_surat_id" class="col-md-4 control-label">Klasifikasi Surat</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="klasifikasi_surat_id" required="">
                                        <option value="">--Pilih Klasifikasi Surat--</option>
                                        @foreach($klasifikasi_surat as $klasifikasi_surats)
                                        <option value="{{$klasifikasi_surats->id}}">{{$klasifikasi_surats->kode_klasifikasi}} | {{$klasifikasi_surats->nama_klasifikasi}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('tanggal_nota_dinas') ? ' has-error' : '' }}">
                                <label for="tanggal_nota_dinas" class="col-md-4 control-label">Tanggal Nota Dinas</label>
                                <div class="col-md-6">
                                    <input id="tanggal_nota_dinas" type="date" class="form-control"
                                        name="tanggal_nota_dinas" placeholder="Enter Tanggal Nota Dinas"
                                        value="{{ old('tanggal_nota_dinas') }}" required>
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
                                        name="tujuan_nota_dinas" placeholder="Enter Lampiran Nota Dinas"
                                        value="{{ old('tujuan_nota_dinas') }}" required>
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
                                        name="perihal_nota_dinas" placeholder="Enter Perihal Nota Dinas"
                                        value="{{ old('perihal_nota_dinas') }}" required>
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
                                        <option value="Sangat Segera">Sangat Segera</option>
                                        <option value="Segera">Segera</option>
                                        <option value="Biasa">Biasa</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('keamanan_nota_dinas') ? ' has-error' : '' }}">
                                <label for="keamanan_nota_dinas" class="col-md-4 control-label">Keamanan Nota Dinas</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="keamanan_nota_dinas" required="">
                                        <option value="">--Pilih Keamanan Nota Dinas--</option>
                                        <option value="Sangat Rahasia">Sangat Rahasia</option>
                                        <option value="Rahasia">Rahasia</option>
                                        <option value="Biasa">Biasa</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="file_nota_dinas" class="col-md-4 col-form-label-text-md-right">File Nota Dinas</label>
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
                                Submit
                            </button>
                            <button type="reset" class="btn btn-danger">
                                Reset
                            </button>
                            <a href="{{route('nota_dinas_kepala_tu.index')}}" class="btn btn-light pull-right">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
@endsection