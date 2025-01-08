@extends('template.ui-main')
@section('title', 'Products')
@section('content')
    <style>
        #quantity:focus {
            border: none;
            outline: none;
        }

        .ptc {
            width: 25%;
        }

        .ptc:hover {
            color: #fff !important;
        }

        @media (max-width: 990px) {
            .ptc {
                width: 50%;
            }
        }

        @media (max-width: 990px) {
            .mobile_cart {
                display: table-row !important;
            }

            .heading1,
            .heading4,
            .heading5 {
                display: none !important;
            }

            .heading3 {
                text-align: end!important;
                padding-right: 53px!important;
            }

            .desktop_cart {
                display: none !important;
            }
        }

        @media (min-width: 991px) {
            .mobile_cart {
                display: none !important;
            }

            .desktop_cart {
                display: table-row !important;
            }
        }
    </style>
    <div class="container mt-5">
        <div class="cart">
            <p class="fs-1">Your Cart</p>
            @if (count($cart) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th class="heading1">Item</th>
                            <th class="heading2">Product</th>
                            <th class="heading3">Price</th>
                            <th class="text-center heading4">Quantity</th>
                            <th class="heading5">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalPrice = 0;
                        @endphp
                        @foreach ($cart as $productId => $item)

                            @php
                                $totalPrice += $item['price'] * $item['quantity'];
                            @endphp
                            <tr class="mobile_cart">
                                <td colspan="5">
                                    <div class="border p-3 m-0 row">
                                        <div class="col-2 p-0">
                                            <a href="{{ asset('assets/uploads/product/' . $item['cover_image_data']) }}"
                                                data-lightbox="image" target="_blank">
                                                <img class="img-thumbnail" style="width: 100px; height: 100px;"
                                                    src="{{ asset('assets/uploads/product/' . $item['cover_image_data']) }}"
                                                    alt="{{ $item['name'] }}" loading="lazy">
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <span>{{ $item['name'] }}</span><br>
                                            @if ($item['color'] != null && $item['size'] != null)
                                                <span class="fst-italic text-muted">Color: {{ $item['color'] }} | Size:
                                                    {{ $item['size'] }}</span>
                                            @endif

                                            <form action="{{ route('store.cart.update', ['shop' => request()->route('shop'), 'productId' => $item['id']]) }}" method="POST"
                                                class=" align-items-center" style="flex-direction: column;">
                                                @csrf
                                                @method('PUT')
                                                <div class="quantity-input">
                                                    <div class="border p-1 quantity-input">
                                                        <a class="decrease-btn btn bg-transparent border-0"
                                                            min="1"><i class="fa-solid fa-minus"></i></a>
                                                        <input type="number" name="quantity"
                                                            value="{{ $item['quantity'] }}" min="1"
                                                            class="quantity-input-field border-0">
                                                        <a class="increase-btn btn bg-transparent border-0"><i
                                                                class="fa-solid fa-plus"></i></a>
                                                    </div>
                                                </div>
                                                <button type="submit"
                                                    class="bg-transparent cart_qty_update_btn border-0 mt-1">Update</button>
                                                <a class="badge bg-danger text-decoration-none text-light"
                                                    href="{{ route('store.cart.remove', ['shop' => request()->route('shop'), 'productId' => $item['id']]) }}">Remove</a>
                                            </form>

                                        </div>
                                        <div class="col-4 text-end">
                                            RS: {{ $item['price'] }}
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            <tr class="desktop_cart">
                                <td>
                                    <a href="{{ asset('assets/uploads/product/' . $item['cover_image_data']) }}"
                                        data-lightbox="image" target="_blank">
                                        <img class="img-thumbnail" style="width: 100px; height: 100px;"
                                            src="{{ asset('assets/uploads/product/' . $item['cover_image_data']) }}"
                                            alt="{{ $item['name'] }}" loading="lazy">
                                    </a>
                                </td>
                                <td class="pt-4">
                                    <span>{{ $item['name'] }}</span><br>
                                    @if ($item['color'] != null && $item['size'] != null)
                                        <span class="fst-italic text-muted">Color: {{ $item['color'] }} | Size:
                                            {{ $item['size'] }}</span>
                                    @endif
                                </td>
                                <td class="pt-4">RS: {{ $item['price'] }}</td>

                                <td>
                                    <form action="{{ route('store.cart.update', ['shop' => request()->route('shop'), 'productId' => $item['id']]) }}" method="POST"
                                        class="d-flex align-items-center" style="flex-direction: column;">
                                        @csrf
                                        @method('PUT')
                                        <div class="quantity-input">
                                            <div class="border p-1 quantity-input">
                                                <a class="decrease-btn btn bg-transparent border-0" min="1"><i
                                                        class="fa-solid fa-minus"></i></a>
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                                    min="1" class="quantity-input-field border-0">
                                                <a class="increase-btn btn bg-transparent border-0"><i
                                                        class="fa-solid fa-plus"></i></a>
                                            </div>
                                        </div>
                                        <button type="submit"
                                            class="bg-transparent cart_qty_update_btn border-0 mt-1">Update</button>
                                    </form>
                                </td>
                                <td class="pt-4">
                                    <a class="text-dark text-decoration-none"
                                        href="{{ route('store.cart.remove', ['shop' => request()->route('shop'), 'productId' => $item['id']]) }}">Remove</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Cart view -->
                <div class="text-end">
                    <p class="fs-4">Total Payment: {{ number_format($totalPrice, 2) }}</p>
                    <form method="POST" action="{{ URL::signedRoute('store.proceed_checkout', ['shop' => request()->route('shop')]) }}">
                        @csrf
                        <input type="hidden" name="total" value="{{ number_format($totalPrice, 2) }}">
                        <button type="submit" id="proceedCheckout" class="bg-dark border btn p-3 rounded-0 text-light ptc">
                            <div class="spinner-grow d-none" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <span class="cart_text">
                                Proceed to checkout
                            </span>
                        </button>
                    </form>
                </div>
            @else
                <p>Your cart is empty!</p>
                <br>
                <a href="{{ route('store.shop', ['shop' => request()->route('shop')]) }}" class="bg-dark border btn p-3 rounded-0 text-light ptc">Continue
                    Shopping</a>
                <br><br><br><br><br><br><br><br>
            @endif
        </div>
    </div>
    <script>
        const decreaseBtns = document.querySelectorAll('.decrease-btn');
        const increaseBtns = document.querySelectorAll('.increase-btn');
        const quantityInputFields = document.querySelectorAll('.quantity-input-field');

        decreaseBtns.forEach((decreaseBtn) => {
            decreaseBtn.addEventListener('click', () => {
                const quantityInputField = decreaseBtn.parentNode.querySelector('.quantity-input-field');
                let currentValue = parseInt(quantityInputField.value);
                if (currentValue > 1) {
                    quantityInputField.value = currentValue - 1;
                }
            });
        });

        increaseBtns.forEach((increaseBtn) => {
            increaseBtn.addEventListener('click', () => {
                const quantityInputField = increaseBtn.parentNode.querySelector('.quantity-input-field');
                let currentValue = parseInt(quantityInputField.value);
                quantityInputField.value = currentValue + 1;
            });
        });

        document.getElementById('proceedCheckout').addEventListener('click', () => {

            document.querySelector('.cart_text').classList.add('d-none');
            document.querySelector('.spinner-grow').classList.remove('d-none');
            document.querySelector('#proceedCheckout').classList.remove('p-3');
            document.querySelector('#proceedCheckout').classList.add('p-2');
            setTimeout(() => {
                document.querySelector('.cart_text').classList.remove('d-none');
                document.querySelector('.spinner-grow').classList.add('d-none');
                document.querySelector('#proceedCheckout').classList.remove('p-2');
                document.querySelector('#proceedCheckout').classList.add('p-3');
            }, 2000);
        });
    </script>
@endsection
