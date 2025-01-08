@extends('template.ui-main')
@section('title', 'Checkout')
@section('content')

    <div class=" accordion-left d-none bg-body-secondary container-fluid p-2">
        <div class="container">
            <div>
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item rounded-0">
                        <h2 class="accordion-header rounded-0" id="headingOne">
                            <button class="bg-body-secondary accordion-button rounded-0 p-4" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                aria-controls="collapseOne">
                                Order summary |
                                <b class="ms-1">RS: {{ number_format($total, 2) }}</b>
                            </button>
                        </h2>
                        <div id="collapseOne" class="bg-body-secondary accordion-collapse collapse "
                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row">
                                    @foreach ($cart as $productId => $item)
                                        <div class="col-2 p-0 mt-3">
                                            <a href="{{ asset('assets/uploads/product/' . $item['cover_image_data']) }}"
                                                data-lightbox="image" target="_blank" class="position-relative ">
                                                <img class="img-thumbnail" style="width: 100px; height: 100px;"
                                                    src="{{ asset('assets/uploads/product/' . $item['cover_image_data']) }}"
                                                    alt="{{ $item['name'] }}" loading="lazy">
                                                <span
                                                    class="position-absolute start-100 translate-middle badge bg-dark border border-light rounded-circle">
                                                    {{ $item['quantity'] }}
                                                </span>
                                            </a>
                                        </div>
                                        <div class="col-7 mt-3">
                                            <span>{{ $item['name'] }}</span><br>
                                            @if ($item['color'] != null && $item['size'] != null)
                                                <span class="fst-italic text-muted">Color: {{ $item['color'] }} | Size:
                                                    {{ $item['size'] }}</span>
                                            @endif
                                        </div>
                                        <div class="col-3 text-end mt-3">
                                            RS: {{ number_format($item['price'] * $item['quantity'], 2) }}
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row mt-5">
                                    <div class="col-6">
                                        <p>Subtotal</p>
                                    </div>
                                    <div class="col-6 text-end">
                                        <p> RS: {{ $subtotal }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p>Shipping</p>
                                    </div>
                                    <div class="col-6 text-end">
                                        <p> RS: {{ $shipping }}</p>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <h4>Total</h4>
                                    </div>
                                    <div class="col-6 text-end mt-3">
                                        <h4> RS: {{ number_format($total, 2) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 ps-4 pe-4">
                <form class="needs-validation" novalidate
                    action="{{ URL::signedRoute('store.checkout', ['shop' => request()->route('shop')]) }}" method="POST">
                    @csrf
                    @if ($storeSettings->email_show == 1)
                    <h4>Contact Information</h4>
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                Email
                                @if ($storeSettings->email_required == 1)
                                    <span class="text-danger">*</span>
                                @else
                                    <span class="text-muted">(Optional)</span>
                                @endif
                            </label>
                            <input type="email" class="form-control form-control-lg rounded-0" id="email"
                                name="email" value="{{ old('email') }}"
                                @if ($storeSettings->email_required == 1) required @endif>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="1" id="news_offers"
                                name="news_offers" {{ old('news_offers') ? 'checked' : '' }}>
                            <label class="form-check-label" for="news_offers">Email me with news and offers</label>
                        </div>
                    @endif

                    <h4>Delivery Information</h4>
                    @if ($storeSettings->country_show == 1)
                        <div class="mb-3">
                            <label for="country" class="form-label">Country/Region
                                @if ($storeSettings->country_required == 1)
                                    <span class="text-danger">*</span>
                                @endif
                            </label>
                            <select class="form-select form-select-lg rounded-0" @if ($storeSettings->email_required == 1) required @endif id="country" name="country">
                                <option value="Pakistan" {{ old('country', 'Pakistan') == 'Pakistan' ? 'selected' : '' }}>
                                    Pakistan</option>
                            </select>
                        </div>
                    @endif

                    <div class="row">
                        @if ($storeSettings->first_name_show == 1)
                            <div class=" {{ $storeSettings->last_name_show != 1 ? 'col-lg-12' : 'col-lg-6' }}">
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">
                                        First Name
                                        @if ($storeSettings->first_name_required == 1)
                                            <span class="text-danger">*</span>
                                        @else
                                            <span class="text-muted">(Optional)</span>
                                        @endif
                                    </label>
                                    <input type="text" class="form-control form-control-lg rounded-0" id="first_name"
                                        name="first_name" value="{{ old('first_name') }}"
                                        @if ($storeSettings->first_name_required == 1) required @endif>
                                </div>
                            </div>
                        @endif

                        @if ($storeSettings->last_name_show == 1)
                            <div class="{{ $storeSettings->first_name_show != 1 ? 'col-lg-12' : 'col-lg-6' }}">
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">
                                        Last Name
                                        @if ($storeSettings->last_name_required == 1)
                                            <span class="text-danger">*</span>
                                        @else
                                            <span class="text-muted">(Optional)</span>
                                        @endif
                                    </label>
                                    <input type="text" class="form-control form-control-lg rounded-0" id="last_name"
                                        name="last_name" value="{{ old('last_name') }}"
                                        @if ($storeSettings->last_name_required == 1) required @endif>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if ($storeSettings->company_show == 1)
                        <div class="mb-3">
                            <label for="company" class="form-label">
                                Company
                                @if ($storeSettings->company_required == 1)
                                    <span class="text-danger">*</span>
                                @else
                                    <span class="text-muted">(Optional)</span>
                                @endif
                            </label>
                            <input type="text" class="form-control form-control-lg rounded-0" id="company"
                                name="company" value="{{ old('company') }}"
                                @if ($storeSettings->company_required == 1) required @endif>
                        </div>
                    @endif

                    @if ($storeSettings->address_show == 1)
                        <div class="mb-3">
                            <label for="address" class="form-label">
                                Address
                                @if ($storeSettings->address_required == 1)
                                    <span class="text-danger">*</span>
                                @else
                                    <span class="text-muted">(Optional)</span>
                                @endif
                            </label>
                            <input type="text" class="form-control form-control-lg rounded-0" id="address"
                                name="address" value="{{ old('address') }}"
                                @if ($storeSettings->address_required == 1) required @endif>
                        </div>
                    @endif

                    @if ($storeSettings->apartment_show == 1)
                        <div class="mb-3">
                            <label for="apartment" class="form-label">
                                Apartment, suite, etc.
                                @if ($storeSettings->apartment_required == 1)
                                    <span class="text-danger">*</span>
                                @else
                                    <span class="text-muted">(Optional)</span>
                                @endif
                            </label>
                            <input type="text" class="form-control form-control-lg rounded-0" id="apartment"
                                name="apartment" value="{{ old('apartment') }}"
                                @if ($storeSettings->apartment_required == 1) required @endif>
                        </div>
                    @endif

                    <div class="row">
                        @if ($storeSettings->city_show == 1)
                            <div class="{{ $storeSettings->postal_code_show != 1 ? 'col-lg-12' : 'col-lg-6' }}">
                                <div class="mb-3">
                                    <label for="city" class="form-label">
                                        City
                                        @if ($storeSettings->city_required == 1)
                                            <span class="text-danger">*</span>
                                        @else
                                            <span class="text-muted">(Optional)</span>
                                        @endif
                                    </label>
                                    <input type="text" class="form-control form-control-lg rounded-0" id="city"
                                        name="city" value="{{ old('city') }}"
                                        @if ($storeSettings->city_required == 1) required @endif>
                                </div>
                            </div>
                        @endif

                        @if ($storeSettings->postal_code_show == 1)
                            <div class="{{ $storeSettings->city_show != 1 ? 'col-lg-12' : 'col-lg-6' }}">
                                <div class="mb-3">
                                    <label for="postal_code" class="form-label">
                                        Postal Code
                                        @if ($storeSettings->postal_code_required == 1)
                                            <span class="text-danger">*</span>
                                        @else
                                            <span class="text-muted">(Optional)</span>
                                        @endif
                                    </label>
                                    <input type="text" class="form-control form-control-lg rounded-0" id="postal_code"
                                        name="postal_code" value="{{ old('postal_code') }}"
                                        @if ($storeSettings->postal_code_required == 1) required @endif>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if ($storeSettings->phone_show == 1)
                        <div class="mb-3">
                            <label for="phone" class="form-label">
                                Phone
                                @if ($storeSettings->phone_required == 1)
                                    <span class="text-danger">*</span>
                                @else
                                    <span class="text-muted">(Optional)</span>
                                @endif
                            </label>
                            <input type="tel" class="form-control form-control-lg rounded-0" id="phone"
                                name="phone" value="{{ old('phone') }}" pattern="03[0-9]{9}"
                                @if ($storeSettings->phone_required == 1) required @endif>
                                <small class="text-muted">Please enter a valid Pakistani mobile number (e.g.,
                                    03XXXXXXXXX)</small>
                        </div>
                    @endif

                    @if ($storeSettings->note_show == 1)
                        <div class="mb-3">
                            <label for="note" class="form-label">
                                Note
                                @if ($storeSettings->note_required == 1)
                                    <span class="text-danger">*</span>
                                @else
                                    <span class="text-muted">(Optional)</span>
                                @endif
                            </label>
                            <textarea name="note" id="note" class="form-control form-control-lg rounded-0"
                                @if ($storeSettings->note_required == 1) required @endif>{{ old('note') }}</textarea>
                        </div>
                    @endif

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="1" id="save_info" name="save_info"
                            {{ old('save_info') ? 'checked' : '' }}>
                        <label class="form-check-label" for="save_info">Save this information for next time</label>
                    </div>

                    <div class="mb-3 mt-4">
                        <h5 class="form-label">Shipping method</h5>
                        <p class="alert alert-light rounded-0 text-dark"><span>Standard</span> <span class="float-end">Rs
                                {{ $shipping }}</span></p>
                        <input type="hidden" name="shipping" value="{{ $shipping }}">
                        <input type="hidden" name="payment_method" value="COD">
                    </div>

                    <div class="mb-3 mt-4">
                        <h5 class="form-label">Payment<br><small class="fs-6 text-muted">All transactions are secure and
                                encrypted.</small></h5>
                        <p class="alert alert-light rounded-0 text-dark"><span>Cash on Delivery (COD)</span> </p>
                    </div>

                    <br>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="1" id="save_info" name="save_info"
                            {{ old('save_info') ? 'checked' : '' }} required>
                        <label class="form-check-label" for="save_info">I agree with the <a target="_blank" href="{{ route('store.pages.show', ['shop' => request()->route('shop'), 'page' => 'terms_of_service']) }}"
                                class="text-decoration-none text-muted privacyPolicy">Terms & Conditions</a></label>
                    </div>

                    <button type="submit" class="bg-dark border btn p-3 rounded-0 text-light w-100 ">Complete
                        Order</button>
                </form>
            </div>
            <div class=" accordion-right col-lg-6 col-md-12 col-sm-12 pe-4 ps-5 border-start">
                <div class="row">
                    @foreach ($cart as $productId => $item)
                        <div class="col-2 p-0 mt-3">
                            <a href="{{ asset('assets/uploads/product/' . $item['cover_image_data']) }}"
                                data-lightbox="image" target="_blank" class="position-relative ">
                                <img class="img-thumbnail" style="width: 100px; height: 100px;"
                                    src="{{ asset('assets/uploads/product/' . $item['cover_image_data']) }}"
                                    alt="{{ $item['name'] }}" loading="lazy">
                                <span
                                    class="position-absolute start-100 translate-middle badge bg-dark border border-light rounded-circle">
                                    {{ $item['quantity'] }}
                                </span>
                            </a>
                        </div>
                        <div class="col-7 mt-3">
                            <span>{{ $item['name'] }}</span><br>
                            @if ($item['color'] != null && $item['size'] != null)
                                <span class="fst-italic text-muted">Color: {{ $item['color'] }} | Size:
                                    {{ $item['size'] }}</span>
                            @endif
                        </div>
                        <div class="col-3 text-end mt-3">
                            RS: {{ number_format($item['price'] * $item['quantity'], 2) }}
                        </div>
                    @endforeach

                </div>

                {{-- <div class="row mt-3">
                    <div class="col-12">
                        <a id="addCouponBtn" style="cursor: pointer;">Have a coupon code?</a>  <small id="discountAmount" class="text-success d-none" style=" font-size: 12px; ">Discount: RS: 0.00</small>
                        <form id="couponForm" class="d-none mt-2">
                            @csrf
                            <div class="input-group">
                                <input type="text" id="couponCode" aria-describedby="basic-addon2" class="form-control rounded-0" placeholder="Enter Coupon Code">
                                <div class="input-group-append">
                                    <button type="button" id="applyCouponBtn" class="btn btn-primary rounded-0">Apply</button>
                                </div>
                            </div>
                            <small id="couponMessage" class="text-danger"></small>
                        </form>

                    </div>
                </div> --}}

                <div class="row mt-5">
                    <div class="col-6">
                        <p>Subtotal</p>
                    </div>
                    <div class="col-6 text-end">
                        <p> RS: {{ number_format($subtotal, 2) }}</p>
                    </div>
                    <div class="col-6">
                        <p>Shipping</p>
                    </div>
                    <div class="col-6 text-end">
                        <p> RS: {{ $shipping }}</p>
                    </div>
                    <div class="col-6 mt-3">
                        <h4>Total</h4>
                    </div>
                    {{-- <div class="col-6 text-end mt-3">
                        <h4 class="total"> RS: {{ number_format($total, 2) }}</h4>
                    </div> --}}
                    <div class="col-6 text-end mt-3">
                        <h4 id="totalAmount" class="total">RS: {{ number_format($total, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.innerWidth < 990) {
                document.querySelector('.accordion-right').classList.add('d-none');
                document.querySelector('.accordion-left').classList.remove('d-none');
            }

            window.addEventListener('resize', function() {
                if (window.innerWidth < 990) {
                    document.querySelector('.accordion-right').classList.add('d-none');
                    document.querySelector('.accordion-left').classList.remove('d-none');
                } else {
                    document.querySelector('.accordion-right').classList.remove('d-none');
                    document.querySelector('.accordion-left').classList.add('d-none');
                }
            });
        });
    </script>
    {{-- <script>
        document.getElementById('addCouponBtn').addEventListener('click', function () {
            document.getElementById('couponForm').classList.toggle('d-none');
        });

        document.getElementById('applyCouponBtn').addEventListener('click', function () {
            const couponCode = document.getElementById('couponCode').value;
            let cartTotal = parseFloat('{{ $total }}'); // Convert to float
            const csrfToken = document.querySelector('input[name="_token"]').value;

            if (couponCode.trim() === '') {
                document.getElementById('couponMessage').innerText = 'Please enter a coupon code.';
                return;
            }

            fetch("{{ route('store.applyCoupon', ['shop' => request()->route('shop')]) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ coupon_code: couponCode, cart_total: cartTotal })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('couponMessage').innerText = data.message;
                    document.getElementById('couponMessage').classList.remove('text-danger');
                    document.getElementById('couponMessage').classList.add('text-success');

                    // Update discount and new total dynamically
                    document.getElementById('discountAmount').classList.remove('d-none');;
                    document.getElementById('discountAmount').innerText = `Discount: RS ${data.discount_amount.toFixed(2)}`;
                    document.getElementById('totalAmount').innerText = `RS: ${data.new_total.toFixed(2)}`;
                } else {
                    document.getElementById('couponMessage').innerText = data.message;
                    document.getElementById('couponMessage').classList.add('text-danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('couponMessage').innerText = 'An error occurred. Please try again.';
            });
        });
    </script> --}}


@endsection
