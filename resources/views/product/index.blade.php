@extends('template.main')
@section('title', 'Products')
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
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="text-right">
                                    <a href="{{ route('product.create', ['shop' => request()->route('shop')]) }}"
                                        class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i> Add
                                        Product</a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-striped table-bordered table-hover text-center"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Cover</th>
                                            <th>Title</th>
                                            <th>Categories</th>
                                            <th>Colors</th>
                                            <th>Sizes</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><img src="{{ asset('assets/uploads/product/' . $data->cover_image_data) }}"
                                                        alt="Product Cover" width="50" height="50"></td>
                                                <td>{{ $data->title }}</td>
                                                <td class="text-left">
                                                    @if ($data->categories && count($data->categories) > 0)
                                                        @foreach ($data->categories as $category)
                                                            <span class="badge badge-light">{{ $category->name }}</span><br>
                                                        @endforeach
                                                    @else
                                                        <span class="text-muted">--</span>
                                                    @endif
                                                </td>
                                                <td class="text-left">
                                                    @if ($data->colors && count($data->colors) > 0)
                                                        @foreach ($data->colors as $color)
                                                            <span class="badge badge-light">{{ $color }}</span><br>
                                                        @endforeach
                                                    @else
                                                        <span class="text-muted">--</span>
                                                    @endif
                                                </td>
                                                <td class="text-left">
                                                    @if ($data->sizes && count($data->sizes) > 0)
                                                        @foreach ($data->sizes as $size)
                                                            <span class="badge badge-light">{{ $size }}</span><br>
                                                        @endforeach
                                                    @else
                                                        <span class="text-muted">--</span>
                                                    @endif
                                                </td>
                                                <td> <b class="badge badge-success"> {{ number_format($data->price, 0) }}
                                                    </b> <s class="badge">{{ number_format($data->compare_at_price, 0) }}
                                                    </s></td>
                                                <td>
                                                    <span
                                                        class="@if ($data->stock > 50) badge bg-success
                                                        @elseif ($data->stock > 10) badge bg-warning
                                                        @else badge bg-danger @endif p-2 rounded">{{ $data->stock }}</span>
                                                </td>
                                                <td>
                                                    <form
                                                        action="{{ route('product.updateStatus', ['shop' => request()->route('shop')]) }}"
                                                        method="POST" id="toggle-form-{{ $data->id }}">
                                                        @csrf
                                                        <input type="hidden" name="product_id"
                                                            value="{{ $data->id }}">
                                                        <input type="hidden" name="shop_id" value="{{ $data->shop_id }}">
                                                        <label class="switch">
                                                            <input type="checkbox" name="status"
                                                                onchange="document.getElementById('toggle-form-{{ $data->id }}').submit();"
                                                                {{ $data->status ? 'checked' : '' }}>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form class="d-inline"
                                                        action="{{ route('product.edit', ['shop' => request()->route('shop'), 'product' => $data->id]) }}"
                                                        method="GET">
                                                        <button type="submit" class="btn btn-success btn-sm mr-1">
                                                            <i class="fa-solid fa-pen"></i> Edit
                                                        </button>
                                                    </form>
                                                    <form class="d-inline"
                                                        action="{{ route('product.destroy', ['shop' => request()->route('shop'), 'product' => $data->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            id="btn-delete">
                                                            <i class="fa-solid fa-trash-can"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
