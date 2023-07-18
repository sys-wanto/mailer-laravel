@section('js')

<script type="text/javascript">
$(document).ready(function() {
    $(".users").select2();
});
</script>
@stop

@extends('layouts.app')

@section('content')

<form method="POST" action="{{ route('disposisi_kepala_kantor.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12 d-flex align-items-stretch grid-margin">
            <div class="row flex-grow">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add New Disposisi</h4>

                            <div class="form-group{{ $errors->has('tanggal_terima') ? ' has-error' : '' }}">
                                <label for="tanggal_terima" class="col-md-4 control-label">Tanggal Terima</label>
                                <div class="col-md-6">
                                    <input id="tanggal_terima" type="date" class="form-control" name="tanggal_terima"
                                        placeholder="Enter Tanggal Terima" value="{{ old('tanggal_terima') }}"
                                        required>
                                    @if ($errors->has('tanggal_terima'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tanggal_terima') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('pegawai_id') ? ' has-error' : '' }} "
                                style="margin-bottom: 20px;">
                                <label for="pegawai_id" class="col-md-4 control-label">Tujuan Disposisi</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="pegawai_id" required="">
                                        <option value="">--Pilih Tujuan Disposisi--</option>
                                        @foreach($pegawai as $pegawais)
                                        <option value="{{$pegawais->id}}">{{$pegawais->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('catatan_disposisi') ? ' has-error' : '' }}">
                                <label for="catatan_disposisi" class="col-md-4 control-label">Catatan Disposisi</label>
                                <div class="col-md-6">
                                    <input id="catatan_disposisi" type="text" class="form-control"
                                        name="catatan_disposisi" placeholder="Enter Catatan Disposisi"
                                        value="{{ old('catatan_disposisi') }}" required>
                                    @if ($errors->has('catatan_disposisi'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('catatan_disposisi') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('tanggal_disposisi') ? ' has-error' : '' }}">
                                <label for="tanggal_disposisi" class="col-md-4 control-label">Tanggal Disposisi</label>
                                <div class="col-md-6">
                                    <input id="tanggal_disposisi" type="date" class="form-control"
                                        name="tanggal_disposisi" placeholder="Enter Tanggal Disposisi"
                                        value="{{ old('tanggal_disposisi') }}" required>
                                    @if ($errors->has('tanggal_disposisi'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tanggal_disposisi') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" id="submit">
                                Submit
                            </button>
                            <button type="reset" class="btn btn-danger">
                                Reset
                            </button>
                            <a href="{{route('disposisi_kepala_kantor.home')}}" class="btn btn-light pull-right">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
@endsection