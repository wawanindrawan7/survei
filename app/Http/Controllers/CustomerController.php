<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    // public function view(){
    //     $user = User::all();
    //     return view('customer.profile', compact('user'));
    // }

    public function create(Request $r)
    {
        DB::beginTransaction();
        try {

            $file = $r->hasFile('file') ?  $r->file('file') : null;

            $p = new Customer();
            $p->nama_lengkap = $r->nama_lengkap;
            $p->no_identitas = $r->no_identitas;
            $p->jenis_identitas = $r->jenis_identitas;
            $p->no_hp = $r->no_hp;
            if($file != null){
                $p->foto_ktm = 'file/' . date('YmdHis') . '-' . $file->getClientOriginalName();
            }
            $p->provider_id = $r->provider_id;
            $p->users_id = Auth::id();
            $p->save();

            if($file != null){
                $file->move('file', $p->foto_ktm);
            }




            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
}
