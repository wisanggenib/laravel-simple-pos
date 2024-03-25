<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('dist/css/custom.css') }}">
</head>

<body>
    <section class="vh-100">
        <div class="container-fluid">
            <div class="row d-flex justify-content-center align-items-center vh-100" style="max-height: 100vh;">
                <div class="col-md-6 col-sm-12" style="padding-left: 3rem; padding-right: 3rem">
                    <h3>Masuk Ke Megamart</h3>
                    <span>Masukkan kredensial Anda untuk masuk ke akun Anda</span>
                    <hr>
                    <form action="/login-action" method="POST" class="d-flex flex-grow-1 flex-column">
                        @csrf
                        <div class="containerform d-flex flex-column flex-grow-1 g-3">
                            <div class=" col-12 col-md-12 col-sm-12 mb-3">
                                <label for="formFile" class="form-label">Username</label>
                                <input class="form-control" type="text" id="formFile" name="username"
                                    placeholder="Masukan username">
                            </div>
                            <div>
                                <label for="formFile" class="form-label">Nama Akun</label>
                                <div class="input-group mb-3">
                                    <input name="password" type="password" value="" class="input form-control"
                                        id="password" placeholder="password" required="true" aria-label="password"
                                        aria-describedby="basic-addon1" />
                                    <div class="input-group-append">
                                        <span class="input-group-text" style="cursor: pointer"
                                            onclick="password_show_hide();">
                                            <ion-icon style="font-size: 1.5rem;" name="eye-outline" id="show_eye">
                                            </ion-icon>
                                            <ion-icon style="font-size: 1.5rem;display:none" name="eye-off-outline"
                                                id="hide_eye">
                                            </ion-icon>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            {{$errors->first()}}
                        </div>
                        @endif
                        <button type="submit" class="btn"
                            style="margin-top: 3rem; background:#00B517; color:white">Masuk</button>
                    </form>
                </div>
                <div class="col-md-6 prevent-select d-none d-md-block d-xl-block d-lg-block"
                    style="background: #E5FAD8; padding:0">
                    <img src="assets/images/bg-login.png" class="img-fluid" alt="Sample image" style="height: 100vh">
                </div>
            </div>
        </div>
    </section>
    <script>
        function password_show_hide() {
            var x = document.getElementById("password");
            var show_eye = document.getElementById("show_eye");
            var hide_eye = document.getElementById("hide_eye");
            hide_eye.classList.remove("d-none");
            if (x.type === "password") {
                x.type = "text";
                show_eye.style.display = "none";
                hide_eye.style.display = "block";
            } else {
                x.type = "password";
                show_eye.style.display = "block";
                hide_eye.style.display = "none";
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>