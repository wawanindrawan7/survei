@extends('layouts.master')

@section('content')
    <div class="modal fade" id="create-pengeluaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="form_pengeluaran">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Pengeluaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="year_production">Tanggal</label>
                            <div class="input-group">
                                <input type="text" class="form-control date" name="tanggal">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar-check"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama</label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Biaya</label>
                            <input type="number" class="form-control" name="biaya" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Supplier</label>
                            <input type="text" class="form-control" name="supplier" required>
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

    <div class="modal fade" id="update-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="form-update" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Provider</h5>
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
                    {{-- <div class="card-title">Vendors List</div> --}}
                    <div class="card-tools">
                        <a href="#" class="btn btn-info btn-border btn-round btn-sm mr-2" data-toggle="modal"
                            data-target="#create-pengeluaran">
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
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Nama</th>
                                <th>Biaya</th>
                                <th>Supplier</th>
                                <th width="10%">Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($pengeluaran as $p)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ date('d F Y', strtotime($p->tanggal)) }}</td>
                                    <td>{{ $p->jam }}</td>
                                    <td>{{ $p->nama }}</td>
                                    <td>Rp. {{ number_format($p->biaya) }}</td>
                                    <td>{{ $p->supplier }}</td>
                                    <td align="center">
                                        <a title="Update" href="#" class="btn btn-warning btn-round btn-xs mr-2 btn-update" data-id="{{ $p->id }}"
                                            data-nama="{{ $p->nama }}">
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
    <script src="{{ asset('public/atlantis/assets/js/plugin/datepicker/bootstrap-datetimepicker.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#basic-datatables').DataTable({});
        });

        $('.date').datetimepicker({
            format: 'MM/DD/YYYY',
        });

        $('#form_pengeluaran').on('submit', function(e) {
            e.preventDefault()
            $.ajax({
                type: 'POST',
                url: "{!! url('pengeluaran/create') !!}",
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

        $(document).on('click','.btn-update', function(e){
        $('#e_id').val($(this).data('id'))
        $('#e_nama').val($(this).data('nama'))
        $('#update-modal').modal('show')
    })

    $('#form-update').on('submit', function(e){
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: "{!! url('provider/update') !!}",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (r) {
                console.log(r)
                if (r == 'success') {
                    swal("Good job!", "Simpan data berhasil !", {
                        icon : "success",
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
                        url: "{{ url('pengeluaran/delete?id=') }}" + id,
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
