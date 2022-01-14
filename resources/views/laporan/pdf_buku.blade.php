<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{ asset('css/laporan_buku.css') }}">>
    <title>Laporan Data Buku</title>
</head>
<body>
<h1 class="center">LAPORAN DATA BUKU</h1>
<table id="pseudo-demo">
    <thead>
    <tr>
        <th>
            Judul
        </th>
        <th>
            ISBN
        </th>
        <th>
            Pengarang
        </th>
        <th>
            Penerbit
        </th>
        <th>
            Tahun
        </th>
        <th>
            Stok
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($datas as $data)
        <tr>
            <td class="py-1">
                {{$data->judul}}
            </td>
            <td>
                {{$data->isbn}}
            </td>
            <td>
                {{$data->pengarang}}
            </td>
            <td>
                {{$data->penerbit}}
            </td>
            <td>
                {{$data->tahun_terbit}}
            </td>
            <td>
                {{$data->jumlah_buku}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
