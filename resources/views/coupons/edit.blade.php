@extends('template.main')
@section('title', 'Edit Coupon')
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
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard', ['shop' => request()->route('shop')]) }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('coupon.index', ['shop' => request()->route('shop')]) }}">Coupon</a></li>
                        <li class="breadcrumb-item active">@yield('title')</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="text-right">
                                <a href="{{ route('coupon.index', ['shop' => request()->route('shop')]) }}" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <form class="needs-validation" novalidate action="{{ route('coupon.update', ['shop' => request()->route('shop'), 'coupon' => $coupon->id]) }}" method="POST"  enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="code">Coupon Code</label>
                                            <input type="text" id="couponCode" name="code" value="{{ old('code', $coupon->code) }}" class="form-control" placeholder="Enter unique coupon code" required>
                                            <small id="codeFeedback" class="form-text"></small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="discount_type">Discount Type</label>
                                            <select name="discount_type" class="form-control" required>
                                                <option value="percentage" {{ old('discount_type', $coupon->discount_type) == 'percentage' ? 'selected' : '' }}>Percentage Discount</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="discount_value">Discount Value (%)</label>
                                            <input type="number" name="discount_value" value="{{ old('discount_value', $coupon->discount_value) }}" class="form-control" placeholder="Enter percentage discount (0-100)" min="0" max="100" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="product_ids">Applicable Products</label>
                                            <select name="product_ids[]" class="form-control chosen-select" multiple>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}" {{ in_array($product->id, old('product_ids', json_decode($coupon->product_ids, true) ?? [])) ? 'selected' : '' }}>{{ $product->title }}</option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">Leave empty to apply coupon to all products.</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="expiry_date">Expiry Date  <span class="badge bg-blue">{{ $coupon->expiry_date ? \Carbon\Carbon::parse($coupon->expiry_date)->format('d/m/Y') : '--' }}</span></label>
                                            <input type="date" id="expiry_date" name="expiry_date" value="{{ old('expiry_date', $coupon->expiry_date) }}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" class="form-control" required>
                                                <option value="1" {{ old('status', $coupon->status) == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ old('status', $coupon->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="qty">QTY</label>
                                            <input type="number" name="qty" value="{{ old('qty', $coupon->qty) }}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-4 pt-4">
                                        <div class="form-group">
                                            <input type="checkbox" name="free_shipping" value="1" {{ old('free_shipping', $coupon->free_shipping) == 1 ? 'checked' : '' }}>
                                            <label for="free_shipping" class="mb-0">Free Shipping</label><br>
                                            <small class="text-muted">Free Shipping Apply Both Discount Types.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-dark mr-1" type="reset"><i class="fa-solid fa-arrows-rotate"></i>
                                    Reset</button>
                                <button class="btn btn-success" type="submit"><i class="fa-solid fa-floppy-disk"></i>
                                    Save</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.content -->
            </div>
        </div>
    </div>
</div>

<script>
    const noteField = document.getElementById('note');
    const charCount = document.getElementById('charCount');
    const maxLength = 160;

    noteField.addEventListener('input', function () {
      let currentLength = noteField.value.length;
      let remainingLength = maxLength - currentLength;

      // If the input exceeds 100 characters, truncate it
      if (currentLength > maxLength) {
        noteField.value = noteField.value.slice(0, maxLength);
        remainingLength = 0;
      }

      // Update the character count display
      charCount.textContent = `${remainingLength}`;

    });
  </script>
  <script>
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview');
        const imagePreviewDiv = document.getElementById('imagePreview');

        // Check if a file was selected and it's an image
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();

            reader.onload = function(e) {
                // Set the image preview
                preview.src = e.target.result;
                preview.style.display = 'block';  // Show the image
            };

            reader.readAsDataURL(file); // Read the file as a data URL
        } else {
            preview.style.display = 'none'; // Hide preview if not an image
        }
    }
</script>
@endsection
