@extends('template.main')
@section('title', 'Add Product')
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
                            <form class="needs-validation" novalidate action="{{ route('product.store', ['shop' => request()->route('shop')]) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
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
                                                            value="{{ old('title') }}" required>
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
                                                            value="{{ old('slug') }}" readonly>
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
                                                        <input type="file" accept="image/*" data-allowed-file-extensions="jpg png jpeg tif tiff pjp webp xbm jxl jfif bmp avif ico gif" name="cover_image" class="dropify">
                                                    </div>
                                                </div>
                                                <div class="col-9">
                                                    <div class="mb-3">
                                                        <label for="productPictures" class="form-label">Product
                                                            Pictures</label>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <input type="file" data-allowed-file-extensions="jpg png jpeg tif tiff pjp webp xbm jxl jfif bmp avif ico gif" accept="image/*" class="dropify"
                                                                    name="product_images[]">
                                                            </div>
                                                            <div class="col-3">
                                                                <input type="file" data-allowed-file-extensions="jpg png jpeg tif tiff pjp webp xbm jxl jfif bmp avif ico gif" accept="image/*" class="dropify"
                                                                    name="product_images[]">
                                                            </div>
                                                            <div class="col-3">
                                                                <input type="file" data-allowed-file-extensions="jpg png jpeg tif tiff pjp webp xbm jxl jfif bmp avif ico gif" accept="image/*" class="dropify"
                                                                    name="product_images[]">
                                                            </div>
                                                            <div class="col-3">
                                                                <input type="file" data-allowed-file-extensions="jpg png jpeg tif tiff pjp webp xbm jxl jfif bmp avif ico gif" accept="image/*" class="dropify"
                                                                    name="product_images[]">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 mb-3">
                                                    <label for="productDiscription" class="form-label">Product
                                                        Description <small class="text-muted">(Optional)</small></label>
                                                    <textarea name="productDiscription" class="editor"></textarea>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <input type="checkbox" id="variations" name="variations">
                                                        <label for="variations">Enable Variations</label>
                                                        <small class="form-text text-muted">Check this box to add variations
                                                            like
                                                            size and color.</small>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 colorSelection">
                                                    <div class="form-group">
                                                        <label for="colors">Colors: <a id="addColor"
                                                                style="pointer:cursor;" class="badge">Add Color</a>
                                                        </label>
                                                        <div id="colorFields">
                                                            <div class="row" id="color-group">

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
                                                                        {{ in_array($category->id, old('category_ids', [])) ? 'checked' : '' }} required>
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
                                                            value="{{ old('price') }}" required>
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
                                                            value="{{ old('compare_at_price') }}">
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
                                                            value="{{ old('stock') }}" required>
                                                        @error('stock')
                                                            <span
                                                                class="invalid-feedback text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="stock">Status</label>
                                                        <select name="status" id="status_id" class="form-control"
                                                            required>
                                                            <option class="text-muted" value="">Select Status
                                                            </option>
                                                            <option value="1">Active</option>
                                                            <option value="0">Deactive</option>

                                                        </select>
                                                        @error('stock')
                                                            <span
                                                                class="invalid-feedback text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 sizeSeleted">
                                                    <div class="form-group">
                                                        <label for="sizes">Sizes</label>
                                                        <div id="sizeFields">
                                                            <div class="input-group">
                                                                <input type="text" name="sizes[]"
                                                                    class="form-control mb-1 mt-1" placeholder="Size">
                                                                <div class="input-group-append mb-1 mt-1">
                                                                    <button type="button" id="addSize"
                                                                        class="btn btn-primary btn-sm ">Add Size</button>
                                                                </div>
                                                            </div>
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
            $('#addColor').on('click', function() {
                let newRow = `
            <div class="col-3">
                <input type="file" accept="image/*" data-allowed-file-extensions="jpg png jpeg tif tiff pjp webp xbm jxl jfif bmp avif ico gif" class="dropify" name="color_images[]">
                <input type="text" name="colors[]" class="form-control image-upload-box-color-input" placeholder="Color">
                <div class="input-group-append">
                    <a type="button" class="badge text-danger remove-color">Remove</a>
                </div>
            </div>`;
                $('#color-group').append(newRow);
                $('.dropify').dropify();
            });

            $(document).on('click', '.remove-color', function() {
                $(this).closest('.col-3').remove(); // Remove the entire color input group
            });
        });
    </script>

    <script>
        $(document).ready(function() {
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

<script>
    $(document).ready(function() {
        function toggleRequired() {
            const anyChecked = $('#collections input[type="checkbox"]:checked').length > 0;
            $('#collections input[type="checkbox"]').prop('required', !anyChecked);
        }

        toggleRequired();

        $('#collections input[type="checkbox"]').on('change', function() {
            toggleRequired();
        });
    });
</script>
@endpush
