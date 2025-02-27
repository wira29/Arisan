<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/html/main/authentication-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jul 2023 02:01:04 GMT -->

<head>
    <!--  Title -->
    <title>Pendaftaran Arisan</title>
    <!--  Required Meta Tag -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="Mordenize" />
    <meta name="author" content="" />
    <meta name="keywords" content="Mordenize" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--  Favicon -->
    <link rel="shortcut icon" type="image/png"
        href="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico" />
    <!-- Core Css -->
    <link id="themeColors" rel="stylesheet" href="{{ asset('assets') }}/css/style.min.css" />
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico"
            alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- Preloader -->
    <div class="preloader">
        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico"
            alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100">
            <div class="position-relative z-index-5">
                <div class="row">
                    <div class="col-xl-7 col-xxl-8">
                        <a href="index-2.html" class="text-nowrap logo-img d-block px-4 py-9 w-50">
                            <img src="assets/images/logofix_transparent.png" width="180" alt="">
                        </a>
                        <div class="d-none d-xl-flex align-items-center justify-content-center" style="height: calc(100vh - 80px);">
                            <img src="assets/images/meja.gif" alt="" class="img-fluid" width="750">
                        </div>
                    </div>
                    <div class="col-xl-5 col-xxl-4">
                        <div
                            class="authentication-register min-vh-100 bg-body row justify-content-center align-items-center p-4">
                            <div class="col-sm-8 col-md-6 col-xl-9">
                                <h2 class="mb-3 fs-7 fw-bolder">Meubel Aji</h2>
                                <p class=" mb-9">Silakan mendaftar akun</p>
                             <form method="POST" action="{{ route('register') }}">
                                @csrf
                            
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Dicky Novaldi">
                            
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                   
                                </div>
                            
                                <div class="mb-3">
                                   <label for="phone_number" class="form-label">Nomor WhatsApp</label>
                                        <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror"
                                            name="phone_number" value="{{ old('phone_number') }}" required autocomplete="phone_number" autofocus placeholder="62895607927777">
                            
                                        @error('phone_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    
                                </div>
                            
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                            
                                 
                                       
                                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" placeholder="johndoe@gmail.com">
                            
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                
                                </div>
                            
                                <div class="mb-3">
                                  <label for="password" class="form-label">Password</label>
                            
                                   
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                            name="password" required autocomplete="new-password" placeholder="password">
                            
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    
                                </div>
                            
                                <div class="mb-3">
                                   <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                            
                              
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                                            autocomplete="new-password" placeholder="confirm password">
                              
                                </div>
                            
                              
                                <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">
                                    {{ __('Daftar') }}
                                </button>
                                <div class="d-flex align-items-center justify-content-center">
                                    <p class="fs-4 mb-0 fw-medium">Sudah punya akun?</p>
                                    <a class="text-primary fw-medium ms-2" href="{{ route('login') }}">Masuk</a>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!--  Import Js Files -->
    <script src="{{ asset('assets') }}/libs/jquery/dist/jquery.min.js"></script>
    <script src="{{ asset('assets') }}/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="{{ asset('assets') }}/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!--  core files -->
    <script src="{{ asset('assets') }}/js/app.min.js"></script>
    <script src="{{ asset('assets') }}/js/app.init.js"></script>
    <script src="{{ asset('assets') }}/js/app-style-switcher.js"></script>
    <script src="{{ asset('assets') }}/js/sidebarmenu.js"></script>

    <script src="{{ asset('assets') }}/js/custom.js"></script>
</body>

<!-- Mirrored from demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/html/main/authentication-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jul 2023 02:01:04 GMT -->

</html>