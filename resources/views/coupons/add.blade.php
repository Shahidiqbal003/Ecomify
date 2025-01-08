@extends('template.main')
@section('title', 'Add Coupon')
@section('content')
<style>
    .chosen-choices{
        padding: 5px!important;
        border-radius: 3px!important;
    }
</style>
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
            <li class="breadcrumb-item"><a href="{{ route('coupon.index', ['shop' => request()->route('shop')]) }}">Coupons</a></li>
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
            <form class="needs-validation" novalidate action="{{ route('coupon.store', ['shop' => request()->route('shop')]) }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="code">Coupon Code</label>
                            <input type="text" id="couponCode" name="code" value="{{ old('code') }}" class="form-control"
                                placeholder="Enter unique coupon code" required>
                            <small id="codeFeedback" class="form-text"></small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="discount_type">Discount Type</label>
                            <select name="discount_type" class="form-control" value="{{old('discount_type')}}" required>
                                <option value="percentage">Percentage Discount</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="discount_value">Discount Value (%)</label>
                            <input type="number" name="discount_value" value="{{old('discount_value')}}" class="form-control" placeholder="Enter percentage discount (0-100)" min="0" max="100" required>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="product_ids">Applicable Products</label>
                            <select name="product_ids[]" class="form-control chosen-select" value="{{old('product_ids[]')}}" multiple>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->title }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Leave empty to apply coupon to all products.</small>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="expiry_date">Expiry Date</label>
                            <input type="date" id="expiry_date" name="expiry_date" value="{{old('expiry_date')}}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" value="{{old('status')}}" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="qty">QTY</label>
                            <input type="number" name="qty" value="{{old('qty')}}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-4 pt-4">
                        <div class="form-group">
                            <input type="checkbox" name="free_shipping" value="1">
                            <label for="free_shipping" class="mb-0">Free Shipping</label><br>
                            <small class="text-muted">Free Shipping Apply Both Discount Types.</small>
                        </div>
                    </div>

                </div>

              </div>
              <div class="card-footer text-right">
                <button class="btn btn-dark mr-1" type="reset"><i class="fa-solid fa-arrows-rotate"></i>
                  Reset</button>
                <button id="submitButton" class="btn btn-success" type="submit"><i class="fa-solid fa-floppy-disk"></i>
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
    document.addEventListener('DOMContentLoaded', function() {
      const today = new Date().toISOString().split('T')[0];
      const expiryDateInput = document.getElementById('expiry_date');
      expiryDateInput.min = today;
    });
  </script>


<script>
    document.getElementById('couponCode').addEventListener('input', function () {
        const codeInput = this;
        const feedback = document.getElementById('codeFeedback');
        const shopId = "{{ $shop->id }}"; // Replace with your shop ID from the backend
        const submitButton = document.getElementById('submitButton');

        if (codeInput.value.trim() === '') {
            feedback.textContent = '';
            codeInput.style.borderColor = '';
            return;
        }

        fetch("{{ route('coupon.validate', ['shop' => request()->route('shop')]) }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                code: codeInput.value.trim(),
                shop_id: shopId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                feedback.textContent = 'Coupon code already exists!';
                feedback.style.color = 'red';
                codeInput.style.borderColor = 'red';
                submitButton.disabled = true;
            } else {
                feedback.textContent = 'Coupon code is available!';
                feedback.style.color = 'green';
                codeInput.style.borderColor = 'green';
                submitButton.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>


@endsection
