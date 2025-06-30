<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 admin dashboard template & web App ui kit.">
    <meta name="keyword"
        content="LUNO, Bootstrap 5, ReactJs, Angular, Laravel, VueJs, ASP .Net, Admin Dashboard, Admin Theme, HRMS, Projects, Hospital Admin, CRM Admin, Events, Fitness, Music, Inventory, Job Portal">
    <link rel="icon" href="{{ asset('assets/img/favicon.ico') }}" type="image/x-icon"> <!-- Favicon-->
    <title>Sign In Page</title>
    <!-- Application vendor css url -->
    <!-- project css file  -->
    <link rel="stylesheet" href="{{ asset('assets/css/luno-style.css') }}">
    <!-- Jquery Core Js -->
    <script src="./assets/js/plugins.js"></script>
</head>

<body id="layout-1" data-luno="theme-blue">
    <!-- start: body area -->
    <div class="wrapper">
        <!-- Sign In version 1 -->
        <!-- start: page body -->
        <div class="page-body auth px-xl-4 px-sm-2 px-0 py-lg-2 py-1">
            <div class="container-fluid">
                <div class="row g-0">
                    <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center">
                        <div style="max-width: 25rem;">
                            <div class="mb-4">
                            </div>
                            <div class="mb-5">
                                <h2 class="color-900">Ngobrol, Tanya, Selesai : Dengan CHATBOT Cerdas</h2>
                            </div>
                            <!-- List Checked -->
                            <ul class="list-unstyled mb-5">
                                <li class="mb-4">
                                    <span class="d-block mb-1 fs-5 fw-light">Cepat & Responsif</span>
                                    <span class="color-600">Hemat waktu dan tenaga dengan respons otomatis</span>
                                </li>
                                <li>
                                    <span class="d-block mb-1 fs-4 fw-light">Interaksi yang Mudah</span>
                                    <span class="color-600">Memudahkan proses pencarian informasi atau penyelesaian
                                        masalah</span>
                                </li>
                            </ul>
                            <div class="mb-2">
                            </div>
                            <div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex justify-content-center align-items-center">
                        <div class="card shadow-sm w-100 p-4 p-md-5" style="max-width: 32rem;">
                            <!-- Form -->
                            <form class="row g-3" method="POST" action="login">
                                @csrf
                                <div class="col-12 text-center mb-5">
                                    <h1>Sign in</h1>
                                    <span class="text-muted">Free access to our dashboard.</span>
                                </div>
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control form-control-lg"
                                            placeholder="Enter your email" name="email">
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-2">
                                        <div class="form-label">
                                            <span class="d-flex justify-content-between align-items-center"> Password
                                            </span>
                                        </div>
                                        <input id="password" class="form-control form-control-lg" type="password"
                                            maxlength="10" placeholder="Enter the password" name="password">
                                        @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 text-center mt-4">
                                    <button class="btn btn-lg btn-block btn-dark lift text-uppercase" type="submit"
                                        title="">SIGN IN</button>
                                </div>
                            </form>
                            <!-- End Form -->
                        </div>
                    </div>
                </div> <!-- End Row -->
            </div>
        </div>
        <script src="https://unpkg.com/bootstrap-show-password@1.2.1/dist/bootstrap-show-password.min.js"></script>
        <script>
            $(function() {
                $('#password').password()
            })
        </script>
    </div>
    <!-- Modal: Setting -->
    <!-- Jquery Page Js -->
    <!-- Jquery Page Js -->
    <script src="./assets/js/theme.js"></script>
    <!-- Plugin Js -->
    <!-- Vendor Script -->
</body>

</html>
