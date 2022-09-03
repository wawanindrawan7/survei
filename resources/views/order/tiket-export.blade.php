<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{!! $order->no_transaksi !!}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
		table tr td,
		table tr th{
			font-size: 8pt;
            padding: 5px;
		}

        @page { margin-left: 0px; margin-right: 0px;margin-top: 24px; margin-bottom: 10px; }
        body { margin-left: 0px; margin-right: 0px;margin-top: 5px; margin-bottom: 10px;}

        * {
            font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; 
        }

        .page_break { page-break-before: always; }

        .card
            {
                height: 100px;
                width: 100%;
                margin: 0 auto;
                background: #fffdfd;
                border-radius: 4px;
            }

        .col-2{
        width: 50px;
        display: block;
        float: right;
        }
        .col-4 {
        width: 50px;
        display: block;
        float: left;
        }
        .col-8 {
        width: 80%;
        display: block;
        float: left;
        }
	</style>
</head>
<body style="margin-top: 10px;">
    <div class="container">
        <div class="row">

            <div class="col-4">
                @php
                    $qrcode = base64_encode(QrCode::size(120)->generate($order->no_transaksi));
                @endphp
                <img src="data:image/png;base64, {!! $qrcode !!}">
            </div>
        
            <div class="col-8">
                <p style="text-align: center">
                    <img src="{{ asset('luv.jpeg') }}" style="width: 40%" alt="">
                    <br>
                    <b>Bukti Pembelian Tiket Konser NOAH</b>
                    {{-- di Parkir Timur Lombok Epicentrum Mall --}}
                </p>
            </div>
            <div class="col-4">
                <div class="card" style="background: {{ $order->status == 'Selesai' ? 'green' : 'red' }}; width: 100px;">
                    <p style="color: #fffdfd; text-align: center;margin-top: 38px;">
                        <b style="text-align: center;">{{ $order->status == 'Selesai' ? 'Lunas' : 'Belum Lunas' }}</b>
                    </p>
                </div>
            </div>
    </div>
    <br><br><br><br><br><br>

    <table class="table">
        <tr>
            <td width="20%">No. Transaksi</td>
            <td width="1%">:</td>
            <td>{{ $order->no_transaksi }}</td>
            <td width="10%">Loket :</td>
            <td>{!! $order->users->status == 'Customer' ? 'Online' : "<b>".$order->users->name."</b>" !!}</td>
        </tr>
        <tr>
            <td>Kategori</td>
            <td>:</td>
            <td colspan="3">
                @foreach ($order->orderItem as $item)
                    {!! $item->tiket->nama." (".$item->qty."), " !!}
                @endforeach
            </td>
        </tr>
    </table>

    <p>Info Contact_</p>
    <table class="table">
        <tr>
            <td width="20%">Nama</td>
            <td width="1%">:</td>
            <td>{{ $order->orderCustomer->nama_lengkap }}</td>
        </tr>
        <tr>
            <td>No.ID</td>
            <td>:</td>
            <td>{{ $order->orderCustomer->no_identitas.' ('.$order->orderCustomer->jenis_identitas.')'  }}</td>
        </tr>
        <tr>
            <td>No.Hp</td>
            <td>:</td>
            <td>{{ $order->orderCustomer->no_hp }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>:</td>
            <td>{{ $order->orderCustomer->email }}</td>
        </tr>
    </table>
    <p style="text-align: left;font-size: 8pt;">* Mohon bukti ini disimpan dengan baik untuk proses penukaran gelang*
        <img src="{{ asset('moment.jpeg') }}" style="width: 20%;float:right;" alt=""></p>
    <p style="text-align: left;font-size: 8pt;">Terimakasih</p>
       

      
        
    </div>
</body>