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
            if (document.getElementById('password').value ===
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

    <form action="{{ route('user.update', $data->id) }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('put') }}
        <div class="row">
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
                <div class="row flex-grow">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Edit user</h4>
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Name</label>
                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" name="name"
                                               value="{{ $data->name }}" required autofocus>
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                    <label for="username" class="col-md-4 control-label">
                                        Username &nbsp<a href="{{ route('username_user', $data->id) }}">Ubah Username</a>
                                    </label>
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
                                    <label for="email" class="col-md-4 control-label">
                                        Email Address &nbsp<a href="{{ route('mail_user', $data->id) }}">Ubah Email</a>
                                    </label>
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email"
                                               value="{{ $data->email }}" required readonly="">
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="col-md-4 control-label">Gambar</label>
                                    <div class="col-md-6">
                                        <img class="product" width="200" height="200"
                                             @if($data->avatar) src="{{ asset('images/user/'.$data->avatar) }}" @endif />
                                        <input type="file" class="uploads form-control" style="margin-top: 20px;"
                                               name="avatar">
                                    </div>
                                </div>

                                @if(Auth::user()->role == 'admin')
                                    <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                                        <label for="role" class="col-md-4 control-label">Role</label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="role" required="">
                                                <option value="admin" @if($data->role == 'admin') selected @endif>
                                                    Admin
                                                </option>
                                                <option value="role" @if($data->role == 'member') selected @endif>User
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">
                                        Password &nbsp<a href="{{ route('password_user', $data->id) }}">Ubah Password</a>
                                    </label>
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" onkeyup='check();'
                                               name="password" required>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm" class="col-md-4 control-label">Confirm
                                        Password</label>
                                    <div class="col-md-6">
                                        <input id="confirm_password" type="password" onkeyup="check()"
                                               class="form-control" name="password_confirmation" required>
                                        <span id='message'></span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" id="submit">
                                    Update
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
