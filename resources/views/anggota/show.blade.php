@section('js')

    <script type="text/javascript">

        $(document).ready(function () {
            $(".users").select2();
        });

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
                            <h4 class="card-title">Detail <b>{{$data->nama}}</b></h4>
                            <form class="forms-sample">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <img class="product" width="200" height="200"
                                             @if(!isset($user->avatar) || !$user->avatar)
                                             src="{{ asset('images/user/default.png') }}"
                                             @else src="{{ asset('images/user/'.$user->avatar) }}"
                                            @endif />
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                                    <label for="nama" class="col-md-4 control-label">Nama</label>
                                    <div class="col-md-6">
                                        <input id="nama" type="text" class="form-control" name="nama"
                                               value="{{ $data->nama }}" readonly>
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
                                        <input id="telp" type="text" class="form-control" name="telp"
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

                                <div class="form-group{{ $errors->has('id_anggota') ? ' has-error' : '' }} "
                                     style="margin-bottom: 20px;">
                                    <label for="id_anggota" class="col-md-4 control-label">User Login</label>
                                    <div class="col-md-6">
                                        <input id="id_anggota" type="text" class="form-control" name="id_anggota"
                                               value="{{ $user->username }}" readonly="">
                                    </div>
                                </div>
                                <a href="{{route('anggota.index')}}" class="btn btn-light pull-right">Back</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
