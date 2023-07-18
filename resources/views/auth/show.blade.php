@section('js')
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


var check = function() {
    if (document.getElementById('password').value ==
        document.getElementById('confirm_password').value) {
        document.getElementById('submit').disabled = false;
        document.getElementById('message').style.color = 'green';
        document.getElementById('message').innerHTML = 'matching';
    } else {
        document.getElementById('submit').disabled = true;
        document.getElementById('message').style.color = 'red';
        document.getElementById('message').innerHTML = 'not matching';
    }
}
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
                        <h4 class="card-title">Detail User - <b>{{$data->username}}</b></h4>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $data->name }}"
                                    required readonly>
                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username" class="col-md-4 control-label">Username</label>
                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username"
                                    value="{{ $data->username }}" required readonly="">
                                @if ($errors->has('username'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email"
                                    value="{{ $data->email }}" required readonly>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">Photo</label>
                            <div class="col-md-6">
                                <img class="product" width="200" height="200" @if($data->gambar)
                                src="{{ asset('images/user/'.$data->gambar) }}" @endif />
                            </div>
                        </div>
                        @if(Auth::user()->level == 'admin_user')
                        <div class="form-group{{ $errors->has('level') ? ' has-error' : '' }}">
                            <label for="level" class="col-md-4 control-label">Level</label>
                            <div class="col-md-6">
                                <select class="form-control" name="level" required="" readonly>
                                    <option value="admin_user" @if($data->level == 'admin_user') selected @endif>Admin
                                        User</option>
                                    <option value="admin_data" @if($data->level == 'admin_data') selected @endif>Admin
                                        Data</option>
                                    <option value="admin_arsip" @if($data->level == 'admin_arsip') selected @endif>Admin
                                        Arsip</option>
                                    <option value="kepala_kantor" @if($data->level == 'kepala_kantor') selected
                                        @endif>Kepala Kantor</option>
                                    <option value="kepala_seksi" @if($data->level == 'kepala_seksi') selected
                                        @endif>Kepala Seksi</option>
                                    <option value="staff_seksi" @if($data->level == 'staff_seksi') selected @endif>Staff
                                        Seksi</option>
                                </select>
                            </div>
                        </div>
                        @endif
                        <a href="{{route('user.index')}}" class="btn btn-light pull-right">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection