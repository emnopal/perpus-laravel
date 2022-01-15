@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".users").select2();
        });

        $(document).on('click', '.pilih_user', function (e) {
            document.getElementById("user_id").value = $(this).attr('data-user_id');
            document.getElementById("user_nama").value = $(this).attr('data-user_nama');
            $('#myModal').modal('hide');
        });

        $(function () {
            $("#lookup").dataTable();
        });
    </script>
@stop
@extends('layouts.app')
@section('content')
    <form method="POST" action="{{ route('anggota.store') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
                <div class="row flex-grow">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Tambah Anggota baru</h4>

                                <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                                    <label for="nama" class="col-md-4 control-label">Nama</label>
                                    <div class="col-md-6">
                                        <input id="nama" type="text" class="form-control" name="nama"
                                               value="{{ old('nama') }}" required>
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
                                               value="{{ old('email') }}" required>
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
                                               value="{{ old('telp') }}" required>
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
                                               value="{{ old('alamat') }}" required>
                                        @if ($errors->has('alamat'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('alamat') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                                    <label for="user_id" class="col-md-4 control-label">User</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input id="user_nama" type="text" class="form-control" readonly=""
                                                   required>
                                            <input id="user_id" type="hidden" name="user_id"
                                                   value="{{ old('user_id') }}" required readonly="">
                                            <span class="input-group-btn">
                                    <button type="button" class="btn btn-warning btn-secondary" data-toggle="modal"
                                            data-target="#myModal"><b>
                                            Cari User
                                        </b><span class="fa fa-search"></span></button></span>
                                        </div>
                                        @if ($errors->has('user_id'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('user_id') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog"
                                     aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content" style="background: #fff;">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Cari User</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <table id="lookup"
                                                       class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>
                                                            Name
                                                        </th>
                                                        <th>
                                                            Username
                                                        </th>
                                                        <th>
                                                            Email
                                                        </th>
                                                        <th>
                                                            Created At
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($users as $user)
                                                        <tr class="pilih_user" data-user_id="<?php echo $user->id; ?>"
                                                            data-user_nama="<?php echo $user->name; ?>">
                                                            <td class="py-1">
                                                                @if(!isset($user->avatar)||!$user->avatar)
                                                                    <img src="{{url('images/user/default.png')}}"
                                                                         alt="image"
                                                                         style="margin-right: 10px;"/>
                                                                @else
                                                                    <img src="{{url('images/user/' . $user->avatar)}}"
                                                                         alt="image"
                                                                         style="margin-right: 10px;"/>
                                                                @endif
                                                                {{$user->name}}
                                                            </td>
                                                            <td>
                                                                {{$user->username}}
                                                            </td>
                                                            <td>
                                                                {{ $user->email }}
                                                            </td>
                                                            <td>
                                                                {{ $user->created_at }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-primary" id="submit">
                                    Submit
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
