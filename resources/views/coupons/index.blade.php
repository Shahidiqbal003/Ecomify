@extends('template.main')
@section('title', 'Coupons')
@section('content')
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 25px;
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
        border-radius: 25px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 4px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #28a745;
    }

    input:checked + .slider:before {
        transform: translateX(25px);
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
                                    <a href="{{ route('coupon.create', ['shop' => request()->route('shop')]) }}"
                                        class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i> Add
                                        Coupon</a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-striped table-bordered table-hover text-center"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Code</th>
                                            <th>Products</th>
                                            <th>Type</th>
                                            <th>Discount %</th>
                                            <th>Free Shipping</th>
                                            <th>Expiry</th>
                                            <th>QTY</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($coupons as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->code }}</td>
                                                <td>
                                                    @php
                                                        $productIds = json_decode($data->product_ids, true); // Decode the JSON
                                                    @endphp
                                                    @if (is_array($productIds) && count($productIds) > 0)
                                                        <span class="badge bg-blue">{{ count($productIds) }}</span>
                                                    @else
                                                    <span class="badge bg-blue">All</span>
                                                    @endif
                                                </td>
                                                <td class="text-capitalize">{{ $data->discount_type }}</td>
                                                <td>
                                                    {{ $data->discount_value ? rtrim(rtrim(number_format($data->discount_value, 2), '0'), '.') . ' %' : '--' }}
                                                </td>
                                                <td>
                                                    {!! $data->free_shipping ? '<span style="color: green;">&#10003;</span>' : '<span style="color: red;">&#10007;</span>' !!}
                                                </td>
                                                <td>
                                                    {{ $data->expiry_date ? \Carbon\Carbon::parse($data->expiry_date)->format('d M Y') : '--' }}
                                                </td>

                                                <td> <span class="badge bg-success">{{ $data->qty ?? '--' }}</span></td>
                                                <td>
                                                    <form action="{{ route('coupon.updateStatus', ['shop' => request()->route('shop')]) }}" method="POST" id="toggle-form-{{ $data->id }}">
                                                        @csrf
                                                        <input type="hidden" name="coupon_id" value="{{ $data->id }}">
                                                        <input type="hidden" name="shop_id" value="{{ $data->shop_id }}">
                                                        <label class="switch">
                                                            <input type="checkbox" name="status" onchange="document.getElementById('toggle-form-{{ $data->id }}').submit();" {{ $data->status ? 'checked' : '' }}>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </form>
                                                </td>



                                                <td>
                                                    <form class="d-inline"
                                                        action="{{ route('coupon.edit', ['shop' => request()->route('shop'), 'coupon' => $data->id]) }}
                                                        "
                                                        method="GET">
                                                        <button type="submit" class="btn btn-success btn-sm mr-1">
                                                            <i class="fa-solid fa-pen"></i>
                                                        </button>
                                                    </form>
                                                    <form class="d-inline"
                                                        action="{{ route('coupon.destroy', ['shop' => request()->route('shop'), 'coupon' => $data->id]) }}
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
