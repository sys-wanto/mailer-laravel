@section('js')

<script type="text/javascript">
$(document).ready(function() {
    $(".users").select2();
});
</script>

<script type="text/javascript">
function readURL() {
    var input = this;
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $(input).prev().attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(function() {
    $(".uploads").change(readURL)
    $("#f").submit(function() {
        // do ajax submit or just classic form submit
        //  alert("fake subminting")
        return false
    })
})
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
                        <h4 class="card-title">Detail Data - <b>{{$klasifikasi_surat->nama_klasifikasi}}</b> </h4>
                        <form class="forms-sample">
                            <div class="form-group{{ $errors->has('kode_klasifikasi') ? ' has-error' : '' }}">
                                <label for="kode_klasifikasi" class="col-md-4 control-label">Kode Klasifikasi
                                    Surat</label>
                                <div class="col-md-6">
                                    <input id="kode_klasifikasi" type="text" class="form-control"
                                        name="kode_klasifikasi" value="{{ $klasifikasi_surat->kode_klasifikasi }}"
                                        readonly="">
                                    @if ($errors->has('kode_klasifikasi'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('kode_klasifikasi') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('nama_klasifikasi') ? ' has-error' : '' }}">
                                <label for="nama_klasifikasi" class="col-md-4 control-label">Nama Klasifikasi
                                    Surat</label>
                                <div class="col-md-6">
                                    <input id="nama_klasifikasi" type="text" class="form-control"
                                        name="nama_klasifikasi" value="{{ $klasifikasi_surat->nama_klasifikasi }}"
                                        readonly="">
                                    @if ($errors->has('nama_klasifikasi'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama_klasifikasi') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('uraian') ? ' has-error' : '' }}">
                                <label for="uraian" class="col-md-4 control-label">Uraian
                                    Surat</label>
                                <div class="col-md-6">
                                    <input id="uraian" type="text" class="form-control"
                                        name="uraian" value="{{ $klasifikasi_surat->uraian }}"
                                        readonly="">
                                    @if ($errors->has('uraian'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('uraian') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{route('klasifikasi_surat_kepala_kantor.index')}}" class="btn btn-light pull-right">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection