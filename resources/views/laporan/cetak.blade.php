@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table').DataTable({
                "iDisplayLength": 50
            });
        });
    </script>
@stop
@extends('layouts.app')
@section('content')

    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Laporan Transaksi</h4>
                    <div class="btn-group dropdown">
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            <b><i class="fa fa-download"></i> Export PDF</b>
                        </button>
                        <div class="dropdown-menu" x-placement="bottom-start"
                             style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 30px, 0px);">
                            <a class="dropdown-item" href="{{url('laporan/cetak?data=transaksi&format=pdf')}}"> Semua Transaksi </a>
                            <a class="dropdown-item" href="{{url('laporan/cetak?data=transaksi&format=pdf&status=pinjam')}}"> Pinjam </a>
                            <a class="dropdown-item" href="{{url('laporan/cetak?data=transaksi&format=pdf&status=kembali')}}">
                                Kembali </a>
                        </div>
                    </div>
                    <div class="btn-group dropdown">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            <b><i class="fa fa-download"></i> Export EXCEL</b>
                        </button>
                        <div class="dropdown-menu" x-placement="bottom-start"
                             style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 30px, 0px);">
                            <a class="dropdown-item" href="{{url('/laporan/cetak?data=transaksi&format=excel')}}"> Semua Transaksi </a>
                            <a class="dropdown-item" href="{{url('/laporan/cetak?data=transaksi&format=excel&status=pinjam')}}">
                                Pinjam </a>
                            <a class="dropdown-item" href="{{url('/laporan/cetak?data=transaksi&format=excel&status=kembali')}}">
                                Kembali </a>
                        </div>
                    </div>
                    <div class="btn-group dropdown">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            <b><i class="fa fa-download"></i> Export CSV</b>
                        </button>
                        <div class="dropdown-menu" x-placement="bottom-start"
                             style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 30px, 0px);">
                            <a class="dropdown-item" href="{{url('/laporan/cetak?data=transaksi&format=csv')}}"> Semua Transaksi </a>
                            <a class="dropdown-item" href="{{url('/laporan/cetak?data=transaksi&format=csv&status=pinjam')}}">
                                Pinjam </a>
                            <a class="dropdown-item" href="{{url('/laporan/cetak?data=transaksi&format=csv&status=kembali')}}">
                                Kembali </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Laporan Buku</h4>
                    <div class="pull-left">
                        <a href="{{ url('/laporan/cetak?data=buku&format=pdf') }}" class="btn btn-primary btn-rounded btn-fw"><b><i
                                    class="fa fa-download"></i>Export PDF</b></a>
                    </div>
                    <div class="col-2 pull-left">
                        <a href="{{ url('/laporan/cetak?data=buku&format=excel') }}" class="btn btn-success btn-rounded btn-fw">
                            <b><i class="fa fa-download"></i>Export EXCEL</b></a>
                    </div>
                    <div class="pull-left">
                        <a href="{{ url('/laporan/cetak?data=buku&format=csv') }}" class="btn btn-success btn-rounded btn-fw">
                            <b><i class="fa fa-download"></i>Export CSV</b></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
