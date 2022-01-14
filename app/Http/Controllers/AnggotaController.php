<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class AnggotaController extends Controller
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
            $data = Anggota::get();
            return view('anggota.index', compact('data'));
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
            $users = User::WhereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('anggota')
                    ->whereRaw('anggota.user_id = users.id');
            })->get();
            return view('anggota.create', compact('users'));
        } catch (\Exception $e) {
            Alert::error('Ups..', 'Terjadi kesalahan!: '. $e->getMessage());
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
            $count = Anggota::where('email', $request->input('email'))->count();

            if ($count > 0) {
                Session::flash('message', 'Email sudah digunakan, silahkan gunakan email lain.');
                Session::flash('message_type', 'danger');
                return redirect()->to('anggota');
            }

            $this->validate($request, [
                'nama' => 'required|string|max:255',
                'alamat' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:anggota',
                'telp' => 'required|string|min:10|max:20',
            ]);

            Anggota::create($request->all());

            Session::flash('message', 'Data berhasil ditambahkan.');
            Session::flash('message_type', 'success');
            return redirect()->route('anggota.index');

        } catch (\Exception $e) {
            Alert::error('Ups.. Gagal mengambil data', 'Terjadi kesalahan!' . $e->getMessage());
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param mixed $id
     * @return View|Factory|Application|RedirectResponse
     */
    public function show(mixed $id): Factory|View|RedirectResponse|Application
    {
        try {
            if (Auth::user()->role == 'member' && Auth::user()->id != $id) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
            }
            $data = Anggota::findOrFail($id);
            $user = User::findOrFail($data->user_id);
            return view('anggota.show', compact('data', 'user'));
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
            if (Auth::user()->role == 'member' && Auth::user()->id != $id) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
            }
            $data = Anggota::findOrFail($id);
            $users = User::get();
            return view('anggota.edit', compact('data', 'users'));
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
            $data = Anggota::findOrFail($id);

            try {
                $data->nama = $request->input('nama');
                try {
                    $data->email = $request->input('email');
                } catch (\Exception $e) {
                    Session::flash('message', 'Email sudah digunakan, silahkan gunakan email lain.');
                    Session::flash('message_type', 'danger');
                    return redirect()->back();
                }
                $data->telp = $request->input('telp');
                $data->alamat = $request->input('alamat');
                $data->update();
                Session::flash('message', 'Data berhasil diubah.');
                Session::flash('message_type', 'success');
                return redirect()->to('anggota');
            } catch (\Exception $e) {
                Alert::error('Oopss..', 'Terjadi kesalahan saat mengubah data.');
                return redirect()->back();
            }
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
            Anggota::find($id)->delete();
            Alert::success('Data berhasil dihapus.', 'Berhasil!');
            return redirect()->route('anggota.index');
        } catch (\Exception $e) {
            Alert::error('Oopss..', 'Terjadi kesalahan saat menghapus data.');
            return back();
        }
    }

}
