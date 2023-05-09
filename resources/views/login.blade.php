<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Jatri Reward | Login</title>
    <link rel="shortcut icon" type="image/jpg" href="https://www.jatri.co/src/images/logo/favicon.svg" />

    <link href="{{ url()->asset('assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url()->asset('assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url()->asset('assets/css/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">

    <script src="{{ url()->asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url()->asset('assets/js/app.js') }}"></script>
</head>

<body>

<div class="page-content">
    <div class="content-wrapper">
        <div class="content-inner">
            <div class="content d-flex justify-content-center align-items-center" style="background-image: url({{ url('assets/images/login_bg.png') }});">

                <form class="login-form" action="{{ url('/auth/login') }}" method="post">
                    @csrf
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                                    <img src="https://www.jatri.co/src/images/logo/logo.svg" class="h-48px" alt="">
                                </div>
                                <h5 class="mb-0">Login to your account</h5>
                                <span class="d-block text-muted">Enter your credentials below</span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <div class="form-control-feedback form-control-feedback-start">
                                    <input type="text" class="form-control" name="email" placeholder="example@email.com" value="@if($errors->has('email')){{ $errors->first('email') }}@endif" required>
                                    <div class="form-control-feedback-icon">
                                        <i class="ph-at text-muted"></i>
                                    </div>
                                </div>
                            </div>

                            @if($errors->has('email'))
                                <span class="label border-danger text-danger fw-bold">Wrong Credentials!</span>
                            @endif

                            <div class="mb-3">
                                <label class="form-label fw-bold">Password</label>
                                <div class="form-control-feedback form-control-feedback-start">
                                    <input type="password" class="form-control" name="password" placeholder="•••••••••••">
                                    <div class="form-control-feedback-icon">
                                        <i class="ph-lock text-muted"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary w-100">Sign in</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

</body>
</html>
