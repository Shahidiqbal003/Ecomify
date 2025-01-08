@extends('template.main')
@section('title', 'Edit Collection')
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
                        <li class="breadcrumb-item"><a href="{{ route('collection.index', ['shop' => request()->route('shop')]) }}">Collection</a></li>
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
                                <a href="{{ route('collection.index', ['shop' => request()->route('shop')]) }}" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <form class="needs-validation" novalidate action="{{ route('collection.update', ['shop' => request()->route('shop'), 'collection' => $collection->id]) }}" method="POST"  enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name">Collection Name</label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Collection Name" value="{{old('name', $collection->name)}}" required>
                                            @error('name')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                          <label for="image">Collection Image</label>
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
                                            <label for="note">Collection Note</label>
                                            <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror" cols="10" rows="5" placeholder="Collection Note">{{old('note', $collection->note)}}</textarea>
                                            @error('note')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                            @enderror
                                            <div id="charCount" class="text-muted mt-2">160</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <!-- Image preview -->
                                        <div id="imagePreview" style="margin-top: 10px;">
                                            <img id="preview" src="{{ asset('assets/uploads/' . $collection->image) }}" class="img-thumbnail" alt="Image preview" style="max-width: 168px;max-height: 200px;display:{{ isset($collection->image) ? 'block' : 'none' }};">

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
