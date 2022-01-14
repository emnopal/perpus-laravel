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
    <div class="row">

        <div class="col-lg-2">
            <a href="{{ route('transaksi.create') }}" class="btn btn-primary btn-rounded btn-fw"><i
                    class="fa fa-plus"></i> Tambah Transaksi</a>
        </div>
        <div class="col-lg-12">
            @if (Session::has('message'))
                <div class="alert alert-{{ Session::get('message_type') }}" id="waktu2"
                     style="margin-top:10px;">{{ Session::get('message') }}</div>
            @endif
        </div>
    </div>
    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">

                <div class="card-body">
                    <h4 class="card-title">Data Transaksi</h4>

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
                                <th>
                                    Action
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
                                    <td>
                                        @if(Auth::user()->role == 'admin')
                                            <div class="btn-group dropdown">
                                                <button type="button" class="btn btn-success dropdown-toggle btn-sm"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" x-placement="bottom-start"
                                                     style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 30px, 0px);">
                                                    @if($content->status == 'pinjam')
                                                        <form action="{{ route('transaksi.update', $content->id) }}"
                                                              method="post" enctype="multipart/form-data">
                                                            {{ csrf_field() }}
                                                            {{ method_field('put') }}
                                                            <button class="dropdown-item"
                                                                    onclick="return confirm('Anda yakin data ini sudah kembali?')">
                                                                Sudah Kembali
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <form action="{{ route('transaksi.destroy', $content->id) }}"
                                                          class="pull-left" method="post">
                                                        {{ csrf_field() }}
                                                        {{ method_field('delete') }}
                                                        <button class="dropdown-item"
                                                                onclick="return confirm('Anda yakin ingin menghapus data ini?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @else
                                            @if($data->status == 'pinjam')
                                                <form action="{{ route('transaksi.update', $content->id) }}"
                                                      method="post" enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    {{ method_field('put') }}
                                                    <button class="btn btn-info btn-xs"
                                                            onclick="return confirm('Anda yakin data ini sudah kembali?')">
                                                        Sudah Kembali
                                                    </button>
                                                </form>
                                            @else
                                                -
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{--  {!! $datas->links() !!} --}}
                </div>
            </div>
        </div>
    </div>
@endsection
