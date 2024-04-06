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
                <h3>Kategori Produk</h3>
            </div>
            <!-- ./col -->
            <div class="col-lg-8 col-12">
                <!-- small box -->
                <div class="d-flex flex-row justify-content-end align-items-center" style=" gap:1rem;">
                    {{-- <div class="hello">
                        Hellooo
                    </div> --}}
                    <button data-toggle="modal" data-target="#modalAddUser" type="button" class="btn"
                        style="background:#00B517; color:white">Tambah Kategori</button>
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
                                    <th>Nama Produk</th>
                                    <th>Harga Produk</th>
                                    <th>Nama Vendor/Suplier</th>
                                    <th>Stok</th>
                                    <th>Tanggal dibuat</th>
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

        {{-- modal add --}}
        <div class="modal fade" id="modalAddUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom: 0px">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori Produk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="/ps-add/" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Kategori</label>
                                <input type="text" class="form-control" id="inputCategoryName" name="inputCategoryName"
                                    placeholder="Masukan Nama Kategori" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Foto Kategori</label>
                                <div class="file-drop-area">
                                    <span class="choose-file-button">Tambahkan foto</span>
                                    <span id="file-message" class="file-message">or drag and drop files here</span>
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
                        <h5 class="modal-title" id="exampleModalLabel">Edit Area</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" enctype="multipart/form-data">
                        {{-- @csrf --}}
                        <div class="modal-body">
                            <div id="errList"></div>
                            <input type="text" id="edit_data_id" aria-hidden="true">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Kategori</label>
                                <input type="text" class="form-control" id="editCategoryName" name="editCategoryName"
                                    placeholder="Masukan Nama Kategori" required>
                            </div>
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

                    </form>
                </div>
            </div>
        </div>

        {{-- modal delete --}}
        <div class="modal fade" id="modalDeleteArea" tabindex="-1" role="dialog" aria-labelledby="modalEditStudentLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom: 0px">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Area</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="errList"></div>
                        <input class="d-none" type="text" id="delete_data_id">
                        <div>
                            Apakah kamu yakin ingin menghapus kategori produk ini ? data yang telah dihapus tidak dapat
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

        function fetchData() {
            $.ajax({
                type: "GET",
                url: "/pc-fetch",
                dataType: "json",
                success: function(respons) {
                    console.log(respons.product_categories)
                    $('tbody').html('')
                    $.each(respons.product_categories.data, function(key, product) {
                        $('tbody').append('<tr>\
                        <td> <img src="/storage/images/' + product.images + '" style="width:5rem; height:auto;margin-right:1rem" alt="img">' + product.product_category_name + '</td>\
                        <td>' + product.created_at + '</td>\
                        <td>\
                        <button value="' + product.id + '" data-toggle="modal" data-target="#modalEditStudent" type="button" class="trigger_edit btn btn-warning">edit</button>\
                        <button value="' + product.id + '" type="button" class="trigger_delete btn btn-danger">delete</button>\
                        </td>\
                        <tr>\
                        ')
                    })
                }
            })
        }

        function resetForm() {
            $('#inputImages').val("")
            $('#editImages').val("")
            $('#inputCategoryName').val("")
            $('#editCategoryName').val("")
            // $('#file-message').val("")
            $('#file-message').html("or drag and drop files here")
            $('#file-message1').html("or drag and drop files here")
        }

        $('#imageUploadForm').on('submit', (function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log("success");
                    console.log(data);
                },
                error: function(data) {
                    console.log("error");
                    console.log(data);
                }
            });
        }));

        $(document).on('click', '.btn-add-data', function(e) {
            e.preventDefault()

            // let data_id = $('#delete_data_id').val()
            let formData = new FormData();
            let data = {
                'categoryName': $('#inputCategoryName').val(),
                'images': $('#inputImages').prop('files')[0]
            }

            formData.append('images', data.images);
            formData.append('categoryName', data.categoryName);

            console.log("HERE", formData)
            $.ajax({
                type: "POST",
                url: "/pc-store",
                data: formData,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res) {
                        console.log(res)
                        $('#alert-success').removeClass("d-none")
                        $('#alert-success').text("Success Create User")
                        $('#modalAddUser').modal('hide')
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
                url: "/pc-fetch/" + data_id,
                success: function(res) {
                    if (res.data) {
                        console.log(res.data)
                        $('#modalEditArea').modal('show')
                        $('#editCategoryName').val(res.data.product_category_name)
                        $('#edit_data_id').val(res.data.id)
                    } else {
                        alert("Error - Something Went woring")
                    }
                }
            })
        })

        $(document).on('click', '.btn-edit-data', function(e) {
            e.preventDefault()

            let formData1 = new FormData();
            let data = {
                'categoryName': $('#editCategoryName').val(),
                'images': $('#editImages').prop('files')[0]
            }

            formData1.append('categoryName', data.categoryName);
            formData1.append('images', data.images);
            let selID = $('#edit_data_id').val();

            $.ajax({
                type: "POST",
                url: "/pc-update/" + selID,
                data: formData1,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.data) {
                        $('#alert-success').removeClass("d-none")
                        $('#alert-success').text("Success Edit")
                        $('#modalEditArea').modal('hide')
                        fetchData()
                        resetForm()
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
            console.log(data_id)
            $.ajax({
                type: "GET",
                url: "/pc-fetch/" + data_id,
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
            console.log(data_id)
            $.ajax({
                type: "DELETE",
                url: "/pc-delete/" + data_id,
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

        //handling drop
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