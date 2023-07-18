@extends('layouts.app')

@section('content')

<form method="POST" action="{{ route('seksi.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12 d-flex align-items-stretch grid-margin">
            <div class="row flex-grow">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add New Seksi</h4>

                            <div class="form-group{{ $errors->has('kode_seksi') ? ' has-error' : '' }}">
                                <label for="kode_seksi" class="col-md-4 control-label">Kode Seksi</label>
                                <div class="col-md-6">
                                    <input id="kode_seksi" type="text" class="form-control" name="kode_seksi" placeholder="Enter Kode Seksi"
                                        required>
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
                                    <input id="nama_seksi" type="text" class="form-control" name="nama_seksi" placeholder="Enter Nama Seksi"
                                        required>
                                    @if ($errors->has('nama_seksi'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama_seksi') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('nama_jabatan') ? ' has-error' : '' }}">
                                <label for="nama_jabatan" class="col-md-4 control-label">Jabatan</label>
                                <div class="input-group mb-3 col-md-6">
                                    <input type="text" class="form-control jabatan_item" name="jabatan[]" value="{{$seksi->jabatan[0]->nama_jabatan ?? '' }}" placeholder="Enter Jabatan"
                                        aria-label="Recipient's username" aria-describedby="button-addon2" id="jab_item">
                                    <button class="btn btn-outline-success add_jabatan" type="button"
                                        id="button-addon2">Add</button>
                                </div>
                                <div id="extra-jabatan"></div>
                            </div>

                            <button type="submit" class="btn btn-primary" id="submit">
                                Submit
                            </button>
                            <button type="reset" class="btn btn-danger">
                                Reset
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
@section('js')

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
var i = 0;
$("#dynamic-ar").click(function() {
    ++i;
    $("#dynamicAddRemove").append('<tr><td><input type="text" name="addMoreInputFields[' + i +
        '][nama_jabatan]" class="form-control" /></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
    );
});
$(document).on('click', '.remove-input-field', function() {
    $(this).parents('tr').remove();
});
</script>

@stop
@push('js')
<script>
    //get currently count item
    var row = $('.jabatan_item').length;
    let item_first = parseInt(row);
    let item = parseInt(row) + 1;
    const add = document.querySelectorAll(".input-group .add_jabatan")
    add.forEach(function(e){
        e.addEventListener('click', function(){
            let element = this.parentElement
            // console.log(element);
            let newElement = document.createElement('div')
                newElement.classList.add('input-group','mb-3','col-md-6')
                newElement.innerHTML = `<input type="text" name="jabatan[]" id=jab_item_`+item+` class="form-control" placeholder="Enter Jabatan" aria-label="Recipient's username" aria-describedby="button-addon2"> <button class="btn btn-outline-danger remove_jabatan" id=jab_btn_`+item+` onclick="delRow(`+item+`)" type="button" id="button-addon2">Remove</button>`
            document.getElementById('extra-jabatan').appendChild(newElement)

            document.querySelector('form').querySelectorAll('.remove_jabatan').forEach(function(remove){
                remove.addEventListener('click',function(elmClick){
                    elmClick.target.parentElement.remove()
                })
            })
        })
    })

    function delRow(id)
    {
        $('#jab_item_'+id).remove();
        $('#jab_btn_'+id).remove();
    }
</script>

@endpush
