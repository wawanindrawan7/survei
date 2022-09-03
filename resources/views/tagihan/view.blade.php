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
                    
                    <li class="nav-item submenu"> <a class="nav-link {{ $tab == 'not_upload' ? 'active show' : '' }} btn-tab" data-tab="not_upload" data-toggle="tab" href="#not_upload" role="tab" aria-selected="false">Menunggu Pembayaran</a> </li>
                    <li class="nav-item submenu"> <a class="nav-link {{ $tab == 'not_approve' ? 'active show' : '' }} btn-tab" data-tab="not_approve" data-toggle="tab" href="#not_approve" role="tab" aria-selected="false">Menunggu Approve</a> </li>
                    <li class="nav-item submenu"> <a class="nav-link {{ $tab == 'approved' ? 'active show' : '' }} btn-tab" data-tab="approved" data-toggle="tab" href="#approved" role="tab" aria-selected="false">Telah di-<i>Approve</i></a> </li>
                    
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content mt-2 mb-3">
                <div class="tab-pane fade {{ $tab == 'not_upload' ? 'active show' : '' }}" id="not_upload" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="table-responsive">
                        <table id="dt2" class="display table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="1%">No.</th>
                                    <th width="5%">No.Transaksi</th>
                                    <th width="5%">Customer</th>
                                    <th width="5%">Termin</th>
                                    <th width="5%">Jumlah Taghihan</th>
                                    <th width="5%">Tempo</th>
                                    <th width="5%">Status</th>
                                    <th width="5%">Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($not_upload as $nup)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $nup->order->no_transaksi }}</td>
                                        <td>{{ $nup->order->orderCustomer->nama_lengkap.' / '.$nup->order->orderCustomer->no_identitas.' / '.$nup->order->orderCustomer->jenis_identitas.' ('.$nup->order->users->name.')' }}</td>
                                        <td>{{ $nup->order->pembayaran == 'LUNAS' ? '-' : $nup->termin }}</td>
                                        <td>{{ 'Rp. ' . number_format($nup->nominal) }}</td>
                                        <td class="{{ strtotime(date('Y-m-d H:i')) > strtotime($nup->tempo) ? 'text-danger' : 'text->success' }}">{{ $nup->tempo }}</td>
                                        <td>{{ $nup->status }}</td>
                                        <td align="center">
                                            @if($nup->approve == 0 && $nup->upload == 1)
                                                    <button class="btn btn-success btn-sm btn-validasi" data-id="{{ $nup->id }}"
                                                        data-bukti_pembayaran="{{ $nup->bukti_pembayaran }}"
                                                        data-rekening="{{ $nup->tagihanRekening->rekening->bank.' / '.$nup->tagihanRekening->rekening->nomor_rekening.' / '.$nup->tagihanRekening->rekening->nama }}"><i
                                                            class="fa fa-check"></i> Validasi Pembayaran</button>
                                                
                                            @endif
                                        </td>
        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade {{ $tab == 'not_approve' ? 'active show' : '' }}" id="not_approve" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="table-responsive">
                        <table id="dt1" class="display table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="1%">No.</th>
                                    <th width="5%">No.Transaksi</th>
                                    <th width="5%">Customer</th>
                                    <th width="5%">Termin</th>
                                    <th width="5%">Jumlah Taghihan</th>
                                    {{-- <th width="5%">File Bukti Pembayaran</th> --}}
                                    <th width="5%">Tempo</th>
                                    <th width="5%">Status</th>
                                    <th width="5%">Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($not_approve as $napp)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $napp->order->no_transaksi }}</td>
                                        <td>
                                            {{ $napp->order->orderCustomer->nama_lengkap.' / '.$napp->order->orderCustomer->no_identitas.' / '.$napp->order->orderCustomer->jenis_identitas }}  
                                            {{ ' ('.($napp->order->users->status == 'Customer') ? 'Online' : $napp->order->users->name.')' }}</td>
                                        <td>{{ $napp->termin }}</td>
                                        <td>{{ 'Rp. ' . number_format($napp->nominal) }}</td>
                                        {{-- <td>
                                            @if($napp->bukti_pembayaran != null)
                                            <a href="{{ url($napp->bukti_pembayaran) }}" class="btn btn-rounded btn-info"><i class="fa fa-cloud-download"></i> File</a>
                                            @endif
                                        </td> --}}
                                        <td>{{ $napp->tempo }}</td>
                                        <td>{{ $napp->status }}</td>
                                        <td align="center">
                                            @if($napp->approve == 0 && $napp->upload == 1)
                                              
                                                    <button class="btn btn-success mt-3 btn-sm btn-validasi" data-id="{{ $napp->id }}"
                                                        data-bukti_pembayaran="{{ $napp->bukti_pembayaran }}"
                                                        data-rekening="{{ $napp->tagihanRekening->rekening->bank.' / '.$napp->tagihanRekening->rekening->nomor_rekening.' / '.$napp->tagihanRekening->rekening->nama }}"><i
                                                            class="fa fa-check"></i> Validasi Pembayaran</button>
                                                
                                            @endif
                                        </td>
        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                

                <div class="tab-pane fade {{ $tab == 'approved' ? 'active show' : '' }}" id="approved" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="table-responsive">
                        <table id="dt3" class="display table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="1%">No.</th>
                                    <th width="5%">No.Transaksi</th>
                                    <th width="5%">Customer</th>
                                    <th width="5%">Termin</th>
                                    <th width="5%">Jumlah Taghihan</th>
                                    <th width="5%">File Bukti Pembayaran</th>
                                    <th width="5%">Tgl.Approve</th>
                                    <th width="5%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($approve as $app)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td><a href="{{ url('order/detail?id='.$app->order_id) }}">{{ $app->order->no_transaksi }}</a></td>
                                        <td>
                                            {{ $app->order->orderCustomer->nama_lengkap.' / '.$app->order->orderCustomer->no_identitas.' / '.$app->order->orderCustomer->jenis_identitas }}  
                                            {{ ($app->order->users->status == 'Customer') ? '(Online)' : '('.$app->order->users->name.')' }}</td>
                                        <td>{{ $app->termin }}</td>
                                        <td>{{ 'Rp. ' . number_format($app->nominal) }}</td>
                                        <td>
                                            @if($app->bukti_pembayaran != null)
                                            <a href="{{ url($app->bukti_pembayaran) }}" class="btn btn-rounded btn-info"><i class="fa fa-cloud-download"></i> File</a>
                                            @endif
                                        </td>
                                        <td>{{ date('d-m-Y', strtotime($app->tanggal_approve)) }}</td>
                                        <td>{{ $app->status }}</td>
        
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
        $('#dt3').DataTable({});
    });

    $(document).on('click','.btn-tab', function(e){
        var tab = $(this).data('tab')
        console.log(tab)
        window.location = "{{ url('tagihan?tab=') }}"+tab
    })


    $(document).on('click', '.btn-validasi', function (e) {
        e.preventDefault()
        $('#v_tg_id').val($(this).data('id'))
        $('#v_rekening').val($(this).data('rekening'))
        var foto = "{{ url('') }}/" + $(this).data('bukti_pembayaran')
        $("#v_bukti_pembayaran").attr("src", foto);

        $('#validasi-modal').modal('show')
    })

    $(document).on('click', '#btn-submit-validasi', function (e) {
        var id = $('#v_tg_id').val()
        e.preventDefault()
        swal({
            title: 'Yakin untuk submit ?',
            text: "Proses tidak dapat di ulang!",
            type: 'warning',
            buttons: {
                confirm: {
                    text: 'Ya, validasi!',
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
                    url: "{{ url('tagihan/validasi?id=') }}" + id,
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