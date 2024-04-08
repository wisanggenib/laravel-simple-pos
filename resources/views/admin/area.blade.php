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
                <h3>Area</h3>
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
                                    <th>Nama Area</th>
                                    <th>Limit Budget</th>
                                    <th>Tanggal diubah</th>
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

        {{-- modal --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom: 0px">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Area</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/area-store" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Area</label>
                                <input type="text" class="form-control" id="inputAreaName" name="inputAreaName"
                                    placeholder="Masukan Nama Area" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Limit Budget</label>
                                <input type="number" class="form-control" id="inputBudget" name="inputBudget"
                                    placeholder="Masukan Limit Budget" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Alamat Lengkap</label>
                                <textarea class="form-control" id="inputAddress" name="inputAddress" rows="3"
                                    placeholder="Masukan alamat lengkap area" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
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
                    {{-- <form method="POST"> --}}
                        {{-- @csrf --}}
                        <div class="modal-body">
                            <div id="errList"></div>
                            <input type="text" id="edit_data_id" class="d-none" aria-hidden="true">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Ubah Area</label>
                                <input type="text" class="form-control" id="editAreaName" name="editAreaName"
                                    placeholder="Masukan Nama Area" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Limit Budget</label>
                                <input type="number" class="form-control" id="editBudget" name="editBudget"
                                    placeholder="Masukan Limit Budget" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Alamat Lengkap</label>
                                <textarea class="form-control" id="editAddress" name="editAddress" rows="3"
                                    placeholder="Masukan alamat lengkap area" required></textarea>
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
                        <h5 class="modal-title" id="exampleModalLabel">Edit Area</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="errList"></div>
                        <input class="d-none" type="text" id="delete_data_id">
                        <div>
                            Apakah kamu yakin ingin menghapus area ini ? data yang telah dihapus tidak dapat
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
    
    $(document).ready(function(){
        fetchData()
        
        function fetchData(){
            $.ajax({
                type:"GET",
                url:"/area-fetch",
                dataType:"json",
                success: function(respons){
                    // console.log(respons.areas)
                    $('tbody').html('')
                    $.each(respons.areas.data, function(key, area){
                        $('tbody').append('<tr>\
                        <td>'+area.area_name+'</td>\
                        <td>'+area.area_budget+'</td>\
                        <td>'+moment(area.updated_at).format("YYYY/MM/DD HH:mm")+'</td>\
                        <td>'+moment(area.created_at).format("YYYY/MM/DD HH:mm")+'</td>\
                        <td>\
                        <button value="'+area.id+'" data-toggle="modal" data-target="#modalEditStudent" type="button" class="trigger_edit btn btn-warning">edit</button>\
                        <button value="'+area.id+'" type="button" class="trigger_delete btn btn-danger">delete</button>\
                        </td>\
                        <tr>\
                        ')
                    })
                }
            })
        }

        $(document).on('click','.trigger_edit', function(e){
            e.preventDefault()
            let data_id = $(this).val()
            $.ajax({
                type:"GET",
                url:"/area-fetch/"+data_id,
                success: function (res){
                    if(res.data){
                        $('#modalEditArea').modal('show')
                        $('#editAreaName').val(res.data.area_name)
                        $('#editBudget').val(res.data.area_budget)
                        $('#editAddress').val(res.data.area_location)
                        $('#edit_data_id').val(data_id)
                    }else{
                        alert("Error - Something Went woring")
                    }
                }
            })
        })

        $(document).on('click','.btn-edit-data', function(e){
            e.preventDefault()
            let data = {
                'area_id': $('#edit_data_id').val(),
                'area_name': $('#editAreaName').val(),
                'area_location': $('#editAddress').val(),
                'area_budget': $('#editBudget').val(),
            
            }
            $.ajax({
                type:"PUT",
                url:"/area-update/"+data.area_id,
                data: data,
                success: function (res){
                if(res.data){
                    $('#alert-success').removeClass("d-none")
                    $('#alert-success').text("Success Edit")
                    $('#modalEditArea').modal('hide')
                    fetchData()
                }else{
                    //soon change with alert modals
                    alert("Error")
                }
                }
            })
        })

        $(document).on('click','.trigger_delete', function(e){
            e.preventDefault()
            let data_id = $(this).val()
            $.ajax({
                type:"GET",
                url:"/area-fetch/"+data_id,
                success: function (res){
                    if(res.data){
                        $('#modalDeleteArea').modal('show')
                        $('#delete_data_id').val(data_id)
                    }else{
                        alert("Error - Something Went woring")
                    }
                }
            })
        })

        $(document).on('click','.btn-delete-data', function(e){
            e.preventDefault()

            let data_id = $('#delete_data_id').val()
            console.log(data_id)
            $.ajax({
                type:"DELETE",
                url:"/area-delete/"+data_id,
                success: function (res){
                if(res.data){
                    $('#alert-success').removeClass("d-none")
                    $('#alert-success').text("Success Delete")
                    $('#modalDeleteArea').modal('hide')
                    fetchData()
                }else{
                    //soon change with alert modals
                    alert("Error")
                }
                }
            })
        })


    })
</script>
@endsection

{{-- end custom script --}}
<!-- /.content -->
@endsection