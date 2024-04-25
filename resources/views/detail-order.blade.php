@extends('template-admin.user')
@section('content')

<section class="py-5" style="min-height: 80vh">
    <div class="container">
        <!-- RELATED PRODUCTS-->
        <div class="custom-cards history-pesanan">
            <div class="d-flex flex-row gap-2" style="align-items: center; justify-items:center">
                <div class="title-detail-pesanan">Detail Pesanan</div>
                <div>/</div>
                <div>{{$orders->created_at}}</div>
                <div>/</div>
                <div>{{count($products)}} Produk</div>
                <div>/</div>
                <div
                    style="background:aqua;padding:2px;padding-left:0.5rem;padding-right:0.5rem; border-radius:8px;font-weight:600">
                    {{format_status($orders->status)}}</div>
            </div>
            <div class="row mt-3">
                <div class="col-8 py-2 font-gray1"
                    style="border-top:1px solid #E6E6E6;border-bottom:1px solid #E6E6E6;text-transform:uppercase;font-weight:500">
                    Penerima
                </div>
                <div class="col-4 d-flex flex-row py-2 font-gray1"
                    style="border-top:1px solid #E6E6E6;border-bottom:1px solid #E6E6E6; font-size:0.8rem; align-items:center;border-left:1px solid #E6E6E6;">
                    <div class="">ORDER ID:</div>
                    <div class="" style="color: #1A1A1A; margin-left:10px;font-weight:400">#{{$orders->id}}</div>
                </div>
            </div>
            {{-- penerima --}}
            <div class="row">
                <div class="col-8 py-2 d-flex flex-column" style="border-bottom:1px solid #E6E6E6;">
                    <div class="bold" style="font-weight: bold;font-size:1.2rem">
                        {{$user->fullname}}
                    </div>
                    <div class="font-gray2" style="margin-bottom: 0.8rem">
                        {{$user->area_location}}
                    </div>
                    <div class="font-gray2">
                        email : <span style="color: #1A1A1A">{{$user->email}}</span>
                    </div>
                </div>
                <div class="col-4 d-flex flex-column py-2"
                    style="border-bottom:1px solid #E6E6E6; font-size:0.8rem;border-left:1px solid #E6E6E6;">
                    <div class="d-flex flex-row py-1"
                        style="justify-content:space-between; border-bottom:1px solid gray">
                        <div class="font-gray2">Subtotal</div>
                        <div class="font-blacky1">Rp. {{number_format($orders->total)}}</div>
                    </div>
                    <div class="d-flex flex-row py-1"
                        style="justify-content:space-between; border-bottom:1px solid gray">
                        <div class="font-gray2">Discount</div>
                        <div class="font-blacky1">0%</div>
                    </div>
                    <div class="d-flex flex-row py-1"
                        style="justify-content:space-between;font-weight:bold; align-items:center">
                        <div class="font-gray2" style="font-size:1rem">Total</div>
                        <div class="font-blacky1" style="font-size:1.5rem; color:#2C742F">Rp.
                            {{number_format($orders->total)}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <table class="table table-detail">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="#product-categories-zone">
                        @foreach($products as $p)
                        <tr>
                            <td>
                                <div class="d-flex flex-row">
                                    <div class="d-flex"><img src="/storage/images/{{$p->thumbnail}}" alt="..."
                                            width="70" />
                                        <div class="ms-3" style="display:flex; align-items:center">
                                            <strong class="h6"><a class="reset-anchor animsition-link"
                                                    href="#">{{($p->product_name)}}</a></strong>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    Rp. {{number_format($p->price)}}
                                </div>

                            </td>
                            <td>{{$p->quantity}}</td>
                            <td>Rp. {{number_format(((int)$p->quantity * (int)$p->price))}}</td>
                            @if ($orders->status != 'kirim')
                            <td>
                                <div>{{ format_status($orders->status) }}</div>
                            </td>
                            @endif

                            @if ($p->status_barang == "proses" && $orders->status == 'kirim')
                            <td>
                                <button value={{$p->id}} type="button" class="upload_bukti btn btn-primary"
                                    data-bs-toggle="modal" data-bs-target="#modalOrder">
                                    Upload Bukti Terima
                                </button>
                            </td>
                            @endif
                            @if ($p->status_barang == "reject" && $orders->status == 'kirim')
                            <td style="width:30%">
                                <div style=" color:red">Ditolak user
                                </div>
                                <div style="font-size:0.8rem;color:gray">**{{ $p->deskripsi }}</div>
                            </td>
                            @endif
                            @if ($p->status_barang == "terima" && $orders->status == 'kirim')
                            <td>
                                <div style=" color:green">Barang Telah Diterima
                                </div>
                            </td>
                            @endif
                            @if ($p->status_barang == "ulang" && $orders->status == 'kirim')
                            <td>
                                <button value={{$p->id}} type="button" class="upload_bukti btn btn-primary"
                                    data-bs-toggle="modal" data-bs-target="#modalOrder">
                                    Upload Bukti Terima
                                </button>
                                <div style="color:gray; font-size:0.8rem;margin-top:0.5rem">**Sudah dikirm ulang</div>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($isCompletedAll && $orders->status == 'kirim')
            <div class="row">
                <div class="col-8">
                    {{-- <div>Masukan Bukti Terima</div> --}}
                    {{-- <input name="inputImages" id="inputImages" type="file"> --}}
                    <button class="btn btn-primary btn-kirim-data" id="btn-kirim-data">Selesaikan Pemesanan</button>
                    <input id="orderIDD" type="text" class="d-none" value={{$orders->id}}>
                </div>
            </div>
            @endif
        </div>
        {{-- {{dd(session()->all())}} --}}
    </div>
    <div class="modal fade" id="modalOrder" tabindex="-1" aria-labelledby="modalOrder" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Bukti</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Bukti Terima</label>
                        <input class="form-control" type="file" id="formFile">
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Status Barang</label>
                        <select class="form-select" id="statusTerima" aria-label="Default select example">
                            <option selected disabled>Pilih status</option>
                            <option value="terima">Terima</option>
                            <option value="reject">Tolak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Deskripsi / Alasan</label>
                        <textarea class="form-control" id="alasanTerima" rows="3"></textarea>
                    </div>
                    <input type="text" id="idOrderDetails" style="display: none">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="kirimStatus btn btn-primary">Kirim</button>
                </div>
            </div>
        </div>
    </div>
</section>

@section('scripts')
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // fetchData()
 
        function fetchData(){
            $.ajax({
                type:"GET",
                url:"/order-fetch",
                dataType:"json",
                success: function(respons){
                    console.log(respons.cutoffs)
                   $('tbody').html('')
                    $.each(respons.cutoffs, function(key, data){
                        $('tbody').append('<tr>\
                        <td>'+data.id+'</td>\
                        <td>'+moment(data.created_at).format("YYYY/MM/DD HH:mm")+'</td>\
                        <td>'+data.total+'</td>\
                        <td>'+data.status+'</td>\
                        <td>\
                        <button value="'+data.id+'" data-toggle="modal" data-target="#modalEditStudent" type="button" class="trigger_edit btn btn-primary">Lihat Detail</button>\
                        </td>\
                        <tr>\
                        ')
                    })
                }
            })
        }

        function resetForm(){
            $("#modalOrder").hide();
            $('#statusTerima').val("")
            $('#alasanTerima').val("")
            $('#idOrderDetails').val("")
            window.location.reload()
        }

        $(document).on('click', '.btn-kirim-data', function(e) {
            e.preventDefault()

            // let data = {
            // 'thumbnail': $('#inputImages').prop('files')[0],
            // }

            console.log("hjere")
            
            // let formData = new FormData();
            // formData.append('thumbnail', $('#inputImages').prop('files')[0]);

            let selID = $('#orderIDD').val();

            $.ajax({
                type: "POST",
                url: "/terima-barang/" + selID,
                // data: formData,
                // enctype: 'multipart/form-data',
                // cache: false,
                // contentType: false,
                // processData: false,
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

        $(document).on('click','.upload_bukti', function(e){
            e.preventDefault()
            let data_id = $(this).val()
            $('#idOrderDetails').val(data_id)
            
            $("#modalOrder").show();
            // $.ajax({
            //     type:"GET",
            //     url:"/order-fetch/"+data_id,
            //     success: function (res){
            //         if(res.data){
                        
            //         }else{
            //             alert("Error - Something Went woring")
            //         }
            //     }
            // })
        })

        $(document).on('click','.kirimStatus', function(e){
            // e.preventDefault()            

            let formData = new FormData();
            formData.append('bukti', $('#formFile').prop('files')[0]);
            formData.append('status', $('#statusTerima').val());
            formData.append('deskripsi', $('#alasanTerima').val());
            formData.append('idOrderDetails', $('#idOrderDetails').val());
            const idDetails = $('#idOrderDetails').val();
            $.ajax({
                type: "POST",
                url: "/update-status-barang/"+idDetails,
                data: formData,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                success: function (res){
                    if(res.data){
                        console.log(res)
                        resetForm()
                    }else{
                        alert("Error - Something Went woring")
                    }
                }
            })
        })
    })
</script>
@endsection


@endsection