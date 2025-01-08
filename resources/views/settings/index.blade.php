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
                                    <div class="tab-pane p-3 active" id="tabs-1" role="tabpanel">
                                        <form
                                            action="{{ route('settings.store', ['shop' => request()->route('shop'), 'id' => $shop->id]) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="logo">Logo</label>
                                                        <input type="file" accept="image/*"
                                                            data-allowed-file-extensions="jpg png jpeg webp" name="logo"
                                                            class="dropify"
                                                            @if ($settings && $settings->logo) data-default-file="{{ asset($settings->logo) }}" @endif>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="favicon">Favicon</label>
                                                        <input type="file" accept="image/*"
                                                            data-allowed-file-extensions="jpg png jpeg webp" name="favicon"
                                                            class="dropify"
                                                            @if ($settings && $settings->favicon) data-default-file="{{ asset($settings->favicon) }}" @endif>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="shop_name">Shop Name</label>
                                                <input type="text" name="shop_name" class="form-control"
                                                    value="{{ $settings->shop_name ?? request()->route('shop') }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea name="description" class="form-control">{{ $settings->description ?? '' }}</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" class="form-control"
                                                    value="{{ $settings->email ?? '' }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="phone">Phone</label>
                                                <input type="text" name="phone" class="form-control"
                                                    value="{{ $settings->phone ?? '' }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                <textarea name="address" class="form-control">{{ $settings->address ?? '' }}</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="phone">Whatsapp Number</label>
                                                <div class="input-group">
                                                    <input type="number" name="whatsapp_number" class="form-control"
                                                        value="{{ $settings->whatsapp_number ?? '' }}"
                                                        aria-describedby="basic-addon2">
                                                    <span class="bg-white input-group-text rounded-0" id="basic-addon2">
                                                        <label class="switch mb-0">
                                                            <input type="hidden" name="is_whatsapp" value="0">
                                                            <input type="checkbox" value="1" name="is_whatsapp"
                                                                {{ $settings->is_whatsapp == 1 ? 'checked' : '' }}>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </span>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-success">Save Settings</button>
                                        </form>
                                    </div>
                                    <div class="tab-pane p-3" id="tabs-2" role="tabpanel">
                                        <h2>About US:</h2>
                                        <div class="mb-8">
                                            <textarea name="about" class="editor"></textarea>
                                        </div>
                                        <h2>Contact:</h2>
                                        <div class="mb-8">
                                            <textarea name="contact" class="editor"></textarea>
                                        </div>
                                    </div>
                                    <div class="tab-pane p-3" id="tabs-3" role="tabpanel">
                                        <form
                                            action="{{ route('settings.store', ['shop' => request()->route('shop'), 'id' => $shop->id]) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="fe_banner">Banner</label>
                                                <input type="file" accept="image/*"
                                                    data-allowed-file-extensions="jpg png jpeg webp gif" name="fe_banner"
                                                    class="dropify"
                                                    @if ($settings && $settings->fe_banner) data-default-file="{{ asset($settings->fe_banner) }}" @endif>
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

@endsection
