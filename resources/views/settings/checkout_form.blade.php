@extends('template.main')
@section('title', 'Settings')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('title')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.dashboard', ['shop' => request()->route('shop')]) }}">Home</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>


        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="text-right">
                                    <a href="{{ route('admin.dashboard', ['shop' => request()->route('shop')]) }}"
                                        class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i>
                                        Back
                                    </a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @include('include.settingnav')
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane p-3 active" id="tabs-3" role="tabpanel">
                                        <form
                                            action="{{ route('settings.store', ['shop' => request()->route('shop'), 'id' => $shop->id]) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h4>Contact Information</h4>
                                                        <div class="bg-gradient-light mb-3 p-3 rounded">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input disabled type="email"
                                                                class="form-control form-control-lg rounded-0"
                                                                id="email">
                                                            <div>
                                                                <input type="hidden" name="email_show" value="0">
                                                                <input type="checkbox" id="email_show" name="email_show"
                                                                    value="1"
                                                                    {{ $settings->email_show == 1 ? 'checked' : '' }}>
                                                                <label for="email_show">Show</label>

                                                                <input type="hidden" name="email_required" value="0">
                                                                <input type="checkbox" id="email_required"
                                                                    name="email_required" value="1"
                                                                    {{ $settings->email_required == 1 ? 'checked' : '' }}>
                                                                <label for="email_required">Required</label>

                                                                <input type="hidden" name="email_quick_buy" value="0">
                                                                <input type="checkbox" id="email_quick_buy"
                                                                    name="email_quick_buy" value="1"
                                                                    {{ $settings->email_quick_buy == 1 ? 'checked' : '' }}>
                                                                <label for="email_quick_buy">Quick Buy</label>

                                                            </div>
                                                        </div>

                                                        <h4>Delivery Information</h4>
                                                        <div class="bg-gradient-light mb-3 p-3 rounded">
                                                            <label for="country" class="form-label">Country/Region</label>
                                                            <select disabled class="form-control form-select-lg rounded-0">
                                                                <option value="Pakistan" selected>Pakistan</option>
                                                            </select>
                                                            <div>
                                                                <input type="hidden" name="country_show" value="0">
                                                                <input type="checkbox" id="country_show" name="country_show"
                                                                    value="1"
                                                                    {{ $settings->country_show == 1 ? 'checked' : '' }}>
                                                                <label for="country_show">Show</label>

                                                                <input type="hidden" name="country_required"
                                                                    value="0">
                                                                <input type="checkbox" id="country_required"
                                                                    name="country_required" value="1"
                                                                    {{ $settings->country_required == 1 ? 'checked' : '' }}>
                                                                <label for="country_required">Required</label>

                                                                <input type="hidden" name="country_quick_buy" value="0">
                                                                <input type="checkbox" id="country_quick_buy" name="country_quick_buy" value="1" {{ $settings->country_quick_buy == 1 ? 'checked' : '' }}>
                                                                <label for="country_quick_buy">Quick Buy</label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="bg-gradient-light mb-3 p-3 rounded">
                                                                    <label for="first_name" class="form-label">First
                                                                        Name</label>
                                                                    <input disabled type="text"
                                                                        class="form-control form-control-lg rounded-0">
                                                                    <div>
                                                                        <input type="hidden" name="first_name_show"
                                                                            value="0">
                                                                        <input type="checkbox" id="first_name_show"
                                                                            name="first_name_show" value="1"
                                                                            {{ $settings->first_name_show == 1 ? 'checked' : '' }}>
                                                                        <label for="first_name_show">Show</label>

                                                                        <input type="hidden" name="first_name_required"
                                                                            value="0">
                                                                        <input type="checkbox" id="first_name_required"
                                                                            name="first_name_required" value="1"
                                                                            {{ $settings->first_name_required == 1 ? 'checked' : '' }}>
                                                                        <label for="first_name_required">Required</label>

                                                                        <input type="hidden" name="first_name_quick_buy"
                                                                            value="0">
                                                                        <input type="checkbox" id="first_name_quick_buy"
                                                                            name="first_name_quick_buy" value="1"
                                                                            {{ $settings->first_name_quick_buy == 1 ? 'checked' : '' }}>
                                                                        <label for="first_name_quick_buy">Quick Buy</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="bg-gradient-light mb-3 p-3 rounded">
                                                                    <label for="last_name" class="form-label">Last
                                                                        Name</label>
                                                                    <input disabled type="text"
                                                                        class="form-control form-control-lg rounded-0">
                                                                    <div>
                                                                        <input type="hidden" name="last_name_show"
                                                                            value="0">
                                                                        <input type="checkbox" id="last_name_show"
                                                                            name="last_name_show" value="1"
                                                                            {{ $settings->last_name_show == 1 ? 'checked' : '' }}>
                                                                        <label for="last_name_show">Show</label>

                                                                        <input type="hidden" name="last_name_required"
                                                                            value="0">
                                                                        <input type="checkbox" id="last_name_required"
                                                                            name="last_name_required" value="1"
                                                                            {{ $settings->last_name_required == 1 ? 'checked' : '' }}>
                                                                        <label for="last_name_required">Required</label>

                                                                        <input type="hidden" name="last_name_quick_buy"
                                                                            value="0">
                                                                        <input type="checkbox" id="last_name_quick_buy"
                                                                            name="last_name_quick_buy" value="1"
                                                                            {{ $settings->last_name_quick_buy == 1 ? 'checked' : '' }}>
                                                                        <label for="last_name_quick_buy">Quick Buy</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="bg-gradient-light mb-3 p-3 rounded">
                                                            <label for="company" class="form-label">Company</label>
                                                            <input disabled type="text"
                                                                class="form-control form-control-lg rounded-0">
                                                            <div>
                                                                <input type="hidden" name="company_show" value="0">
                                                                <input type="checkbox" id="company_show"
                                                                    name="company_show" value="1"
                                                                    {{ $settings->company_show == 1 ? 'checked' : '' }}>
                                                                <label for="company_show">Show</label>

                                                                <input type="hidden" name="company_required"
                                                                    value="0">
                                                                <input type="checkbox" id="company_required"
                                                                    name="company_required" value="1"
                                                                    {{ $settings->company_required == 1 ? 'checked' : '' }}>
                                                                <label for="company_required">Required</label>

                                                                <input type="hidden" name="company_quick_buy" value="0">
                                                                <input type="checkbox" id="company_quick_buy" name="company_quick_buy" value="1" {{ $settings->company_quick_buy == 1 ? 'checked' : '' }}>
                                                                <label for="company_quick_buy">Quick Buy</label>
                                                            </div>
                                                        </div>

                                                        <div class="bg-gradient-light mb-3 p-3 rounded">
                                                            <label for="address" class="form-label">Address</label>
                                                            <input disabled type="text"
                                                                class="form-control form-control-lg rounded-0">
                                                            <div>
                                                                <input type="hidden" name="address_show" value="0">
                                                                <input type="checkbox" id="address_show"
                                                                    name="address_show" value="1"
                                                                    {{ $settings->address_show == 1 ? 'checked' : '' }}>
                                                                <label for="address_show">Show</label>

                                                                <input type="hidden" name="address_required"
                                                                    value="0">
                                                                <input type="checkbox" id="address_required"
                                                                    name="address_required" value="1"
                                                                    {{ $settings->address_required == 1 ? 'checked' : '' }}>
                                                                <label for="address_required">Required</label>

                                                                <input type="hidden" name="address_quick_buy"
                                                                    value="0">
                                                                <input type="checkbox" id="address_quick_buy"
                                                                    name="address_quick_buy" value="1"
                                                                    {{ $settings->address_quick_buy == 1 ? 'checked' : '' }}>
                                                                <label for="address_quick_buy">Quick Buy</label>
                                                            </div>
                                                        </div>

                                                        <div class="bg-gradient-light mb-3 p-3 rounded">
                                                            <label for="apartment" class="form-label">Apartment, suite,
                                                                etc.</label>
                                                            <input disabled type="text"
                                                                class="form-control form-control-lg rounded-0">
                                                            <div>
                                                                <input type="hidden" name="apartment_show"
                                                                    value="0">
                                                                <input type="checkbox" id="apartment_show"
                                                                    name="apartment_show" value="1"
                                                                    {{ $settings->apartment_show == 1 ? 'checked' : '' }}>
                                                                <label for="apartment_show">Show</label>

                                                                <input type="hidden" name="apartment_required"
                                                                    value="0">
                                                                <input type="checkbox" id="apartment_required"
                                                                    name="apartment_required" value="1"
                                                                    {{ $settings->apartment_required == 1 ? 'checked' : '' }}>
                                                                <label for="apartment_required">Required</label>

                                                                <input type="hidden" name="apartment_quick_buy" value="0">
                                                                <input type="checkbox" id="apartment_quick_buy" name="apartment_quick_buy" value="1" {{ $settings->apartment_quick_buy == 1 ? 'checked' : '' }}>
                                                                <label for="apartment_quick_buy">Quick Buy</label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="bg-gradient-light mb-3 p-3 rounded">
                                                                    <label for="city" class="form-label">City</label>
                                                                    <input disabled type="text"
                                                                        class="form-control form-control-lg rounded-0">
                                                                    <div>
                                                                        <input type="hidden" name="city_show"
                                                                            value="0">
                                                                        <input type="checkbox" id="city_show"
                                                                            name="city_show" value="1"
                                                                            {{ $settings->city_show == 1 ? 'checked' : '' }}>
                                                                        <label for="city_show">Show</label>

                                                                        <input type="hidden" name="city_required"
                                                                            value="0">
                                                                        <input type="checkbox" id="city_required"
                                                                            name="city_required" value="1"
                                                                            {{ $settings->city_required == 1 ? 'checked' : '' }}>
                                                                        <label for="city_required">Required</label>

                                                                        <input type="hidden" name="city_quick_buy"
                                                                            value="0">
                                                                        <input type="checkbox" id="city_quick_buy"
                                                                            name="city_quick_buy" value="1"
                                                                            {{ $settings->city_quick_buy == 1 ? 'checked' : '' }}>
                                                                        <label for="city_quick_buy">Quick Buy</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="bg-gradient-light mb-3 p-3 rounded">
                                                                    <label for="postal_code" class="form-label">Postal
                                                                        code</label>
                                                                    <input disabled type="text"
                                                                        class="form-control form-control-lg rounded-0">
                                                                    <div>
                                                                        <input type="hidden" name="postal_code_show"
                                                                            value="0">
                                                                        <input type="checkbox" id="postal_code_show"
                                                                            name="postal_code_show" value="1"
                                                                            {{ $settings->postal_code_show == 1 ? 'checked' : '' }}>
                                                                        <label for="postal_code_show">Show</label>

                                                                        <input type="hidden" name="postal_code_required"
                                                                            value="0">
                                                                        <input type="checkbox" id="postal_code_required"
                                                                            name="postal_code_required" value="1"
                                                                            {{ $settings->postal_code_required == 1 ? 'checked' : '' }}>
                                                                        <label for="postal_code_required">Required</label>

                                                                        <input type="hidden" name="postal_code_quick_buy"
                                                                            value="0">
                                                                        <input type="checkbox" id="postal_code_quick_buy"
                                                                            name="postal_code_quick_buy" value="1"
                                                                            {{ $settings->postal_code_quick_buy == 1 ? 'checked' : '' }}>
                                                                        <label for="postal_code_quick_buy">Quick
                                                                            Buy</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="bg-gradient-light mb-3 p-3 rounded">
                                                            <label for="phone" class="form-label">Phone</label>
                                                            <input disabled type="tel"
                                                                class="form-control form-control-lg rounded-0">
                                                            <div>
                                                                <input type="hidden" name="phone_show" value="0">
                                                                <input type="checkbox" id="phone_show" name="phone_show"
                                                                    value="1"
                                                                    {{ $settings->phone_show == 1 ? 'checked' : '' }}>
                                                                <label for="phone_show">Show</label>

                                                                <input type="hidden" name="phone_required"
                                                                    value="0">
                                                                <input type="checkbox" id="phone_required"
                                                                    name="phone_required" value="1"
                                                                    {{ $settings->phone_required == 1 ? 'checked' : '' }}>
                                                                <label for="phone_required">Required</label>

                                                                <input type="hidden" name="phone_quick_buy"
                                                                    value="0">
                                                                <input type="checkbox" id="phone_quick_buy"
                                                                    name="phone_quick_buy" value="1"
                                                                    {{ $settings->phone_quick_buy == 1 ? 'checked' : '' }}>
                                                                <label for="phone_quick_buy">Quick Buy</label>
                                                            </div>
                                                        </div>

                                                        <div class="bg-gradient-light mb-3 p-3 rounded">
                                                            <label for="note" class="form-label">Note</label>
                                                            <textarea disabled class="form-control form-control-lg rounded-0"></textarea>
                                                            <div>
                                                                <input type="hidden" name="note_show" value="0">
                                                                <input type="checkbox" id="note_show" name="note_show"
                                                                    value="1"
                                                                    {{ $settings->note_show == 1 ? 'checked' : '' }}>
                                                                <label for="note_show">Show</label>

                                                                <input type="hidden" name="note_required"
                                                                    value="0">
                                                                <input type="checkbox" id="note_required"
                                                                    name="note_required" value="1"
                                                                    {{ $settings->note_required == 1 ? 'checked' : '' }}>
                                                                <label for="note_required">Required</label>

                                                                <input type="hidden" name="note_quick_buy"
                                                                    value="0">
                                                                <input type="checkbox" id="note_quick_buy"
                                                                    name="note_quick_buy" value="1"
                                                                    {{ $settings->note_quick_buy == 1 ? 'checked' : '' }}>
                                                                <label for="note_quick_buy">Quick Buy</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6"></div>
                                                </div>


                                                {{--
                                                <label class=" mb-0">
                                                    <input type="hidden" name="is_topbar" value="0">
                                                    <input type="checkbox" value="1" name="is_topbar"
                                                        {{ $settings->is_topbar == 1 ? 'checked' : '' }}>
                                                    Show Topbar
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">Select Navbar:</label>
                                                <br>
                                                <label class="mb-0">
                                                    <input type="radio" value="1" name="is_navbar"
                                                        {{ $settings->is_navbar == 1 ? 'checked' : '' }}>
                                                    Navbar #1
                                                    <br>
                                                    <input type="radio" value="2" name="is_navbar"
                                                        {{ $settings->is_navbar == 2 ? 'checked' : '' }}>
                                                    Navbar #2
                                                </label>
                                            </div>

                                            <div class="form-group">
                                                <label for="fe_banner">Banner</label>
                                                <input type="file" accept="image/*"
                                                    data-allowed-file-extensions="jpg png jpeg webp gif" name="fe_banner"
                                                    class="dropify"
                                                    @if ($settings && $settings->fe_banner) data-default-file="{{ asset($settings->fe_banner) }}" @endif>
                                            </div>

                                            <div class="form-group">
                                                <label class="mb-3">Customers Reviews: </label> <a type="button" class="btn btn-outline-primary btn-sm float-lg-right" id="addReview">Add</a>
                                                <div id="customerReviews">
                                                    @if (!empty($settings->customer_review_detail))
                                                        @foreach (json_decode($settings->customer_review_detail, true) ?? [] as $index => $review)
                                                            <div class="review-entry row mb-2">
                                                                <div class="col-8">
                                                                    <input type="text"
                                                                        name="customer_reviews[{{ $index }}][name]"
                                                                        class="form-control" value="{{ $review['name'] }}"
                                                                        placeholder="Customer's Name">
                                                                </div>
                                                                <div class="col-3">
                                                                    <input
                                                                        name="customer_reviews[{{ $index }}][stars]"
                                                                        type="number" min="1" max="5"
                                                                        class="form-control" value="{{ $review['stars'] }}"
                                                                        placeholder="Stars (1 to 5)">
                                                                </div>
                                                                <div class="col-1">
                                                                    <button type="button"
                                                                    class="btn btn-danger remove-review w-100">X</button>
                                                                </div>
                                                                <div class="col-12 mt-2">
                                                                    <textarea name="customer_reviews[{{ $index }}][review]" class="form-control" cols="30" rows="3"
                                                                        placeholder="Customer's Review">{{ $review['review'] }}</textarea>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div> --}}

                                                {{-- </div> --}}

                                                <button type="submit" class="btn btn-success">Save Settings</button>
                                        </form>
                                    </div>
                                </div>



                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
        </div>
    </div>

    <script>
        function validateTopbarText(input) {
            if (input.value.length > 65) {
                input.value = input.value.substring(0, 65);
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let reviewContainer = document.getElementById('customerReviews');
            let addReviewBtn = document.getElementById('addReview');

            function updateButtonState() {
                let totalReviews = reviewContainer.querySelectorAll('.review-entry').length;

                if (totalReviews >= 3) {
                    addReviewBtn.disabled = true;
                    addReviewBtn.classList.add('disabled');
                } else {
                    addReviewBtn.disabled = false;
                    addReviewBtn.classList.remove('disabled');
                }
            }

            addReviewBtn.addEventListener('click', function() {
                let index = reviewContainer.children.length; // Get next index
                if (index < 3) {
                    let reviewHtml = `
                    <div class="review-entry row mb-2">
                        <div class="col-8">
                            <input type="text" name="customer_reviews[${index}][name]" class="form-control" placeholder="Customer's Name">
                        </div>
                        <div class="col-3">
                            <input name="customer_reviews[${index}][stars]" type="number" min="1" max="5" class="form-control" placeholder="Stars (1 to 5)">
                        </div>
                        <div class="col-1">
                            <button type="button"
                            class="btn btn-danger remove-review w-100">X</button>
                        </div>
                        <div class="col-12 mt-2">
                            <textarea name="customer_reviews[${index}][review]" class="form-control" cols="30" rows="3" placeholder="Customer's Review"></textarea>
                        </div>
                    </div>
                `;
                    reviewContainer.insertAdjacentHTML('beforeend', reviewHtml);
                }
                updateButtonState();
            });

            reviewContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-review')) {
                    event.target.closest('.review-entry').remove();
                    updateButtonState();
                }
            });

            // Initialize button state on page load
            updateButtonState();
        });
    </script>


@endsection
