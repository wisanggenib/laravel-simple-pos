@extends('template-admin.user')
@section('content')

<section class="py-5">
    <div class="container">
        <div class="row mb-5 custom-cards-tb">
            <div class="col-lg-2">
                <!-- PRODUCT SLIDER-->
                <div class="row m-sm-0">
                    <div class="col-sm-2 p-sm-0 order-2 order-sm-1 mt-2 mt-sm-0 px-xl-2">
                        <div class="swiper product-slider-thumbs">
                            <div class="swiper-wrapper">
                                {{-- <div class="swiper-slide h-auto swiper-thumb-item mb-3"><img class="w-100"
                                        src="{{ asset('fe-dist/img/product-detail-1.jpg') }}" alt="..."></div>
                                <div class="swiper-slide h-auto swiper-thumb-item mb-3"><img class="w-100"
                                        src="{{ asset('fe-dist/img/product-detail-2.jpg') }}" alt="..."></div>
                                <div class="swiper-slide h-auto swiper-thumb-item mb-3"><img class="w-100"
                                        src="{{ asset('fe-dist/img/product-detail-3.jpg') }}" alt="..."></div>
                                <div class="swiper-slide h-auto swiper-thumb-item mb-3"><img class="w-100"
                                        src="{{ asset('fe-dist/img/product-detail-4.jpg') }}" alt="..."></div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 order-1 order-sm-2">
                        <div class="swiper product-slider">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide h-auto"><a class="glightbox product-view"
                                        href="/storage/{{$products->thumbnail}}" data-gallery="gallery2"
                                        data-glightbox="Product item 1"><img class="img-fluid"
                                            src="/storage/{{$products->thumbnail}}" alt="..."></a></div>
                                {{-- <div class="swiper-slide h-auto"><a class="glightbox product-view"
                                        href="{{ asset('fe-dist/img/product-detail-2.jpg') }}" data-gallery="gallery2"
                                        data-glightbox="Product item 2"><img class="img-fluid"
                                            src="{{ asset('fe-dist/img/product-detail-2.jpg') }}" alt="..."></a></div>
                                <div class="swiper-slide h-auto"><a class="glightbox product-view"
                                        href="{{ asset('fe-dist/img/product-detail-3.jpg') }}" data-gallery="gallery2"
                                        data-glightbox="Product item 3"><img class="img-fluid"
                                            src="{{ asset('fe-dist/img/product-detail-3.jpg') }}" alt="..."></a></div>
                                <div class="swiper-slide h-auto"><a class="glightbox product-view"
                                        href="{{ asset('fe-dist/img/product-detail-4.jpg') }}" data-gallery="gallery2"
                                        data-glightbox="Product item 4"><img class="img-fluid"
                                            src="{{ asset('fe-dist/img/product-detail-4.jpg') }}" alt="..."></a></div>
                                --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- PRODUCT DETAILS-->
            <div class="col-lg-10">
                <h1>{{$products->product_name}}</h1>
                <p class="text-muted lead">Rp. {{number_format($products->product_price, 0, ",", ",")}}</p>
                <p class="text-sm mb-4">{{$products->product_description}}</p>
                <div class="row align-items-stretch mb-4">
                    <div class="col-sm-5 pr-sm-0">
                        @csrf
                        <div
                            class="border d-flex align-items-center justify-content-between py-1 px-3 bg-white border-white">
                            <span class="small text-uppercase text-gray mr-4 no-select">Quantity</span>
                            <div class="quantity">
                                {{-- <button class="dec-btn p-0"><i class="fas fa-caret-left"></i></button> --}}
                                <input id="productQTY" name="productQTY" class="form-control border-0 shadow-0 p-0"
                                    type="number" min="0" value=1>
                                <input id="productID" name="productID" class="form-control d-none" type="text"
                                    value="{{$products->id}}">
                                {{-- <button class="inc-btn p-0"><i class="fas fa-caret-right"></i></button> --}}
                            </div>
                        </div>
                    </div>
                    @if (getStatusCutOff())
                    <div class="btn-add-cart col-sm-3 pl-sm-0"><a
                            class="btn btn-dark btn-sm btn-block h-100 d-flex align-items-center justify-content-center px-0">Add
                            to cart</a></div>
                    @else
                    <div class="col-sm-3 pl-sm-0"> <a href="#" style="background:grey"
                            class="btn btn-sm btn-block h-100 d-flex align-items-center justify-content-center px-0">Tidak
                            Boleh</a> </div>
                    @endif

                    {{-- @if ($avalable_stock > 0)
                    <div class="btn-add-cart col-sm-3 pl-sm-0"><a
                            class="btn btn-dark btn-sm btn-block h-100 d-flex align-items-center justify-content-center px-0">Add
                            to cart</a></div>
                    @else
                    <div class="col-sm-3 pl-sm-0"><a
                            class="btn btn-secondary btn-sm btn-block h-100 d-flex align-items-center justify-content-center px-0">Add
                            to cart</a></div>
                    @endif --}}
                </div>
                <ul class="list-unstyled small d-inline-block">
                    {{-- <li class="px-3 py-2 mb-1 bg-white"><strong class="text-uppercase">STOCK:</strong><span
                            class="ms-2 text-muted">{{$avalable_stock}}</span></li> --}}
                    <li class="px-3 py-2 mb-1 bg-white text-muted"><strong
                            class="text-uppercase text-dark">Category:</strong><a class="reset-anchor ms-2"
                            href="#!">{{$products->product_category_name}}</a></li>
                </ul>
            </div>
        </div>
        <!-- DETAILS TABS-->
        <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
            <li class="nav-item"><a class="nav-link text-uppercase active" id="description-tab" data-bs-toggle="tab"
                    href="#description" role="tab" aria-controls="description" aria-selected="true">Description</a></li>
        </ul>
        <div class="tab-content mb-5" id="myTabContent">
            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                <div class="p-4 p-lg-5 bg-white">
                    <h6 class="text-uppercase">Product description </h6>
                    <p class="text-muted text-sm mb-0">{{$products->product_description}}.</p>
                </div>
            </div>
        </div>
        <!-- RELATED PRODUCTS-->
        <div class="custom-cards">
            <h2 class="h5 text-uppercase mb-4">Related products</h2>
            <div class="row">
                <!-- PRODUCT-->
                @foreach($products2 as $user)
                <div class="col-lg-3 col-sm-6">
                    <div class="product text-center skel-loader">
                        <div class="d-block mb-3 position-relative"><a class="d-block"
                                href="/detail-product/{{$user->id}}"><img class="img-fluid w-100"
                                    src="/storage/{{$user->thumbnail}}" alt="..."></a>
                            <div class="product-overlay">
                                <ul class="mb-0 list-inline">
                                    <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-dark" href="#!">Add to
                                            cart</a></li>
                                    <li class="list-inline-item mr-0"><a class="btn btn-sm btn-outline-dark"
                                            href="#productView" data-bs-toggle="modal"><i class="fas fa-expand"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <h6> <a class="reset-anchor" href="/detail-product">{{$user->product_name}}</a></h6>
                        <p class="small text-muted">Rp. {{number_format($user->product_price, 0, ",", ".")}}</p>
                    </div>
                </div>
                @endforeach
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

        $(document).on('click','.btn-add-cart', function(e){
            e.preventDefault()
            let data = {
                'productQTY' : $('#productQTY').val(),
                'productID' : $('#productID').val()
            }

            $.ajax({
                type:"POST",
                url:"/add-to-chart",
                data:data,
                success: function (res){
                if(res){
                    if(res.message == "error"){
                        return(alert(res.data))
                    }
                    alert('success')
                    // window.location.reload()
                    window.location.href = '/cart';
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