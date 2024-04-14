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
                <h3>Pesanan</h3>
            </div>
            <!-- ./col -->
            <div class="col-lg-8 col-12">
                <!-- small box -->
                <div class="d-flex flex-row justify-content-end align-items-center" style=" gap:1rem;">
                    {{-- <div class="hello">
                        Hellooo
                    </div> --}}
                    {{-- <button type="button" class="btn" style="background:#00B517; color:white">Tambah
                        Area</button> --}}
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row" style="margin-top:1rem">
            {{-- {{dd($orders)}} --}}
            @foreach($orders as $o)
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body p-0" style="overflow: hidden">
                        <div class="d-flex flex-row" style="border-bottom:1px solid gray">
                            <div class="d-flex flex-row p-3 px-4" style="gap:0.5rem;">
                                <div class="div">{{format_status($o->status)}}</div>
                                <div class="div">/</div>
                                <div class="div" style="font-weight: bold; color:#00B517">#{{$o->id}}</div>
                                <div class="div">/</div>
                                <div class="div">{{$o->created_at}}</div>
                            </div>
                        </div>
                        <div class="row" style="border-bottom:1px solid gray">
                            <div class="col-12" style="">
                                <div class="row px-4 py-1">
                                    {{-- <div class="row col-4" style="background: yellow">
                                        <div class="col-4">
                                            images
                                        </div>
                                        <div class="col-8 d-flex flex-column">
                                            <div class="">Product</div>
                                            <div class="">Dan lain</div>
                                        </div>
                                    </div> --}}
                                    <div class="col-6 d-flex flex-column">
                                        <div style="font-weight: 600; font-size:1rem">Alamat</div>
                                        <div style="color:#758091">{{$o->area_location}}</div>
                                    </div>
                                    <div class="col-6 d-flex flex-column">
                                        <div style="font-weight: 600; font-size:1rem">Pemesan</div>
                                        <div style="color:#758091">{{$o->fullname}}</div>
                                        <div style="color:#758091">{{$o->email}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="border-bottom:1px solid gray">
                            <div class="col-12 py-2 px-4" style="">
                                <div class="d-flex flex-row"
                                    style="align-items: center; justify-content: space-between">
                                    <div style="font-weight: bold; font-size:1rem" class="">Total Pesanan</div>
                                    <div style="font-weight: bold; font-size:1.2rem" class="">Rp.
                                        {{number_format($o->total)}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 py-2 px-4" style="">
                                <div class="d-flex flex-row" style="align-items: flex-end; justify-content: flex-end">
                                    <button value={{$o->id}}
                                        type="button" class="trigger_edit btn btn-primary">Lihat Detail</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            @endforeach
            <!-- /.col -->
        </div>
        <!-- /.row (main row) -->

        {{-- modal --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom: 0px">
                        <h5 class="modal-title" id="exampleModalLabel">Detail Pesanan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex flex-row"
                                        style="justify-content: space-between; align-items: center">
                                        <div class="div">No. Order</div>
                                        <input id="orderIDD" type="text" disabled
                                            style="all:unset;width:40%;color:#00B517;font-weight:bold" class="div" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex flex-row"
                                        style="justify-content: space-between; align-items: center">
                                        <div class="div">Tanggal Pemesanan</div>
                                        <input id="tanggalPesan" type="text" disabled style="all:unset;width:40%;"
                                            class="div" />
                                    </div>
                                </div>
                                <div class="col-12 mt-5">
                                    Detail Produk
                                </div>
                                <div class="row mx-2" id="detaill-produk" style="width: 100%">
                                    <div class="col-12 p-2 mx-2" style="border:1px solid gray;border-radius:8px">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="d-flex flex-row">
                                                    <div>Image</div>
                                                    <div>
                                                        <div>asd</div>
                                                        <div>asd</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="d-flex flex-column" style="align-items: center">
                                                    <div class="">Total</div>
                                                    <div class="">Rp XXXX</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="text" name="edit_data_id" id="edit_data_id" class="d-none">
                                <div class="row mx-2" id="warpproses" style="width: 100%">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" id="modalFooters">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn-add-data btn btn-primary">Save changes</button>
                        </div>
                    </form>
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
        

        $(document).on('click','.trigger_edit', function(e){
            e.preventDefault()
            let data_id = $(this).val()
            console.log(data_id)
            $.ajax({
                type:"GET",
                url:"/order-fetch/"+data_id,
                success: function (res){
                    if(res.data){
                        $('#exampleModal').modal('show')
                        $('#orderIDD').val(res.data[0].id)
                        $('#tanggalPesan').val(res.data[0].created_at)

                        //set button
                        $('#modalFooters').html('')
                        $('#warpproses').html('')
                        console.log(res.data[0])
                        if(res.data[0].status === 'order'){
                            $('#modalFooters').append('<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>\
                            <button type="submit" id="btn-tolak-data" class="btn-tolak-data btn-add-data btn btn-danger">Tolak</button>\
                            <button type="submit" class="btn-add-data btn btn-primary">Proses</button>\
                            ')
                        }
                        else if(res.data[0].status === 'proses'){
                            $('#modalFooters').append('<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>\
                                <button type="submit" id="btn-kirim-data" class="btn-kirim-data btn-add-data btn btn-primary">Kirim</button>\
                            ')

                            $('#warpproses').append('<div class="col-12 p-2 mx-2">\
                                    <div class="row">\
                                        <div class="col-12">Masukan Bukti Kirim</div>\
                                        <input name="inputImages" style="border:1px solid gray;margin-left:0.5rem;" id="inputImages" type="file">\
                                    </div>\
                                </div>\
                            ')
                        }else{
                            $('#modalFooters').append('<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>\
                            ')
                        }
                       

                        // 'order', 'proses', 'kirim', 'selesai', 'tolak'

                        //reset produk
                        $('#detaill-produk').html('')
                        $.each(res.data, function(key, cf){
                        $('#detaill-produk').append('\
                        <div class="col-12 p-2 mx-2" style="border:1px solid gray;border-radius:8px;margin-top:0.5rem;">\
                            <div class="row">\
                                <div class="col-8">\
                                    <div class="d-flex flex-row">\
                                        <div><img src="/storage/images/' + cf.thumbnail + '" style="width:5rem; height:auto;margin-right:1rem" alt="img"></div>\
                                        <div>\
                                            <div>'+cf.product_name+'</div>\
                                            <div>'+cf.quantity+' x '+cf.price+'</div>\
                                        </div>\
                                    </div>\
                                </div>\
                                <div class="col-4">\
                                    <div class="d-flex flex-column" style="align-items: center">\
                                        <div class="">Total</div>\
                                        <div class="">Rp '+parseInt(cf.price)*parseInt(cf.quantity)+'</div>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>\
                            ')
                            })
                    }else{
                        alert("Error - Something Went woring")
                    }
                }
            })
        })

        $(document).on('click', '.btn-kirim-data', function(e) {
            e.preventDefault()

            let data = {
            'thumbnail': $('#inputImages').prop('files')[0],
            }
            
            let formData = new FormData();
            formData.append('thumbnail', $('#inputImages').prop('files')[0]);

            let selID = $('#orderIDD').val();

            $.ajax({
                type: "POST",
                url: "/kirim-barang/" + selID,
                data: formData,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.data) {
                        $('#alert-success').removeClass("d-none")
                        $('#alert-success').text("Success Edit")
                        $('#exampleModal').modal('hide')
                        window.location.reload()
                    } else {
                        //soon change with alert modals
                        alert("Error")
                    }
                }
            })
        })

        $(document).on('click', '.btn-tolak-data', function(e) {
            e.preventDefault()

            let selID = $('#orderIDD').val();

            $.ajax({
                type: "POST",
                url: "/tolak-barang/" + selID,
                data: null,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.data) {
                        $('#alert-success').removeClass("d-none")
                        $('#alert-success').text("Success Edit")
                        $('#exampleModal').modal('hide')
                        window.location.reload()
                    } else {
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