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
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Product</a></li>
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
                                    <a href="{{ route('product.index') }}" class="btn btn-warning btn-sm"><i
                                            class="fa-solid fa-arrow-rotate-left"></i>
                                        Back
                                    </a>
                                </div>
                            </div>
                            <form class="needs-validation" novalidate action="{{ route('product.store') }}" method="POST"
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
                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="coverPicture" class="form-label">Cover Picture</label>
                                                        <div id="coverPictureContainer"
                                                            class="d-flex align-items-center justify-content-center border cover-picture"
                                                            style="width: 100%; height: 323px;" ondrop="drop(event)"
                                                            ondragover="allowDrop(event)">
                                                            <input type="file" id="coverImageInput" class="productCoverImageInput" name="cover_image"
                                                                accept="image/*" style="display: none;">
                                                            <button type="button" class="btn btn-secondary"
                                                                id="addCoverPicture">+</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-8">
                                                    <div class="mb-3">
                                                        <label for="productPictures" class="form-label">Product
                                                            Pictures <a
                                                                class="badge float-lg-right mt-1 font-weight-bolder ml-1 remove-btn  text-danger"
                                                                id="removeBtn">Remove</a></label>

                                                        <div id="productPicturesContainer" class="d-flex flex-wrap gap-3">
                                                            <div class="product-picture p-1 border d-flex align-items-center justify-content-center"
                                                                draggable="true" ondragstart="drag(event)"
                                                                id="productImage1">
                                                                <input type="file" name="product_images[]"
                                                                    class="productImageInput" accept="image/*" multiple
                                                                    style="display: none;">
                                                                <button type="button" class=" addProductPicture">+</button>

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
                                                                        {{ in_array($category->id, old('category_ids', [])) ? 'checked' : '' }}>
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
                                            </div>

                                        </div>
                                    </div>



                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="variations">Enable Variations</label>
                                                <input type="checkbox" id="variations" name="variations"
                                                    class="form-check-input">
                                                <small class="form-text text-muted">Check this box to add variations like
                                                    size and color.</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="variationFields" style="display: none;">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="sizes">Sizes</label>
                                                    <div id="sizeFields">

                                                    </div>
                                                    <button type="button" id="addSize"
                                                        class="btn btn-primary btn-sm mt-2">Add Size</button>
                                                </div>
                                            </div>

                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label for="colors">Colors</label>
                                                    <div id="colorFields">
                                                        <div class="color-group">
                                                            <div class="row">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="button" id="addColor"
                                                        class="btn btn-primary btn-sm mt-2">Add Color</button>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const variationsCheckbox = document.getElementById('variations');
            const variationFields = document.getElementById('variationFields');
            const addSizeBtn = document.getElementById('addSize');
            const sizeFields = document.getElementById('sizeFields');
            const addColorBtn = document.getElementById('addColor');
            const colorFields = document.getElementById('colorFields');

            let colorRow = colorFields.querySelector('.row'); // Use the existing row

            if (!colorRow) {
                colorRow = document.createElement('div');
                colorRow.classList.add('row');
                colorFields.appendChild(colorRow); // If no row exists, create one
            }

            variationsCheckbox.addEventListener('change', function() {
                if (variationsCheckbox.checked) {
                    variationFields.style.display = 'block';
                    setTimeout(function() {
                        variationFields.style.opacity = 1;
                    }, 10); // Delay opacity change to trigger transition
                } else {
                    variationFields.style.opacity = 0;
                    setTimeout(function() {
                        variationFields.style.display = 'none';
                    }, 300); // Wait for opacity transition before setting display to none
                }
            });

            // Add Size Input Field
            addSizeBtn.addEventListener('click', function() {
                const sizeGroup = document.createElement('div');
                sizeGroup.classList.add('input-group', 'size-group');
                sizeGroup.innerHTML = `
                        <input type="text" name="sizes[]" class="form-control mb-1 mt-1" placeholder="Size">
                        <div class="input-group-append mb-1 mt-1">
                            <button type="button" class="btn btn-danger btn-sm remove-size">Remove</button>
                        </div>
                    `;
                sizeFields.appendChild(sizeGroup);
                toggleRemoveButtons();
            });

            // Add Color Input Field with Image Upload
            addColorBtn.addEventListener('click', function() {
                const colorGroup = document.createElement('div');
                colorGroup.classList.add('col-3'); // Add col-3 for the color field
                colorGroup.innerHTML = `
                        <div class="image-upload-box">
                            <input type="file" name="color_images[]" accept="image/*" class="form-control-file" style="display: none;">
                            <div class="image-preview" onclick="this.querySelector('input[type=file]').click();">
                                <span class="plus-sign">+</span>
                                <img src="" alt="" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </div>
                        <input type="text" name="colors[]" class="form-control image-upload-box-color-input" placeholder="Color">
                        <div class="input-group-append">
                            <a type="button" class="badge text-danger remove-color" style="display: none;">Remove</a>
                        </div>
                    `;

                // Add the new color input to the current row
                colorRow.appendChild(colorGroup);

                // If there are 4 color fields in the current row, create a new row
                if (colorRow.children.length === 4) {
                    colorRow = document.createElement('div');
                    colorRow.classList.add('row');
                    colorFields.appendChild(colorRow); // Add the new row to the container
                }

                toggleRemoveButtons(); // Update the visibility of remove buttons
            });

            // Trigger file input when image preview is clicked
            colorFields.addEventListener('click', function(e) {
                if (e.target.closest('.image-preview')) {
                    const fileInput = e.target.closest('.image-upload-box').querySelector(
                        'input[type="file"]');
                    fileInput.click();
                }
            });

            // Event listener for image selection
            colorFields.addEventListener('change', function(e) {
                if (e.target.type === 'file') {
                    const file = e.target.files[0];
                    const preview = e.target.closest('.image-upload-box').querySelector(
                        '.image-preview img');

                    if (file) {
                        const reader = new FileReader();

                        reader.onload = function(event) {
                            preview.src = event.target.result;
                            preview.style.display = 'block'; // Show the selected image
                            e.target.closest('.image-upload-box').querySelector('.plus-sign').style
                                .display = 'none'; // Hide the plus sign
                        };

                        reader.readAsDataURL(file);
                    }
                }
            });

            // Remove Size Input Field
            sizeFields.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-size')) {
                    e.target.closest('.size-group').remove();
                    toggleRemoveButtons();
                }
            });

            // Remove Color Input Field
            colorFields.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-color')) {
                    // Target only the specific .col-3 element that was clicked
                    const colorCol = e.target.closest('.col-3');
                    colorCol.remove(); // Remove the entire col-3 element
                    toggleRemoveButtons();
                }
            });

            // Toggle the visibility of remove buttons
            function toggleRemoveButtons() {
                const sizeGroups = sizeFields.querySelectorAll('.size-group');
                const colorCols = colorFields.querySelectorAll('.col-3');

                sizeGroups.forEach(group => {
                    const removeBtn = group.querySelector('.remove-size');
                    removeBtn.style.display = sizeGroups.length > 1 ? 'inline-block' : 'none';
                });

                colorCols.forEach(col => {
                    const removeBtn = col.querySelector('.remove-color');
                    removeBtn.style.display = colorCols.length > 1 ? 'inline-block' : 'none';
                });
            }

            // Initialize button visibility
            toggleRemoveButtons();
        });
    </script>

    <script>
        // Function to generate slug
        function generateSlug(title) {
            return title
                .toLowerCase()
                .replace(/ /g, '-')
                .replace(/[^\w-]+/g, '');
        }

        // Add event listener to the Title input
        document.getElementById('title').addEventListener('input', function() {
            const titleValue = this.value;
            const slugValue = generateSlug(titleValue);
            document.getElementById('slug').value = slugValue;
        });

        /////////////////////////

        const coverPictureContainer = document.getElementById('coverPictureContainer');
        const productPicturesContainer = document.getElementById('productPicturesContainer');
        const removeBtn = document.getElementById('removeBtn');

        let selectedImages = [];

        // Handle cover image selection
        document.getElementById('addCoverPicture').addEventListener('click', () => {
            const fileInput = document.getElementById('coverImageInput');
            fileInput.click(); // Trigger file input when the button is clicked
        });

        document.getElementById('coverImageInput').addEventListener('change', (event) => {
            const files = event.target.files;
            if (files.length > 0) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Set the first image as the cover picture
                    coverPictureContainer.innerHTML =
                        `<img src="${e.target.result}" alt="Cover Image" class="img-fluid" style="max-width: 100%; max-height: 100%;">`;

                    // Add the selected image to the hidden product images input field
                    const productCoverImageInput = document.createElement('input');
                    productCoverImageInput.type = 'file';
                    productCoverImageInput.name = 'cover_image';
                    productCoverImageInput.classList.add('productCoverImageInput');
                    productCoverImageInput.accept = 'image/*';
                    productCoverImageInput.style.display = 'none';
                    productCoverImageInput.files = event.target.files; // Assign selected file to the input

                    // Append the product image input to the product pictures container (optional, for visual tracking)
                    productPicturesContainer.appendChild(productCoverImageInput);

                    addProductImages(files); // Add the remaining images as product images
                };
                reader.readAsDataURL(files[0]); // Set first image as cover
            }
        });

        // Handle product image selection
        productPicturesContainer.addEventListener('click', (event) => {
            if (event.target.classList.contains('addProductPicture')) {
                const productImageInput = event.target.previousElementSibling;
                productImageInput.click(); // Trigger file input for product image
            }
        });

        productPicturesContainer.addEventListener('change', (event) => {
            if (event.target.classList.contains('productImageInput')) {
                const files = event.target.files;
                if (files.length > 0) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Add the selected image as the main product image
                        const productPictureDiv = event.target.parentElement;
                        productPictureDiv.innerHTML = `
                            <img src="${e.target.result}" alt="Product Image" class="img-fluid" style="max-width: 100%; max-height: 100%;">
                            <div class="checkbox-container">
                                <input type="checkbox" class="image-checkbox">
                            </div>
                        `;

                        addEmptySlot(); // Ensure there is always an empty slot for product images
                        // Create and add the file input for the first image
                        const productImageInput = document.createElement('input');
                        productImageInput.type = 'file';
                        productImageInput.name = 'product_images[0]'; // Index 0 for the first image
                        productImageInput.classList.add('productImageInput');
                        productImageInput.accept = 'image/*';
                        productImageInput.style.display = 'none';

                        // Assign the first file to the input
                        const fileArray = new DataTransfer();
                        fileArray.items.add(files[0]);
                        productImageInput.files = fileArray.files;
                        productPictureDiv.appendChild(productImageInput);

                    };
                    reader.readAsDataURL(files[0]); // Use the first image

                    addProductImages(files); // Add other images
                }
            }
        });

        // Add product images to the container
        function addProductImages(files) {
            for (let i = 1; i < files.length; i++) { // Start from 1 as 0 is the cover image
                const productPictureDiv = document.createElement('div');
                productPictureDiv.className =
                    'product-picture border d-flex p-1 align-items-center justify-content-center';
                productPictureDiv.style.cssText = 'width: 160px; height: 160px;';
                productPictureDiv.setAttribute('draggable', 'true');
                productPictureDiv.addEventListener('dragstart', drag);

                const reader = new FileReader();
                reader.onload = function(e) {
                    productPictureDiv.innerHTML = `
                        <img src="${e.target.result}" alt="Product Image" class="img-fluid" style="max-width: 100%; max-height: 100%;">
                        <div class="checkbox-container">
                            <input type="checkbox" class="image-checkbox">
                        </div>
                    `;

                    // Create a new input field for this specific image
                    const productImageInput = document.createElement('input');
                    productImageInput.type = 'file';
                    productImageInput.name = 'product_images[' + i + ']'; // This will create an array for product images
                    productImageInput.classList.add('productImageInput');
                    productImageInput.accept = 'image/*';
                    productImageInput.style.display = 'none';

                    // Assign only this file to this input
                    const fileArray = new DataTransfer(); // Create a DataTransfer object to store the file

                    fileArray.items.add(files[i]); // Add this specific file
                    productImageInput.files = fileArray.files; // Assign the specific file to this input
                    productPictureDiv.appendChild(productImageInput);

                    productPicturesContainer.appendChild(productPictureDiv);
                    movePlusButtonToEnd(); // Ensure "plus" button stays at the end
                };
                reader.readAsDataURL(files[i]);
            }
        }



        // Add an empty slot for product images
        function addEmptySlot() {
            const lastSlot = productPicturesContainer.lastElementChild;
            if (!lastSlot || lastSlot.querySelector('img')) {
                const emptySlot = document.createElement('div');
                emptySlot.className = 'product-picture border d-flex p-1 align-items-center justify-content-center';
                emptySlot.style.cssText = 'width: 160px; height: 160px;';
                emptySlot.innerHTML = `
            <input type="file" name="product_images[]" class="productImageInput" accept="image/*" multiple style="display: none;">
            <button type="button" class="addProductPicture">+</button>
        `;
                productPicturesContainer.appendChild(emptySlot);
            }
        }

        // Move the "plus" button to the end after adding images
        function movePlusButtonToEnd() {
            const plusButton = productPicturesContainer.querySelector('.addProductPicture');
            if (plusButton) {
                productPicturesContainer.appendChild(plusButton.closest('.product-picture'));
            }
        }

        // Handle drag and drop for cover image
        function allowDrop(event) {
            event.preventDefault();
            coverPictureContainer.classList.add('drag-over');
        }

        function drop(event) {
            event.preventDefault();
            coverPictureContainer.classList.remove('drag-over');

            // Remove existing image if any
            coverPictureContainer.innerHTML = '';

            // Get the file from the dropped event
            const files = event.dataTransfer.files;

            if (files.length > 0) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Add the dropped image to cover picture container
                    coverPictureContainer.innerHTML =
                        `<img src="${e.target.result}" alt="Cover Image" class="img-fluid" style="max-width: 100%; max-height: 100%;">`;

                    // Add the dropped image to the hidden product images input field
                    const productCoverImageInput = document.createElement('input');
                    productCoverImageInput.type = 'file';
                    productCoverImageInput.name = 'cover_image';
                    productCoverImageInput.classList.add('productCoverImageInput');
                    productCoverImageInput.accept = 'image/*';
                    productCoverImageInput.style.display = 'none';
                    productCoverImageInput.files = files; // Assign dropped file to the input

                    // Append the product image input to the product pictures container (optional, for visual tracking)
                    productPicturesContainer.appendChild(productCoverImageInput);
                };
                reader.readAsDataURL(files[0]); // Set the dropped image
            }
        }

        // Handle dragging product images
        function drag(event) {
            event.dataTransfer.setData("text", event.target.id);
        }

        // Remove selected images when the button is clicked
        removeBtn.addEventListener('click', () => {
            document.querySelectorAll('.image-checkbox:checked').forEach(checkbox => {
                const parentDiv = checkbox.closest('.product-picture') || checkbox.closest(
                    '.cover-picture');
                parentDiv.remove();
            });
        });

        // Show/remove the "Remove Selected" button
        productPicturesContainer.addEventListener('change', () => {
            if (document.querySelectorAll('.image-checkbox:checked').length > 0) {
                removeBtn.classList.add('show');
            } else {
                removeBtn.classList.remove('show');
            }
        });
    </script>
@endsection
