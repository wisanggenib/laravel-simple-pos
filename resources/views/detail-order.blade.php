@extends('template-admin.user')
@section('content')

<section class="py-5" style="min-height: 80vh">
    <div class="container">
        <!-- RELATED PRODUCTS-->
        <div class="custom-cards">
            <div class="d-flex flex-row gap-2" style="align-items: center">
                <h2 class="">Detail Pesanan</h2>
                <div>/</div>
                <div>{{$orders->created_at}}</div>
                <div>/</div>
                <div>{{count($products)}} Produk</div>
                <div>/</div>
                <div
                    style="background:aqua;padding:2px;padding-left:4px;padding-right:4px; border-radius:2px;font-weight:bold">
                    {{format_status($orders->status)}}</div>
            </div>
            <div class="row mt-3">
                <div class="col-8 py-2" style="border-top:1px solid gray;border-bottom:1px solid gray;">
                    Penerima
                </div>
                <div class="col-4 d-flex flex-row py-2"
                    style="border-top:1px solid gray;border-bottom:1px solid gray; font-size:0.8rem; align-items:center;border-left:1px solid gray;">
                    <div class="">ORDER ID:</div>
                    <div class="">{{$orders->id}}</div>
                </div>
            </div>
            {{-- penerima --}}
            <div class="row">
                <div class="col-8 py-2 d-flex flex-column" style="border-bottom:1px solid gray;">
                    <div class="bold" style="font-weight: bold;font-size:1.2rem">
                        {{$user->fullname}}
                    </div>
                    <div class="div">
                        {{$user->area_location}}
                    </div>
                    <div class="div">
                        email : {{$user->email}}
                    </div>
                </div>
                <div class="col-4 d-flex flex-column py-2"
                    style="border-bottom:1px solid gray; font-size:0.8rem;border-left:1px solid gray;">
                    <div class="d-flex flex-row py-1"
                        style="justify-content:space-between; border-bottom:1px solid gray">
                        <div class="div">Subtotal</div>
                        <div class="div">Rp. {{number_format($orders->total)}}</div>
                    </div>
                    <div class="d-flex flex-row py-1"
                        style="justify-content:space-between; border-bottom:1px solid gray">
                        <div class="div">Discount</div>
                        <div class="div">0%</div>
                    </div>
                    <div class="d-flex flex-row py-1"
                        style="justify-content:space-between;font-weight:bold; align-items:center">
                        <div class="div" style="font-size:1rem">Total</div>
                        <div class="div" style="font-size:1.5rem; color:#2C742F">Rp. {{number_format($orders->total)}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody id="#product-categories-zone">
                        @foreach($products as $p)
                        <tr>
                            <td>
                                <div class="d-flex flex-row">
                                    <div class="d-flex"><img src="/storage/images/{{$p->thumbnail}}" alt="..."
                                            width="70" />
                                        <div class="ms-3"><strong class="h6"><a class="reset-anchor animsition-link"
                                                    href="#">{{($p->product_name)}}</a></strong></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    {{number_format($p->price)}}
                                </div>

                            </td>
                            <td>{{$p->quantity}}</td>
                            <td>Rp. {{number_format(((int)$p->quantity * (int)$p->price))}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($orders->status == 'kirim')
            <div class="row">
                <div class="col-8">
                    <div>Masukan Bukti Terima</div>
                    <input name="inputImages" id="inputImages" type="file">
                    <button class="btn btn-primary btn-kirim-data" id="btn-kirim-data">Kirim Bukti Terima</button>
                    <input id="orderIDD" type="text" class="d-none" value={{$orders->id}}>
                </div>
            </div>
            @endif
        </div>
        {{-- {{dd(session()->all())}} --}}
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
                url: "/terima-barang/" + selID,
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
    })
</script>
@endsection


@endsection