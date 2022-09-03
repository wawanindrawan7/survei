@extends('layouts.master')

@section('content')
    <div class="modal fade" id="create-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="form_tiket">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Tiket</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama</label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Foto</label>
                            <input type="file" class="form-control" name="foto" id="foto">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Kategori</label>
                            <select class="form-control" name="kategori">
                                <option>Festival</option>
                                <option>Privilege</option>
                                <option>VIP</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Stok</label>
                            <input type="number" class="form-control" name="stok" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Harga</label>
                            <input type="number" class="form-control" name="harga" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Min Order</label>
                            <input type="number" class="form-control" name="min_order" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="update-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="form-update" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Tiket</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <input type="hidden" name="id" id="e_id">

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama</label>
                            <input type="text" class="form-control" name="nama" id="e_nama" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Foto</label>
                            <input type="file" class="form-control" name="foto" id="foto">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Kategori</label>
                            <select class="form-control" name="kategori" id="e_kategori">
                                <option>Festival</option>
                                <option>Privilege</option>
                                <option>VIP</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Stok</label>
                            <input type="number" class="form-control" name="stok" required id="e_stok">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Harga</label>
                            <input type="number" class="form-control" name="harga" required id="e_harga">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Min Order</label>
                            <input type="number" class="form-control" name="min_order" required id="e_min_order">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="e_deskripsi" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Tiket</div>
                    <div class="card-tools">
                        <a href="#" class="btn btn-info btn-border btn-round btn-sm mr-2" data-toggle="modal"
                            data-target="#create-modal">
                            <span class="btn-label">
                                <i class="fa fa-plus"></i>
                            </span>
                            Create
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="basic-datatables" class="display table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="1%">No.</th>
                                <th>Nama</th>
                                <th>Foto</th>
                                <th>Deskripsi</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th>Min Order</th>
                                <th width="10%">Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($tiket as $p)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $p->nama }}</td>
                                    <td>
                                        @if($p->foto != null)
                                        <div class="avatar avatar-xxl">
                                            <img src="{{ asset($p->foto) }}" alt="..." class="avatar-img">
                                        </div>
                                        @endif
                                    </td>
                                    <td>{!! $p->deskripsi !!}</td>
                                    <td>{{ $p->kategori }}</td>
                                    <td>{{ $p->stok }}</td>
                                    <td>{{ 'Rp. ' . number_format($p->harga) }}</td>
                                    <td>{{ $p->min_order }}</td>
                                    <td align="center">
                                        <a title="Update" href="#"
                                            class="btn btn-warning btn-round btn-xs mr-2 btn-update"
                                            data-id="{{ $p->id }}" data-nama="{{ $p->nama }}"
                                            data-kategori="{{ $p->kategori }}" data-stok="{{ $p->stok }}"
                                            data-harga="{{ $p->harga }}"
                                            data-min_order="{{ $p->min_order }}"
                                            data-deskripsi="{{ $p->deskripsi }}">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <a title="Delete" href="#"
                                            class="btn btn-danger btn-round btn-xs mr-2 btn-delete"
                                            data-id="{{ $p->id }}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
        $(document).ready(function() {
            $('#basic-datatables').DataTable({});
        });

        $('#form_tiket').on('submit', function(e) {
            e.preventDefault()
            $.ajax({
                type: 'POST',
                url: "{!! url('tiket/create') !!}",
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
            $('#e_deskripsi').val($(this).data('deskripsi'))
            $('#e_kategori').val($(this).data('kategori'))
            $('#e_stok').val($(this).data('stok'))
            $('#e_harga').val($(this).data('harga'))
            $('#e_min_order').val($(this).data('min_order'))
            $('#update-modal').modal('show')
        })

        $('#form-update').on('submit', function(e) {
            e.preventDefault()
            $.ajax({
                type: 'post',
                url: "{!! url('tiket/update') !!}",
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
                        url: "{{ url('tiket/delete?id=') }}" + id,
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
