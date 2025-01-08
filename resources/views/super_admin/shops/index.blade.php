@extends('template.main')
@section('title', 'Dashboard')
@section('content')
<style>
    .switch {
    position: relative;
    display: inline-block;
    width: 34px;
    height: 20px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 20px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 14px;
    width: 14px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50%;
}

input:checked + .slider {
    background-color: #4caf50;
}

input:checked + .slider:before {
    transform: translateX(14px);
}

</style>

    @if (auth()->check() && auth()->user()->is_super_admin)

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
                                <li class="breadcrumb-item"><a href="{{ route('super.admin.dashboard') }}">Home</a>
                                </li>
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
                                        <a href="{{ route('shops.create') }}"
                                            class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i> Add
                                            Shop</a>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-striped table-bordered table-hover text-center"
                                        style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Domain</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($shops as $data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>

                                                    <td>{{ $data->name ?? '--' }}</td>
                                                    <td>{{ $data->domain ?? '--' }}</td>
                                                    <td>
                                                        <p>
                                                            @php
                                                                $createdAt = \Carbon\Carbon::parse($data->created_at);
                                                                if ($createdAt->isToday()) {
                                                                    echo 'Today, ' . $createdAt->format('h:i A');
                                                                } elseif ($createdAt->isYesterday()) {
                                                                    echo 'Yesterday, ' . $createdAt->format('h:i A');
                                                                } else {
                                                                    echo $createdAt->format('l, h:i A'); // 'Friday, 02:41 AM'
                                                                }
                                                            @endphp
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <form method="POST" action="{{ route('shops.toggleStatus', $data->id) }}" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <label class="switch">
                                                                <input type="checkbox" name="status" onchange="this.form.submit()"
                                                                    {{ $data->status == 1 ? 'checked' : '' }}>
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </form>
                                                    </td>

                                                    <td>
                                                        <form class="d-inline"
                                                            action="{{ route('shops.edit' , $data->id) }}"
                                                            method="GET">
                                                            <button type="submit" class="btn btn-success btn-sm mr-1">
                                                                <i class="fa-solid fa-pen"></i>
                                                            </button>
                                                        </form>
                                                        <form class="d-inline"
                                                            action="{{ route('shops.destroy', $data->id) }}"
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

    @endif
@endsection
