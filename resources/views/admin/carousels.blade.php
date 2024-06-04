@extends('template-admin.admin')

@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        @if (session('message'))
        <div class="alert alert-success" id="alert-success">
            {{ session('message') }}
        </div>
        @endif

        <div class="alert alert-success d-none" id="alert-success"></div>

        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-4 col-12">
                <h3>Carousels</h3>
            </div>
            <!-- ./col -->
            <div class="col-lg-8 col-12">
                <!-- small box -->
                <div class="d-flex flex-row justify-content-end align-items-center" style=" gap:1rem;">
                    {{-- <div class="hello">
                        Hellooo
                    </div> --}}
                    <button data-toggle="modal" data-target="#exampleModal" type="button" class="btn"
                        style="background:#00B517; color:white">Tambah Area</button>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row" style="margin-top:1rem">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th style="width:5%">ID</th>
                                    <th style="width:50%">Gambar</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row (main row) -->

        {{-- modal --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom: 0px">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Carousels</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Foto Carousels</label>
                                <div class="file-drop-area">
                                    <span class="choose-file-button">Tambahkan foto</span>
                                    <span id="file-message1" class="file-message">or drag and drop files here</span>
                                    <input class="file-input" name="inputImages" id="inputImages" type="file">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn-add-data btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- modal edit --}}
        <div class="modal fade" id="modalEditArea" tabindex="-1" role="dialog" aria-labelledby="modalEditStudentLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom: 0px">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Carousels</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{-- <form method="POST"> --}}
                        {{-- @csrf --}}
                        <div class="modal-body">
                            <input type="text" id="edit_data_id" aria-hidden="true" class="d-none">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Foto Kategori</label>
                                <div class="file-drop-area">
                                    <span class="choose-file-button">Tambahkan foto</span>
                                    <span id="file-message1" class="file-message">or drag and drop files here</span>
                                    <input class="file-input" name="editImages" id="editImages" type="file">
                                </div>
                                <span style="font-size: 0.8rem; color:gray">Masukan gambar baru jika ingin mengganti
                                    **</span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" name="btn-edit-data" id="btn-edit-data"
                                class="btn-edit-data btn btn-primary">Simpan</button>
                        </div>
                        {{--
                    </form> --}}
                </div>
            </div>
        </div>

        {{-- modal delete --}}
        <div class="modal fade" id="modalDeleteArea" tabindex="-1" role="dialog" aria-labelledby="modalEditStudentLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom: 0px">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="errList"></div>
                        <input class="d-none" type="text" id="delete_data_id">
                        <div>
                            Apakah kamu yakin ingin menghapus data ini ? data yang telah dihapus tidak dapat
                            dikembalikan.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" name="btn-delete-data" id="btn-delete-data"
                            class="btn-delete-data btn btn-danger">Hapus</button>
                    </div>
                </div>
            </div>
        </div>


    </div><!-- /.container-fluid -->
</section>
@section('scripts')
{{-- custom script --}}
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        fetchData()

        function resetForm() {
            $('#editArea').val("")
            $('#editPeriod').val("")
            $('#inputArea').val("")
            $('#inputPeriod').val("")
        }

        function fetchData() {
            $.ajax({
                type: "GET",
                url: "/carousels-fetch",
                dataType: "json",
                success: function(respons) {
                    console.log(respons)
                    // console.log(respons.areas)
                    $('tbody').html('')
                    $.each(respons.carousels.data, function(key, cf) {
                        $('tbody').append('<tr>\
                        <td>' + cf.id + '</td>\
                        <td> <img src="/storage/' + cf.gambar + '" style="width:5rem; height:auto;margin-right:1rem" alt="img"> </td>\
                        <td>\
                        <button value="' + cf.id + '" data-toggle="modal" data-target="#modalEditStudent" type="button" class="trigger_edit btn btn-warning">edit</button>\
                        <button value="' + cf.id + '" type="button" class="trigger_delete btn btn-danger">delete</button>\
                        </td>\
                        <tr>\
                        ')
                    })
                }
            })
        }

        $(document).on('click', '.btn-add-data', function(e) {
            e.preventDefault()

            let data = {
            'thumbnail': $('#inputImages').prop('files')[0],
            }

            let formData = new FormData();
            formData.append('thumbnail', $('#inputImages').prop('files')[0]);

            $.ajax({
                type: "POST",
                url: "/carousels-store",
                data: formData,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res) {
                        if (res.message == "error") {
                            return (alert(res.data))
                        }
                        $('#alert-success').removeClass("d-none")
                        $('#alert-success').text("Success Create User")
                        $('#exampleModal').modal('hide')
                        fetchData()
                        resetForm()
                    } else {
                        //soon change with alert modals
                        alert("Error")
                    }
                }
            })
        })

        $(document).on('click', '.trigger_edit', function(e) {
            e.preventDefault()
            let data_id = $(this).val()
            $.ajax({
                type: "GET",
                url: "/carousels-fetch/" + data_id,
                success: function(res) {
                    if (res.data) {
                        $('#modalEditArea').modal('show')
                        $('#edit_data_id').val(data_id)
                    } else {
                        alert("Error - Something Went woring")
                    }
                }
            })
        })

        $(document).on('click', '.btn-edit-data', function(e) {
            e.preventDefault()
            
            let data = {
            'thumbnail': $('#editImages').prop('files')[0],
            }
            
            let formData = new FormData();
            formData.append('thumbnail', $('#editImages').prop('files')[0]);
            let selID = $('#edit_data_id').val();

            $.ajax({
                type: "POST",
                url: "/carousels-update/" + selID,
                data: formData,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.data) {
                        if (res.message == "error") {
                            return (alert(res.data))
                        }
                        $('#alert-success').removeClass("d-none")
                        $('#alert-success').text("Success Edit")
                        $('#modalEditArea').modal('hide')
                        fetchData()
                    } else {
                        //soon change with alert modals
                        alert("Error")
                    }
                }
            })
        })

        $(document).on('click', '.trigger_delete', function(e) {
            e.preventDefault()
            let data_id = $(this).val()
            $.ajax({
                type: "GET",
                url: "/carousels-fetch/" + data_id,
                success: function(res) {
                    if (res.data) {
                        $('#modalDeleteArea').modal('show')
                        $('#delete_data_id').val(data_id)
                    } else {
                        alert("Error - Something Went woring")
                    }
                }
            })
        })

        $(document).on('click', '.btn-delete-data', function(e) {
            e.preventDefault()

            let data_id = $('#delete_data_id').val()
            $.ajax({
                type: "GET",
                url: "/carousels-delete/" + data_id,
                success: function(res) {
                    if (res.data) {
                        $('#alert-success').removeClass("d-none")
                        $('#alert-success').text("Success Delete")
                        $('#modalDeleteArea').modal('hide')
                        fetchData()
                    } else {
                        //soon change with alert modals
                        alert("Error")
                    }
                }
            })
        })

        $(document).on('change', '.file-input', function() {
            var filesCount = $(this)[0].files.length;

            var textbox = $(this).prev();

            if (filesCount === 1) {
                var fileName = $(this).val().split('\\').pop();
                textbox.text(fileName);
            } else {
                textbox.text(filesCount + ' files selected');
            }
        });

    })
</script>
@endsection

{{-- end custom script --}}
<!-- /.content -->
@endsection