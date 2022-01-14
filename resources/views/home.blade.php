@section('js')
    <script type="application/javascript">
        $(document).ready(function () {
            $('#table').DataTable({
                "iDisplayLength": 50,
            });
        });
    </script>
@stop
@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
            <div class="card card-statistics">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-left">
                            <i class="mdi mdi-poll-box text-danger icon-lg"></i>
                        </div>
                        <div class="float-right">
                            <p class="mb-0 text-right">Transaksi</p>
                            <div class="fluid-container">
                                <h3 class="font-weight-medium text-right mb-0">{{$transaksi->count()}}</h3>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted mt-3 mb-0">
                        <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> Total seluruh transaksi
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
            <div class="card card-statistics">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-left">
                            <i class="mdi mdi-receipt text-warning icon-lg"></i>
                        </div>
                        <div class="float-right">
                            <p class="mb-0 text-right">Sedang Pinjam</p>
                            <div class="fluid-container">
                                <h3 class="font-weight-medium text-right mb-0">{{$transaksi->where('status', 'pinjam')->count()}}</h3>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted mt-3 mb-0">
                        <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i> sedang dipinjam
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
            <div class="card card-statistics">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-left">
                            <i class="mdi mdi-book text-success icon-lg" style="width: 40px;height: 40px;"></i>
                        </div>
                        <div class="float-right">
                            <p class="mb-0 text-right">Buku</p>
                            <div class="fluid-container">
                                <h3 class="font-weight-medium text-right mb-0">{{$buku->count()}}</h3>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted mt-3 mb-0">
                        <i class="mdi mdi-book mr-1" aria-hidden="true"></i> Total judul buku
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
            <div class="card card-statistics">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-left">
                            <i class="mdi mdi-account-location text-info icon-lg"></i>
                        </div>
                        <div class="float-right">
                            <p class="mb-0 text-right">Anggota</p>
                            <div class="fluid-container">
                                <h3 class="font-weight-medium text-right mb-0">{{$anggota->count()}}</h3>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted mt-3 mb-0">
                        <i class="mdi mdi-account mr-1" aria-hidden="true"></i> Total seluruh anggota
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">

                <div class="card-body">
                    <h4 class="card-title">Data Transaksi sedang pinjam</h4>

                    <div class="table-responsive">
                        <table class="table table-striped" id="table">
                            <thead>
                            <tr>
                                <th>
                                    Kode
                                </th>
                                <th>
                                    Buku
                                </th>
                                <th>
                                    Peminjam
                                </th>
                                <th>
                                    Tgl Pinjam
                                </th>
                                <th>
                                    Tgl Kembali
                                </th>
                                <th>
                                    Status
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $content)
                                <tr>
                                    <td class="py-1">
                                        <a href="{{route('transaksi.show', $content->id)}}">
                                            {{$content->kode_transaksi}}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="/buku/{{$content->buku->id}}">
                                            {{$content->buku->judul}}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="/anggota/{{$content->anggota_id}}">
                                            {{$content->anggota->nama}}
                                        </a>
                                    </td>
                                    <td>
                                        {{date('d/m/y', strtotime($content->tgl_pinjam))}}
                                    </td>
                                    <td>
                                        {{date('d/m/y', strtotime($content->tgl_kembali))}}
                                    </td>
                                    <td>
                                        @if($content->status == 'pinjam')
                                            <label class="badge badge-warning">Pinjam</label>
                                        @else
                                            <label class="badge badge-success">Kembali</label>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
