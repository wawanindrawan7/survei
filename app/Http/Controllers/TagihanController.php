<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Tagihan;
use App\Models\TagihanRekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagihanController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    
    public function view(Request $r)
    {
        // return $r->all();
        $not_upload = Tagihan::where('upload', 0)->where('approve', 0)->get();
        $not_approve = Tagihan::where('upload', 1)->where('approve', 0)->get();
        $approve = Tagihan::where('approve', 1)->get();

        $tab = $r->has('tab') ?  $r->tab : 'not_approve';

        return view('tagihan.view', compact('not_upload','not_approve','approve','tab'));
    }

    public function confirm(Request $r)
    {
        DB::beginTransaction();
        try {
            $file = $r->file('file');

            $tg = Tagihan::find($r->tagihan_id);
            $tg->bukti_pembayaran = 'file/'.date('YmdHis').'-'.$file->getClientOriginalName();
            $tg->status = 'Menunggu validasi pembayaran';
            $tg->upload = 1;
            $tg->save();

            $tg_rek = new TagihanRekening();
            $tg_rek->tagihan_id = $tg->id;
            $tg_rek->rekening_id = $r->rekening_id;
            $tg_rek->save();

            $file->move('file', $tg->bukti_pembayaran);

            DB::commit();
            return 'success';

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function validasi(Request $r)
    {
        DB::beginTransaction();
        try {
            
            $tg = Tagihan::find($r->id);
            $tg->status = 'Pembayaran telah divalidasi';
            $tg->approve = 1;
            $tg->tanggal_approve = date('Y-m-d');
            $tg->save();

            $order = Order::find($tg->order_id);
            $order->sisa_pembayaran -= $tg->nominal;
            $order->status = $order->sisa_pembayaran == 0 ? 'Selesai' : '';
            $order->save();

            if($order->sisa_pembayaran > 0){
                $tagihan = new Tagihan();
                $tagihan->termin = 2;
                $tagihan->order_id = $order->id;
                $tagihan->nominal = $order->sisa_pembayaran;
                $tagihan->tempo = "2022-09-10 12:00";
                $tagihan->status = 'Menunggu konfirmasi pembayaran';
                $tagihan->save();

                $order->status = 'Menunggu konfirmasi pembayaran Termin '.$tagihan->termin;
                $order->save();
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
