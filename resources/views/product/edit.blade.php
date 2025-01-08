@extends('template.main')
@section('title', 'Edit Product')
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
                            <li class="breadcrumb-item"><a href="{{ route('product.index', ['shop' => request()->route('shop')]) }}">Product</a></li>
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
                                    <a href="{{ route('product.index', ['shop' => request()->route('shop')]) }}" class="btn btn-warning btn-sm"><i
                                            class="fa-solid fa-arrow-rotate-left"></i>
                                        Back
                                    </a>
                                </div>
                            </div>

                            <form class="needs-validation" enctype="multipart/form-data" novalidate action="{{ route('product.update', ['shop' => request()->route('shop'), 'product' => $product->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-9">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="title">Title</label>
                                                        <input type="text" name="title"
                                                            class="form-control @error('title') is-invalid @enderror"
                                                            id="title" placeholder="Title of the product"
                                                            value="{{ old('title', $product->title) }}" required>
                                                        @error('title')
                                                            <span
                                                                class="invalid-feedback text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="slug">Slug</label>
                                                        <input type="text" name="slug"
                                                            class="form-control @error('slug') is-invalid @enderror"
                                                            id="slug" placeholder="Slug of the product"
                                                            value="{{ old('slug', $product->slug) }}" readonly>
                                                        @error('slug')
                                                            <span
                                                                class="invalid-feedback text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="coverPicture" class="form-label">Cover Picture</label>
                                                        <input type="file" accept="image/*" name="cover_image"
                                                        class="dropify" data-default-file="{{ asset('assets/uploads/product/' . $product->cover_image_data) }}">
                                                    </div>
                                                </div>

                                                <div class="col-9">
                                                    <div class="mb-3">
                                                        <label for="productPictures" class="form-label">Product Pictures</label>
                                                        <div class="row">
                                                            @php
                                                            $productImages = $product->product_images_data ? json_decode($product->product_images_data, true) : [];
                                                        @endphp

                                                            @foreach ($productImages as $index => $image)
                                                                <div class="col-3">
                                                                    <input type="file" accept="image/*" class="dropify" name="product_images[]"
                                                                        data-default-file="{{ asset('assets/uploads/product/' . $image) }}">
                                                                </div>
                                                            @endforeach

                                                            @for ($i = count($productImages); $i < 4; $i++)
                                                                <div class="col-3">
                                                                    <input type="file" accept="image/*" class="dropify" name="product_images[]">
                                                                </div>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <input type="checkbox" id="variations" name="variations"
                                                            {{ $product->variations ? 'checked' : '' }}>
                                                        <label for="variations">Enable Variations</label>
                                                        <small class="form-text text-muted">Check this box to add variations
                                                            like size and color.</small>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 colorSelection">
                                                    <div class="form-group">
                                                        <label for="colors">Colors:
                                                            <a id="addColor" style="pointer:cursor;" class="badge">Add
                                                                Color</a>
                                                        </label>
                                                        <div id="colorFields">
                                                            <div class="row" id="color-group">
                                                                <!-- Existing color fields will be appended here -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="collections">Collections</label>
                                                        <div id="collections">
                                                            @foreach ($categories as $category)
                                                                <div class="form-check">
                                                                    <input type="checkbox" name="category_ids[]"
                                                                        value="{{ $category->id }}"
                                                                        id="category_{{ $category->id }}"
                                                                        class="form-check-input"
                                                                        {{ in_array($category->id, json_decode($product->category_ids, true) ?? []) ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="category_{{ $category->id }}">
                                                                        {{ $category->name }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        @error('category_ids')
                                                            <span
                                                                class="invalid-feedback text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="price">Price</label>
                                                        <input type="number" step="0.01" name="price"
                                                            class="form-control @error('price') is-invalid @enderror"
                                                            id="price" placeholder="Price"
                                                            value="{{ old('price', $product->price) }}" required>
                                                        @error('price')
                                                            <span
                                                                class="invalid-feedback text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="compare_at_price">Compare-at Price</label>
                                                        <input type="number" step="0.01" name="compare_at_price"
                                                            class="form-control @error('compare_at_price') is-invalid @enderror"
                                                            id="compare_at_price" placeholder="Compare-at Price"
                                                            value="{{ old('compare_at_price', $product->compare_at_price) }}">
                                                        @error('compare_at_price')
                                                            <span
                                                                class="invalid-feedback text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="stock">Stock</label>
                                                        <input type="number" min="1" name="stock"
                                                            class="form-control @error('stock') is-invalid @enderror"
                                                            id="stock" placeholder="Stock"
                                                            value="{{ old('stock', $product->stock) }}" required>
                                                        @error('stock')
                                                            <span
                                                                class="invalid-feedback text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="status">Status</label>
                                                        <select name="status" id="status_id" class="form-control" required>
                                                            <option class="text-muted" value="">Select Status</option>
                                                            <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active</option>
                                                            <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Inactive</option>
                                                        </select>
                                                        @error('status')
                                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 sizeSeleted">
                                                    <div class="form-group">
                                                        <label for="sizes">Sizes</label>
                                                        <div class="input-group">
                                                            <input type="text" name="sizes[]"
                                                                class="form-control mb-1 mt-1" placeholder="Size">
                                                            <div class="input-group-append mb-1 mt-1">
                                                                <button type="button" id="addSize"
                                                                    class="btn btn-primary btn-sm">Add Size</button>
                                                            </div>
                                                        </div>
                                                        <div id="sizeFields">
                                                            <!-- Existing sizes will be appended here -->
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                    <button class="btn btn-dark mr-1" type="reset"><i
                                            class="fa-solid fa-arrows-rotate"></i>
                                        Reset</button>
                                    <button class="btn btn-success" type="submit"><i
                                            class="fa-solid fa-floppy-disk"></i>
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

@endsection

@push('scripts')
    <script>
        function generateSlug(title) {
            return title
                .toLowerCase()
                .replace(/ /g, '-')
                .replace(/[^\w-]+/g, '');
        }
        document.getElementById('title').addEventListener('input', function() {
            const titleValue = this.value;
            const slugValue = generateSlug(titleValue);
            document.getElementById('slug').value = slugValue;
        });
    </script>


    <script>
        $(document).ready(function() {
            // Base URL for your image paths
            let basePath = "{{ asset('assets/uploads/product') }}/";

            // Fetch colors and color images from server-side variables
            let colors = @json(json_decode($product->colors, true));
            let colorImages = @json(json_decode($product->color_images, true));

            // Append existing colors and images
            if (colors && colorImages && colors.length === colorImages.length) {
                colors.forEach((color, index) => {
                    let image = colorImages[index];
                    let existingRow = `
                <div class="col-3">
                    <input type="file" accept="image/*" class="dropify" name="color_images[]"
                           data-default-file="${basePath}${image}">
                    <input type="text" name="colors[]" class="form-control image-upload-box-color-input"
                           placeholder="Color" value="${color}">
                    <div class="input-group-append">
                        <a type="button" class="badge text-danger remove-color">Remove</a>
                    </div>
                </div>`;
                    $('#color-group').append(existingRow);
                });

                // Initialize Dropify for existing inputs
                $('.dropify').dropify();
            }

            // Add new color field
            $('#addColor').on('click', function() {
                let newRow = `
            <div class="col-3">
                <input type="file" accept="image/*" class="dropify" name="color_images[]">
                <input type="text" name="colors[]" class="form-control image-upload-box-color-input" placeholder="Color">
                <div class="input-group-append">
                    <a type="button" class="badge text-danger remove-color">Remove</a>
                </div>
            </div>`;
                $('#color-group').append(newRow);

                // Reinitialize Dropify for the new input
                $('.dropify').dropify();
            });

            // Remove color field
            $(document).on('click', '.remove-color', function() {
                $(this).closest('.col-3').remove();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Get sizes from server-side variable
            let existingSizes = @json(json_decode($product->sizes, true));

            // Append existing sizes
            if (existingSizes && existingSizes.length > 0) {
                existingSizes.forEach(size => {
                    var sizeField = `
                    <div class="input-group">
                        <input type="text" name="sizes[]" value="${size}" class="form-control mb-1 mt-1" placeholder="Size">
                        <div class="input-group-append mb-1 mt-1">
                            <button type="button" class="btn btn-danger btn-sm remove-size">Remove</button>
                        </div>
                    </div>
                `;
                    $('#sizeFields').append(sizeField);
                });
            }

            // Add new size field
            $('#addSize').on('click', function() {
                var newSizeField = `
                <div class="input-group">
                    <input type="text" name="sizes[]" class="form-control mb-1 mt-1" placeholder="Size">
                    <div class="input-group-append mb-1 mt-1">
                        <button type="button" class="btn btn-danger btn-sm remove-size">Remove</button>
                    </div>
                </div>
            `;
                $('#sizeFields').append(newSizeField);
            });

            // Remove size field
            $(document).on('click', '.remove-size', function() {
                $(this).closest('.input-group').remove();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.colorSelection').hide();
            $('.sizeSeleted').hide();
            if ($('#variations').prop('checked')) {
                $('.colorSelection').show();
                $('.sizeSeleted').show();
            } else {
                $('.colorSelection').hide();
                $('.sizeSeleted').hide();
            }
            $('#variations').change(function() {
                if ($(this).prop('checked')) {
                    $('.colorSelection').show();
                    $('.sizeSeleted').show();
                } else {
                    $('.colorSelection').hide();
                    $('.sizeSeleted').hide();
                }
            });
        });
    </script>
@endpush
