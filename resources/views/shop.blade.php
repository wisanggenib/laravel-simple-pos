@extends('template-admin.user')
@section('content')

<section class="py-5">
    <div class="container p-0">
        <div class="row">
            <!-- SHOP SIDEBAR-->

            <div class="col-lg-3 order-2 order-lg-1">

                <h6 class="text-uppercase mb-4">Cari Produk</h6>
                <div class="price-range mb-5">
                    <input type="text" class="form-control" value="" id="inputSearch" name="inputSearch"
                        style="width:100%" placeholder="Cari Produk">
                </div>
                <h6 class="text-uppercase mb-4">Price range</h6>
                <div class="price-range pt-4 mb-5">
                    <div id="range"></div>
                    <div class="row pt-2">
                        <div class="col-6"><strong class="small fw-bold text-uppercase">From</strong></div>
                        <div class="col-6 text-end"><strong class="small fw-bold text-uppercase">To</strong></div>
                    </div>
                </div>
                <h6 class="text-uppercase mb-3">Buying format</h6>
                <div class="list-category mb-5"></div>

                <button class="btn btn-primary" id="getSliderValue">Terapkan</button>
            </div>
            <!-- SHOP LISTING-->
            <div class="col-lg-9 order-1 order-lg-2 mb-5 mb-lg-0">
                <div class="row mb-3 align-items-center">
                    <div class="col-lg-6 mb-2 mb-lg-0">
                        {{-- <p class="text-sm text-muted mb-0">Showing 1–12 of 53 results</p> --}}
                    </div>
                    <div class="col-lg-6">
                        <ul class="list-inline d-flex align-items-center justify-content-lg-end mb-0">
                            {{-- <li class="list-inline-item text-muted me-3"><a class="reset-anchor p-0" href="#!"><i
                                        class="fas fa-th-large"></i></a></li>
                            <li class="list-inline-item text-muted me-3"><a class="reset-anchor p-0" href="#!"><i
                                        class="fas fa-th"></i></a></li>
                            <li class="list-inline-item">
                                <select class="selectpicker" data-customclass="form-control form-control-sm">
                                    <option value>Sort By </option>
                                    <option value="default">Default sorting </option>
                                    <option value="popularity">Popularity </option>
                                    <option value="low-high">Price: Low to High </option>
                                    <option value="high-low">Price: High to Low </option>
                                </select>
                            </li> --}}
                        </ul>
                    </div>
                </div>
                <div class="row list-produk">
                    <!-- PRODUCT-->

                </div>
                <!-- PAGINATION-->
                {{-- <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center justify-content-lg-end">
                        <li class="page-item mx-1"><a class="page-link" href="#!" aria-label="Previous"><span
                                    aria-hidden="true">«</span></a></li>
                        <li class="page-item mx-1 active"><a class="page-link" href="#!">1</a></li>
                        <li class="page-item mx-1"><a class="page-link" href="#!">2</a></li>
                        <li class="page-item mx-1"><a class="page-link" href="#!">3</a></li>
                        <li class="page-item ms-1"><a class="page-link" href="#!" aria-label="Next"><span
                                    aria-hidden="true">»</span></a></li>
                    </ul>
                </nav> --}}
            </div>
        </div>
    </div>
</section>

@section('scripts')
<script>
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $(document).ready(function(){
        fetchProductCategory()
        let max_price = 0
        priceRange()
      
      //handling button filter
        $("#getSliderValue").click(function () {
            var sliderValue = range.noUiSlider.get()
            var id_category = $(".form-check-input:checked").val();
            const removeString = (data) =>{
                const remove = data.replace('Rp.','')
                return parseInt(remove) || 0
            }
            const data = {
                min_price:removeString(sliderValue[0]),
                max_price:removeString(sliderValue[1]),
                id_category:id_category,
            }
            const dataEncode = encodeURIComponent(JSON.stringify(data))
            const A = $('#inputSearch').val()
            const AA  = A ? encodeURIComponent(JSON.stringify(A)) : ""
            fetchProduct(dataEncode,AA)
        });  

        function fetchProduct(data,name) {
            $.ajax({
                type: "GET",
                url: "/product-filter/"+data+"/"+name,
                dataType: "json",
                success: function(respons) {
                    $('.list-produk').html('')
                    $.each(respons.data, function(key, product) {
                        $('.list-produk').append('<div class="col-lg-4 col-sm-6">\
                            <div class="product text-center">\
                                <div class="mb-3 position-relative">\
                                    <div class="badge text-white bg-"></div><a class="d-block" href="/detail-product/'+product.id+'"><img class="img-fluid w-100"\
                                            src="/storage/'+product.thumbnail+'" alt="..."></a>\
                                    <div class="product-overlay">\
                                        <ul class="mb-0 list-inline">\
                                            <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-dark" href="/detail-product/'+product.id+'">Add\
                                                    to cart</a></li>\
                                        </ul>\
                                    </div>\
                                </div>\
                                <h6> <a class="reset-anchor" href="/detail-product/'+product.id+'">'+product.product_name+'</a></h6>\
                                <p class="small text-muted">'+product.product_price+'</p>\
                            </div>\
                        </div>\
                        ')
                    })
                }
            })
        }

        function priceRange() {
            $.ajax({
                type: "GET",
                url: "/price-range",
                dataType: "json",
                success: function(respons) {
                    console.log(respons.data[0].max_price)
                    var range = document.getElementById('range');
                        noUiSlider.create(range, {
                            range: {
                                'min': 0,
                                'max': parseInt(respons.data[0].max_price)
                            },
                            step: 1000,
                            start: [0, parseInt(respons.data[0].max_price)],
                            margin: 300,
                            connect: true,
                            direction: 'ltr',
                            orientation: 'horizontal',
                            behaviour: 'tap-drag',
                            tooltips: true,
                            format: {
                            to: function ( value ) {
                                return 'Rp.' + parseInt(value);
                            },
                            from: function ( value ) {
                                return value.replace('', '');
                            }
                            }
                    });

                    //after that call this first get
                    const searchParams = new URLSearchParams(window.location.search);
                    const x = searchParams.get('id_cat');
                    const data = {
                        min_price:0,
                        max_price:respons.data[0].max_price,
                        id_category:x ? x : "All",
                    }
                    const dataEncode = encodeURIComponent(JSON.stringify(data))
                    const A = $('#inputSearch').val()
                    const AA = A ? encodeURIComponent(JSON.stringify(A)) :""
                    fetchProduct(dataEncode,AA)
                }
            })
        }

        function fetchProductCategory(){
            $.ajax({
                type: "GET",
                url: "/pc-fetch-all",
                dataType: "json",
                success: function(respons) {
                    const searchParams = new URLSearchParams(window.location.search);
                    const x = searchParams.get('id_cat');
                    $('.list-category').html('')
                    $('.list-category').append('<div class="form-check mb-1">\
                        <input class="form-check-input" value="All" type="radio" name="customRadio" id="radio_4" checked>\
                        <label class="form-check-label" for="radio_4">All Data</label>\
                    </div>\
                    ')
                    $.each(respons.product_categories, function(key, product) {
                        const isCheck = x === product.id ? 'checked':'';
                        $('.list-category').append('<div class="form-check mb-1">\
                            <input class="form-check-input" value="'+product.id+'" type="radio" name="customRadio" id="'+product.id+'" '+isCheck+' >\
                            <label class="form-check-label" for="'+product.id+'">'+product.product_category_name+'</label>\
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