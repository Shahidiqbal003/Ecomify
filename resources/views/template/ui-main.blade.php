<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="{{$storeSettings->description ?? '' }}">
    <link rel="icon" type="image/x-icon" href="{{asset($storeSettings->favicon ?? '')}}">
    <meta name="keywords" content="HTML, CSS, JavaScript">
    <title>@yield('title') | {{ $storeSettings->shop_name ?? request()->route('shop') }}</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/dist/css/style.css">
</head>

<body>

    @include('sweetalert::alert')

    <div>
        @include('include.navbar')
        @yield('content')
        @if($storeSettings->is_whatsapp != 0)
            <a href="https://wa.me/{{$storeSettings->whatsapp_number}}" class="whatsapp-float" target="_blank" data-toggle="tooltip" data-placement="left" title="Contact Us" >
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
            </a>
        @endif
        @include('include.footer')
    </div>

    <!-- jQuery -->
    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <script src="/assets/dist/js/frontend_main.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    @yield('scripts')



    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}", '', {
                positionClass: 'toast-top-right'
            });
        @elseif (session('error'))
            toastr.error("{{ session('error') }}", '', {
                positionClass: 'toast-top-right'
            });
        @elseif (session('info'))
            toastr.info("{{ session('info') }}", '', {
                positionClass: 'toast-top-right'
            });
        @elseif (session('warning'))
            toastr.warning("{{ session('warning') }}", '', {
                positionClass: 'toast-top-right'
            });
        @endif
    </script>

    <script>
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>

</html>
