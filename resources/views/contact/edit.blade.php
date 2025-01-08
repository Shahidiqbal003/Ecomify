@extends('template.main')
@section('title', 'Order Detail')
@section('content')
    <style>
        .cart_information {
            overflow-x: hidden;
            overflow-y: scroll;
            height: 341px;
            white-space: nowrap;
        }
        .cart_information::-webkit-scrollbar {
            width: 6px;
        }

        .cart_information::-webkit-scrollbar-thumb {
            background-color: #007bff;
            border-radius: 10px;
        }

        .cart_information::-webkit-scrollbar-track {
            background-color: #f1f1f1;
            border-radius: 10px;
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
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.dashboard', ['shop' => request()->route('shop')]) }}">Home</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('orders.index', ['shop' => request()->route('shop')]) }}">order</a></li>
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
                                <h4 class="float-left w-50">Order: {{ $order->order_serial ?? '--' }} <b>

                                        @php
                                            $statusLabels = [
                                                0 => 'Pending',
                                                1 => 'Confirm',
                                                2 => 'Dispatched',
                                                3 => 'Arrived',
                                                4 => 'Completed',
                                                5 => 'Canceled',
                                            ];

                                            $statusColors = [
                                                0 => 'bg-warning',
                                                1 => 'bg-primary',
                                                2 => 'bg-info',
                                                3 => 'bg-secondary',
                                                4 => 'bg-success',
                                                5 => 'bg-danger',
                                            ];
                                        @endphp

                                        <b class="badge {{ $statusColors[$order->status] ?? 'bg-dark' }}">
                                            {{ $statusLabels[$order->status] ?? 'Unknown' }}
                                        </b>

                                    </b> <b class="badge bg-blue">{{ $order->country ?? '--' }}</b></h4>
                                <div class="text-right">
                                    <a href="{{ route('orders.index', ['shop' => request()->route('shop')]) }}"
                                        class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i>
                                        Back
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6 pl-5 pr-5">
                                        <div class="row ">
                                            <div class="col-12">
                                                <h4>Contact Information</h4>
                                            </div>
                                            <div class="col-6">
                                                <b>Name:</b>
                                                <p> {{ $order->first_name ?? '--' }} {{ $order->last_name ?? '--' }}</p>
                                            </div>
                                            <div class="col-6">
                                                <b>Phone:</b>
                                                <p> {{ $order->phone ?? '--' }}</p>
                                            </div>
                                            <div class="col-6">
                                                <b>email:</b>
                                                <p> {{ $order->email ?? '--' }}</p>
                                            </div>
                                            <div class="col-12">
                                                <h4>Delivery Information</h4>
                                            </div>
                                            <div class="col-6">
                                                <b>Address:</b>
                                                <p>{{ $order->address ?? '--' }}</p>
                                            </div>
                                            <div class="col-6">
                                                <b>City:</b>
                                                <p>{{ $order->city ?? '--' }}</p>
                                            </div>
                                            <div class="col-6">
                                                <b>Apartment & Street:</b>
                                                <p>{{ $order->apartment ?? '--' }}</p>
                                            </div>
                                            <div class="col-6">
                                                <b>Postal Code:</b>
                                                <p>{{ $order->postal_code ?? '--' }}</p>
                                            </div>

                                            <div class="col-12">
                                                <h4>Payment Information</h4>
                                            </div>
                                            <div class="col-6">
                                                <b>Payment Method:</b><br>
                                                <p class="badge bg-success">{{ $order->payment_method ?? '--' }}</p>
                                            </div>
                                            <div class="col-6">
                                                <b>Change Order Status:</b><br>
                                                <form
                                                    action="{{ route('orders.update', ['shop' => request()->route('shop'), 'order' => $order->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="input-group">
                                                        <select name="status" id="status"
                                                            class="form-control rounded-0">
                                                            @foreach ($statusLabels as $value => $label)
                                                                <option value="{{ $value }}"
                                                                    {{ $order->status == $value ? 'selected' : '' }}>
                                                                    {{ $label }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <button type="submit"
                                                            class="btn btn-primary rounded-0">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-12">
                                                <h4>Customer Request</h4>
                                            </div>

                                            <div class="col-12">
                                                <b>Customer Request Information:</b>
                                                <p>{{ $order->note ?? '--' }}</p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-6 col-6 pl-5 pr-5 border-left">
                                        @php
                                            $orderData = json_decode($order->order_data, true);
                                        @endphp
                                        @if ($orderData)
                                            <h4>Cart Information</h4>
                                            <div class="row cart_information">
                                                @foreach ($orderData as $key => $item)
                                                    <div class="col-2 p-0 mt-2">
                                                        <a href="{{ asset('assets/uploads/product/' . $item['cover_image_data']) }}"
                                                            data-lightbox="image" target="_blank"
                                                            class="position-relative ">
                                                            <img class="img-thumbnail" style="width: 100px; height: 100px;"
                                                                src="{{ asset('assets/uploads/product/' . $item['cover_image_data']) }}"
                                                                alt="{{ $item['name'] }}" loading="lazy">
                                                            <span
                                                                class="position-absolute start-100 translate-middle badge bg-dark border border-light rounded-circle">
                                                                {{ $item['quantity'] }}
                                                            </span>
                                                        </a>
                                                    </div>
                                                    <div class="col-7 pl-4 mt-2">
                                                        <span>{{ $item['name'] }}</span><br>
                                                        @if ($item['color'] != null && $item['size'] != null)
                                                            <span class="fst-italic text-muted">Color: {{ $item['color'] }}
                                                                | Size:
                                                                {{ $item['size'] }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="col-3 text-right mt-2">
                                                        RS: {{ number_format($item['price'] * $item['quantity'], 2) }}
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-6">
                                                    <p>Subtotal</p>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <p> RS: {{ $order->sub_total ?? '--' }}</p>
                                                </div>
                                                <div class="col-6">
                                                    <p>Shipping</p>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <p> RS: {{ $order->shipping ?? '--' }}</p>
                                                </div>
                                                <div class="col-6 mt-3">
                                                    <h4>Total</h4>
                                                </div>
                                                <div class="col-6 text-right mt-3">
                                                    <h4> RS: {{ $order->total_payment ?? '--' }}</h4>
                                                </div>
                                            </div>
                                        @else
                                            <p>--</p>
                                        @endif
                                    </div>
                                </div>

                            </div>


                            {{-- <form class="needs-validation" novalidate action="{{ route('orders.update', ['shop' => request()->route('shop'), 'order' => $order->id]) }}" method="POST"  enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name">order Name</label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="order Name" value="{{old('name', $order->name)}}" required>
                                            @error('name')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                          <label for="image">order Image</label>
                                          <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="image" value="{{old('image')}}"  accept="image/*" required onchange="previewImage(event)">
                                          @error('image')
                                          <span class="invalid-feedback text-danger">{{ $message }}</span>
                                          @enderror

                                        </div>
                                      </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="note">order Note</label>
                                            <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror" cols="10" rows="5" placeholder="order Note">{{old('note', $order->note)}}</textarea>
                                            @error('note')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                            @enderror
                                            <div id="charCount" class="text-muted mt-2">160</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <!-- Image preview -->
                                        <div id="imagePreview" style="margin-top: 10px;">
                                            <img id="preview" src="{{ asset('assets/uploads/' . $order->image) }}" class="img-thumbnail" alt="Image preview" style="max-width: 168px;max-height: 200px;display:{{ isset($order->image) ? 'block' : 'none' }};">

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
                        </form> --}}
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

        noteField.addEventListener('input', function() {
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
                    preview.style.display = 'block'; // Show the image
                };

                reader.readAsDataURL(file); // Read the file as a data URL
            } else {
                preview.style.display = 'none'; // Hide preview if not an image
            }
        }
    </script>
@endsection
