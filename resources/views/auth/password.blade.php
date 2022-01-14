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
            if (document.getElementById('old_password').value ===
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

        var passwordCheck = function () {
            if (document.getElementById('new_password').value.length < 6){
                document.getElementById('submit').disabled = true;
                document.getElementById('message').style.color = 'red';
                document.getElementById('message').innerHTML = 'password must be at least 6 characters long';
            }
        }
    </script>
@stop

@extends('layouts.app')

@section('content')

    <form action="{{ route('password_store', $data->id) }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('put') }}
        <div class="row">
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
                <div class="row flex-grow">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Edit user</h4>

                                <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                                    <label for="new_password" class="col-md-4 control-label">
                                        New Password
                                    </label>
                                    <div class="col-md-6">
                                        <input id="new_password" type="password" class="form-control" onkeyup="passwordCheck()"
                                               name="new_password" required>
                                        @if ($errors->has('new_password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('new_password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                                    <label for="old_password" class="col-md-4 control-label">
                                        Old Password
                                    </label>
                                    <div class="col-md-6">
                                        <input id="old_password" type="password" class="form-control" onkeyup='check();'
                                               name="old_password" required>
                                        @if ($errors->has('old_password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('old_password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm" class="col-md-4 control-label">Confirm Old
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
                                <a href="{{route('user.edit', $data->id)}}" class="btn btn-light pull-right">Back</a>
                                <a href="{{route('user.index')}}" class="btn btn-light pull-right">User List</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
@endsection
