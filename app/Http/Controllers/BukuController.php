<?php

namespace App\Http\Controllers;

use App\Exports\FormatBuku;
use App\Helper\Helper;
use App\Imports\ImportBuku;
use App\Models\Buku;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Excel as ExcelWriter;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BukuController extends Controller
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
     * @return View|Factory|Application|RedirectResponse
     */
    public function index(): View|Factory|Application|RedirectResponse
    {
        try {
            if (Auth::user()->role == 'member') {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
            }
            $data = Buku::get();
            return view('buku.index', compact('data'));
        } catch (\Exception $e) {
            Alert::error('Ups.. Gagal mengambil data', 'Terjadi kesalahan!');
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View|Factory|Application|RedirectResponse
     */
    public function create(): View|Factory|Application|RedirectResponse
    {
        try {
            if (Auth::user()->role == 'member') {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
            }
            return view('buku.create');
        } catch (\Exception $e) {
            Alert::error('Ups.. Gagal mengambil data', 'Terjadi kesalahan!');
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        try {

            $this->validate($request, [
                'judul' => 'required|string|max:255',
                'isbn' => 'required|string'
            ]);

            $cover = Helper::fileUpload($request->file('cover'), 'images/buku');


            Buku::create([
                'judul' => $request->get('judul'),
                'isbn' => $request->get('isbn'),
                'pengarang' => $request->get('pengarang'),
                'penerbit' => $request->get('penerbit'),
                'tahun_terbit' => $request->get('tahun_terbit'),
                'jumlah_buku' => $request->get('jumlah_buku'),
                'deskripsi' => $request->get('deskripsi'),
                'cover' => $cover
            ]);
            Session::flash('message', 'Data berhasil ditambahkan.');
            Session::flash('message_type', 'success');
            return redirect()->route('buku.index');

        } catch (\Exception $e) {
            Alert::error('Ups.. Gagal menambah data', 'Terjadi kesalahan!' . $e->getMessage());
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param mixed $id
     * @return View|Factory|Application|RedirectResponse
     */
    public function show(mixed $id): View|Factory|Application|RedirectResponse
    {
        try {
            if (Auth::user()->role == 'member' && Auth::user()->id != $id) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
            }
            $data = Buku::findOrFail($id);
            return view('buku.show', compact('data'));
        } catch (\Exception $e) {
            Alert::error('Ups.. Gagal mengambil data', 'Terjadi kesalahan!');
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param mixed $id
     * @return View|Factory|Application|RedirectResponse
     */
    public function edit(mixed $id): View|Factory|RedirectResponse|Application
    {
        try {
            if (Auth::user()->role == 'member') {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
            }
            $data = Buku::findOrFail($id);
            return view('buku.edit', compact('data'));
        } catch (\Exception $e) {
            Alert::error('Ups.. Gagal mengambil data', 'Terjadi kesalahan!');
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param mixed $id
     * @return RedirectResponse
     */
    public function update(Request $request, mixed $id): RedirectResponse
    {
        try {

            if ($request->file('cover')){
                $cover = Helper::fileUpload($request->file('cover'), 'images/buku');
            } else {
                $data = Buku::findOrFail($id);
                $cover = Helper::fileUpload(filename: '/'.$data->cover);
            }

            Buku::find($id)->update([
                'judul' => $request->get('judul'),
                'isbn' => $request->get('isbn'),
                'pengarang' => $request->get('pengarang'),
                'penerbit' => $request->get('penerbit'),
                'tahun_terbit' => $request->get('tahun_terbit'),
                'jumlah_buku' => $request->get('jumlah_buku'),
                'deskripsi' => $request->get('deskripsi'),
                'cover' => $cover
            ]);

            Session::flash('message', 'Data berhasil diubah.');
            Session::flash('message_type', 'success');

            return redirect()->route('buku.index');
        } catch (\Exception $e) {
            Alert::error('Oopss..', 'Terjadi kesalahan saat mengubah data.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param mixed $id
     * @return RedirectResponse
     */
    public function destroy(mixed $id): RedirectResponse
    {
        try {
            Buku::find($id)->delete();

            Session::flash('message', 'Data berhasil dihapus.');
            Session::flash('message_type', 'success');

            return redirect()->route('buku.index');
        } catch (\Exception $e) {
            Alert::error('Oopss..', 'Terjadi kesalahan saat menghapus data.');
            return back();
        }
    }

    /**
     * Generate format of book
     *
     * @return Response|BinaryFileResponse|RedirectResponse
     */
    public function format(): Response|BinaryFileResponse|RedirectResponse
    {
        try {
            $data = [
                [
                    'judul',
                    'isbn',
                    'pengarang',
                    'penerbit',
                    'tahun_terbit',
                    'jumlah_buku',
                    'deskripsi'
                ]
            ];

            $fileName = 'format-buku';

            $export = new FormatBuku($data);

            Alert::success('Berhasil', 'Format data buku telah diunduh.');
            return Excel::download($export, $fileName . date('Y-m-d_H-i-s').'.xlsx', ExcelWriter::XLSX);
        } catch (\Exception $e) {
            Alert::error('Oopss..', 'Terjadi kesalahan saat mengambil data.');
            return back();
        }
    }

    /**
     * Import data from format book
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function import(Request $request): RedirectResponse
    {
        try {
            $this->validate($request, [
                'importBuku' => 'required'
            ]);

            if ($request->hasFile('importBuku')) {
                $path = $request->file('importBuku')->getRealPath();

//                $data = Excel::load($path, function ($reader) {})->get();
                $data = Excel::import(import: new ImportBuku, filePath: $path, readerType: ExcelWriter::XLSX);

//                if (!empty($a) && $a->count()) {
//                    foreach ($a as $key => $value) {
//                        $insert[] = [
//                            'judul' => $value->judul,
//                            'isbn' => $value->isbn,
//                            'pengarang' => $value->pengarang,
//                            'penerbit' => $value->penerbit,
//                            'tahun_terbit' => $value->tahun_terbit,
//                            'jumlah_buku' => $value->jumlah_buku,
//                            'deskripsi' => $value->deskripsi,
//                            'cover' => NULL
//                        ];
//
//                        Buku::create($insert[$key]);
//                    }
//                };
            }
            Alert::success('Berhasil.', 'Data telah diimport!');
            return back();
        } catch (\Exception $e) {
            Alert::error('Oopss..', 'Terjadi kesalahan saat mengimport data.'.$e->getMessage());
            return back();
        }
    }

}
