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
                <h3>User</h3>
            </div>
            <!-- ./col -->
            <div class="col-lg-8 col-12">
                <!-- small box -->
                <div class="d-flex flex-row justify-content-end align-items-center" style=" gap:1rem;">
                    {{-- <div class="hello">
                        Hellooo
                    </div> --}}
                    <button data-toggle="modal" data-target="#modalAddUser" type="button" class="btn"
                        style="background:#00B517; color:white">Tambah User</button>
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
                                    <th>Username</th>
                                    <th>Nama Pengguna</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Area</th>
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
                        <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Pengguna</label>
                                <input type="text" class="form-control" id="inputFullname" name="inputFullname"
                                    placeholder="Masukan Nama Pengguna" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Username</label>
                                <input type="text" class="form-control" id="inputUsername" name="inputUsername"
                                    placeholder="Masukan Username" required>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="exampleFormControlTextarea1">Email</label>
                                    <input type="email" class="form-control" id="inputEmail" name="inputEmail"
                                        placeholder="Masukan Email" required>
                                </div>
                                <div class="form-group col-6">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" id="inputPassword" name="inputPassword"
                                        placeholder="Masukan Username" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="exampleInputPassword1">Role</label>
                                    <select name="inputRole" id="inputRole" class="custom-select custom-select-md mb-3"
                                        required>
                                        <option value="">--Pilih Role--</option>
                                        <option value="admin">Admin</option>
                                        <option value="member">Member</option>
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label for="exampleFormControlTextarea1">Area</label>
                                    <select name="inputArea" id="inputArea"
                                        class="custom-area custom-select custom-select-md mb-3" required>
                                        <option value="">--Pilih Area--</option>
                                    </select>
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
                    {{-- <form method="POST"> --}}
                        {{-- @csrf --}}
                        <div class="modal-body">
                            <div id="errList"></div>
                            <input type="text" id="edit_data_id" aria-hidden="true">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Pengguna</label>
                                <input type="text" class="form-control" id="editFullname" name="editFullname"
                                    placeholder="Masukan Nama Pengguna" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Username</label>
                                <input type="text" class="form-control" id="editUsername" name="editUsername"
                                    placeholder="Masukan Username" required>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="exampleFormControlTextarea1">Email</label>
                                    <input type="email" class="form-control" id="editEmail" name="editEmail"
                                        placeholder="Masukan Email" required>
                                </div>
                                <div class="form-group col-6">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" id="editPassword" name="editPassword"
                                        placeholder="Masukan Username" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="exampleInputPassword1">Role</label>
                                    <select name="editRole" id="editRole" class="custom-select custom-select-md mb-3"
                                        required>
                                        <option value="">--Pilih Role--</option>
                                        <option value="admin">Admin</option>
                                        <option value="member">Member</option>
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label for="exampleFormControlTextarea1">Area</label>
                                    <select name="editArea" id="editArea"
                                        class="custom-area custom-select custom-select-md mb-3" required>
                                        <option value="">--Pilih Area--</option>
                                    </select>
                                </div>
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
        fetchArea()
        fetchData()
        
        function fetchArea(){
            $.ajax({
                type:"GET",
                url:"/area-fetch",
                dataType:"json",
                success: function(respons){
                    // console.log(respons.areas)
                    // $('.custom-area').html('')
                    $.each(respons.areas.data, function(key, area){
                        $('.custom-area').append('<option value="'+area.id+'">'+area.area_name+'</option>')
                    })
                }
            })
        }
        
        function fetchData(){
            $.ajax({
                type:"GET",
                url:"/user-fetch",
                dataType:"json",
                success: function(respons){
                    console.log(respons.users)
                    $('tbody').html('')
                    $.each(respons.users.data, function(key, user){
                        $('tbody').append('<tr>\
                        <td>'+user.username+'</td>\
                        <td>'+user.fullname+'</td>\
                        <td>'+user.email+'</td>\
                        <td>'+user.role+'</td>\
                        <td>'+user.area_name+'</td>\
                        <td>'+user.created_at+'</td>\
                        <td>\
                        <button value="'+user.id+'" data-toggle="modal" data-target="#modalEditStudent" type="button" class="trigger_edit btn btn-warning">edit</button>\
                        <button value="'+user.id+'" type="button" class="trigger_delete btn btn-danger">delete</button>\
                        </td>\
                        <tr>\
                        ')
                    })
                }
            })
        }

        function resetForm(){
            $('#inputFullname').val("")
            $('#inputEmail').val("")
            $('#inputUsername').val("")
            $('#inputPassword').val("")
            $('#inputArea').val("")
            $('#inputRole').val("")
        }

        $(document).on('click','.btn-add-data', function(e){
            e.preventDefault()

            // let data_id = $('#delete_data_id').val()
            let data = {
                'fullname' : $('#inputFullname').val(),
                'email' : $('#inputEmail').val(),
                'username' : $('#inputUsername').val(),
                'password' : $('#inputPassword').val(),
                'area_id' : $('#inputArea').val(),
                'role' : $('#inputRole').val(),
            }

            console.log("HERE",data)
            $.ajax({
                type:"POST",
                url:"/registration",
                data:data,
                success: function (res){
                if(res){
                    console.log(res)
                    $('#alert-success').removeClass("d-none")
                    $('#alert-success').text("Success Create User")
                    $('#modalAddUser').modal('hide')
                    fetchData()
                    resetForm()
                }else{
                    //soon change with alert modals
                    alert("Error")
                }
                }
            })
        })

        $(document).on('click','.trigger_edit', function(e){
            e.preventDefault()
            let data_id = $(this).val()
            $.ajax({
                type:"GET",
                url:"/user-fetch/"+data_id,
                success: function (res){
                    if(res.data){
                        console.log(res.data)
                        $('#modalEditArea').modal('show')
                        $('#editFullname').val(res.data.fullname)
                        $('#editUsername').val(res.data.username)
                        $('#editEmail').val(res.data.email)
                        // $('#editPassword').val(res.data.password)
                        $('#editRole').val(res.data.role)
                        $('#editArea').val(res.data.id_area)
                        $('#edit_data_id').val(res.data.id)
                    }else{
                        alert("Error - Something Went woring")
                    }
                }
            })
        })

        $(document).on('click','.btn-edit-data', function(e){
            e.preventDefault()
            let data = {
                'fullname' : $('#editFullname').val(),
                'email' : $('#editEmail').val(),
                'username' : $('#editUsername').val(),
                'password' : $('#editPassword').val(),
                'area_id' : $('#editArea').val(),
                'role' : $('#editRole').val(),
                'id':$('#edit_data_id').val()
            }
            $.ajax({
                type:"PUT",
                url:"/user-update/"+data.id,
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
            console.log(data_id)
            $.ajax({
                type:"GET",
                url:"/user-fetch/"+data_id,
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
                url:"/user-delete/"+data_id,
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