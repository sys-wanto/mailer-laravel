@section('js')
<script type="text/javascript">
    function readURL() {
        var input = this;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(input).prev().attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(function () {
        $(".uploads").change(readURL)
        $("#f").submit(function () {
            // do ajax submit or just classic form submit
            //  alert("fake subminting")
            return false
        })
    })


    var check = function () {
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

<form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12 d-flex align-items-stretch grid-margin">
            <div class="row flex-grow">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add New User</h4>

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" placeholder="Name"
                                        value="{{ old('name') }}" required>
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
                                    <input id="username" type="text" class="form-control" name="username" placeholder="Username"
                                        value="{{ old('username') }}" required>
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
                                    <input id="email" type="email" class="form-control" name="email" placeholder="E-mail Address"
                                        value="{{ old('email') }}" required>
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
                                    <img class="product" width="200" height="200" />
                                    <input type="file" class="uploads form-control" style="margin-top: 20px;"
                                        name="gambar" placeholder="Photo">
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('level') ? ' has-error' : '' }}">
                                <label for="level" class="col-md-4 control-label">Level</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="level" placeholder="Level User" required="">
                                        <option value="">-- Pilih Level User --</option>
                                        <option value="admin_user">Admin User</option>
                                        <option value="admin_data">Admin Data</option>
                                        <option value="admin_arsip">Admin Arsip</option>
                                        <option value="kepala_kantor">Kepala Kantor</option>
                                        <option value="kepala_tu">Kepala TU</option>
                                        <option value="staff_tu">Staff TU</option>
                                        <option value="kepala_seksi">Kepala Seksi</option>
                                        <option value="staff_seksi">Staff Seksi</option>
                                        <option value="user">User</option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" onkeyup='check();'
                                        name="password" placeholder="Password" required>
                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                                <div class="col-md-6">
                                    <input id="confirm_password" type="password" onkeyup="check()" class="form-control"
                                        name="password_confirmation" placeholder="Confirm Password" required>
                                    <span id='message'></span>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" id="submit">
                                Register
                            </button>
                            <button type="reset" class="btn btn-danger">
                                Reset
                            </button>
                            <a href="{{route('user.index')}}" class="btn btn-light pull-right">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
@endsection
