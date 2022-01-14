<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
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
            $data = User::get();
            return view('auth.user', compact('data'));
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
            return view('auth.register');
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
            $count = User::where('username', $request->input('username'))->count();
            $mail_count = User::where('email', $request->input('email'))->count();

            if ($count > 0 && $mail_count > 0) {
                Session::flash('message', 'Username atau email sudah digunakan, silahkan gunakan username atau email lain.');
                Session::flash('message_type', 'danger');
                return redirect()->to('/user');
            }

            $this->validate($request, [
                'name' => 'required|string|max:255',
                'username' => 'required|unique:users|string|max:20',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $gambar = Helper::fileUpload($request->file('gambar'), 'images/user/');

            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'username' => $request->input('username'),
                'password' => bcrypt($request->input('password')),
                'avatar' => $gambar,
                'role' => $request->input('role'),
            ]);

            Session::flash('message', 'Data berhasil ditambahkan.');
            Session::flash('message_type', 'success');
            return redirect()->route('user.index');

        } catch (\Exception $e) {
            Alert::error('Ups..', 'Terjadi kesalahan!' . $e->getMessage());
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
            $data = User::findOrFail($id);
            return view('auth.show', compact('data'));
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
            $data = User::findOrFail($id);
            return view('auth.edit', compact('data'));
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
            $data = User::findOrFail($id);

            $data->avatar = Helper::fileUpload($request->file('gambar'), 'images/user/');

            $data->name = $request->input('name');
            $data->email = $request->input('email');

            $data->role = $request->input('role');

            if(bcrypt(($request->input('password'))) == $data->password) {
                $data->update();

                Session::flash('message', 'Data berhasil diubah.');
                Session::flash('message_type', 'success');

                return redirect()->route('user.index');
            } else {
                throw new \Exception('Password salah');
            }
        } catch (\Exception $e) {
            Alert::error('Oopss..', 'Terjadi kesalahan saat mengubah data.'. $e->getMessage());
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param mixed $id
     * @return View|Factory|Application|RedirectResponse
     */
    public function editMail(mixed $id): View|Factory|RedirectResponse|Application
    {
        try {
            if (Auth::user()->role == 'member' && Auth::user()->id != $id) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
            }
            $data = User::findOrFail($id);
            return view('auth.mail', compact('data'));
        } catch (\Exception $e) {
            Alert::error('Ups.. Gagal mengambil data', 'Terjadi kesalahan!'. $e->getMessage());
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
    public function updateMail(Request $request, mixed $id): RedirectResponse
    {
        try {
            $data = User::findOrFail($id);

            if ($data->email != $request->input('email')){
                $data->email = $request->input('email');
            } else {
                throw new \Exception('Email sudah pernah dipakai sebelumnya');
            }

            if(password_verify(($request->input('password')), $data->password)) {
                $data->update();

                Session::flash('message', 'Data berhasil diubah.');
                Session::flash('message_type', 'success');

                return redirect()->route('user.index');
            } else {
                throw new \Exception('Password salah');
            }

        } catch (\Exception $e) {
            Alert::error('Oopss..', 'Terjadi kesalahan saat mengubah data: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param mixed $id
     * @return View|Factory|Application|RedirectResponse
     */
    public function editUsername(mixed $id): View|Factory|RedirectResponse|Application
    {
        try {
            if (Auth::user()->role == 'member' && Auth::user()->id != $id) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
            }
            $data = User::findOrFail($id);
            return view('auth.username', compact('data'));
        } catch (\Exception $e) {
            Alert::error('Ups.. Gagal mengambil data', 'Terjadi kesalahan!'. $e->getMessage());
            return back();
        }
    }

    public function updateUsername(Request $request, mixed $id): RedirectResponse
    {
        try {
            $data = User::findOrFail($id);

            $data->username = $request->input('username');

            if(password_verify(($request->input('password')), $data->password)) {
                $data->update();

                Session::flash('message', 'Data berhasil diubah.');
                Session::flash('message_type', 'success');

                return redirect()->route('user.index');
            } else {
                throw new \Exception('Password salah');
            }

        } catch (\Exception $e) {
            Alert::error('Oopss..', 'Terjadi kesalahan saat mengubah data.');
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param mixed $id
     * @return View|Factory|Application|RedirectResponse
     */
    public function editPassword(mixed $id): View|Factory|RedirectResponse|Application
    {
        try {
            if (Auth::user()->role == 'member' && Auth::user()->id != $id) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
            }
            $data = User::findOrFail($id);
            return view('auth.password', compact('data'));
        } catch (\Exception $e) {
            Alert::error('Ups.. Gagal mengambil data', 'Terjadi kesalahan!'. $e->getMessage());
            return back();
        }
    }

    public function updatePassword(Request $request, mixed $id): RedirectResponse
    {
        try {
            $data = User::findOrFail($id);

            if(password_verify(($request->input('old_password')), $data->password)) {
                $data->password = bcrypt($request->input('new_password'));
                $data->update();

                Session::flash('message', 'Data berhasil diubah.');
                Session::flash('message_type', 'success');

                return redirect()->route('user.index');
            } else {
                throw new \Exception('Password salah');
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
    public function destroy($id): RedirectResponse
    {
        try {
            if (Auth::user()->id != $id) {
                $data = User::findOrFail($id);
                $data->delete();
                Session::flash('message', 'Data berhasil dihapus.');
                Session::flash('message_type', 'success');
                return redirect()->to('user');
            }
            Session::flash('message', 'Akun tidak dapat dihapus.');
            Session::flash('message_type', 'danger');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Oopss..', 'Terjadi kesalahan saat menghapus akun.');
            return back();
        }
    }
}
