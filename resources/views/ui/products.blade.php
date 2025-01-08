@extends('template.ui-main')
@section('title', 'Products')
@section('content')

    <section type="Products">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-dismissible alert-light  fade mt-4 pb-1 rounded-0 show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <p>You can continue shopping or <a
                            href="{{ route('store.cart.show', ['shop' => request()->shop->name]) }} " class="alert-link">view
                            your cart</a>.</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif(session('error'))
                <div class="alert alert-light  alert-dismissible rounded-0 mt-4 pb-1 fade show" role="alert">
                    <strong>{{ session('error') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
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
                                        <img class="thumbnail" src="{{ asset('assets/uploads/product/' . $product_image) }}"
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

                        <button type="button" class="bg-black border-1 buynow-btn mt-3 p-3 text-white w-100"
                            onclick="populateModal()">
                            Buy with Cash on Delivery
                        </button>

                        <button type="button" class="bg-success border-1 whatsapp-btn mt-3 p-3 text-white w-100"
                            onclick="orderOnWhatsApp()">
                            Order on WhatsApp
                        </button>
                        <div class="product-description" style=" overflow: hidden; ">
                            {!! $product->productDiscription !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="buyNowModal" tabindex="-1" aria-labelledby="buyNowModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content rounded-0">
                <form class="needs-validation" novalidate
                    action="{{ URL::signedRoute('store.quick.checkout', ['shop' => request()->route('shop')]) }}"
                    method="POST">
                    @csrf
                    <div class="bg-body-secondary modal-header">
                        <h5 class="modal-title" id="buyNowModalLabel">Complete Your Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="accordion pb-2" id="accordionExample">
                            <div class="accordion-item rounded-0">
                                <h2 class="accordion-header rounded-0" id="headingOne">
                                    <button class="bg-body-secondary accordion-button rounded-0" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne">
                                        Order summary |
                                        <b class="ms-1"><span id="modalTotalmain"></span></b>
                                    </button>
                                </h2>
                                <div id="collapseOne" class="bg-body-secondary accordion-collapse collapse "
                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-2 p-0 mt-2 text-center">
                                                <img id="modalProductImage" src="" alt="Product Image"
                                                    class="img-thumbnail" style="width: 100px; height: auto;"
                                                    loading="lazy">
                                            </div>
                                            <div class="col-6 pl-4 mt-2">
                                                <span id="modalProductTitle"></span>
                                                <span id="modalProductTitle"></span><br>
                                                <span class="fst-italic text-muted">Color: <span
                                                        id="modalProductColor"></span></span>
                                                <span class="fst-italic text-muted">Size: <span
                                                        id="modalProductSize"></span></span><br>
                                                <span class="fst-italic text-muted">QTY: <span
                                                        id="modalProductQuantity"></span></span>
                                            </div>
                                            <div class="col-4 mt-2 pe-4 text-end">
                                                <span>Rs. <span id="modalProductPrice"></span></span>
                                            </div>
                                            <div class="col-12 mt-2 pe-4 ">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <b>Shipping:</b>
                                                    </div>
                                                    <div class="col-4 text-end">
                                                        <span id="modalShipping"></span>
                                                    </div>
                                                    <div class="col-8">
                                                        <b>Total Price:</b>
                                                    </div>
                                                    <div class="col-4 text-end">
                                                        <span id="modalTotal"></span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Information Form -->

                        @if ($storeSettings->email_quick_buy == 1)
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
                                    <label class="form-check-label" for="news_offers">Email me with news and
                                        offers</label>
                                </div>
                            @endif
                        @endif

                        <h4>Delivery Information</h4>
                        @if ($storeSettings->country_quick_buy == 1)
                            @if ($storeSettings->country_show == 1)
                                <div class="mb-3">
                                    <label for="country" class="form-label">Country/Region
                                        @if ($storeSettings->country_required == 1)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>
                                    <select class="form-select form-select-lg rounded-0"
                                        @if ($storeSettings->email_required == 1) required @endif id="country" name="country">
                                        <option value="Pakistan"
                                            {{ old('country', 'Pakistan') == 'Pakistan' ? 'selected' : '' }}>
                                            Pakistan</option>
                                    </select>
                                </div>
                            @endif
                        @endif

                        <div class="row">
                            @if ($storeSettings->first_name_quick_buy == 1)
                                @if ($storeSettings->first_name_show == 1)
                                    <div class=" {{ ($storeSettings->first_name_quick_buy == 1 || $storeSettings->last_name_show != 1) ? 'col-lg-12' : 'col-lg-6' }}">
                                        <div class="mb-3">
                                            <label for="first_name" class="form-label">
                                                First Name
                                                @if ($storeSettings->first_name_required == 1)
                                                    <span class="text-danger">*</span>
                                                @else
                                                    <span class="text-muted">(Optional)</span>
                                                @endif
                                            </label>
                                            <input type="text" class="form-control form-control-lg rounded-0"
                                                id="first_name" name="first_name" value="{{ old('first_name') }}"
                                                @if ($storeSettings->first_name_required == 1) required @endif>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            @if ($storeSettings->last_name_quick_buy == 1)
                                @if ($storeSettings->last_name_show == 1)
                                    <div class="{{ ($storeSettings->last_name_quick_buy == 1 || $storeSettings->first_name_show != 1) ? 'col-lg-12' : 'col-lg-6' }} ">
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">
                                                Last Name
                                                @if ($storeSettings->last_name_required == 1)
                                                    <span class="text-danger">*</span>
                                                @else
                                                    <span class="text-muted">(Optional)</span>
                                                @endif
                                            </label>
                                            <input type="text" class="form-control form-control-lg rounded-0"
                                                id="last_name" name="last_name" value="{{ old('last_name') }}"
                                                @if ($storeSettings->last_name_required == 1) required @endif>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>

                        @if ($storeSettings->company_quick_buy == 1)
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
                        @endif

                        @if ($storeSettings->address_quick_buy == 1)
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
                        @endif

                        @if ($storeSettings->apartment_quick_buy == 1)
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
                        @endif

                        <div class="row">
                            @if ($storeSettings->city_quick_buy == 1)
                                @if ($storeSettings->city_show == 1)
                                    <div class="{{ ($storeSettings->city_quick_buy == 1 || $storeSettings->postal_code_show != 1) ? 'col-lg-12' : 'col-lg-6' }}">
                                        <div class="mb-3">
                                            <label for="city" class="form-label">
                                                City
                                                @if ($storeSettings->city_required == 1)
                                                    <span class="text-danger">*</span>
                                                @else
                                                    <span class="text-muted">(Optional)</span>
                                                @endif
                                            </label>
                                            <input type="text" class="form-control form-control-lg rounded-0"
                                                id="city" name="city" value="{{ old('city') }}"
                                                @if ($storeSettings->city_required == 1) required @endif>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            @if ($storeSettings->postal_code_quick_buy == 1)
                                @if ($storeSettings->postal_code_show == 1)
                                    <div class="{{ ($storeSettings->postal_code_quick_buy == 1 || $storeSettings->city_show != 1) ? 'col-lg-12' : 'col-lg-6' }}">
                                        <div class="mb-3">
                                            <label for="postal_code" class="form-label">
                                                Postal Code
                                                @if ($storeSettings->postal_code_required == 1)
                                                    <span class="text-danger">*</span>
                                                @else
                                                    <span class="text-muted">(Optional)</span>
                                                @endif
                                            </label>
                                            <input type="text" class="form-control form-control-lg rounded-0"
                                                id="postal_code" name="postal_code" value="{{ old('postal_code') }}"
                                                @if ($storeSettings->postal_code_required == 1) required @endif>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>

                        @if ($storeSettings->phone_quick_buy == 1)
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
                        @endif

                        @if ($storeSettings->note_quick_buy == 1)
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
                        @endif

                        {{-- <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg rounded-0" id="first_name"
                                        name="first_name" required>
                                </div>
                            </div>
                            <div class="col-lg-6  col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg rounded-0" id="last_name"
                                        name="last_name" required>
                                </div>
                            </div>
                        </div>


                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone<span class="text-danger">*</span></label>
                            <input type="tel" class="form-control form-control-lg rounded-0" id="phone"
                                name="phone" value="{{ old('phone') }}" required pattern="03[0-9]{9}">
                            <small class="text-muted">Please enter a valid Pakistani mobile number (e.g.,
                                03XXXXXXXXX)</small>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg rounded-0" id="address"
                                name="address" required>
                        </div>

                        <div class="mb-3">
                            <label for="city" class="form-label">City<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg rounded-0" id="city"
                                name="city" value="{{ old('city') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Note(optional)</label>
                            <textarea name="note" id="note" value="{{ old('note') }}" class="form-control form-control-lg rounded-0"></textarea>
                        </div> --}}



                        <div class="mb-3 mt-4">
                            <h5 class="form-label">Shipping method</h5>
                            <p class="alert alert-light rounded-0 text-dark"><span>Standard</span> <span
                                    class="float-end"> <span id="modalFormShipping"></span></span></p>
                            <input type="hidden" id="modalInputShipping" name="shipping" value="">
                        </div>

                        <div class="mb-3 mt-4">
                            <h5 class="form-label">Payment</h5>
                            <p class="alert alert-light rounded-0 text-dark"><span>Cash on Delivery (COD)</span></p>
                            <input type="hidden" name="payment_method" value="COD">
                            <input type="hidden" id="total_payment" name="total_payment" value="">
                        </div>

                        <input type="hidden" class="form-control form-control-lg rounded-0" id="country"
                            name="country" value="Pakistan" required>
                        <input type="hidden" class="form-control form-control-lg rounded-0" id="id"
                            name="id" required>
                        <input type="hidden" class="form-control form-control-lg rounded-0" id="name"
                            name="name" required>
                        <input type="hidden" class="form-control form-control-lg rounded-0" id="price"
                            name="price" required>
                        <input type="hidden" class="form-control form-control-lg rounded-0" id="cover_image_data"
                            name="cover_image_data">
                        <input type="hidden" class="form-control form-control-lg rounded-0" id="size"
                            name="size">
                        <input type="hidden" class="form-control form-control-lg rounded-0" id="color"
                            name="color">
                        <input type="hidden" class="form-control form-control-lg rounded-0" id="quantityinput"
                            name="quantity" value="1" required>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="1" id="save_info"
                                name="save_info" {{ old('save_info') ? 'checked' : '' }} required>
                            <label class="form-check-label" for="save_info">I agree with the <a target="_blank"
                                    href="{{ route('store.pages.show', ['shop' => request()->route('shop'), 'page' => 'terms_of_service']) }}"
                                    class="text-decoration-none text-muted privacyPolicy">Terms & Conditions</a></label>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="bg-dark border btn p-3 rounded-0 text-light w-100 ">Complete
                                Order</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function populateModal() {
            const productId = "{{ $product->id }}";
            const productTitle = "{{ $product->title }}";
            const shipping = parseFloat("{{ $product->shipping }}"); // Convert shipping to float
            const productPrice = parseFloat("{{ $product->price }}"); // Convert price to float for calculation
            const selectedQuantity = parseInt(document.getElementById('quantity').value, 10); // Convert quantity to integer
            const selectedSize = document.getElementById('selectedSize').value;
            const selectedColor = document.getElementById('selectedColor').value;
            const productImage = document.getElementById('mainImage').src;
            const productImageInput = "{{ $product->cover_image_data }}";

            // Validate size and color
            let valid = true;

            if (document.querySelectorAll('.size-options input').length > 0 && !selectedSize) {
                document.querySelectorAll('.size-options label').forEach(label => {
                    label.style.borderColor = 'red'; // Highlight size options
                });
                valid = false;
            }

            if (document.querySelectorAll('.color-options input').length > 0 && !selectedColor) {
                document.querySelectorAll('.color-options label').forEach(label => {
                    label.style.borderColor = 'red'; // Highlight color options
                });
                valid = false;
            }

            if (!valid) {
                return; // Stop if validation fails
            }

            // Calculate total price
            const totalPrice = (productPrice * selectedQuantity).toFixed(
                2); // Multiply price and quantity, format to 2 decimals
            const total = (parseFloat(totalPrice) + shipping).toFixed(2); // Add shipping cost, format to 2 decimals

            // Populate modal with product details
            document.getElementById('modalProductTitle').innerText = productTitle;
            document.getElementById('modalProductPrice').innerText = totalPrice; // Show total price in modal
            document.getElementById('modalProductQuantity').innerText = selectedQuantity;
            document.getElementById('modalProductSize').innerText = selectedSize || 'N/A';
            document.getElementById('modalProductColor').innerText = selectedColor || 'N/A';
            document.getElementById('modalShipping').innerText = shipping ? `Rs. ${shipping}` :
                '<span class="badge bg-success">Free</span>';
            document.getElementById('modalFormShipping').innerText = shipping ? `Rs. ${shipping}` :
                '<span class="badge bg-success">Free</span>';
            document.getElementById('modalTotal').innerText = `Rs. ${total}`;
            document.getElementById('modalTotalmain').innerText = `Rs. ${total}`;
            document.getElementById('modalProductImage').src = productImage;

            // Populate modal Input with product details
            document.getElementById('modalInputShipping').value = shipping;
            document.getElementById('total_payment').value = total;

            document.getElementById('id').value = productId;
            document.getElementById('name').value = productTitle;
            document.getElementById('price').value = productPrice;
            document.getElementById('cover_image_data').value = productImageInput;
            document.getElementById('size').value = selectedSize;
            document.getElementById('quantityinput').value = selectedQuantity;

            // Open the modal
            const buyNowModal = new bootstrap.Modal(document.getElementById('buyNowModal'));
            buyNowModal.show();
        }
    </script>
@endsection
