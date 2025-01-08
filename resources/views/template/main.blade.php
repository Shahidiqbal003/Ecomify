<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if (!empty($storeSettings) && $storeSettings->favicon)
        <link rel="icon" type="image/x-icon" href="{{ asset($storeSettings->favicon) ?? 'Ecomify' }}">
    @endif
    <title>@yield('title') | {{ $storeSettings->shop_name ?? request()->route('shop') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Font Awesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="/assets/dist/css/product.css">



</head>

<body class="hold-transition sidebar-mini">

    @include('sweetalert::alert')

    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                {{-- <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li> --}}
                <li class="nav-item">
                    @if (request()->shop)
                        <a class="nav-link" target="blank"
                            href="{{ route('store.home', ['shop' => request()->shop->name]) }}" role="button">
                            <i class="fa-solid fa-store"></i>
                        </a>
                    @endif

                </li>

                <!-- Messages Dropdown Menu -->
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="/assets/dist/img/user1-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Brad Diesel
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">Call me whenever you can...</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="/assets/dist/img/user8-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="/assets/dist/img/user3-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Nora Silvester
                                        <span class="float-right text-sm text-warning"><i
                                                class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">The subject goes here</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li> --}}
                <!-- Notifications Dropdown Menu -->
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li> --}}
                {{-- <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a class=" log-out nav-link" href="#">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        @if (request()->shop)
                            <form action="{{ route('admin.logout', ['shop' => request()->route('shop')]) }}"
                                method="POST" id="logging-out">
                                @csrf
                            </form>
                        @else
                            <form action="{{ route('super_admin.logout') }}" method="POST" id="logging-out">
                                @csrf
                            </form>
                        @endif
                    </a>
                </li>

                {{-- <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"
                        role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li> --}}
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="elevation-4 main-sidebar sidebar-light-dark">
            <!-- Brand Logo -->
            @if (request()->shop)
                <a href="{{ route('admin.dashboard', ['shop' => request()->route('shop')]) }}" class="brand-link">
                    @if (!empty($storeSettings) && $storeSettings->favicon)
                        <img src="{{ asset($storeSettings->favicon) }}"
                            alt="{{ $storeSettings->shop_name ?? request()->route('shop') }}"
                            class="brand-image img-circle" style="opacity: .8">
                    @else
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTk8PqnBe2mbcqAfTfj98oy4lPzUiJ6gnjepQ&s"
                            alt="{{ $storeSettings->shop_name ?? request()->route('shop') }}"
                            class="brand-image img-circle" style="opacity: .8">
                    @endif

                    <span
                        class="brand-text font-weight-light text-capitalize">{{ $storeSettings->shop_name ?? request()->route('shop') }}</span>
                </a>
            @else
                <a href="{{ route('super.admin.dashboard') }}" class="brand-link">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTk8PqnBe2mbcqAfTfj98oy4lPzUiJ6gnjepQ&s"
                            alt="{{ $storeSettings->shop_name ?? request()->route('shop') }}"
                            class="brand-image img-circle" style="opacity: .8">
                    <span
                        class="brand-text font-weight-light text-capitalize">Ecomify</span>
                </a>
            @endif
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQdztTDcpZ2pFqwWDYwSXbvZq5nzJYg5cn8w&s"
                            class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        @if (request()->shop)
                            <a href="{{ route('admin.dashboard', ['shop' => request()->route('shop')]) }}"
                                class="d-block">{{ auth()->user()->name ?? '' }}<span
                                    class="badge text-capitalize">{{ $storeSettings->shop_name ?? request()->route('shop') }}</span></a>
                        @else
                            <a href="{{ route('super.admin.dashboard') }}"
                                class="d-block">{{ auth()->user()->name ?? '' }}</a>
                        @endif
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                {{-- <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div> --}}

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        {{-- <li class="nav-item">
                            <a href="{{ route('home') }}" target="blank" class="nav-link">
                                <i class="nav-icon fa-solid fa-store"></i>
                                <p>
                                    View Store
                                </p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            @if (request()->shop)
                                <a href="{{ route('admin.dashboard', ['shop' => request()->route('shop')]) }}"
                                    class="nav-link">
                                    <i class="nav-icon fa-solid fa-gauge-high"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            @else
                                <a href="{{ route('super.admin.dashboard') }}"
                                    class="nav-link">
                                    <i class="nav-icon fa-solid fa-gauge-high"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            @endif
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ route('barang.index', ['shop' => request()->route('shop')]) }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-box"></i>
                                <p>
                                    Barang
                                </p>
                            </a>
                        </li> --}}
                        @if (request()->shop)
                            {{-- <li class="nav-item">
                                <a href="{{ route('coupon.index', ['shop' => request()->route('shop')]) }}"
                                    class="nav-link">
                                    <i class="nav-icon fa  fa-gift"></i>
                                    <p>
                                        Coupons
                                    </p>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a href="{{ route('pages.index', ['shop' => request()->route('shop')]) }}"
                                    class="nav-link">
                                    <i class="nav-icon fa-regular fa-file-lines"></i>
                                    <p>
                                        Pages
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('collection.index', ['shop' => request()->route('shop')]) }}"
                                    class="nav-link">
                                    <i class="nav-icon fa-solid fa-layer-group"></i>
                                    <p>
                                        Collections
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('product.index', ['shop' => request()->route('shop')]) }}"
                                    class="nav-link">
                                    <i class="nav-icon fa-solid fa-tags"></i>
                                    <p>
                                        Products
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('orders.index', ['shop' => request()->route('shop')]) }}"
                                    class="nav-link">
                                    <i class="nav-icon fa fa-shopping-cart"></i>
                                    <p>
                                        Orders
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('contact.index', ['shop' => request()->route('shop')]) }}"
                                    class="nav-link">
                                    <i class="nav-icon fa fa-address-book"></i>
                                    <p>
                                        Contact Us
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('settings.index', ['shop' => request()->route('shop')]) }}"
                                    class="nav-link">
                                    <i class="nav-icon fa-solid fa-cog"></i>
                                    <p>
                                        Settings
                                    </p>
                                </a>
                            </li>
                        @else
                        <li class="nav-item">
                            <a href="{{ route('shops.index') }}"
                                class="nav-link">
                                <i class="nav-icon fa-solid fa-store"></i>
                                <p>
                                    Shops
                                </p>
                            </a>
                        </li>
                        @endif


                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        @yield('content')

        <!-- Content Wrapper. Contains page content -->
        {{-- content here --}}
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">

            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2023 <a href="#">Ecomify</a>.</strong> All rights
            reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="/assets/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap 4 -->
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/assets/dist/js/adminlte.min.js"></script>
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dropify/dist/js/dropify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
    {{-- <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script> --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    @stack('scripts')

    <script>
        document.querySelectorAll('.editor').forEach(editorElement => {
            ClassicEditor.create(editorElement).catch(error => console.error(error));
        });
    </script>
    <script>
        // Initialize Chosen plugin
        $(document).ready(function() {
          $('.chosen-select').chosen({
            no_results_text: "Oops, nothing found!",
            width: "100%"
          });
        });
      </script>

    <script>
        $(document).ready(function() {
            $('.dropify').dropify();
        });
    </script>

    <script>
        $(function() {
            var url = window.location;
            // for single sidebar menu
            $('ul.nav-sidebar a').filter(function() {
                return this.href == url;
            }).addClass('active');

            // for sidebar menu and treeview
            $('ul.nav-treeview a').filter(function() {
                    return this.href == url;
                }).parentsUntil(".nav-sidebar > .nav-treeview")
                .css({
                    'display': 'block'
                })
                .addClass('menu-open').prev('a')
                .addClass('active');
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#example1').DataTable({
                responsive: true
            });

        });
    </script>

    <script type="text/javascript">
        $(document).on('click', '#btn-delete', function(e) {
            e.preventDefault();
            var form = $(this).closest("form");
            Swal.fire({
                title: 'Are you sure?',
                text: "You will not be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#7367f0',
                cancelButtonColor: '#82868b',
                confirmButtonText: 'Yes, delete!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        });
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

    <script>
        $(".log-out").on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#7367f0',
                cancelButtonColor: '#82868b',
                confirmButtonText: 'Yes, Log Out !'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#logging-out').submit()
                }
            })
        });
    </script>

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
</body>

</html>
