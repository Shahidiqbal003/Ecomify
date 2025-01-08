@extends('template.ui-main')
@section('title', 'Home')
@section('content')

    <section type='banner'>
        <div class="container-fluid p-0">
            <img class="img-fluid w-100" src="{{ asset($storeSettings->fe_banner) }}" alt="banner">
        </div>
    </section>

    <section type="products">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 p-3">
                    <span class="fs-4">Featured products</span>
                </div>
                @foreach ($products as $data)
                    <div class="col-lg-3 col-md-4 col-sm-12 pt-3">
                        <a href="{{ route('store.product.detail', ['shop' => request()->route('shop'), 'slug' => $data->slug]) }}"
                            class="cart-link text-decoration-none">
                            <div class="border-0 card" style="width: 100%;">
                                <div class="position-relative">
                                    <img src="{{ asset('assets/uploads/product/' . $data->cover_image_data) }}"
                                        class="card-img-top rounded-0 img-main" alt="{{ $data->title }}"
                                        style="height: 306px;">
                                    <img class="img-hover card-img-top rounded-0"
                                        src="{{ asset('assets/uploads/product/' . ($data->cover_first_image ?? $data->cover_image_data)) }}"
                                        alt="{{ $data->title }}" style="display: none; height: 306px;">
                                    <span class="badge bg-dark position-absolute bottom-0 start-0 m-2">Sale</span>
                                </div>
                                <div class="card-body">
                                    <span class="card-title">
                                        <span class="product-title">{{ $data->title }}</span>
                                        <p class="text-muted mb-1">
                                            <del>Rs. {{ number_format($data->compare_at_price, 2) }} PKR</del> &nbsp;
                                            <span>Rs. {{ number_format($data->price, 2) }} PKR</span>
                                        </p>
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach

                @if ($products->count() >= 8)
                    <div class="col-12">
                        <div class="container text-center">
                            <a href="{{ route('store.shop', ['shop' => request()->shop->name]) }}"
                                class="btn btn-dark pb-2 pe-4 ps-4 pt-2 rounded-0">View all</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section type="product-detail">
        <div class="container mt-5">
            <div class="row align-items-center">
                <!-- Text Section -->
                <div class="col-lg-6 col-md-12 p-5">
                    <span class="fs-1">Finishing Touch Flawless Pedi Electronic Tool File and Callus Remover</span>
                    <ul class="p-5 text-muted">
                        <li>Your at home pedicure solution: this tool does everything you need: it removes calluses and
                            dry cracked skin in a safe way.</li>
                        <li>Pedi includes 2 roller heads: one fine roller for polishing and everyday maintenance and one
                            coarse roller for smoothing stubborn calluses and dead skin.</li>
                    </ul>
                </div>

                <!-- Image Section -->
                <div class="col-lg-6 col-md-12">
                    <img src="https://www.herbalbyte.store/cdn/shop/files/200-finishing-touch-flawless-pedi-roller-electronic-pedicure-original-imagafamrq4kz8ge.webp?v=1728968170&width=750"
                        class="img-fluid" alt="Product Image">
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container mt-5">
            <span class="fs-1">Quick Buy Our Unique Products</span>
            <div class="m-auto pt-4 ps-3 pe-3 pb-5">
                <div class="row">
                    <div class="col-lg-7 col-md-6 col-sm-12 pt-3">
                        <div class="slider-container">
                            <!-- Main image container with zoom effect -->
                            <div class="image-container">
                                <img id="mainImage" class="main-image"
                                    src="{{ asset('assets/uploads/product/' . $product->cover_image_data) }}"
                                    alt="{{ $product->title }}" loading="lazy">
                            </div>
                            <!-- Thumbnails -->
                            <div class="thumbnails">
                                <!-- Add the cover image as the first thumbnail and make it active -->
                                <img class="thumbnail active"
                                    src="{{ asset('assets/uploads/product/' . $product->cover_image_data) }}"
                                    alt="Cover Image" loading="lazy"
                                    onclick="changeImage('{{ asset('assets/uploads/product/' . $product->cover_image_data) }}', this)">

                                @if ($product->product_images_data && count($product->product_images_data) > 0)
                                    @foreach ($product->product_images_data as $index => $product_image)
                                        <img class="thumbnail"
                                            src="{{ asset('assets/uploads/product/' . $product_image) }}"
                                            alt="Thumbnail {{ $index + 2 }}" loading="lazy"
                                            onclick="changeImage('{{ asset('assets/uploads/product/' . $product_image) }}', this)">
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 col-md-6 col-sm-12 pt-3 p-5">

                        @if ($product->categories && count($product->categories) > 0)
                            @foreach ($product->categories as $index => $category)
                                <small class="text-muted">{{ $category->name }}</small>
                                @if ($index < count($product->categories) - 1)
                                    <span class="text-muted"> | </span>
                                @endif
                            @endforeach
                        @else
                            <span class="text-muted">--</span>
                        @endif

                        <p class="fs-1 ">
                            {{ $product->title }}
                        </p>

                        <p class="text-muted mb-4">
                            <del>Rs. {{ number_format($product->compare_at_price, 2) }} PKR</del> &nbsp; <span
                                class="text-black"> Rs. {{ number_format($product->price, 2) }}PKR</span> <span
                                class="badge rounded-pill bg-dark m-2">Sale</span>
                        </p>

                        @if ($product->sizes && $product->sizes[0] != null && count($product->sizes) > 0)
                            <span class="fs-4">Sizes</span>
                            <div class="size-options">
                                @foreach ($product->sizes as $index => $size)
                                    <label class="btn btn-outline-dark">
                                        <input type="radio" name="size" value="{{ $size }}"
                                            autocomplete="off">
                                        {{ $size }}
                                    </label>
                                @endforeach
                            </div>
                            <br>
                        @endif

                        <!-- Color Selection -->
                        @if ($product->colors && $product->colors[0] != null && count($product->colors) > 0)
                            <span class="fs-4">Colors</span>
                            <div class="color-options">
                                @foreach ($product->colors as $index => $color)
                                    <label class="btn btn-outline-dark">
                                        <input type="radio" name="color" value="{{ $color }}" autocomplete="off"
                                            onclick="changeColorImage('{{ asset('assets/uploads/product/' . $product->color_images[$index]) }}')">
                                        {{ $color }}
                                    </label>
                                @endforeach
                            </div>
                            <br>
                        @endif

                        <div class="quantity-input">
                            <div class="border p-1 quantity-input">
                                <button id="decreaseBtn" class="bg-transparent border-0" min="1"><i
                                        class="fa-solid fa-minus"></i></button>
                                <input type="number" id="quantity" value="1" min="1" class="border-0">
                                <button id="increaseBtn" class="bg-transparent border-0"><i
                                        class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>

                        <form
                            action="{{ route('store.cart.add', ['shop' => request()->route('shop'), 'productId' => $product->id]) }} "
                            method="POST">
                            @csrf
                            <input type="hidden" name="size" id="selectedSize" value="" required>
                            <input type="hidden" name="color" id="selectedColor" value="" required>
                            <input type="hidden" name="quantity" id="selectedQuantity" value="1">

                            <button type="submit"
                                class="bg-transparent border-1 border-black btn cart-btn mt-5 p-3 rounded-0 w-100">
                                ADD TO CART
                            </button>
                        </form>

                        {{-- <button type="button" class="bg-black border-1 buynow-btn mt-3 p-3 text-white w-100"
                            onclick="populateModal()">
                            Buy with Cash on Delivery
                        </button> --}}

                        <div class="product-description" style=" overflow: hidden; ">
                            {!! $product->productDiscription !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section type="customer-review">
        <div class="bg-light-subtle container-fluid p-5 mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 pb-3">
                        <span class="fs-1">
                            Customers Reviews
                        </span>
                    </div>

                    @php
                        $reviews = json_decode($storeSettings->customer_review_detail, true) ?? [];
                    @endphp

                    @foreach ($reviews as $review)
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="bg-light p-4 border">
                                <h5>{{ $review['name'] ?? 'Anonymous' }}
                                    {{ str_repeat('⭐', $review['stars'] ?? 5) }}
                                </h5>
                                <p class="text-muted">
                                    {{ $review['review'] ?? 'No review text available.' }}
                                </p>
                            </div>
                        </div>
                    @endforeach

                    @if (empty($reviews))
                        <div class="col-12 text-center">
                            <p class="text-muted">No customer reviews available.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>


    <section type="Contact-Form">
        <div class="container mt-5">
            <div class="m-auto w-75">
                <span class="fs-1 pb-3">
                    Contact form
                </span>
                @include('include.contactform')
            </div>

        </div>
    </section>

@endsection
