<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <meta name="robots" content="all,follow">

    <link rel="stylesheet" href=" {{ asset('fe-dist/vendor/glightbox/css/glightbox.min.css') }}">
    <!-- Range slider-->
    <link rel="stylesheet" href=" {{ asset('fe-dist/vendor/nouislider/nouislider.min.css') }}">
    <!-- Choices CSS-->
    <link rel="stylesheet" href=" {{ asset('fe-dist/vendor/choices.js/public/assets/styles/choices.min.css') }}">
    <!-- Swiper slider-->
    <link rel="stylesheet" href=" {{ asset('fe-dist/vendor/swiper/swiper-bundle.min.css') }}">

    <!-- Google fonts-->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@300;400;700&amp;display=swap">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Martel+Sans:wght@300;400;800&amp;display=swap">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{ asset('fe-dist/css/style.default.css') }}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{ asset('fe-dist/css/custom.css') }}">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.png">
    {{--
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" /> --}}
</head>

<body>
    @if (str_contains(url()->current(),"detail-product"))
    <div class="page-holder" style="background:#f7f7f7">
        @else
        <div class="page-holder">
            @endif
            <!-- navbar-->
            <header class="header bg-white">
                <div>
                    <nav class="navbar navbar-expand-lg navbar-light px-lg-0">
                        <button class="navbar-toggler navbar-toggler-end" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation"><span
                                class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <div class="customheader container navbar-nav">
                                <a href="/">
                                    <img class="img-fluid" src="{{ asset('assets/images/logo.svg') }}" alt="...">
                                </a>
                                <div class="searching">
                                    <input type="text" name="" id="">
                                </div>
                                <div class="profile-container">
                                    <a class="nav-link" href="/cart"> <i class="fas fa-bell  me-1 text-gray"></i>
                                        {{-- <small class="text-gray fw-normal">(2)</small> --}}
                                    </a>
                                    <a class="nav-link" href="/cart"> <i
                                            class="fas fa-shopping-bag me-1 text-gray"></i></a>
                                    <div class="dropdown">
                                        <div class="user-wrapper" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <div class="user-container text-uppercase">
                                                {{ substr(Auth::user()->fullname,0,1) }}
                                            </div>
                                            <div class="username-text">
                                                {{ Auth::user()->fullname }}
                                            </div>
                                        </div>
                                        <ul class="dropdown-menu shadow-lg" aria-labelledby="dropdownMenuButton1"
                                            style="border:1px solid #f7f7f7">
                                            <li><a class="dropdown-item" style="color:red" href="/logout">Logout</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            {{-- <ul class="navbar-nav me-auto">
                                <li class="nav-item">
                                    <img class="img-fluid w-100" src="{{ asset('assets/images/logo.svg') }}" alt="...">
                                </li>
                                <li class="nav-item">
                                    <!-- Link--><a class="nav-link active" href="index.html">Home</a>
                                </li>
                                <li class="nav-item">
                                    <!-- Link--><a class="nav-link" href="shop.html">Shop</a>
                                </li>
                                <li class="nav-item">
                                    <!-- Link--><a class="nav-link" href="detail.html">Product detail</a>
                                </li>
                                <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" id="pagesDropdown"
                                        href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">Pages</a>
                                    <div class="dropdown-menu mt-3 shadow-sm" aria-labelledby="pagesDropdown"><a
                                            class="dropdown-item border-0 transition-link"
                                            href="index.html">Homepage</a><a
                                            class="dropdown-item border-0 transition-link"
                                            href="shop.html">Category</a><a
                                            class="dropdown-item border-0 transition-link" href="detail.html">Product
                                            detail</a><a class="dropdown-item border-0 transition-link"
                                            href="cart.html">Shopping cart</a><a
                                            class="dropdown-item border-0 transition-link"
                                            href="checkout.html">Checkout</a>
                                    </div>
                                </li>
                            </ul>
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item"><a class="nav-link" href="cart.html"> <i
                                            class="fas fa-dolly-flatbed me-1 text-gray"></i>Cart<small
                                            class="text-gray fw-normal">(2)</small></a></li>
                                <li class="nav-item"><a class="nav-link" href="#!"> <i
                                            class="far fa-heart me-1"></i><small class="text-gray fw-normal">
                                            (0)</small></a></li>
                                <li class="nav-item"><a class="nav-link" href="#!"> <i
                                            class="fas fa-user me-1 text-gray fw-normal"></i>Login</a></li>
                            </ul> --}}
                        </div>
                    </nav>
                    <div class="custom-border-bottom">
                        <div class="container second-nav">
                            <div class="left-side">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="categoriesdropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Semua Kategori
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="categoriesdropdown">
                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="right-side">
                                <div class="container-wallet">
                                    <i class="fas fa-wallet" style="color: black"></i>
                                    <div>Saldo Dompet</div>
                                    <div class="my-money">Rp. 2000.0000</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!--  Modal -->
            {{-- <div class="modal fade" id="productView" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content overflow-hidden border-0">
                        <button class="btn-close p-4 position-absolute top-0 end-0 z-index-20 shadow-0" type="button"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-body p-0">
                            <div class="row align-items-stretch">
                                <div class="col-lg-6 p-lg-0"><a
                                        class="glightbox product-view d-block h-100 bg-cover bg-center"
                                        style="background: url(img/product-5.jpg)" href="img/product-5.jpg"
                                        data-gallery="gallery1" data-glightbox="Red digital smartwatch"></a><a
                                        class="glightbox d-none" href="img/product-5-alt-1.jpg" data-gallery="gallery1"
                                        data-glightbox="Red digital smartwatch"></a><a class="glightbox d-none"
                                        href="img/product-5-alt-2.jpg" data-gallery="gallery1"
                                        data-glightbox="Red digital smartwatch"></a></div>
                                <div class="col-lg-6">
                                    <div class="p-4 my-md-4">
                                        <ul class="list-inline mb-2">
                                            <li class="list-inline-item m-0"><i
                                                    class="fas fa-star small text-warning"></i>
                                            </li>
                                            <li class="list-inline-item m-0 1"><i
                                                    class="fas fa-star small text-warning"></i>
                                            </li>
                                            <li class="list-inline-item m-0 2"><i
                                                    class="fas fa-star small text-warning"></i>
                                            </li>
                                            <li class="list-inline-item m-0 3"><i
                                                    class="fas fa-star small text-warning"></i>
                                            </li>
                                            <li class="list-inline-item m-0 4"><i
                                                    class="fas fa-star small text-warning"></i>
                                            </li>
                                        </ul>
                                        <h2 class="h4">Red digital smartwatch</h2>
                                        <p class="text-muted">$250</p>
                                        <p class="text-sm mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                            In
                                            ut ullamcorper leo, eget euismod orci. Cum sociis natoque penatibus et
                                            magnis
                                            dis parturient montes nascetur ridiculus mus. Vestibulum ultricies aliquam
                                            convallis.</p>
                                        <div class="row align-items-stretch mb-4 gx-0">
                                            <div class="col-sm-7">
                                                <div
                                                    class="border d-flex align-items-center justify-content-between py-1 px-3">
                                                    <span
                                                        class="small text-uppercase text-gray mr-4 no-select">Quantity</span>
                                                    <div class="quantity">
                                                        <button class="dec-btn p-0"><i
                                                                class="fas fa-caret-left"></i></button>
                                                        <input class="form-control border-0 shadow-0 p-0" type="text"
                                                            value="1">
                                                        <button class="inc-btn p-0"><i
                                                                class="fas fa-caret-right"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-5"><a
                                                    class="btn btn-dark btn-sm w-100 h-100 d-flex align-items-center justify-content-center px-0"
                                                    href="cart.html">Add to cart</a></div>
                                        </div><a class="btn btn-link text-dark text-decoration-none p-0" href="#!"><i
                                                class="far fa-heart me-2"></i>Add to wish list</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <!-- HERO SECTION-->
            <div class="container" style="margin-bottom: 0.5rem;">
                @yield('content')
            </div>
            <footer class="bg-dark text-white">
                <div class="container py-4">
                    <div class="row py-5">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <h6 class="text-uppercase mb-3">
                                <img class="img-fluid" src="{{ asset('assets/images/logo-white.svg') }}" alt="...">
                            </h6>
                            <ul class="list-unstyled mb-0">
                                <li class="footer-desc-new">
                                    Morbi cursus porttitor enim lobortis molestie. Duis
                                    gravida turpis dui, eget bibendum magna congue nec.
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <h6 class="text-uppercase mb-3">My Account</h6>
                            <ul class="list-unstyled mb-0">
                                <li><a class="footer-link" href="#!">My Account</a></li>
                                <li><a class="footer-link" href="#!">Order History</a></li>
                                <li><a class="footer-link" href="#!">Keranjang Belanja</a></li>
                                <li><a class="footer-link" href="#!">Notifikasi</a></li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-uppercase mb-3">Helps</h6>
                            <ul class="list-unstyled mb-0">
                                <li><a class="footer-link" href="#!">Privacy Policy</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="border-top pt-4" style="border-color: #1d1d1d !important">
                        <div class="row">
                            <div class="col-md-12 text-center text-md-start">
                                <center>
                                    <p class="small text-muted mb-0">Reeno Store &copy; 2024 All rights reserved.</p>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- JavaScript files-->
            {{-- <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script> --}}
            <script src="{{ asset('fe-dist/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
            <script src="{{ asset('fe-dist/vendor/glightbox/js/glightbox.min.js') }}"></script>
            <script src="{{ asset('fe-dist/vendor/nouislider/nouislider.min.js') }}"></script>
            <script src="{{ asset('fe-dist/vendor/swiper/swiper-bundle.min.js') }}"></script>
            <script src="{{ asset('fe-dist/vendor/choices.js/public/assets/scripts/choices.min.js') }}"></script>
            <script src="{{ asset('fe-dist/js/front.js') }}"></script>
            <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
            <script>
                // ------------------------------------------------------- //
            //   Inject SVG Sprite - 
            //   see more here 
            //   https://css-tricks.com/ajaxing-svg-sprite/
            // ------------------------------------------------------ //
            function injectSvgSprite(path) {
            
                var ajax = new XMLHttpRequest();
                ajax.open("GET", path, true);
                ajax.send();
                ajax.onload = function(e) {
                var div = document.createElement("div");
                div.className = 'd-none';
                div.innerHTML = ajax.responseText;
                document.body.insertBefore(div, document.body.childNodes[0]);
                }
            }
            // this is set to BootstrapTemple website as you cannot 
            // inject local SVG sprite (using only 'icons/orion-svg-sprite.svg' path)
            // while using file:// protocol
            // pls don't forget to change to your domain :)
            injectSvgSprite('https://bootstraptemple.com/files/icons/orion-svg-sprite.svg'); 
            
            </script>
            <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
                integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
                crossorigin="anonymous">
            @yield('scripts')
        </div>
</body>

</html>