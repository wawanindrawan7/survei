<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TiketController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function view(){
        if(Auth::user()->status == 'Super Admin'){
            $tiket = Tiket::all();
            return view('tiket.view', compact('tiket'));
        }else{
            return redirect('home');
        }
    }

    public function create(Request $r)
    {
        DB::beginTransaction();
        try {
            $foto = $r->file('foto');
            $p = new Tiket();
            $p->nama = $r->nama;
            $p->deskripsi = $r->deskripsi;
            $p->kategori = $r->kategori;
            $p->stok = $r->stok;
            $p->min_order = $r->min_order;
            $p->harga = $r->harga;
            $p->foto = 'file/'.date('YmdHis').'-'.$foto->getClientOriginalName();
            $p->save();
            $foto->move('file', $p->foto);
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function update(Request $r)
    {
        DB::beginTransaction();
        try {
            $foto = $r->file('foto');
            
            $p = Tiket::find($r->id);
            $p->nama = $r->nama;
            $p->deskripsi = $r->deskripsi;
            $p->kategori = $r->kategori;
            $p->stok = $r->stok;
            $p->min_order = $r->min_order;
            $p->harga = $r->harga;
            if($foto != null){
                $p->foto = 'file/'.date('YmdHis').'-'.$foto->getClientOriginalName();
            }
            $p->save();

            if($foto != null){
                $foto->move('file', $p->foto);
            }
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function delete(Request $r)
    {
        DB::beginTransaction();
        try {
            $p = Tiket::find($r->id);
            $p->delete();
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
}
