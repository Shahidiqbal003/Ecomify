@extends('template.ui-main')
@section('title', $collection->name)
@section('content')
    <section type="collection">
        <div class="container">
            <div class="m-auto pt-4 ps-3 pe-3 pb-5">
                <span class="fs-1 pb-5">
                    {{ $collection->name }}
                </span>
                <br>
                <br>
                <div class="row">
                    @foreach ($products as $data)
                        <div class="col-lg-3 col-md-4 col-sm-12 pt-3">
                            <a href="{{ route('store.product.detail', ['shop' => request()->route('shop'), 'slug' => $data->slug]) }}" class="cart-link text-decoration-none">
                                <div class="border-0 card" style="width: 100%;">
                                    <div class="position-relative">
                                        <img src="{{ asset('assets/uploads/product/' . $data->cover_image_data) }}"
                                            class="card-img-top rounded-0 img-main" alt="{{ $data->title }}"
                                            style="height: 306px;">
                                        <img class="img-hover card-img-top rounded-0"
                                            src="{{ asset('assets/uploads/product/' . $data->cover_first_image) }}"
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

                    <div class="col-12">
                        <div class="container text-center">
                            <a href="#" class="btn btn-dark pb-2 pe-4 ps-4 pt-2 rounded-0">View all</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
