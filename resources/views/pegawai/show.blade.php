@section('js')

<script type="text/javascript">
    $(document).ready(function () {
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
                        <h4 class="card-title">Detail <b>{{$pegawai->nama}}</b></h4>
                        <form class="forms-sample">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <img class="product" width="200" height="200" @if($pegawai->users->gambar)
                                    src="{{ asset('images/user/'.$pegawai->users->gambar) }}" @endif />
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                                <label for="nama" class="col-md-4 control-label">Nama</label>
                                <div class="col-md-6">
                                    <input id="nama" type="text" class="form-control" name="nama"
                                        value="{{ $pegawai->nama }}" readonly>
                                    @if ($errors->has('nama'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('nip') ? ' has-error' : '' }}">
                                <label for="nip" class="col-md-4 control-label">NIP</label>
                                <div class="col-md-6">
                                    <input id="nip" type="number" class="form-control" name="nip"
                                        value="{{ $pegawai->nip }}" readonly>
                                    @if ($errors->has('nip'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nip') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('seksi_id') ? ' has-error' : '' }} "
                                style="margin-bottom: 20px;">
                                <label for="seksi_id" class="col-md-4 control-label">Seksi</label>
                                <div class="col-md-6">
                                    <input id="nama_seksi" type="text" class="form-control" name="nama_seksi"
                                        value="{{ $pegawai->seksi->nama_seksi }}" readonly="">
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('jabatan_id') ? ' has-error' : '' }} "
                                style="margin-bottom: 20px;">
                                <label for="jabatan_id" class="col-md-4 control-label">Jabatan</label>
                                <div class="col-md-6">
                                    <input id="nama_jabatan" type="text" class="form-control" name="nama_jabatan"
                                        value="{{ $pegawai->jabatan->nama_jabatan }}" readonly="">
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('status_pegawai') ? ' has-error' : '' }}">
                                <label for="status_pegawai" class="col-md-4 control-label">Status Pegawai</label>
                                <div class="col-md-6">
                                    <input id="nip" type="status_pegawai" class="form-control" name="status_pegawai"
                                        value="{{ $pegawai->status_pegawai }}" readonly>
                                    @if ($errors->has('status_pegawai'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('status_pegawai') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('users_id') ? ' has-error' : '' }} "
                                style="margin-bottom: 20px;">
                                <label for="users_id" class="col-md-4 control-label">User Login</label>
                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control" name="username"
                                        value="{{ $pegawai->users->username }}" readonly="">
                                </div>
                            </div>
                            <a href="{{route('pegawai.index')}}" class="btn btn-light pull-right">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
