<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderCustomer;
use App\Models\OrderItem;
use App\Models\OrderTemp;
use App\Models\Pembayaran;
use App\Models\Rekening;
use App\Models\Tagihan;
use App\Models\Tiket;
use App\Models\TiketItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use PDF;

class OrderController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }
    
    public function view()
    {
        if(Auth::user()->status == 'Admin' || Auth::user()->status == 'Super Admin'){
            $order = Order::all();
        }else{
            $order = Order::where('users_id', Auth::id())->get();
        }
        // return $order;
        return view('order.view', compact('order'));
    }
    
    public function detail(Request $r)
    {
        $order = Order::find($r->id);
        $rekening = Rekening::all();
        
        if(Auth::id() == $order->users_id || Auth::user()->status == 'Super Admin' || (Auth::user()->customer != null && Auth::id() == $order->users_id)){
            return view('order.detail', compact('order','rekening'));
        }else{
            return 'Mohon maaf anda mengakses akun lain';
        }
    }
    
    public function form(Request $r)
    {
        
            if(Auth::user()->status == 'Admin' || Auth::user()->status == 'Super Admin'){
                $pre_tiket = Tiket::where('stok','>', 0)->get();
                $opt_tiket = [];
            }else{
                $pre_tiket = Tiket::where('id', $r->id)->get();
                $opt_tiket = Tiket::where('nama', 'not like','%Presale%')->where('nama','not like','%EarlyBird%')->where('nama','not like','%On The Spot%')->where('stok','>', 0)->get();
            }
        
        return view('order.form', compact('pre_tiket','opt_tiket'));
    }
    
    public function cart(Request $r)
    {
        
        $cart_item = OrderTemp::with('tiket')->where('users_id', Auth::id())->get();
        return compact('cart_item');
    }
    
    public function cartAdd(Request $r)
    {
        DB::beginTransaction();
        try {
            $tiket = Tiket::find($r->tiket_id);
            $c = OrderTemp::where('tiket_id', $r->tiket_id)->where('users_id', Auth::id())->get();
            if(count($c) == 0){
                $cart = new OrderTemp();
                $cart->users_id = Auth::id();
                $cart->tiket_id = $r->tiket_id;
                $cart->qty = $r->qty;
                $cart->harga = $tiket->harga;
                $cart->subtotal = $cart->qty * $cart->harga;
                $cart->save();
            }else{
                $cart = OrderTemp::where('tiket_id', $r->tiket_id)->where('users_id', Auth::id())->first();
                $cart->qty += $r->qty;
                $cart->harga = $tiket->harga;
                $cart->subtotal = $cart->qty * $cart->harga;
                $cart->save();
            }
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
    
    public function cartAddQty(Request $r)
    {
        DB::beginTransaction();
        try {
            $cart = OrderTemp::find($r->id);
            $tiket = Tiket::find($cart->tiket_id);
            
            $cart->qty += 1;
            $cart->harga = $tiket->harga;
            $cart->subtotal = $cart->qty * $cart->harga;
            $cart->save();
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
    
    public function cartMinQty(Request $r)
    {
        DB::beginTransaction();
        try {
            $cart = OrderTemp::find($r->id);
            $tiket = Tiket::find($cart->tiket_id);
            
            $cart->qty -= 1;
            $cart->harga = $tiket->harga;
            $cart->subtotal = $cart->qty * $cart->harga;
            if($cart->qty == 0){
                $cart->delete();
            }else{
                $cart->save();
            }
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }
    
    public function checkOut(Request $r)
    {
        DB::beginTransaction();
        try {
            $cart = OrderTemp::where('users_id', Auth::id())->get();
            
            $order = new Order();
            $order->tanggal = date('Y-m-d');
            $order->jam = date('H:i:s');
            $order->total = $cart->sum('subtotal');
            $order->users_id = Auth::id();
            $order->pembayaran = $r->pembayaran;
            $order->jumlah_tagihan = $r->jumlah_tagihan;
            $order->sisa_pembayaran = $order->total;
            $order->status = 'Menunggu konfirmasi pembayaran';
            $order->save();
            
            $order->no_transaksi = "TR-".$order->id.'.'.date('dmY');
            $order->save();

            if(Auth::user()->status == 'Super Admin' || Auth::user()->status == 'Admin' || Auth::user()->status == 'Agen'){
                $oc = new OrderCustomer();
                $oc->order_id = $order->id;
                $oc->nama_lengkap = $r->nama_lengkap;
                $oc->no_identitas = $r->no_identitas;
                $oc->jenis_identitas = $r->jenis_identitas;
                $oc->no_hp = str_replace("+","", $r->no_hp);
                $oc->email = $r->email;
                $oc->save();
            }elseif(Auth::user()->status == 'Customer'){
                $oc = new OrderCustomer();
                $oc->order_id = $order->id;
                $oc->nama_lengkap = Auth::user()->customer->nama_lengkap;
                $oc->no_identitas = Auth::user()->customer->no_identitas;
                $oc->jenis_identitas = Auth::user()->customer->jenis_identitas;
                $oc->no_hp = Auth::user()->customer->no_hp;
                $oc->email = Auth::user()->email;
                $oc->save();
            }
            
            
            $tagihan = new Tagihan();
            $tagihan->termin = ($order->pembayaran == 'LUNAS') ? 0 : 1;
            $tagihan->order_id = $order->id;
            $tagihan->nominal = $order->jumlah_tagihan;
            $tagihan->tempo = date( "Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))+(60*30));
            if((Auth::user()->status == 'Super Admin' || Auth::user()->status == 'Admin' || Auth::user()->status == 'Agen') && $order->pembayaran == 'LUNAS'){
                $tagihan->status = 'Pembayaran telah divalidasi';
                $tagihan->tanggal_approve = date('Y-m-d');
                $tagihan->upload = 1;
                $tagihan->approve = 1;
                $tagihan->save();

                $order = Order::find($tagihan->order_id);
                $order->sisa_pembayaran -= $tagihan->nominal;
                $order->status = $order->sisa_pembayaran == 0 ? 'Selesai' : '';
                $order->save();
            }else{
                $tagihan->status = 'Menunggu konfirmasi pembayaran';
                $tagihan->save();
            }
            
            
            
            $no = 1;
            foreach ($cart as $c) {
                $item = new OrderItem();
                $item->date = $order->date;
                $item->order_id = $order->id;
                $item->tiket_id = $c->tiket_id;
                $item->harga = $c->harga;
                $item->qty = $c->qty;
                $item->subtotal = $c->subtotal;
                $item->save();

                $tiket = Tiket::find($item->tiket_id);
                $tiket->stok -= $item->qty;
                $tiket->save();

                for ($i=0; $i < $item->qty; $i++) { 
                    $ti = new TiketItem();
                    $ti->tiket_id = $item->tiket_id;
                    $ti->order_id = $order->id;
                    $ti->save();
                    $ti->no_tiket = 'LUV.'.$ti->id.'.'.$order->no_transaksi;
                    $ti->save();
                }
                
                $c->delete();
            }
            
            DB::commit();
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function tiketExport(Request $r)
    {
        $order = Order::find($r->order_id);
        $pdf = FacadePdf::loadView('order.tiket-export', compact('order'));
        return $pdf->stream();
    }
}
