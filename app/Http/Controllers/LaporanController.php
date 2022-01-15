<?php

namespace App\Http\Controllers;

use App\Exports\TransaksiBuku;
use App\Exports\TransaksiExcel;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Excel as ExcelWriter;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

// TODO: Fix the laporan controller

class LaporanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the transaksi as pdf.
     *
     * @param Request $request
     * @return BinaryFileResponse|Response|RedirectResponse|View|Factory|Application
     */
    public function laporan(Request $request): BinaryFileResponse|Response|RedirectResponse|View|Factory|Application
    {
        try {

            if ($request->get('data') == 'transaksi') {

                $nama = 'laporan_transaksi_' . date('Y-m-d_H-i-s');

                $q = Transaksi::query();

                if ($request->get('status')) {
                    if ($request->get('status') == 'pinjam') {
                        $nama .= '_pinjam';
                        $q->where('status', 'pinjam');
                    } else {
                        $nama .= '_kembali';
                        $q->where('status', 'kembali');
                    }
                }

                if (Auth::user()->role == 'member') {
                    $q->where('anggota_id', Auth::user()->anggota->id);
                }

                $datas = $q->get();

                Alert::success('Berhasil', 'Laporan transaksi berhasil dicetak');

                if ($request->get('format') == 'pdf') {
                    $pdf = PDF::loadView('laporan.pdf_transaksi', compact('datas'));
                    return $pdf->download($nama . '.pdf');
                } else if ($request->get('format') == 'excel') {
                    return Excel::download(new TransaksiExcel(compact('datas')), $nama . '.xlsx', ExcelWriter::XLSX);
                } else {
                    return Excel::download(new TransaksiExcel(compact('datas')), $nama . '.csv', ExcelWriter::CSV);
                }

            } elseif ($request->get('data') == 'buku') {

                $nama = 'laporan_buku_' . date('Y-m-d_H-i-s');

                $datas = Buku::all();

                if ($request->get('format') == 'pdf') {
                    $pdf = PDF::loadView('laporan.pdf_buku', compact('datas'));
                    return $pdf->download($nama . '.pdf');
                } else if ($request->get('format') == 'excel') {
                    return Excel::download(new TransaksiBuku(compact('datas')), $nama . '.xlsx', ExcelWriter::XLSX);
                } else {
                    return Excel::download(new TransaksiBuku(compact('datas')), $nama . '.csv', ExcelWriter::CSV);
                }

            } else {
                try {
                    return view('laporan.cetak');
                } catch (\Exception $e) {
                    Alert::error('Oops..', 'Terjadi kesalahan saat mencetak laporan transaksi: ' . $e->getMessage());
                    return back();
                }
            }

        } catch (\Exception $e) {
            Alert::error('Oops..', 'Terjadi kesalahan saat mencetak laporan transaksi: ' . $e->getMessage());
            return back();
        }
    }
}
