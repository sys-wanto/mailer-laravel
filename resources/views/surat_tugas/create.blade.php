@section('js')

    <script type="text/javascript">
        $(document).ready(function() {
            $(".users").select2();
        });
        $('#pegawai_ditugaskan').select2({
            placeholder: "--Pilih Pegawai--",
            allowClear: true
        });
        $('#pegawai_tembusan').select2({
            placeholder: "--Pilih Pegawai--",
            allowClear: true
        });
    </script>
@stop

@extends('layouts.app')

@section('content')

    <form method="POST" action="{{ route('surat_tugas.store') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
                <div class="row flex-grow">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Add New Surat Tugas</h4>

                                <div class="form-group{{ $errors->has('seksi_id') ? ' has-error' : '' }} "
                                    style="margin-bottom: 20px;">
                                    <label for="seksi_id" class="col-md-4 control-label">Kode Seksi</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="seksi_id" required="">
                                            <option value="">--Pilih Kode Seksi--</option>
                                            @foreach ($seksi as $seksis)
                                                <option value="{{ $seksis->id }}">{{ $seksis->kode_seksi }} |
                                                    {{ $seksis->nama_seksi }}</option>
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
                                            <option value="">--Pilih Klasifikasi Surat--</option>
                                            @foreach ($klasifikasi_surat as $klasifikasi_surats)
                                                <option value="{{ $klasifikasi_surats->id }}">
                                                    {{ $klasifikasi_surats->kode_klasifikasi }} |
                                                    {{ $klasifikasi_surats->nama_klasifikasi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('tanggal_surat_tugas') ? ' has-error' : '' }}">
                                    <label for="tanggal_surat_tugas" class="col-md-4 control-label">Tanggal Surat
                                        Tugas</label>
                                    <div class="col-md-6">
                                        <input id="tanggal_surat_tugas" type="date" class="form-control"
                                            name="tanggal_surat_tugas" placeholder="Enter Tanggal Surat Tugas"
                                            value="{{ old('tanggal_surat_tugas') }}" required>
                                        @if ($errors->has('tanggal_surat_tugas'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('tanggal_surat_tugas') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('jenis_surat_tugas') ? ' has-error' : '' }}">
                                    <label for="jenis_surat_tugas" class="col-md-4 control-label">Jenis Surat Tugas</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="jenis_surat_tugas" required="">
                                            <option value="">--Pilih Jenis Surat Tugas--</option>
                                            <option value="Dengan SPD">Dengan SPD</option>
                                            <option value="Tanpa SPD">Tanpa SPD</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('perihal_surat_tugas') ? ' has-error' : '' }}">
                                    <label for="perihal_surat_tugas" class="col-md-4 control-label">Perihal Surat
                                        Tugas</label>
                                    <div class="col-md-6">
                                        <input id="perihal_surat_tugas" type="text" class="form-control"
                                            name="perihal_surat_tugas" placeholder="Enter Perihal Surat Tugas"
                                            value="{{ old('perihal_surat_tugas') }}" required>
                                        @if ($errors->has('perihal_surat_tugas'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('perihal_surat_tugas') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('sifat_surat_tugas') ? ' has-error' : '' }}">
                                    <label for="sifat_surat_tugas" class="col-md-4 control-label">Sifat Surat
                                        Tugas</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="sifat_surat_tugas" required="">
                                            <option value="">--Pilih Sifat Surat Tugas--</option>
                                            <option value="Sangat Segera">Sangat Segera</option>
                                            <option value="Segera">Segera</option>
                                            <option value="Biasa">Biasa</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('keamanan_surat_tugas') ? ' has-error' : '' }}">
                                    <label for="keamanan_surat_tugas" class="col-md-4 control-label">Keamanan Surat
                                        Tugas</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="keamanan_surat_tugas" required="">
                                            <option value="">--Pilih Keamanan Surat Keluar--</option>
                                            <option value="Sangat Rahasia">Sangat Rahasia</option>
                                            <option value="Rahasia">Rahasia</option>
                                            <option value="Biasa">Biasa</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('tempat_tugas') ? ' has-error' : '' }}">
                                    <label for="tempat_tugas" class="col-md-4 control-label">Tempat
                                        Tugas</label>
                                    <div class="col-md-6">
                                        <input id="tempat_tugas" type="text" class="form-control" name="tempat_tugas"
                                            placeholder="Enter Tempat Tugas" value="{{ old('tempat_tugas') }}" required>
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
                                        <input id="tanggal_tugas" type="date" class="form-control"
                                            name="tanggal_tugas" placeholder="Enter Tanggal Tugas"
                                            value="{{ old('tanggal_tugas') }}" required>
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
                                            name="tanggal_selesai_tugas" placeholder="Enter Tanggal Selesai Tugas"
                                            value="{{ old('tanggal_selesai_tugas') }}" required>
                                        @if ($errors->has('tanggal_selesai_tugas'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('tanggal_selesai_tugas') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('pegawai_ditugaskan') ? ' has-error' : '' }} "
                                    style="margin-bottom: 20px;">
                                    <label for="pegawai_ditugaskan" class="col-md-4 control-label">CC</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="pegawai_ditugaskan[]" multiple="multiple"
                                            id="pegawai_ditugaskan" required="">
                                            @foreach ($pegawai as $pegawais)
                                                <option value="{{ $pegawais->id }}">{{ $pegawais->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('pegawai_tembusan') ? ' has-error' : '' }} "
                                    style="margin-bottom: 20px;">
                                    <label for="pegawai_tembusan" class="col-md-4 control-label">BCC</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="pegawai_tembusan[]" multiple="multiple"
                                            id="pegawai_tembusan" required="">
                                            @foreach ($pegawai as $pegawais)
                                                <option value="{{ $pegawais->id }}">{{ $pegawais->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="file_surat_tugas" class="col-md-4 col-form-label-text-md-right">File Surat
                                        Tugas</label>
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
                                    Submit
                                </button>
                                <button type="reset" class="btn btn-danger">
                                    Reset
                                </button>
                                <a href="{{ route('surat_tugas.index') }}" class="btn btn-light pull-right">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
@endsection
