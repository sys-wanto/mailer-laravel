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

<form action="{{ route('seksi.update', $seksi->id) }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('put') }}
    <div class="row">
        <div class="col-md-12 d-flex align-items-stretch grid-margin">
            <div class="row flex-grow">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Edit Seksi - <b>{{$seksi->nama_seksi}}</b> </h4>
                            <form class="forms-sample">
                                <div class="form-group{{ $errors->has('kode_seksi') ? ' has-error' : '' }}">
                                    <label for="kode_seksi" class="col-md-4 control-label">Kode Seksi</label>
                                    <div class="col-md-6">
                                        <input id="kode_seksi" type="text" class="form-control" name="kode_seksi"
                                            placeholder="Kode Seksi" value="{{ $seksi->kode_seksi }}" required>
                                        @if ($errors->has('kode_seksi'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('kode_seksi') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('nama_seksi') ? ' has-error' : '' }}">
                                    <label for="nama_seksi" class="col-md-4 control-label">Nama Seksi</label>
                                    <div class="col-md-6">
                                        <input id="nama_seksi" type="text" class="form-control" name="nama_seksi"
                                            placeholder="Nama Seksi" value="{{ $seksi->nama_seksi }}" required>
                                        @if ($errors->has('nama_seksi'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nama_seksi') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('nama_jabatan') ? ' has-error' : '' }}">
                                    <label for="nama_jabatan" class="col-md-4 control-label">Jabatan</label>
                                    @foreach($seksi->jabatan as $key => $item )
                                    <div class="input-group mb-3 col-md-6">
                                        @if($key == 0)
                                        <input type="text" class="form-control jabatan_item" name="jabatan[]"
                                            value="{{$item->nama_jabatan}}" placeholder="Jabatan"
                                            aria-label="Recipient's username" aria-describedby="button-addon2"
                                            id=jab_item_{{$key}}>
                                        <button class="btn btn-outline-success add_jabatan" type="button"
                                            id="button-addon2">Add</button>
                                        @else
                                        <input type="text" name="jabatan[]" id=jab_item_{{$key}} class="form-control"
                                            value="{{$item->nama_jabatan}}" placeholder="Jabatan"
                                            aria-label="Recipient's username" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-danger remove_jabatan" id=jab_btn_{{$key}}
                                            onclick="delRow({{$key}})" type="button" id="button-addon2">Remove</button>
                                        @endif
                                    </div>
                                    @endforeach
                                    <div id="extra-jabatan"></div>
                                </div>

                                <button type="submit" class="btn btn-primary" id="submit">
                                    Update
                                </button>
                                <a href="{{route('seksi.index')}}" class="btn btn-light pull-right">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
@endsection
@push('js')
<script>
//get currently count item
var row = $('.jabatan_item').length;
let item_first = parseInt(row);
let item = parseInt(row) + 1;
const add = document.querySelectorAll(".input-group .add_jabatan")
add.forEach(function(e) {
    e.addEventListener('click', function() {
        let element = this.parentElement
        // console.log(element);
        let newElement = document.createElement('div')
        newElement.classList.add('input-group', 'mb-3', 'col-md-6')
        newElement.innerHTML = `<input type="text" name="jabatan[]" id=jab_item_` + item +
            ` class="form-control" placeholder="Jabatan" aria-label="Recipient's username" aria-describedby="button-addon2"> <button class="btn btn-outline-danger remove_jabatan" id=jab_btn_` +
            item + ` onclick="delRow(` + item + `)" type="button" id="button-addon2">Remove</button>`
        document.getElementById('extra-jabatan').appendChild(newElement)

        document.querySelector('form').querySelectorAll('.remove_jabatan').forEach(function(remove) {
            remove.addEventListener('click', function(elmClick) {
                elmClick.target.parentElement.remove()
            })
        })
    })
})

function delRow(id) {
    $('#jab_item_' + id).remove();
    $('#jab_btn_' + id).remove();
}
</script>
@endpush