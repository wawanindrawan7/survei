@extends('layouts.master')
@section('content')
<div class="col-md-12">
    <div class="modal fade" id="validasi-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
               
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Validasi Pembayaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="v_tg_id" name="tagihan_id">
                        <div class="form-group form-group-default">
                            <label for="exampleFormControlInput1">Rekening Tujuan</label>
                            <input type="text" readonly id="v_rekening" class="form-control">
                        </div>

                        <div class="form-group form-group-default">
                            <label for="exampleFormControlInput1">Foto</label>
                            <img src="" id="v_bukti_pembayaran" alt="" class="form-control">
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="btn-submit-validasi" class="btn btn-primary">Submit</button>
                    </div>
                
            </div>
        </div>
    </div>

    <div class="card card-with-nav">
        <div class="card-header">
            <div class="row row-nav-line">
                <ul class="nav nav-tabs nav-line nav-color-secondary w-100 pl-4" role="tablist">
                    
                    <li class="nav-item submenu"> <a class="nav-link {{ $tab == 'belum_diambil' ? 'active show' : '' }} btn-tab" data-tab="belum_diambil" data-toggle="tab" href="#belum_diambil" role="tab" aria-selected="false">Belum Diambil</a> </li>
                    <li class="nav-item submenu"> <a class="nav-link {{ $tab == 'sudah_diambil' ? 'active show' : '' }} btn-tab" data-tab="sudah_diambil" data-toggle="tab" href="#sudah_diambil" role="tab" aria-selected="false">Sudah Diambil</a> </li>
                    
                </ul>
            </div>
            <div class="card-head-row mt-2">
                {{-- <div class="card-title">Vendors List</div> --}}
                <div class="card-tools">
                    <div class="col-md-2">

                        <a href="#" class="btn btn-info btn-border btn-round btn-sm mr-2" data-toggle="modal"
                        data-target="#create-pengeluaran">
                        <span class="btn-label">
                            <i class="fas fa-qrcode"></i>
                        </span>
                        Scan QR
                    </a>
                </div>
                </div>
            </div>


        </div>
        <div class="card-body">
            <div class="tab-content mt-2 mb-3">
                <div class="tab-pane fade {{ $tab == 'belum_diambil' ? 'active show' : '' }}" id="belum_diambil" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="table-responsive">
                        <table id="dt1" class="display table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="1%">No.</th>
                                    <th width="5%">No.Transaksi</th>
                                    <th width="5%">Customer</th>
                                    <th width="5%">Jumlah Tiket</th>
                                    <th width="5%">Detail Tiket</th>
                                    <th style="text-align: center" width="5%">Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($belum_diambil as $bd)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td><a href="{{ url('order/detail?id='.$bd->id) }}">{{ $bd->no_transaksi }}</a></td>
                                        <td>{{ $bd->orderCustomer->nama_lengkap.' / '.$bd->orderCustomer->no_identitas.' / '.$bd->orderCustomer->jenis_identitas }}</td>
                                        <td align="center">{{ count($bd->tiketItem).' Tiket' }}</td>
                                        <td align="center">
                                            @foreach ($bd->orderItem as $item)
                                                {!! $item->qty.' x '.$item->tiket->nama."<br>" !!}
                                            @endforeach
                                        </td>
                                        <td align="center">
                                            <button class="btn btn-success mt-3 btn-sm btn-ambil"
                                                data-id="{{ $bd->id }}"><i class="fa fa-check"></i> Ambil Gelang</button>
                                        </td>
        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade {{ $tab == 'sudah_diambil' ? 'active show' : '' }}" id="sudah_diambil" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="table-responsive">
                        <table id="dt2" class="display table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="1%">No.</th>
                                    <th width="5%">No.Transaksi</th>
                                    <th width="5%">Customer</th>
                                    <th width="5%">Tgl. Pengambilan</th>
                                    <th width="5%">Jumlah Tiket</th>
                                    <th width="5%">Detail Tiket</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($sudah_diambil as $sd)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td><a href="{{ url('order/detail?id='.$sd->id) }}">{{ $sd->no_transaksi }}</a></td>
                                    <td>{{ $sd->orderCustomer->nama_lengkap.' / '.$sd->orderCustomer->no_identitas }}</td>
                                    <td align="center">{{ date('d-m-Y', strtotime($sd->tgl_pengambilan)) }}</td>
                                    <td align="center">{{ count($sd->tiketItem).' Tiket' }}</td>
                                    <td align="center">
                                        @foreach ($sd->orderItem as $item)
                                            {!! $item->qty.' x '.$item->tiket->nama."<br>" !!}
                                        @endforeach
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('public/atlantis/assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('public/atlantis/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('public/atlantis/assets/js/plugin/moment/moment.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#dt1').DataTable({});
        $('#dt2').DataTable({});
    });

    $(document).on('click','.btn-tab', function(e){
        var tab = $(this).data('tab')
        console.log(tab)
        window.location = "{{ url('pengambilan-gelang?tab=') }}"+tab
    })


    

    $(document).on('click', '.btn-ambil', function (e) {
        var id = $(this).data('id')
        e.preventDefault()
        swal({
            title: 'Yakin untuk submit ?',
            text: "Proses tidak dapat di kembalikan !",
            type: 'warning',
            buttons: {
                confirm: {
                    text: 'Ya, submit !',
                    className: 'btn btn-success'
                },
                cancel: {
                    visible: true,
                    text: 'Batal',
                    className: 'btn btn-danger'
                }
            }
        }).then((Validasi) => {
            if (Validasi) {
                $.ajax({
                    type: 'GET',
                    url: "{{ url('pengambilan-gelang/submit?id=') }}" + id,
                    success: function (r) {
                        console.log(r)
                        if (r == 'success') {
                            swal({
                                title: 'Validated !',
                                text: 'Tagihan telah divalidasi',
                                type: 'success',
                                buttons: {
                                    confirm: {
                                        className: 'btn btn-success'
                                    }
                                }
                            }).then(function () {
                                location.reload()
                            });
                        }
                    }
                })

            } else {
                swal.close();
            }
        });
    })

    
</script>
@endsection