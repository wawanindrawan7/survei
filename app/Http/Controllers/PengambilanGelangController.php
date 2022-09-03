<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengambilanGelangController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function view(Request $r)
    {
        $belum_diambil = Order::where('status', 'Selesai')->where('pengambilan_gelang', 0)->get();
        $sudah_diambil = Order::where('pengambilan_gelang', 1)->get();

        $tab = $r->has('tab') ?  $r->tab : 'belum_diambil';
        return view('pengambilan-tiket.view', compact('belum_diambil','sudah_diambil','tab'));
    }

    public function submit(Request $r)
    {
        DB::beginTransaction();
        try {
            $order = Order::find($r->id);
            $order->pengambilan_gelang = 1;
            $order->tgl_pengambilan = date('Y-m-d');
            $order->save();

            foreach ($order->tiketItem as $item) {
                $item->pengambilan = 1;
                $item->date = date('Y-m-d');
                $item->time = date('H:i:s');
                $item->save();
            }

            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $th->getMessage();
        }
    }
}
