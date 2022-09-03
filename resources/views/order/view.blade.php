@extends('layouts.master')
@section('content')
    <a href="{{ url('home') }}" class="btn btn-primary mb-3"> <i class="
        fas fa-shopping-cart"></i> Order</a>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fa fa-list"></i> History Order</h4>
                </div>
                <div class="card-body">
                    <div id="cart-list" class="card-list">
                        <div class="list list-bordered cart-item">
                            @foreach ($order as $ord)
                            <div class="item-list">
                                <div class="info-user ml-3">
                                    <div class="username"><a href="{{ url('order/detail?id='.$ord->id) }}">#{{ $ord->no_transaksi.'/'.$ord->orderCustomer->nama_lengkap }} ({!! $ord->users->status == 'Customer' ? 'Online' : "<b>".$ord->users->name !!})</a></div>
                                    <div class=""><b>Total : {{ number_format($ord->total) }}</b></div>
                                    <div class="status mt-2"><span class="badge bg-success text-white">{{ $ord->status }}</span></div>

                                    @if($ord->status != 'Selesai')
                                    <button type="button" class="btn btn-sm btn-primary btn-detail mt-2" data-id="{{ $ord->id }}">
                                        <i class="fas fa-arrow-right"></i> Klik untuk upload pembayaran
                                    </button>
                                    @else
                                    <a href="{{ url('order/tiket-export?order_id='.$ord->id) }}" class="btn btn-sm btn-primary mt-2">Print Tiket</a>
                                    @endif
                                </div>
                              
                            </div>
                            <hr class="">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).on('click','.btn-detail', function(e){
            e.preventDefault()
            var id = $(this).data('id')
            window.location = "{{ url('order/detail?id=') }}"+id
        })
    </script>
@endsection
