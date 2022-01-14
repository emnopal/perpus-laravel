<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Transaksi;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return Factory|View|Application|RedirectResponse
     */
    public function index(): Factory|View|Application|RedirectResponse
    {
        try
        {
            $transaksi = Transaksi::get();
            $anggota = Anggota::get();
            $buku = Buku::get();

//            if (Auth::user()->role == 'member'){
//                $data = Transaksi::where('status', 'pinjam')
//                    ->where('user_id', Auth::user()->anggota->id)
//                    ->get();
//            } else {
//                $data = Transaksi::where('status', 'pinjam')->get();
//            }
            $data = Transaksi::where('status', 'pinjam')->get();
            return view('home', compact('data', 'transaksi', 'anggota', 'buku'));
        } catch (\Exception $e) {
            Alert::info('Oopss..', 'Ada error yang terjadi: '. $e->getMessage());
            return back();
        }
    }
}
