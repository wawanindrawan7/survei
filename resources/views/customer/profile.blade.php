@extends('layouts.master')

@section('content')
    <form id="form_customer">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Google ID</label>
                            <input type="text" class="form-control" name="google_id" value="{{ Auth::user()->google_id }}"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Username</label>
                            <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}"
                                readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Email</label>
                            <input type="text" class="form-control" name="google_id" value="{{ Auth::user()->email }}"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Jenis Identitas</label>
                            <select name="jenis_identitas" id="jenis_identitas" class="form-control">
                                <option value=""></option>
                                <option>KTP</option>
                                <option>Kartu Mahasiswa / Kartu Pelajar</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nomor Identitas</label>
                            <input type="text" class="form-control" name="no_identitas">
                        </div>
                    </div>
                    <div class="col-md-4 file_identitas">
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nomor Hp</label>
                            <input type="text" class="form-control" name="no_hp">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Jenis Provider</label>
                            <select name="provider_id" class="form-control">
                                @foreach ($provider as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script src="{{ asset('public/atlantis/assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('public/atlantis/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('public/atlantis/assets/js/plugin/moment/moment.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#basic-datatables').DataTable({});
        });

        $(document).on('change','#jenis_identitas', function(e){
            var jenis_identitas = $(this).val()
            console.log(jenis_identitas)
            if(jenis_identitas === 'Kartu Mahasiswa / Kartu Pelajar'){
                $('.file_identitas').append(
                    '<div class="form-group">\
                        <label for="exampleFormControlInput1">Foto KTM</label>\
                        <input type="file" class="form-control" name="file" accept="image/*" required>\
                    </div>'
                )
            }else{
                $('.file_identitas').empty()
            }
            
        })

        $('#form_customer').on('submit', function(e) {
            e.preventDefault()
            $.ajax({
                type: 'POST',
                url: "{!! url('customer/create') !!}",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(r) {
                    console.log(r)
                    if (r == 'success') {
                        swal("Good job!", "Simpan data berhasil !", {
                            icon: "success",
                            buttons: {
                                confirm: {
                                    className: 'btn btn-success'
                                }
                            },
                        }).then(function() {
                            location.reload()
                        });
                    }
                }
            })
        });

        $(document).on('click', '.btn-update', function(e) {
            $('#e_id').val($(this).data('id'))
            $('#e_nama').val($(this).data('nama'))
            $('#update-modal').modal('show')
        })

        $('#form-update').on('submit', function(e) {
            e.preventDefault()
            $.ajax({
                type: 'post',
                url: "{!! url('provider/update') !!}",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(r) {
                    console.log(r)
                    if (r == 'success') {
                        swal("Good job!", "Simpan data berhasil !", {
                            icon: "success",
                            buttons: {
                                confirm: {
                                    className: 'btn btn-success'
                                }
                            },
                        }).then(function() {
                            location.reload()
                        });
                    }
                }
            })
        });

        $(document).on('click', '.btn-delete', function(e) {
            var id = $(this).data('id')
            e.preventDefault()
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                buttons: {
                    confirm: {
                        text: 'Yes, delete it!',
                        className: 'btn btn-success'
                    },
                    cancel: {
                        visible: true,
                        className: 'btn btn-danger'
                    }
                }
            }).then((Delete) => {
                if (Delete) {
                    $.ajax({
                        type: 'GET',
                        url: "{{ url('provider/delete?id=') }}" + id,
                        success: function(r) {
                            if (r == 'success') {
                                swal({
                                    title: 'Deleted!',
                                    text: 'Your file has been deleted.',
                                    type: 'success',
                                    buttons: {
                                        confirm: {
                                            className: 'btn btn-success'
                                        }
                                    }
                                }).then(function() {
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
