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
                                                <label for="phone">Topbar: <small class="text-muted badge">Max 65
                                                        characters allowed.</small></label>
                                                <div class="input-group">
                                                    <input type="text" name="topbar_text" class="form-control"
                                                        value="{{ $settings->topbar_text ?? '' }}"
                                                        aria-describedby="basic-addon2" maxlength="65"
                                                        oninput="validateTopbarText(this)">
                                                </div>
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
                                                </div>

                                            </div>

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
    document.addEventListener("DOMContentLoaded", function () {
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

        addReviewBtn.addEventListener('click', function () {
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

        reviewContainer.addEventListener('click', function (event) {
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
