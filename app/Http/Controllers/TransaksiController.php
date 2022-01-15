<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Transaksi;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class TransaksiController extends Controller
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
                $data = Transaksi::where('anggota_id', Auth::user()->anggota->id)->get();
            } else {
                $data = Transaksi::get();
            }
            return view('transaksi.index', compact('data'));
        } catch (\Exception $e) {
            Alert::error('Ups.. Gagal mengambil data', 'Terjadi kesalahan! ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function create(): Application|Factory|View|RedirectResponse
    {
        try {
            $getRow = Transaksi::orderBy('id', 'DESC')->get();
            $rowCount = $getRow->count();

            $lastId = $getRow->first();

            $kode = "TR00001";

            if ($rowCount > 0) {
                if ($lastId->id < 9) {
                    $kode = "TR0000" . '' . ($lastId->id + 1);
                } else if ($lastId->id < 99) {
                    $kode = "TR000" . '' . ($lastId->id + 1);
                } else if ($lastId->id < 999) {
                    $kode = "TR00" . '' . ($lastId->id + 1);
                } else if ($lastId->id < 9999) {
                    $kode = "TR0" . '' . ($lastId->id + 1);
                } else {
                    $kode = "TR" . '' . ($lastId->id + 1);
                }
            }
            $buku = Buku::where('jumlah_buku', '>', 0)->get();
            $anggota = Anggota::get();
            return view('transaksi.create', compact('buku', 'kode', 'anggota'));
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
                'kode_transaksi' => 'required|string|max:255',
                'tgl_pinjam' => 'required',
                'tgl_kembali' => 'required',
                'buku_id' => 'required',
                'id_anggota' => 'required',
            ]);

            $transaksi = Transaksi::create([
                'kode_transaksi' => $request->get('kode_transaksi'),
                'tgl_pinjam' => $request->get('tgl_pinjam'),
                'tgl_kembali' => $request->get('tgl_kembali'),
                'buku_id' => $request->get('buku_id'),
                'id_anggota' => $request->get('id_anggota'),
                'ket' => $request->get('ket'),
                'status' => 'pinjam'
            ]);

            $transaksi->buku->where('id', $transaksi->buku_id)
                ->update([
                    'jumlah_buku' => ($transaksi->buku->jumlah_buku - 1),
                ]);

            alert()->success('Berhasil.', 'Data telah ditambahkan!');
            return redirect()->route('transaksi.index');
        } catch (\Exception $e) {
            Alert::error('Ups.. Gagal mengambil data', 'Terjadi kesalahan! ' . $e->getMessage());
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
            $data = Transaksi::findOrFail($id);
            if ((Auth::user()->role == 'member') && (Auth::user()->anggota->id != $data->id_anggota)) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
            }
            return view('transaksi.show', compact('data'));
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
    public function edit(mixed $id): View|Factory|Application|RedirectResponse
    {
        try {
            $data = Transaksi::findOrFail($id);

            if ((Auth::user()->role == 'member') && (Auth::user()->anggota->id != $data->id_anggota)) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
            }

            return view('buku.edit', compact('data'));
        } catch (\Exception $e) {
            Alert::error('Ups.. Gagal mengambil data', 'Terjadi kesalahan!');
            return redirect()->to('/');
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
            $transaksi = Transaksi::find($id);

            $transaksi->update([
                'status' => 'kembali'
            ]);

            $transaksi->buku->where('id', $transaksi->buku->id)
                ->update([
                    'jumlah_buku' => ($transaksi->buku->jumlah_buku + 1),
                ]);

            alert()->success('Berhasil.', 'Data telah diubah!');
            return redirect()->route('transaksi.index');
        } catch (\Exception $e) {
            Alert::error('Ups.. Gagal mengambil data', 'Terjadi kesalahan!');
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
            Transaksi::find($id)->delete();
            alert()->success('Berhasil.', 'Data telah dihapus!');
            return redirect()->route('transaksi.index');
        } catch (\Exception $e) {
            Alert::error('Ups.. Gagal mengambil data', 'Terjadi kesalahan!');
            return back();
        }
    }
}
