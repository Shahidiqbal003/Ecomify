@extends('template.main')
@section('title', 'Collections')
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
                                    <a href="{{ route('collection.create', ['shop' => request()->route('shop')]) }}"
                                        class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i> Add
                                        collection</a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-striped table-bordered table-hover text-center"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Products</th>
                                            <th style="width: 400px!important;">Collection Detail</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($collection as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @if ($data->image)
                                                        <img src="{{ asset('assets/uploads/' . $data->image) }}"
                                                            alt="Collection Image"
                                                            style="max-width: 80px; max-height: 80px;"
                                                            class="img-thumbnail m-auto">
                                                    @else
                                                        <i style="font-size: 70px"
                                                            class="fa-regular fa-image text-muted"></i>
                                                    @endif
                                                </td>
                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td> {{ $data->note ?? '--' }}</td>
                                                <td>
                                                    <form
                                                        action="{{ route('collection.updateStatus', ['shop' => request()->route('shop')]) }}"
                                                        method="POST" id="toggle-form-{{ $data->id }}">
                                                        @csrf
                                                        <input type="hidden" name="collection_id"
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
                                                        action="{{ route('collection.edit', ['shop' => request()->route('shop'), 'collection' => $data->id]) }}
                                                        "
                                                        method="GET">
                                                        <button type="submit" class="btn btn-success btn-sm mr-1">
                                                            <i class="fa-solid fa-pen"></i>
                                                        </button>
                                                    </form>
                                                    <form class="d-inline"
                                                        action="{{ route('collection.destroy', ['shop' => request()->route('shop'), 'collection' => $data->id]) }}
                                                        "
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            id="btn-delete">
                                                            <i class="fa-solid fa-trash-can"></i>
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
