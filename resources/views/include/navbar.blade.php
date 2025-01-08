<style>
    /* Navbar visible only on mobile */
    @media (min-width: 990px) {
        .mobile-navbar {
            display: none;
        }
        .desktop-navbar{
            display: block;
        }
        .topbar{
            display: block;
        }
    }
    @media (max-width: 990px) {
        .mobile-navbar {
            display: block;
        }
        .desktop-navbar{
            display: none;
        }
        .topbar{
            display: none;
        }

    }

    /* Full-screen dropdown styles */
    .custom-dropdown {
        position: fixed;
        top: 92px;
        /* Navbar height */
        left: -100%;
        /* Initially off-screen */
        width: 100%;
        height: calc(100vh - 56px);
        /* Full height minus navbar */
        background-color: #fff;
        transition: left 0.5s ease-in-out;
        /* Smooth left-to-right animation */
        z-index: 1050;
        padding: 16px 57px;
        /* display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center; */
    }

    .custom-dropdown.show {
        left: 0;
        /* Slide in */
    }

    /* Dropdown links styling */
    .custom-dropdown ul {
        list-style: none;
        padding: 0;
    }

    .custom-dropdown ul li {
        margin: 10px 0;
    }

    .custom-dropdown ul li a {
        font-size: 1.5rem;
        text-decoration: none;
        color: #000;
        transition: color 0.3s ease;
    }

    .custom-dropdown ul li a:hover {
        color: #007bff;
    }

    /* Submenu styles */
    .submenu {
        overflow: hidden;
        max-height: 0;
        /* Hidden initially */
        transition: max-height 0.5s ease, padding 0.5s ease;
        /* Smooth slide-down */
        background-color: #fff;
        margin: 5px 0;
        padding: 0;
    }

    .submenu.show {
        max-height: 200px;
        /* Adjust based on submenu content */
        /* padding: 10px 0; */
    }

    .submenu li {
        margin: 5px 0;
    }

    .submenu li a {
        font-size: 1.2rem;
    }

    /* Disable body scrolling */
    .no-scroll {
        overflow: hidden;
        height: 100vh;
        /* Prevent scrolling */
    }
</style>
<?php
if (isset($_GET['signature'])) {?>
<section type='navbar' class="topbar">
    <div class="container-fluid navbar-container border-bottom">
        <div class="container ">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ route('store.home', ['shop' => request()->shop->name]) }}"><img
                            src="https://www.herbalbyte.store/cdn/shop/files/Untitled_design_8.png?v=1728979232&width=170"
                            alt="logo"></a>

                    <a class="nav-link position-relative me-3"
                        href="{{ route('store.cart.show', ['shop' => request()->shop->name]) }}">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge bg-primary border border-light rounded-circle">{{ collect(session('cart', []))->sum('quantity') }}
                        </span>
                    </a>
                </div>
            </nav>
        </div>
    </div>
</section>
<?php
} else {?>
@if($storeSettings->is_topbar != 0)
<section type='topbar' class="topbar">
    <div class="  container-fluid bg-primary text-center p-2">
        <span class="text-light fw-semibold">{{$storeSettings->topbar_text}}</span>
    </div>
</section>
@endif
<section type='navbar'>
    <div class="container-fluid bg-light navbar-container">
        <div class="container">
            @if($storeSettings->is_navbar == 1)
            <nav class="navbar navbar-expand-lg desktop-navbar">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ route('store.home', ['shop' => request()->shop->name]) }}">
                        @if (!empty($storeSettings) && $storeSettings->logo)
                            <img width="130px" src="{{ asset($storeSettings->logo) }}"
                                alt="{{ $storeSettings->shop_name ?? 'Ecomify' }}">
                        @else
                            {{ $storeSettings->shop_name ?? 'Ecomify' }}
                        @endif
                    </a>

                    <div class="collapse navbar-collapse" id="navbarText">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item pe-2 ps-2">
                                <a class="nav-link active" aria-current="page"
                                    href="{{ route('store.home', ['shop' => request()->shop->name]) }}">Home</a>
                            </li>
                            <li class="nav-item pe-2 ps-2">
                                <a class="nav-link"
                                    href="{{ route('store.shop', ['shop' => request()->shop->name]) }}">Shop</a>
                            </li>
                            <li class="nav-item pe-2 ps-2 dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="collectionsDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    All Collections
                                </a>
                                <ul class="dropdown-menu animated-dropdown border-0 rounded-0"
                                    aria-labelledby="collectionsDropdown">
                                    @foreach ($collections as $collection)
                                        <li>
                                            <a class="dropdown-item" href="{{ route('store.collection', ['shop' => request()->route('shop'), 'collectionName' => str_replace(' ', '-', strtolower($collection->name))]) }}">
                                                {{ $collection->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="nav-item pe-2 ps-2">
                                <a class="nav-link"
                                    href="{{ route('store.pages.show', ['shop' => request()->route('shop'), 'page' => 'about']) }}">About Us</a>
                            </li>
                            <li class="nav-item pe-2 ps-2">
                                <a class="nav-link"
                                    href="{{ route('store.contact', ['shop' => request()->shop->name]) }}">Contact</a>
                            </li>
                        </ul>
                        <span class="navbar-right">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                {{-- <li class="nav-item pe-2 ps-2">
                                    <a class="nav-link" href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
                                </li>
                                <li class="nav-item pe-2 ps-2">
                                    <a class="nav-link" href="#"><i class="fa-regular fa-user"></i></a>
                                </li> --}}
                                <li class="nav-item pe-2 ps-2">
                                    <a class="nav-link position-relative"
                                        href="{{ route('store.cart.show', ['shop' => request()->shop->name]) }}">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                        <span
                                            class="position-absolute start-100 translate-middle badge bg-primary border border-light rounded-circle">{{ collect(session('cart', []))->sum('quantity') }}
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </span>
                    </div>
                </div>
            </nav>
            @else
            <nav class="navbar navbar-expand-lg desktop-navbar">
                <div class="container-fluid flex-column">
                    <!-- Centered Logo -->
                    <div class="w-100 d-flex justify-content-center border-bottom">
                        <a class="navbar-brand" href="{{ route('store.home', ['shop' => request()->shop->name]) }}">
                            @if (!empty($storeSettings) && $storeSettings->logo)
                                <img width="130px" src="{{ asset($storeSettings->logo) }}"
                                    alt="{{ $storeSettings->shop_name ?? 'Ecomify' }}">
                            @else
                                {{ $storeSettings->shop_name ?? 'Ecomify' }}
                            @endif
                        </a>
                    </div>

                    <!-- Navigation Menu -->
                    <div class="w-100 d-flex justify-content-between align-items-center mt-2">
                        <!-- Left-aligned Menu -->
                        <div>
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item pe-2 ps-2">
                                    <a class="nav-link active" aria-current="page"
                                        href="{{ route('store.home', ['shop' => request()->shop->name]) }}">Home</a>
                                </li>
                                <li class="nav-item pe-2 ps-2">
                                    <a class="nav-link"
                                        href="{{ route('store.shop', ['shop' => request()->shop->name]) }}">Shop</a>
                                </li>
                                <li class="nav-item pe-2 ps-2 dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="collectionsDropdown"
                                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        All Collections
                                    </a>
                                    <ul class="dropdown-menu animated-dropdown border-0 rounded-0"
                                        aria-labelledby="collectionsDropdown">
                                        @foreach ($collections as $collection)
                                            <li>
                                                <a class="dropdown-item" href="{{ route('store.collection', ['shop' => request()->route('shop'), 'collectionName' => str_replace(' ', '-', strtolower($collection->name))]) }}">
                                                    {{ $collection->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="nav-item pe-2 ps-2">
                                    <a class="nav-link"
                                        href="{{ route('store.pages.show', ['shop' => request()->route('shop'), 'page' => 'about']) }}">About Us</a>
                                </li>
                                <li class="nav-item pe-2 ps-2">
                                    <a class="nav-link"
                                        href="{{ route('store.contact', ['shop' => request()->shop->name]) }}">Contact</a>
                                </li>
                            </ul>
                        </div>

                        <!-- Right-aligned Cart Icon -->
                        <div>
                            <ul class="navbar-nav">
                                <li class="nav-item pe-2 ps-2">
                                    <a class="nav-link position-relative"
                                        href="{{ route('store.cart.show', ['shop' => request()->shop->name]) }}">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                        <span class="position-absolute start-100 translate-middle badge bg-primary border border-light rounded-circle">
                                            {{ collect(session('cart', []))->sum('quantity') }}
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            @endif
            {{-- mobile navbar --}}

            <nav class="navbar navbar-expand-lg bg-light mobile-navbar">
                <div class="container-fluid">
                    <!-- Toggle Button -->
                    <button id="toggleButton" class="navbar-toggler" style=" width: 56px; height: 40px; "
                        type="button">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Center Logo -->
                    <a class="navbar-brand  mx-auto"
                        href="{{ route('store.home', ['shop' => request()->shop->name]) }}">
                        @if (!empty($storeSettings) && $storeSettings->logo)
                            <img width="130px" src="{{ asset($storeSettings->logo) }}"
                                alt="{{ $storeSettings->shop_name ?? 'Ecomify' }}">
                        @else
                            {{ $storeSettings->shop_name ?? 'Ecomify' }}
                        @endif
                    </a>

                    <!-- Cart Icon -->
                    <a class="nav-link position-relative"
                        href="{{ route('store.cart.show', ['shop' => request()->shop->name]) }}">
                        <i class="fs-1 fa-solid fa-cart-shopping"></i>
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge bg-primary border border-light rounded-circle">{{ collect(session('cart', []))->sum('quantity') }}
                        </span>
                    </a>
                </div>
            </nav>

            <!-- Full-Screen Custom Dropdown -->
            <div id="customDropdown" class="custom-dropdown">
                <ul>
                    <li>
                        <a class="nav-link active" aria-current="page"
                            href="{{ route('store.home', ['shop' => request()->shop->name]) }}">Home</a>
                    </li>
                    <li>
                        <a class="nav-link"
                            href="{{ route('store.shop', ['shop' => request()->shop->name]) }}">Shop</a>
                    </li>
                    <li>
                        <a href="#" id="collectionsToggle">All Collections <i id="arrowIcon" class="fs-6 fa-solid fa-chevron-right"></i></a>
                        <ul id="collectionsSubmenu" class="submenu">
                            @foreach ($collections as $collection)
                                <li><a class="dropdown-item" href="#">{{ $collection->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li>
                        <a class="nav-link"
                            href="{{ route('store.pages.show', ['shop' => request()->route('shop'), 'page' => 'about']) }}">About Us</a>
                    </li>
                    <li>
                        <a class="nav-link"
                            href="{{ route('store.contact', ['shop' => request()->shop->name]) }}">Contact</a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</section>

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#toggleButton').on('click', function() {
                const dropdown = $('#customDropdown');
                const toggleButton = $(this);

                dropdown.toggleClass('show'); // Toggle dropdown visibility

                // Change the toggle button icon
                if (dropdown.hasClass('show')) {
                    toggleButton.html('<i class="fa-solid fa-xmark"></i>'); // Cross icon
                    $('body').addClass('no-scroll'); // Disable body scrolling
                } else {
                    toggleButton.html('<span class="navbar-toggler-icon"></span>'); // Default toggle icon
                    $('body').removeClass('no-scroll'); // Enable body scrolling
                }
            });

            // Toggle collections submenu and arrow icon
            $('#collectionsToggle').on('click', function(e) {
                e.preventDefault(); // Prevent default link behavior
                const submenu = $('#collectionsSubmenu');
                const arrowIcon = $('#arrowIcon');

                submenu.toggleClass('show'); // Toggle submenu visibility

                // Change arrow icon direction
                if (submenu.hasClass('show')) {
                    arrowIcon.removeClass('fa-solid fa-chevron-right').addClass(
                    'fa-solid fa-chevron-down'); // Arrow points down
                } else {
                    arrowIcon.removeClass('fa-solid fa-chevron-down').addClass(
                    'fa-solid fa-chevron-right'); // Arrow points right
                }
            });
        });
    </script>
    {{-- <script>
        $(document).ready(function() {
            $('#closeBtn').hide();
            $('.card').hover(
                function() {
                    $(this).find('.img-main').hide();
                    $(this).find('.img-hover').show();
                },
                function() {
                    $(this).find('.img-main').show();
                    $(this).find('.img-hover').hide();
                }
            );

            $('#navbarText').on('show.bs.collapse', function() {
                setTimeout(function() {
                    $('.navbar-toggler').hide();
                    $('#closeBtn').show();
                }, 500);
            });

            $('#navbarText').on('hide.bs.collapse', function() {
                setTimeout(function() {
                    $('.navbar-toggler').show();
                    $('#closeBtn').hide();
                }, 100);

            });

            $('#closeBtn').click(function() {
                $('#navbarText').css('animation', 'slideOut 0.3s ease');
                setTimeout(function() {
                    $('#navbarText').collapse('hide');
                    $('#navbarText').css('animation', '');
                }, 300);
            });

            $('#navbarText').on('show.bs.collapse', function() {
                $('body').addClass('no-scroll');
            });

            $('#navbarText').on('hidden.bs.collapse', function() {
                $('body').removeClass('no-scroll');
            });

            function adjustNavbarCollapsePosition() {
                var topbarHeight = $('.topbar').outerHeight();
                var navbarHeight = $('.navbar-container').outerHeight();
                var totalHeight = topbarHeight +
                    navbarHeight;
                $('.navbar-collapse').css('top', totalHeight);
            }

            adjustNavbarCollapsePosition();

            $(window).resize(function() {
                adjustNavbarCollapsePosition();
            });

            function isMobile() {
                return window.innerWidth <= 990;
            }

            $('.dropdown').on('show.bs.dropdown', function(e) {
                if (isMobile()) {
                    $('#closeBtn').removeClass('d-none');
                    $(this).find('.dropdown-menu').addClass('animated-dropdown').removeClass(
                        'hide-animation');
                    $(this).find('.dropdown-menu a').addClass('nav-link')
                }
            });

            $('.dropdown').on('hide.bs.dropdown', function(e) {
                if (isMobile()) {
                    var $dropdownMenu = $(this).find('.dropdown-menu');
                    $dropdownMenu.addClass('hide-animation');
                    e.preventDefault();

                    setTimeout(function() {
                        $dropdownMenu.removeClass('show hide-animation');
                        $(this).removeClass('show');
                    }.bind(this), 300);
                }
            });

        });
    </script> --}}
@endsection

<?php
}
?>
