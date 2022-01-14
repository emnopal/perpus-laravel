<?php

namespace App\Http\Controllers;

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
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

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
     * Display a listing of the resource.
     *
     * @return View|Factory|RedirectResponse|Application
     */
    public function buku(): View|Factory|RedirectResponse|Application
    {
        try {
            return view('laporan.buku');
        } catch (\Exception $e) {
            Alert::error('Terjadi Kesalahan!', $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display a listing of the resource as PDF.
     *
     * @return View|Factory|RedirectResponse|Application
     */
    public function bukuPdf(): Response|RedirectResponse
    {
        try {
            $datas = Buku::all();
            $pdf = PDF::loadView('laporan.pdf_buku', compact('datas'));
            return $pdf->download('laporan_buku_' . date('Y-m-d_H-i-s') . '.pdf');
        } catch (\Exception $e) {
            Alert::error('Oops..', 'Terjadi kesalahan saat mencetak laporan transaksi: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Display a listing of the resource as Excel.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function bukuExcel(Request $request): RedirectResponse
    {
        try {
            $nama = 'laporan_buku_' . date('Y-m-d_H-i-s');
            Excel::create($nama, function ($excel) use ($request) {
                $excel->sheet('Laporan Data Buku', function ($sheet) use ($request) {

                    $sheet->mergeCells('A1:H1');

                    // $sheet->setAllBorders('thin');
                    $sheet->row(1, function ($row) {
                        $row->setFontFamily('Calibri');
                        $row->setFontSize(11);
                        $row->setAlignment('center');
                        $row->setFontWeight('bold');
                    });

                    $sheet->row(1, array('LAPORAN DATA BUKU'));

                    $sheet->row(2, function ($row) {
                        $row->setFontFamily('Calibri');
                        $row->setFontSize(11);
                        $row->setFontWeight('bold');
                    });

                    $datas = Buku::all();

                    // $sheet->appendRow(array_keys($datas[0]));
                    $sheet->row($sheet->getHighestRow(), function ($row) {
                        $row->setFontWeight('bold');
                    });

                    $datasheet = array();
                    $datasheet[0] = array("NO", "JUDUL", "ISBN", "PENGARANG", "PENERBIT", "TAHUN TERBIT", "JUMLAH BUKU");
                    $i = 1;

                    foreach ($datas as $data) {

                        // $sheet->appendrow($data);
                        $datasheet[$i] = array($i,
                            $data['judul'],
                            $data['isbn'],
                            $data['pengarang'],
                            $data['penerbit'],
                            $data['tahun_terbit'],
                            $data['jumlah_buku'],
                        );

                        $i++;
                    }

                    $sheet->fromArray($datasheet);
                });

            })->export('xls');
            return back();
        } catch (\Exception $e) {
            Alert::error('Oops..', 'Terjadi kesalahan saat mencetak laporan transaksi: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Display a listing of the transaksi.
     *
     * @return View|Factory|RedirectResponse|Application
     */
    public function transaksi(): View|Factory|Application|RedirectResponse
    {
        try {
            return view('laporan.transaksi');
        } catch (\Exception $e) {
            Alert::error('Oops..', 'Terjadi kesalahan saat mencetak laporan transaksi: ' . $e->getMessage());
            return back();
        }
    }


    /**
     * Display a listing of the transaksi as pdf.
     *
     * @param Request $request
     * @return Response|RedirectResponse
     */
    // Response|RedirectResponse
    public function transaksiPdf(Request $request): Response|RedirectResponse
    {
        try {
            $q = Transaksi::query();

            if ($request->get('status')) {
                if ($request->get('status') == 'pinjam') {
                    $q->where('status', 'pinjam');
                } else {
                    $q->where('status', 'kembali');
                }
            }

            if (Auth::user()->role == 'member') {
                $q->where('id_anggota', Auth::user()->anggota->id);
            }

            $datas = $q->get();

//             return view('laporan.pdf_transaksi', compact('datas'));
            $pdf = PDF::loadView('laporan.pdf_transaksi', compact('datas'));
            return $pdf->download('laporan_transaksi_' . date('Y-m-d_H-i-s') . '.pdf');
        } catch (\Exception $e) {
            Alert::error('Oops..', 'Terjadi kesalahan saat mencetak laporan transaksi: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Display a listing of the transaksi as excel.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function transaksiExcel(Request $request): RedirectResponse
    {
        try {
            $nama = 'laporan_transaksi_' . date('Y-m-d_H-i-s');
            Excel::create($nama, function ($excel) use ($request) {
                $excel->sheet('Laporan Data Transaksi', function ($sheet) use ($request) {

                    $sheet->mergeCells('A1:H1');

                    // $sheet->setAllBorders('thin');
                    $sheet->row(1, function ($row) {
                        $row->setFontFamily('Calibri');
                        $row->setFontSize(11);
                        $row->setAlignment('center');
                        $row->setFontWeight('bold');
                    });

                    $sheet->row(1, array('LAPORAN DATA TRANSAKSI'));

                    $sheet->row(2, function ($row) {
                        $row->setFontFamily('Calibri');
                        $row->setFontSize(11);
                        $row->setFontWeight('bold');
                    });

                    $q = Transaksi::query();

                    if ($request->get('status')) {
                        if ($request->get('status') == 'pinjam') {
                            $q->where('status', 'pinjam');
                        } else {
                            $q->where('status', 'kembali');
                        }
                    }

                    if (Auth::user()->role == 'member') {
                        $q->where('id_anggota', Auth::user()->anggota->id);
                    }

                    $datas = $q->get();

                    // $sheet->appendRow(array_keys($datas[0]));
                    $sheet->row($sheet->getHighestRow(), function ($row) {
                        $row->setFontWeight('bold');
                    });
                    $datasheet = array();
                    $datasheet[0] = array("NO", "KODE TRANSAKSI", "BUKU", "PEMINJAM", "TGL PINJAM", "TGL KEMBALI", "STATUS", "KET");
                    $i = 1;
                    foreach ($datas as $data) {
                        // $sheet->appendrow($data);
                        $datasheet[$i] = array($i,
                            $data['kode_transaksi'],
                            $data->buku->judul,
                            Anggota::findOrFail($data->id_anggota)->nama,
                            date('d/m/y', strtotime($data['tgl_pinjam'])),
                            date('d/m/y', strtotime($data['tgl_kembali'])),
                            $data['status'],
                            $data['ket']
                        );
                        $i++;
                    }
                    $sheet->fromArray($datasheet);
                });
            })->export('xls');
            return back();
        } catch (\Exception $e) {
            Alert::error('Oops..', 'Terjadi kesalahan saat mencetak laporan transaksi: ' . $e->getMessage());
            return back();
        }
    }
}
