<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengeluaranController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function view(){
        $pengeluaran = Pengeluaran::all();
        return view('pengeluaran.view', compact('pengeluaran'));
    }

    public function create(Request $r)
    {
        DB::beginTransaction();
        try {
            $p = new Pengeluaran();
            $p->tanggal = date('Y-m-d', strtotime($r->tanggal));
            $p->jam = Carbon::now();
            $p->nama = $r->nama;
            $p->biaya = $r->biaya;
            $p->supplier = $r->supplier;
            $p->users_id = Auth::id();
            $p->save();
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function delete(Request $r)
    {
        DB::beginTransaction();
        try {
            $p = Pengeluaran::find($r->id);
            $p->delete();
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

}
