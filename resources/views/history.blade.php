@extends('template-admin.user')
@section('content')

<section class="py-5" style="min-height: 80vh">
    <div class="container">
        <!-- RELATED PRODUCTS-->
        <div class="custom-cards">
            <h2 class="h5 text-uppercase mb-4">History Pemesanan</h2>
            <div class="row">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#Order ID</th>
                            <th scope="col">Tanggal Pemesanan</th>
                            <th scope="col">Total</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="#product-categories-zone">
                        <tr>
                            <th>1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                        </tr>
                    </tbody>
                </table>
            </div>
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

        fetchData()

        function format_status(data)
        {
            if (data === 'order') {
                return 'Sedang Dalam Proses';
            } else if (data === 'kirim') {
                return 'Barang Sedang Dikirim';
            } else if (data === 'proses') {
                return 'Menunggu Pengiriman';
            } else if (data === 'tolak') {
                return 'PO Ditolak';
            } else if (data === 'selesai') {
                return 'PO Selesai';
            } else {
                return 'Check Status';
            }
        }
 
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
                        <td>'+format_status(data.status)+'</td>\
                        <td>\
                        <a href="/detail-order/'+data.id+'"><button value="'+data.id+'" data-toggle="modal" data-target="#modalEditStudent" type="button" class="trigger_edit btn btn-primary">Lihat Detail</button></a>\
                        </td>\
                        <tr>\
                        ')
                    })
                }
            })
        }
    })
</script>
@endsection


@endsection