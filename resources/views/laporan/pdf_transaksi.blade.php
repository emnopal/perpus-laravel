<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{ asset('css/laporan_transaksi.css') }}">>
    <title>Laporan Data Transaksi</title>
</head>
<body>
<h1 class="center">LAPORAN DATA TRANSAKSI</h1>
<table id="pseudo-demo">
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
    @foreach($datas as $data)
        <tr>
            <td class="py-1">
                {{$data->kode_transaksi}}
            </td>
            <td>
                {{$data->buku->judul}}
            </td>
            <td>
                {{$data->peminjam->nama}}
            </td>
            <td>
                {{date('d/m/y', strtotime($data->tgl_pinjam))}}
            </td>
            <td>
                {{date('d/m/y', strtotime($data->tgl_kembali))}}
            </td>
            <td>
                @if($data->status == 'pinjam')
                    <label class="badge badge-warning">Pinjam</label>
                @else
                    <label class="badge badge-success">Kembali</label>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
