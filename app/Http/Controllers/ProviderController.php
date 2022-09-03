<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProviderController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function view()
    {
        $provider = Provider::all();
        return view('provider.view', compact('provider'));
    }

    public function create(Request $r)
    {
        DB::beginTransaction();
        try {
            $p = new Provider();
            $p->nama = $r->nama;
            $p->save();
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
            $p = Provider::find($r->id);
            $p->nama = $r->nama;
            $p->save();
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
            $p = Provider::find($r->id);
            $p->delete();
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
}
