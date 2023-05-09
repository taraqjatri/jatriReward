<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Reward Service</title>
    <link rel="shortcut icon" type="image/jpg" href="https://www.jatri.co/src/images/logo/favicon.svg" />
</head>

<body>

<!-- Page content -->
<div class="page-content">

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Inner content -->
        <div class="content-inner">

            <!-- Content area -->
            <div class="content d-flex justify-content-center align-items-center">

                <!-- Container -->
                <div class="flex-fill">

                    <!-- Error title -->
                    <div class="text-center mb-4">
                        <img src="{{ url()->asset('assets/images/error_bg.svg') }}" class="img-fluid mb-3" height="230" alt="">
                        <h1 class="display-3 fw-semibold lh-1 mb-3">404</h1>
                        <h6 class="w-md-25 mx-md-auto">Oops, an error has occurred. <br> The resource requested could not be found on this server.</h6>
                    </div>
                    <!-- /error title -->


                    <!-- Error content -->
                    <div class="text-center">
                        <a href="{{ url('/') }}" class="btn btn-primary">
                            <i class="ph-house me-2"></i>
                            Return to dashboard
                        </a>
                    </div>
                    <!-- /error wrapper -->

                </div>
                <!-- /container -->

            </div>
            <!-- /content area -->

        </div>
        <!-- /inner content -->

    </div>
    <!-- /main content -->

</div>
<!-- /page content -->

</body>
</html>
