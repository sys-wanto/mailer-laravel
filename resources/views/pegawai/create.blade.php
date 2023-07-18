@section('js')

<script type="text/javascript">
$(document).ready(function() {
    $(".users").select2();
});

function getJabatan(jabatan_id) {
    $.get("{{ url('getJabatan') }}" + "/" + jabatan_id, function(data) {
        var temp = [];
        $.each(data, function(key, value) {
            temp.push({
                v: value,
                k: key
            });
        });
        var x = document.getElementById("jabatan_id");
        $('#jabatan_id').empty();
        var opt_head = document.createElement('option');
        opt_head.text = '-- Pilih Jabatan --';
        opt_head.value = '0';
        opt_head.disabled = true;
        opt_head.selected = true;
        x.appendChild(opt_head);
        //console.log(temp[0].v);
        for (var i = 0; i < temp.length; i++) {
            var opt = document.createElement('option');
            opt.value = temp[i].v.id;
            opt.text = temp[i].v.nama_jabatan;
            x.appendChild(opt);
        }
    });
}
</script>
@stop

@extends('layouts.app')

@section('content')

<form method="POST" action="{{ route('pegawai.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12 d-flex align-items-stretch grid-margin">
            <div class="row flex-grow">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add New Pegawai</h4>

                            <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                                <label for="nama" class="col-md-4 control-label">Nama Pegawai</label>
                                <div class="col-md-6">
                                    <input id="nama" type="text" class="form-control" name="nama" placeholder="Enter Nama Pegawai"
                                        value="{{ old('nama') }}" required>
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
                                    <input id="nip" type="number" class="form-control" name="nip" placeholder="Enter NIP"
                                        value="{{ old('nip') }}" required>
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

                            <div class="form-group{{ $errors->has('jabatan_id') ? ' has-error' : '' }} "
                                style="margin-bottom: 20px;">
                                <label for="jabatan_id" class="col-md-4 control-label">Jabatan</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="jabatan_id" required="" id="jabatan_id">
                                        <option value="">-- Pilih Jabatan --</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('status_pegawai') ? ' has-error' : '' }}">
                                <label for="status_pegawai" class="col-md-4 control-label">Status Pegawai</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="status_pegawai" required="">
                                        <option value="">--Pilih Status Pegawai--</option>
                                        <option value="ASN">ASN</option>
                                        <option value="Non-ASN">Non-ASN</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('users_id') ? ' has-error' : '' }} "
                                style="margin-bottom: 20px;">
                                <label for="users_id" class="col-md-4 control-label">User Login</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="users_id" required="">
                                        <option value="">--Pilih User Pegawai--</option>
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" id="submit">
                                Submit
                            </button>
                            <button type="reset" class="btn btn-danger">
                                Reset
                            </button>
                            <a href="{{route('pegawai.index')}}" class="btn btn-light pull-right">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
@endsection