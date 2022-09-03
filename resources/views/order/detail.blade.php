@extends('layouts.master')
@section('content')
<div class="row">

    <div class="modal fade" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="form_confirm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pembayaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="tg_id" name="tagihan_id">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Rekening Tujuan</label>
                            <select class="form-control" name="rekening_id">
                               @foreach ($rekening as $rek)
                                   <option value="{{ $rek->id }}">{{ $rek->bank.' / '.$rek->nomor_rekening.' / '.$rek->nama }}</option>
                               @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">File</label>
                            <input type="file" class="form-control" name="file" accept="image/*" required>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4><i class="fa fa-list"></i> Order Detail {{ $order->no_transaksi }}</h4>
            </div>
            <div class="card-body">
                
                <div id="cart-list" class="card-list">
                    <div class="list list-bordered cart-item">
                        @foreach ($order->orderItem as $item)
                        <div class="item-list">
                            <div class="info-user ml-3">
                                <div class="username">{{ $item->tiket->nama.' ('.$item->tiket->kategori.')'  }}</div>
                                <div class="status">{{ $item->qty }} @ {{ number_format($item->harga) }}</div>
                                <div class="">{{ number_format($item->subtotal) }}</div>
                            </div>
                        </div>
                        <hr class="">
                        @endforeach
                    </div>
                </div>

                

                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="form-group form-group-default">
                            <label for="">Total</label>
                            <input type="text" class="form-control" readonly value="{{ number_format($order->total)  }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-group-default">
                            <label for="">Termin Pembayaran</label>
                            <input type="text" class="form-control" readonly value="{{ $order->pembayaran }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-group-default">
                            <label for="">Sisa Pembayaran</label>
                            <input type="text" class="form-control" readonly value="{{ $order->sisa_pembayaran }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ url('order/tiket-export?order_id='.$order->id) }}" class="btn btn-primary">Print Tiket</a>
                    
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4><i class="fa fa-money"></i> Tagihan</h4>
            </div>
            <div class="card-body">
                <div id="cart-list" class="card-list">
                    <div class="list list-bordered cart-item">
                        @foreach ($order->tagihan as $tg)
                        <div class="item-list">
                            <div class="info-user ml-3">
                                <div>
                                    {{ 'Termin '.$tg->termin.' ( Jatuh tempo '.date('d F Y H:i', strtotime($tg->tempo)).' )' }}
                                </div>
                                <div class=""><b>{{ number_format($tg->nominal) }}</b></div>
                                <div class="status {{ $tg->approve == 0 ? 'text-danger' : 'text-success' }}">
                                    Status : {{ $tg->status }}
                                </div>
                                @if($tg->approve == 0 && $tg->upload == 0)
                                <div class="status">
                                    <button class="btn btn-success mt-3 btn-sm btn-confirm" data-id="{{ $tg->id }}"><i class="fa fa-check"></i> Konfirmasi Pembayaran</button>
                                </div>
                                @endif
                                
                            </div>

                            {{-- @if($tg->approve == 0)
                                <button type="button" class="btn btn-icon btn-xs btn-round btn-primary btn-confirm"
                                    data-id="{{ $tg->id }}">
                                    <i class="fas fa-check"></i>
                                </button>
                            @endif --}}
                        </div>
                        <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('public/atlantis/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('public/atlantis/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
<script>

    $(document).on('click','.btn-confirm', function(e){
        e.preventDefault()
        $('#tg_id').val($(this).data('id'))
        $('#confirm-modal').modal('show')
    })

    $(document).on('click','.btn-validasi', function(e){
        e.preventDefault()
        $('#v_tg_id').val($(this).data('id'))
        $('#v_rekening').val($(this).data('rekening'))
        var foto = "{{ url('') }}/"+$(this).data('bukti_pembayaran')
        $("#v_bukti_pembayaran").attr("src", foto);
        
        $('#validasi-modal').modal('show')
    })

    $('#form_confirm').on('submit', function(e){
        e.preventDefault()
        showPleaseWait()
        $.ajax({
            type: 'post',
            url: "{!! url('tagihan/confirm') !!}",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (r) {
                console.log(r)
                hidePleaseWait()
                if (r == 'success') {
                    swal("Berhasil !", "Konfirmasi pembayaran berhasil dikirim !", {
                        icon : "success",
                        timer : 1500,
                        buttons: {
                            confirm: {
                                className : 'btn btn-success'
                            }
                        },
                    }).then(function(){
                        location.reload()
                    });
                }
            }
        })
    });

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