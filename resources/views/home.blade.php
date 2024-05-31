@extends('template-admin.user')
@section('content')

<section>
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img class="img-fluid" src="{{ asset('fe-dist/img/hero-banner-alt.jpg') }}" alt="...">
            </div>
            <div class="swiper-slide">
                <img class="img-fluid" src="{{ asset('fe-dist/img/hero-banner-alt.jpg') }}" alt="...">
            </div>
            <div class="swiper-slide">
                <img class="img-fluid" src="{{ asset('fe-dist/img/hero-banner-alt.jpg') }}" alt="...">
            </div>
            <div class="swiper-slide">
                <img class="img-fluid" src="{{ asset('fe-dist/img/hero-banner-alt.jpg') }}" alt="...">
            </div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>

<!-- CATEGORIES SECTION-->
<section class="pt-5">
    <header class="header-section-custom">
        <h2 class="h5 text-uppercase">Kategori</h2>
        <a href="/shop">
            <div class="view-all-container">
                <div>Lihat Semua</div>
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>
    </header>
    <div class="row gap-mobile-2" id="product-categories-zone">
        <div class="col-md-2">
            <a class="category-item" href=""><img class="img-fluid w-100" src="{{ asset('fe-dist/img/product-1.jpg') }}"
                    alt="" />
                <div
                    style="position: absolute;bottom:5%;width:100%;display:flex;align-items:center;justify-content:center;font-weight:bold">
                    Helloow</div>
            </a>

        </div>
        <div class="col-md-2">
            <a class="category-item" href=""><img class="img-fluid" src="{{ asset('fe-dist/img/product-1.jpg') }}"
                    alt="" />
                <strong class="category-item-title">Clothes</strong>
            </a>
        </div>
        <div class="col-md-2">
            <a class="category-item" href=""><img class="img-fluid" src="{{ asset('fe-dist/img/product-1.jpg') }}"
                    alt="" />
                <strong class="category-item-title">Clothes</strong>
            </a>
        </div>
    </div>
</section>

<div class="py-5"></div>
<hr/>
<!-- TRENDING PRODUCTS-->
<section class="py-5">
    <header class="header-section-custom">
        <h2 class="h5 text-uppercase">List Produk</h2>
        <a href="/shop">
            <div class="view-all-container">
                <div>Lihat Semua</div>
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>
    </header>
    <div class="row" id="product-zone">
        <!-- PRODUCT-->

    </div>
</section>
<!-- SERVICES-->
{{-- <section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center gy-3">
            <div class="col-lg-4">
                <div class="d-inline-block">
                    <div class="d-flex align-items-end">
                        <svg class="svg-icon svg-icon-big svg-icon-light">
                            <use xlink:href="#delivery-time-1"> </use>
                        </svg>
                        <div class="text-start ms-3">
                            <h6 class="text-uppercase mb-1">Free shipping</h6>
                            <p class="text-sm mb-0 text-muted">Free shipping worldwide</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="d-inline-block">
                    <div class="d-flex align-items-end">
                        <svg class="svg-icon svg-icon-big svg-icon-light">
                            <use xlink:href="#helpline-24h-1"> </use>
                        </svg>
                        <div class="text-start ms-3">
                            <h6 class="text-uppercase mb-1">24 x 7 service</h6>
                            <p class="text-sm mb-0 text-muted">Free shipping worldwide</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="d-inline-block">
                    <div class="d-flex align-items-end">
                        <svg class="svg-icon svg-icon-big svg-icon-light">
                            <use xlink:href="#label-tag-1"> </use>
                        </svg>
                        <div class="text-start ms-3">
                            <h6 class="text-uppercase mb-1">Festivaloffers</h6>
                            <p class="text-sm mb-0 text-muted">Free shipping worldwide</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}
<!-- NEWSLETTER-->
{{-- <section class="py-5">
    <div class="container p-0">
        <div class="row gy-3">
            <div class="col-lg-6">
                <h5 class="text-uppercase">Let's be friends!</h5>
                <p class="text-sm text-muted mb-0">Nisi nisi tempor consequat laboris nisi.</p>
            </div>
            <div class="col-lg-6">
                <form action="#">
                    <div class="input-group">
                        <input class="form-control form-control-lg" type="email" placeholder="Enter your email address"
                            aria-describedby="button-addon2">
                        <button class="btn btn-dark" id="button-addon2" type="submit">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section> --}}

@section('scripts')
<script>
    var swiper = new Swiper(".mySwiper", {
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
    },
    });
</script>
<script>
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $(document).ready(function(){
        fetchDataProductCategories()
        fetchProduct()
 
        function fetchDataProductCategories(){
            $.ajax({
                type:"GET",
                url:"/pc-fetch",
                dataType:"json",
                success: function(respons){
                    const AA = respons.product_categories.data.slice(0,6)
                    $('#product-categories-zone').html('')
                    $.each(AA, function(key, product){
                        $('#product-categories-zone').append('<div class="col-md-2">\
                            <a class="category-item" href="shop?id_cat='+product.id+'"><img class="img-fluid" src="/storage/images/'+product.images+'" alt="" />\
                                <div style="position: absolute;bottom:0%;width:100%;background:white;display:flex;align-items:center;justify-content:center;font-weight:bold">'+product.product_category_name+'</div>\
                            </a>\
                        </div>\
                        ')
                    })
                }
            })
        }

        function fetchProduct() {
            $.ajax({
                type: "GET",
                url: "/product-fetch",
                dataType: "json",
                success: function(respons) {
                    console.log(respons.products)
                    $('#product-zone').html('')
                    $.each(respons.products.data, function(key, product) {
                        $('#product-zone').append('<div class="col-xl-3 col-lg-4 col-sm-6">\
                        <div class="product text-center">\
                            <div class="position-relative mb-3">\
                                <div class="badge text-white bg-"></div><a class="d-block" href="/detail-product/'+product.id+'"><img class="img-fluid w-100"\
                                        src="/storage/images/'+product.thumbnail+'" alt="..."></a>\
                                <div class="product-overlay">\
                                    <ul class="mb-0 list-inline">\
                                        <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-dark" href="/detail-product/'+product.id+'">Add\
                                                to\
                                                cart</a></li>\
                                        </li>\
                                    </ul>\
                                </div>\
                            </div>\
                            <h6> <a class="reset-anchor" href="/detail-product/'+product.id+'">'+product.product_name+'</a></h6>\
                            <p class="small text-muted">'+formatRupiah(product.product_price)+'</p>\
                        </div>\
                    </div>\
                        ')
                    })
                }
            })
        }
    })
</script>
@endsection


@endsection

{{-- <li class="list-inline-item me-0"><a class="btn btn-sm btn-outline-dark" href="#productView" \
        data-bs-toggle="modal"><i class="fas fa-expand"></i></a>\ --}}