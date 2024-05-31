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
                <h3>Produk</h3>
            </div>
            <!-- ./col -->
            <div class="col-lg-8 col-12">
                <!-- small box -->
                <div class="d-flex flex-row justify-content-end align-items-center" style=" gap:1rem;">
                    {{-- <div class="hello">
                        Hellooo
                    </div> --}}
                    <button data-toggle="modal" data-target="#modalAddUser" type="button" class="btn"
                        style="background:#00B517; color:white">Tambah Produk</button>
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
                                    <th>Kategori Produk</th>
                                    <th>Harga Produk</th>
                                    <th>Nama Vendor/Suplier</th>
                                    <th>Stok Tersedia</th>
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
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Produk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="/ps-add/" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Produk</label>
                                <input type="text" class="form-control" id="inputProductName" name="inputProductName"
                                    placeholder="Masukan Nama Kategori" required>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="exampleFormControlTextarea1">Stok</label>
                                    <input type="number" class="form-control" id="inputStok" name="inputStok"
                                        placeholder="Masukan Stok" required>
                                </div>
                                <div class="form-group col-6">
                                    <label for="exampleInputPassword1">Satuan</label>
                                    <select name="inputSatuan" id="inputSatuan"
                                        class="custom-select custom-select-md mb-3" required>
                                        <option value="">--Pilih Salah Satu--</option>
                                        <option value="satuan">Satuan</option>
                                        <option value="kilo">Kilo</option>
                                        <option value="botol">Botol</option>
                                        <option value="can">Can</option>
                                        <option value="liter">Liter (L)</option>
                                        <option value="mililiter">Mili Liter (Ml)</option>
                                        <option value="lusin">Lusin</option>
                                        <option value="pack">Pack</option>
                                        <option value="pcs">Pcs</option>
                                        <option value="pouch">Pouch</option>
                                        <option value="pasang">Pasang (psg)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="exampleFormControlTextarea1">Harga</label>
                                    <input type="number" class="form-control" id="inputHarga" name="inputHarga"
                                        placeholder="Masukan Harga" required>
                                </div>
                                <div class="form-group col-6">
                                    <label for="exampleInputPassword1">Kategori</label>
                                    <select name="inputKategori" id="inputKategori"
                                        class="custom-pc custom-select custom-select-md mb-3" required>
                                        <option value="">--Pilih Kategori--</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Foto Kategori</label>
                                <div class="file-drop-area">
                                    <span class="choose-file-button">Tambahkan foto</span>
                                    <span id="file-message1" class="file-message">or drag and drop files here</span>
                                    <input class="file-input" name="inputImages" id="inputImages" type="file">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Deskripsi Produk</label>
                                <textarea class="form-control" id="inputDeskripsi" name="inputDeskripsi" rows="3"
                                    placeholder="Masukan Deskripsi" required></textarea>
                            </div>
                            <div class="form-group">
                                <input id="isVendor" name="isVendor" type="checkbox"
                                    aria-label="Checkbox for following text input" value="false">
                                <label for="exampleFormControlTextarea1">Apakah vendor / suplier</label>
                            </div>
                            <div class="form-group" id="vendorInput">
                                <label for="exampleInputEmail1">Nama Vendor / Supplier</label>
                                <input type="text" class="form-control" id="inputVendor" name="inputVendor"
                                    placeholder="Masukan Nama Kategori" required>
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
                        <h5 class="modal-title" id="exampleModalLabel">Edit Produk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" enctype="multipart/form-data">
                        {{-- @csrf --}}
                        <div class="modal-body">
                            <div id="errList"></div>
                            <input type="text" id="edit_data_id" aria-hidden="true" class="d-none">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Produk</label>
                                <input type="text" class="form-control" id="editProductName" name="editProductName"
                                    placeholder="Masukan Nama Kategori" required>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="exampleFormControlTextarea1">Stok</label>
                                    <input type="number" class="form-control" id="editStok" name="editStok"
                                        placeholder="Masukan Stok" required>
                                </div>
                                <div class="form-group col-6">
                                    <label for="exampleInputPassword1">Satuan</label>
                                    <select name="editSatuan" id="editSatuan"
                                        class="custom-select custom-select-md mb-3" required>
                                        <option value="">--Pilih Salah Satu--</option>
                                        <option value="satuan">Satuan</option>
                                        <option value="kilo">Kilo</option>
                                        <option value="botol">Botol</option>
                                        <option value="can">Can</option>
                                        <option value="liter">Liter (L)</option>
                                        <option value="mililiter">Mili Liter (Ml)</option>
                                        <option value="lusin">Lusin</option>
                                        <option value="pack">Pack</option>
                                        <option value="pcs">Pcs</option>
                                        <option value="pouch">Pouch</option>
                                        <option value="pasang">Pasang (psg)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="exampleFormControlTextarea1">Harga</label>
                                    <input type="number" class="form-control" id="editHarga" name="editHarga"
                                        placeholder="Masukan Harga" required>
                                </div>
                                <div class="form-group col-6">
                                    <label for="exampleInputPassword1">Kategori</label>
                                    <select name="editKategori" id="editKategori"
                                        class="custom-pc custom-select custom-select-md mb-3" required>
                                        <option value="">--Pilih Kategori--</option>
                                    </select>
                                </div>
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
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Deskripsi Produk</label>
                                <textarea class="form-control" id="editDeskripsi" name="editDeskripsi" rows="3"
                                    placeholder="Masukan Deskripsi" required></textarea>
                            </div>
                            <div class="form-group">
                                <input id="isEditVendor" name="isEditVendor" type="checkbox"
                                    aria-label="Checkbox for following text input" value="false">
                                <label for="exampleFormControlTextarea1">Apakah vendor / suplier</label>
                            </div>
                            <div class="form-group" id="vendorEdit">
                                <label for="exampleInputEmail1">Nama Vendor / Supplier</label>
                                <input type="text" class="form-control" id="editVendor" name="editVendor"
                                    placeholder="Masukan Nama Kategori" required>
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
                        <h5 class="modal-title" id="exampleModalLabel">Delete Produk</h5>
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
        fetchCategories()

        function fetchData() {
            $.ajax({
                type: "GET",
                url: "/product-fetch",
                dataType: "json",
                success: function(respons) {
                    console.log(respons.products)
                    $('tbody').html('')
                    $.each(respons.products.data, function(key, product) {
                        $('tbody').append('<tr>\
                        <td> <div style="display:flex; flex-direction:row; align-items:start"><img src="/storage/' + product.thumbnail + '" style="width:5rem; height:auto;margin-right:1rem" alt="img">' +
                        product.product_name + '</div></td>\
                        <td>' + product.product_category_name + '</td>\
                        <td>' + formatRupiah(product.product_price) + '</td>\
                        <td>' + product.vendor_name + '</td>\
                        <td> <div class="badge text-white bg-green">' + product.available_stock + '</div></td>\
                        <td>' + product.product_stock + '</td>\
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

        function fetchCategories(){
            $.ajax({
                type:"GET",
                url:"/pc-fetch",
                dataType:"json",
                success: function(respons){
                    // console.log(respons.areas)
                    // $('.custom-area').html('')
                    $.each(respons.product_categories.data, function(key, pc){
                        $('.custom-pc').append('<option value="'+pc.id+'">'+pc.product_category_name+'</option>')
                    })
                }
            })
        }

        function resetForm() {
            $('#inputProductName').val("")
            $('#inputStok').val("")
            $('#inputSatuan').val("")
            $('#inputHarga').val("")
            $('#inputKategori').val("")
            $('#inputDeskripsi').val("")
            $('#inputVendor').val("")
            $("#isVendor").prop("checked", 0);
            $("#isVendor").val("false");
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
            
            let data = {
                'product_name': $('#inputProductName').val(),
                'product_stock': $('#inputStok').val(),
                'product_type': $('#inputSatuan').val(),
                'product_price': $('#inputHarga').val(),
                'id_category': $('#inputKategori').val(),
                'thumbnail': $('#inputImages').prop('files')[0],
                'product_description': $('#inputDeskripsi').val(),
                'is_vendor': $('#isVendor').val(),
                'vendor_name': $('#inputVendor').val()
            }

            let formData = new FormData();
            formData.append('product_name', data.product_name);
            formData.append('product_stock', data.product_stock);
            formData.append('product_type', data.product_type);
            formData.append('product_price', data.product_price);
            formData.append('id_category', data.id_category);
            formData.append('thumbnail', $('#inputImages').prop('files')[0]);
            formData.append('product_description', data.product_description);
            formData.append('is_vendor', data.is_vendor);
            formData.append('vendor_name', data.vendor_name);

            
            $.ajax({
                type: "POST",
                url: "/product-store",
                data: formData,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res) {
                        console.log(res)
                        $('#alert-success').removeClass("d-none")
                        $('#alert-success').text("Success Create Product")
                        $('#modalAddUser').modal('hide')
                        fetchData()
                        resetForm()
                    } else {
                        //soon change with alert modals
                        alert("Error")
                    }
                },
                error: function(res){
                    Toast.fire({
                    icon: 'error',
                    title: 'Tolong Lengkapi Semua Data.'
                    })
                }
            })
        })

        

        $(document).on('click', '.trigger_edit', function(e) {
            e.preventDefault()
            let data_id = $(this).val()
            $.ajax({
                type: "GET",
                url: "/product-fetch/" + data_id,
                success: function(res) {
                    if (res.data) {
                        console.log(res.data)
                        $('#modalEditArea').modal('show')
                        $('#editProductName').val(res.data.product_name)
                        $('#editSatuan').val(res.data.product_type)
                        $('#editHarga').val(parseInt(res.data.product_price))
                        $('#editStok').val(parseInt(res.data.product_stock))
                        $('#editKategori').val(res.data.id_category)
                        $('#editDeskripsi').val(res.data.product_description)
                        // $('#isEditVendor').val(res.data.is_vendor)
                        if(res.data.is_vendor === "false"){
                            $("#vendorEdit").hide();
                            $("#isEditVendor").val(false);
                        }else{
                            $("#vendorEdit").show();
                            $("#isEditVendor").val(true);
                            $('#editVendor').val(res.data.vendor_name)
                        }
                        $('#edit_data_id').val(res.data.id)
                    } else {
                        alert("Error - Something Went woring")
                    }
                }
            })
        })

        $(document).on('click', '.btn-edit-data', function(e) {
            e.preventDefault()

            let data = {
            'product_name': $('#editProductName').val(),
            'product_stock': $('#editStok').val(),
            'product_type': $('#editSatuan').val(),
            'product_price': $('#editHarga').val(),
            'id_category': $('#editKategori').val(),
            'thumbnail': $('#editImages').prop('files')[0],
            'product_description': $('#editDeskripsi').val(),
            'is_vendor': $('#isEditVendor').val(),
            'vendor_name': $('#editVendor').val()
            }
            
            let formData = new FormData();
            formData.append('product_name', data.product_name);
            formData.append('product_stock', data.product_stock);
            formData.append('product_type', data.product_type);
            formData.append('product_price', data.product_price);
            formData.append('id_category', data.id_category);
            formData.append('thumbnail', $('#editImages').prop('files')[0]);
            formData.append('product_description', data.product_description);
            formData.append('is_vendor', data.is_vendor);
            formData.append('vendor_name', data.vendor_name);

            let selID = $('#edit_data_id').val();

            $.ajax({
                type: "POST",
                url: "/product-update/" + selID,
                data: formData,
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
                url: "/product-fetch/" + data_id,
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
                url: "/product-delete/" + data_id,
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

        //handling checklist
        $("#vendorInput").hide();
        $("#isVendor").click(function() {
            if($(this).is(":checked")) {
                $("#vendorInput").show();
                $("#isVendor").val(true);
            } else {
                $("#vendorInput").hide();
                $("#isVendor").val(false);
            }
        });

        $("#isEditVendor").click(function() {
            if($(this).is(":checked")) {
                $("#vendorEdit").show();
                $("#isEditVendor").val(true);
            } else {
                $("#vendorEdit").hide();
                $("#isEditVendor").val(false);
            }
        });


    })
</script>
@endsection

{{-- end custom script --}}
<!-- /.content -->
@endsection