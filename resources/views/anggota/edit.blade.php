@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".users").select2();
        });
    </script>
@stop
@extends('layouts.app')
@section('content')
    <form action="{{ route('anggota.update', $data->id) }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('put') }}
        <div class="row">
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
                <div class="row flex-grow">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Edit Anggota</h4>

                                <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                                    <label for="nama" class="col-md-4 control-label">Nama</label>
                                    <div class="col-md-6">
                                        <input id="nama" type="text" class="form-control" name="nama"
                                               value="{{ $data->nama }}" required>
                                        @if ($errors->has('nama'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">Email</label>
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email"
                                               value="{{ $data->email }}" required>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('telp') ? ' has-error' : '' }}">
                                    <label for="telp" class="col-md-4 control-label">Telephone</label>
                                    <div class="col-md-6">
                                        <input id="telp" type="tel" class="form-control" name="telp"
                                               value="{{ $data->telp }}" required>
                                        @if ($errors->has('telp'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('telp') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
                                    <label for="alamat" class="col-md-4 control-label">Alamat</label>
                                    <div class="col-md-6">
                                        <input id="alamat" type="text" class="form-control" name="alamat"
                                               value="{{ $data->alamat }}" required>
                                        @if ($errors->has('alamat'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('alamat') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }} "
                                     style="margin-bottom: 20px;">
                                    <label for="user_id" class="col-md-4 control-label">User Login</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="user_id" required="">
                                            <option value="">(Cari User)</option>
                                            @foreach($users as $user)
                                                <option
                                                    value="{{$user->id}}" {{$data->user_id === $user->id ? "selected" : ""}}>{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary" id="submit">
                                    Ubah
                                </button>
                                <button type="reset" class="btn btn-danger">
                                    Reset
                                </button>
                                <a href="{{route('anggota.index')}}" class="btn btn-light pull-right">Back</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
@endsection
