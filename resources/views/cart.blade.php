@extends('template-admin.user')
@section('content')
<section class="py-5">
    <h2 class="h5 text-uppercase mb-4">Keranjang saya</h2>
    <div class="row gx-5">
        <div class="col-lg-8 mb-4 mb-lg-0">
            <div class="custom-cards">
                <!-- CART TABLE-->
                <div class="table-responsive mb-4">
                    <table class="table text-nowrap">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 p-3" scope="col"> <strong
                                        class="text-sm text-uppercase">Produk</strong></th>
                                <th class="border-0 p-3" scope="col"> <strong
                                        class="text-sm text-uppercase">Harga</strong>
                                </th>
                                <th class="border-0 p-3" scope="col"> <strong
                                        class="text-sm text-uppercase">Quantity</strong></th>
                                <th class="border-0 p-3" scope="col"> <strong
                                        class="text-sm text-uppercase">Total</strong>
                                </th>
                                <th class="border-0 p-3" scope="col"> <strong class="text-sm text-uppercase"></strong>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="border-0">
                            @foreach($cart_products as $p)
                            <tr>
                                <th class="ps-0 py-3 border-light" scope="row">
                                    <div class="d-flex align-items-center"><a
                                            class="reset-anchor d-block animsition-link" href="detail.html"><img
                                                src="/storage/{{$p['image']}}" alt="..." width="70" /></a>
                                        <div class="ms-3"><strong class="h6"><a class="reset-anchor animsition-link"
                                                    href="detail.html">{{($p['product_name'])}}</a></strong></div>
                                    </div>
                                </th>
                                <td class="p-3 align-middle border-light">
                                    <p class="mb-0 small">Rp.{{(number_format($p['price']))}}</p>
                                </td>
                                <td class="p-3 align-middle border-light">
                                    <div class="border d-flex align-items-center justify-content-between px-3">
                                        {{-- <span
                                            class="small text-uppercase text-gray headings-font-family">Quantity</span>
                                        --}}
                                        <div class="quantity">
                                            <button value={{$p['id']}} class="btn-update-cart dec-btn p-0"
                                                onclick="handleDecreaseQTY(this.value)"><i
                                                    class="fas fa-caret-left"></i></button>
                                            <input class="form-control form-control-sm border-0 shadow-0 p-0"
                                                type="number" min="0" style="background: white; width:100%" disabled
                                                value={{($p['quantity'])}} />
                                            <button value={{$p['id']}} onclick="handleAddQTY(this.value)"
                                                class="btn-update-cart inc-btn p-0"><i
                                                    class="fas fa-caret-right"></i></button>

                                        </div>
                                    </div>
                                </td>
                                <td class="p-3 align-middle border-light">
                                    <p class="mb-0 small">Rp.{{number_format(($p['quantity']) * ($p['price']))}}</p>
                                </td>
                                <td class="p-3 align-middle border-light"><a class="reset-anchor"
                                        href="/delete-cart/{{$p['id']}}"><i
                                            class="fas fa-trash-alt small text-muted"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- CART NAV-->
                <div class="bg-light px-4 py-3">
                    <div class="row align-items-center text-center">
                        <div class="col-md-6 mb-3 mb-md-0 text-md-start"><a class="btn btn-link p-0 text-dark btn-sm"
                                href="/"><i class="fas fa-long-arrow-alt-left me-2"> </i>Lanjut Belanja</a>
                        </div>
                        {{-- <div class="col-md-6 text-md-end"><a class="btn btn-outline-dark btn-sm"
                                href="checkout.html">Procceed to
                                checkout<i class="fas fa-long-arrow-alt-right ms-2"></i></a></div> --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- ORDER TOTAL-->
        <div class="col-lg-4">
            <div class="custom-cards p-lg-4 bg-light">
                <div class="card-body">
                    <h5 class="text-uppercase mb-4">Cart total</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-center justify-content-between"><strong
                                class="text-uppercase small font-weight-bold">Subtotal</strong><span
                                class="text-muted small">Rp.{{number_format($cart_total)}}</span></li>
                        <li class="border-bottom my-2"></li>
                        <li class="d-flex align-items-center justify-content-between mb-4"><strong
                                class="text-uppercase small font-weight-bold">Total</strong><span>Rp.
                                {{number_format($cart_total)}}</span>
                        </li>
                        <li>
                            {{-- <form action="#"> --}}

                                @if (count($cart_products) > 0)
                                <div class="input-group mb-0">
                                    <button class="btn btn-dark btn-sm w-100" data-bs-toggle="modal"
                                        data-bs-target="#modalPayment">Bayar
                                        Sekarang</button>
                                </div>
                                @else
                                <div class="input-group mb-0">
                                    <button class="btn btn-dark btn-sm w-100" data-bs-toggle="modal"
                                        data-bs-target="#modalPayment" disabled>Bayar
                                        Sekarang</button>
                                </div>
                                @endif

                                {{--
                            </form> --}}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPayment" tabindex="-1" aria-labelledby="modalPaymentLabel" aria-hidden="true">
        <div class="modal-dialog" style="color: #3B4963">
            <div class="modal-content" style="border-radius:12px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPaymentLabel">Payment Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"
                    style="padding-left:1rem; padding-right:1rem; display flex; flex-direction:column;">
                    <div
                        style="display:flex;flex-direction:row;justify-content:space-between;align-items:center;border-bottom:1px solid gray; margin-bottom:10px;padding-bottom: 10px">
                        <div class="payment-title">Saldo Dompet</div>
                        <div class="payment-content1">Rp. {{number_format(users_count(), 0, ",", ".")}}</div>
                    </div>
                    <div
                        style="display:flex;flex-direction:row;justify-content:space-between;align-items:center; margin-bottom:5rem">
                        <div class="payment-title" style="font-size:18px;">Total Pembayaran</div>
                        <div class="payment-content1" style="font-weight: bold">Rp. {{number_format($cart_total, 0, ",",
                            ".")}}</div>
                    </div>

                    @if (users_count()>=$cart_total)
                    <div><button type="button" class="btn btn-primary btn-order" id="btn-order"
                            style="width: 100%;background:#1C86FF;border-radius:10px;border:none;margin-bottom:10px;color:white">Bayar</button>
                    </div>
                    @else
                    <div><button type="button" class="btn btn-primary" disabled
                            style="width: 100%;background:#1C86FF;border-radius:10px;border:none;margin-bottom:1rem;color:white">Bayar</button>
                    </div>
                    @endif
                    <div><button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            style="width: 100%;margin-bottom:10px;border-radius:10px;border:1px solid gray; background:white;color:gray">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('scripts')
<script>
    function handleAddQTY(id){
        let data = {
            'status' : 'inc',
            'productID' : id
        }
        console.log(data)
        $.ajax({
                type:"POST",
                url:"/update-to-chart",
                data:data,
                success: function (res){
                if(res){
                    
                    if(res.message == "error"){
                        alert(res.data)
                        return window.location.reload()
                    }
                    window.location.reload()
                }else{
                    //soon change with alert modals
                    alert("Error")
                }
                }
            })
    }

    function handleDecreaseQTY(id){
        let data = {
            'status' : 'dec',
            'productID' : id
        }
        $.ajax({
                type:"POST",
                url:"/update-to-chart",
                data:data,
                success: function (res){
                if(res){
                    if(res.message == "error"){
                        alert(res.data)
                        return window.location.reload()
                    }
                    window.location.reload()
                }else{
                    //soon change with alert modals
                    alert("Error")
                }
                }
            })
    }

    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click','.btn-order', function(e){
            e.preventDefault()

            $.ajax({
                type:"POST",
                url:"/order",
                data:null,
                success: function (res){
                if(res){
                    if(res.status === 400){
                        alert("Stock Berubah");
                        return window.location.reload();
                    }
                    else if(res.message == "error"){
                        return(alert(res.data))
                    }
                    alert('success')
                    // window.location.reload();
                    window.location.href = '/history';
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
@endsection