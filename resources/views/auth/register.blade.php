<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Register</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicon -->
    <link href="{{ asset('creator/public/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('creator/public/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('creator/public/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('creator/public/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('creator/public/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('creator/public/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('creator/public/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('creator/public/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('creator/public/assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('creator/public/assets/css/style.css') }}" rel="stylesheet">


</head>

<body>

    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="assets/img/logo.png" alt="">
                                    <span class="d-none d-lg-block">NiceAdmin</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                                        <p class="text-center small">Enter your personal details to create account</p>
                                    </div>

                                    <form action="{{ route('register') }}" method="POST"
                                        class="row g-3 needs-validation" novalidate>
                                        @csrf
                                        <div class="col-12">
                                            <label for="yourName" class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control" id="name" value="{{old('name')}}" required>
                                            <div class="invalid-feedback">Please, enter your name!</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourEmail" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" required>
                                            <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="password"
                                                required>
                                            <div class="invalid-feedback">Please enter your password!</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Confirm Password</label>
                                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
                                                required>
                                            <div class="invalid-feedback">Please enter your password!</div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="user_role" id="user_role_creator" value="1">
                                                <label class="form-check-label" for="user_role_creator">
                                                    I am a creator
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="user_role" id="user_role_client" value="2">
                                                <label class="form-check-label" for="user_role_client">
                                                    I am looking for a creator
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" name="terms" type="checkbox" value=""
                                                    id="acceptTerms" required>
                                                <label class="form-check-label" for="acceptTerms">I agree and accept the
                                                    <a href="#">terms and conditions</a></label>
                                                <div class="invalid-feedback">You must agree before submitting.</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Create Account</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Already have an account? <a
                                                    href="pages-login.html">Log in</a></p>
                                        </div>
                                    </form>

                                    @if ($errors->any())
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    @endif

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <!-- Vendor JS Files -->
    <script src="{{ asset('creator/public/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('creator/public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('creator/public/assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('creator/public/assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('creator/public/assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('creator/public/assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('creator/public/assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('creator/public/assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('creator/public/assets/js/main.js') }}"></script>

</body>

</html>