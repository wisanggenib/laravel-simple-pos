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
                <h3>Konfigurasi Cut Off</h3>
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
                                    <th>Area</th>
                                    <th>Tanggal Cut Off</th>
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
                    <form method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Area</label>
                                <select name="inputArea" id="inputArea"
                                    class="custom-area custom-select custom-select-md mb-3" required>
                                    <option value="">--Pilih Area--</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Pilih Periode</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input name="inputPeriod" id="inputPeriod" type="text" placeholder="Select Date"
                                        class="form-control float-right">
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
                        <h5 class="modal-title" id="exampleModalLabel">Edit Cut off</h5>
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
                                <label for="exampleFormControlTextarea1">Area</label>
                                <select name="editArea" id="editArea"
                                    class="custom-area custom-select custom-select-md mb-3" required>
                                    <option value="">--Pilih Area--</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Pilih Periode</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input name="editPeriod" id="editPeriod" type="text" placeholder="Select Date"
                                        class="form-control float-right">
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
    
    $(document).ready(function(){
        fetchData()
        fetchArea()

        function resetForm(){
            $('#editArea').val("")
            $('#editPeriod').val("")
            $('#inputArea').val("")
            $('#inputPeriod').val("")
        }
        
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
                url:"/cutoff-fetch",
                dataType:"json",
                success: function(respons){
                    // console.log(respons.areas)
                    $('tbody').html('')
                    $.each(respons.cutoffs.data, function(key, cf){
                        $('tbody').append('<tr>\
                        <td>'+cf.area_name+'</td>\
                        <td>'+moment(cf.startDate).format("YYYY/MM/DD")+' - '+moment(cf.endDate).format("YYYY/MM/DD")+'</td>\
                        <td>'+moment(cf.created_at).format("YYYY/MM/DD HH:mm")+'</td>\
                        <td>\
                        <button value="'+cf.id+'" data-toggle="modal" data-target="#modalEditStudent" type="button" class="trigger_edit btn btn-warning">edit</button>\
                        <button value="'+cf.id+'" type="button" class="trigger_delete btn btn-danger">delete</button>\
                        </td>\
                        <tr>\
                        ')
                    })
                }
            })
        }

         $(document).on('click','.btn-add-data', function(e){
            e.preventDefault()

            let splitDate = $('#inputPeriod').val()
            let formatDate = splitDate.split("-");
            let startDate = formatDate[0].trim()
            let endDate = formatDate[1].trim()

            let data = {
            'startDate' : moment(startDate).format("YYYY-MM-DD HH:mm:ss"),
            'endDate' : moment(endDate).format("YYYY-MM-DD HH:mm:ss"),
            'area' : $('#inputArea').val()
            }

            $.ajax({
                type:"POST",
                url:"/cutoff-store",
                data:data,
                success: function (res){
                if(res){
                    if(res.message == "error"){
                        return(alert(res.data))
                    }
                    $('#alert-success').removeClass("d-none")
                    $('#alert-success').text("Success Create User")
                    $('#exampleModal').modal('hide')
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
                url:"/cutoff-fetch/"+data_id,
                success: function (res){
                    if(res.data){
                        $('#modalEditArea').modal('show')
                        $('#editPeriod').val(moment(res.data.startDate).format("MM/DD/YYYY") + " - " + moment(res.data.endDate).format("MM/DD/YYYY"))
                        $('#editArea').val(res.data.id_area)
                        $('#edit_data_id').val(data_id)
                    }else{
                        alert("Error - Something Went woring")
                    }
                }
            })
        })

        $(document).on('click','.btn-edit-data', function(e){
            e.preventDefault()
            
            let splitDate = $('#editPeriod').val()
            let formatDate = splitDate.split("-");
            let startDate = formatDate[0].trim()
            let endDate = formatDate[1].trim()

            let data = {
                'startDate' : moment(startDate).format("YYYY-MM-DD HH:mm:ss"),
                'endDate' : moment(endDate).format("YYYY-MM-DD HH:mm:ss"),
                'area' : $('#editArea').val()
            }
            let selID = $('#edit_data_id').val();
            
            $.ajax({
                type:"PUT",
                url:"/cutoff-update/"+selID,
                data: data,
                success: function (res){
                if(res.data){
                    if(res.message == "error"){
                    return(alert(res.data))
                    }
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
                url:"/cutoff-fetch/"+data_id,
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
                url:"/cutoff-delete/"+data_id,
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

        // var today = null;
        // var endDate = null;
        $('#inputPeriod').daterangepicker({ 
            // startDate: today, // after open picker you'll see this dates as picked
            // endDate: endDate,
            autoUpdateInput: false,
        })

        $('input[name="inputPeriod"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('input[name="inputPeriod"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        $('#editPeriod').daterangepicker({ 
            // startDate: today, // after open picker you'll see this dates as picked
            // endDate: endDate,
            autoUpdateInput: false,
        })

        $('input[name="editPeriod"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('input[name="editPeriod"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

    })
</script>
@endsection

{{-- end custom script --}}
<!-- /.content -->
@endsection