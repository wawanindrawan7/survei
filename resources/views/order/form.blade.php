@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{{ asset('jquery.bootstrap-touchspin.min.css') }}">
@endsection
@section('content')
    <div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form_add_cart">
                    @csrf
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel">Tambah Keranjang</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="c_id" name="tiket_id">
                        <div class="form-gorup">
                            <img class="card-img-top rounded" src="" alt="Product 1" id="foto">
                            <p id="deskripsi"></p>
                        </div>
                        <div class="form-group"">
                            <label for="">Harga</label>
                            <input type="text" id="f_harga" readonly class="form-control">
                        </div>
                        <input type="hidden" id="harga" class="form-control">

                        <div class="form-group">
                            <label for="">Qty</label>
                            <input type="number" readonly id="qty" name="qty" class="form-control" value="1" data-bts-min="0" data-bts-max="10" data-bts-init-val="" data-bts-step="1">
                            <small id="emailHelp" class="form-text text-muted">Maksimal pembelian 10 tiket.</small>
                        </div>

                        <div class="form-group">
                            <label for="">Subtotal</label>
                            <input type="text" id="f_subtotal" readonly class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                        <button type="submit" class="btn btn-success form-control">Tambah Ke Keranjang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="row">
                @foreach ($pre_tiket as $item)
                    <div class="col-md-6">
                        <a href="#" class="btn-add-cart" data-toggle="modal" data-target="#add-modal" data-id="{{ $item->id }}" 
                            data-foto = "{{ $item->foto }}"
                            data-deskripsi = "{{ $item->deskripsi }}"
                            data-nama="{{ $item->nama }}"
                            data-harga="{{ $item->harga }}">
                            <div class="card">
                                <div class="p-2">
                                    <img class="card-img-top"
                                        src="{{ asset($item->foto) }}"
                                        alt="Product 1">
                                </div>
                        </a>
                        <div class="card-body pt-2">
                            <h4 class="mb-1 fw-bold">{{ $item->nama }}</h4>
                            <p class="text-muted small mb-2">Kategori Tiket : <strong>{{ $item->kategori }}</strong>
                            </p>
                        </div>
                    </div>

            </div>
            @endforeach
            @foreach ($opt_tiket as $item)
                    <div class="col-md-6">
                        <a href="#" class="btn-add-cart" data-toggle="modal" data-target="#add-modal" data-id="{{ $item->id }}" 
                            data-foto = "{{ $item->foto }}"
                            data-deskripsi = "{{ $item->deskripsi }}"
                            data-nama="{{ $item->nama }}"
                            data-min_order="{{ $item->min_order }}"
                            data-harga="{{ $item->harga }}">
                            <div class="card">
                                <div class="p-2">
                                    <img class="card-img-top"
                                        src="{{ asset($item->foto) }}"
                                        alt="Product 1">
                                </div>
                        </a>
                        <div class="card-body pt-2">
                            <h4 class="mb-1 fw-bold">{{ $item->nama }}</h4>
                            <p class="text-muted small mb-2">Kategori Tiket : <strong>{{ $item->kategori }}</strong>
                            </p>
                        </div>
                    </div>

            </div>
            @endforeach
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4><i class="fa fa-shopping-cart"></i> Keranjang</h4>
            </div>
            <div class="card-body">
                <div id="cart-list" class="card-list">
                    <div class="list list-bordered cart-item">
                    </div>
                </div>
                <form id="form_checkout">
                @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-gorup form-group-default">
                                <label for="">Total</label>
                                <input type="text" class="form-control" id="f_total" readonly>
                                <input type="hidden" name="total">
                            </div>
                            <div class="form-gorup form-group-default">
                                <label for="">Pembayaran</label>
                                <select class="form-control" name="pembayaran" id="pembayaran" required>
                                    <option value=""></option>
                                    @if(Auth::user()->customer != null && Auth::user()->customer->jenis_identitas != 'KTP')
                                    <option>DP 50%</option>
                                    @endif
                                    <option>LUNAS</option>
                                </select>
                            </div>
                            <div class="form-gorup form-group-default">
                                <label for="">Jumlah Tagihan</label>
                                <input type="text" class="form-control" id="f_jumlah_tagihan" readonly>
                                <input type="hidden" id="jumlah_tagihan" name="jumlah_tagihan" required>
                            </div>

                            @if(Auth::user()->status != 'Customer')
                            <div class="form-group form-group-default">
                                <label for="exampleFormControlInput1">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama_lengkap">
                            </div>
                            <div class="form-group form-group-default">
                                <label for="exampleFormControlInput1">No.Identitas</label>
                                <input type="text" class="form-control" name="no_identitas" required>
                            </div>
                            <div class="form-group form-group-default">
                                <label for="exampleFormControlInput1">Jenis Identitas</label>
                                <select class="form-control" name="jenis_identitas" required>
                                    <option>KTP</option>
                                </select>
                            </div>
                            <div class="form-group form-group-default">
                                <label for="exampleFormControlInput1">No.Hp</label>
                                <input type="text" class="form-control" name="no_hp" required>
                            </div>
                            <div class="form-group form-group-default">
                                <label for="exampleFormControlInput1">Email</label>
                                <input type="text" class="form-control" name="email" required>
                            </div>
                            @endif
                            <button type="submit" class="btn btn-success form-control">Checkout</button>

 
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('js')
<script src="{{ asset('jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ asset('public/atlantis/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('public/atlantis/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
<script>
    $("#qty").TouchSpin({
        // prefix: 'Qty'
    });
    var total = 0

    loadCart()


    $(document).on('click','.btn-add-cart', function(e){
        e.preventDefault()
        $('#qty').val(1)
        var barang_id = $(this).data('id')
        $('.item_nama').text($(this).data('nama'))
        var harga = $(this).data('harga')
        $('#f_harga').val(nf.format(harga))
        $('#harga').val(harga)
        $('#c_id').val($(this).data('id'))
        $('#deskripsi').text($(this).data('deskripsi'))
        var foto = "{{ url('') }}/"+$(this).data('foto')
        $("#foto").attr("src", foto);

        // $("#qty").trigger("touchspin.updatesettings", {max: $(this).data('min_order')});
   
        
        var qty = $('#qty').val()
        var subtotal = qty * harga
        $('#f_subtotal').val(nf.format(subtotal))
        
        $('#add-modal').modal('show')
        $('#add-modal').modal().on('shown', function(){
                $('body').css('overflow', 'hidden');
            }).on('hidden', function(){
                $('body').css('overflow', 'auto');
            })
    })

    $('#form_add_cart').on('submit', function(e){
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: "{!! url('cart/add') !!}",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (r) {
                console.log(r)
                if (r == 'success') {
                    loadCart()
                    $.notify({
                        message: 'Berhasil ditambahkan ke keranjang'
                    },{
                        type: 'success',
                        timer: 1000,
                        animate: {
                            enter: 'animated fadeInDown',
                            exit: 'animated fadeOutUp'
                        },
                    });
                    $('#qty').val(1)
                    $('#add-modal').modal('hide')
                }
            }
        })
    })

    $(document).on('click','.btn-add-qty', function(e){
        e.preventDefault()
        var id = $(this).data('id')
        $.ajax({
            type : 'get',
            url : "{{ url('cart/add-qty?id=') }}"+id,
            success : function(r){
                console.log(r)
                if(r == 'success'){
                    loadCart()
                }
            }
        })
    })

    $(document).on('click','.btn-min-qty', function(e){
        e.preventDefault()
        var id = $(this).data('id')
        $.ajax({
            type : 'get',
            url : "{{ url('cart/min-qty?id=') }}"+id,
            success : function(r){
                console.log(r)
                if(r == 'success'){
                    loadCart()
                }
            }
        })
    })

    $(document).on('input','#qty', function(e){
        var qty = $('#qty').val()
        var harga = $('#harga').val()
        var subtotal = qty * harga
        $('#f_subtotal').val(nf.format(subtotal))
    })

    $(document).on('change','#qty', function(e){
        var qty = $('#qty').val()
        var harga = $('#harga').val()
        var subtotal = qty * harga
        $('#f_subtotal').val(nf.format(subtotal))
    })

    $(document).on('change','#pembayaran', function(e){
        var pembayaran = $(this).val()
        console.log(pembayaran)
        if(pembayaran === 'DP 50%'){
            $('#f_jumlah_tagihan').val(nf.format(total / 2))
            $('#jumlah_tagihan').val(total / 2)
        }else if(pembayaran === 'LUNAS'){
            $('#f_jumlah_tagihan').val(nf.format(total))
            $('#jumlah_tagihan').val(total)
        }else{
            $('#f_jumlah_tagihan').val(nf.format(0))
            $('#jumlah_tagihan').val(0)
        }
    })



    function loadCart(){
        
        total = 0
        $.ajax({
            type : 'get',
            url : "{{ url('cart/item') }}",
            success : function(r){
                $('.cart-item').empty()
                $.each(r.cart_item, function(i, d){
                    total += +d.subtotal
                    $('.cart-item').append(
                        '<div class="item-list">\
                                    <div class="info-user ml-3">\
                                        <div class="username">'+d.tiket.nama+'</div>\
                                        <div class="status">'+d.qty+' @'+nf.format(d.harga)+'</div>\
                                        <div class="">'+nf.format(d.subtotal)+'</div>\
                                    </div>\
                                    <button type="button" class="btn btn-icon btn-xs btn-round btn-danger btn-min-qty mr-1" data-id="'+d.id+'">\
                                        <i class="fas fa-minus"></i>\
                                    </button>\
                                    <button type="button" class="btn btn-icon btn-xs btn-round btn-primary btn-add-qty" data-id="'+d.id+'">\
                                        <i class="fas fa-plus"></i>\
                                    </button>\
                                </div>\
                                <hr class="">'
                    )
                    
                })

                $('#f_total').val(nf.format(total))
                $('#f_jumlah_tagihan').val(nf.format(0))
                $('#jumlah_tagihan').val(0)
                $('#pembayaran').val('')



            }
        })
    }

    $('#form_checkout').on('submit', function(e){
        e.preventDefault()
        showPleaseWait()
        $.ajax({
            type: 'post',
            url: "{!! url('cart/checkout') !!}",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (r) {
                console.log(r)
                hidePleaseWait()
                if (r == 'success') {
                    swal("Berhasil !", "Tunggu konfirmasi Admin !", {
                        icon : "success",
                        timer : 1500,
                        buttons: {
                            confirm: {
                                className : 'btn btn-success'
                            }
                        },
                    }).then(function(){
                        window.location = "{{ url('order') }}"
                    });
                }
            }
        })
    });

</script>
@endsection
