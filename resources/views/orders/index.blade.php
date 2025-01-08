@extends('template.main')
@section('title', 'Orders')
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
                                    <a href="{{ route('admin.dashboard', ['shop' => request()->route('shop')]) }}"
                                        class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i>
                                        Back
                                    </a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-striped table-bordered table-hover text-center"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order</th>
                                            <th>Date</th>
                                            <th>Customer</th>
                                            <th>Phone</th>
                                            <th>Payment Status</th>
                                            <th>Order Status</th>
                                            <th>Total</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $key => $order)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td><b>{{ $order->order_serial ?? '--'  }}</b></td>
                                                <td>
                                                    <p>
                                                        @php
                                                            $createdAt = \Carbon\Carbon::parse($order->created_at);
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
                                                <td>{{ $order->first_name ?? '--'  }} {{ $order->last_name ?? '--'  }}</td>
                                                <td>{{ $order->phone ?? '--'  }}</td>
                                                <td><p class="badge bg-success">{{ $order->payment_method ?? '--'  }}</p></td>
                                                <td>
                                                    @php
                                                        $statusLabels = [
                                                            0 => 'Pending',
                                                            1 => 'Confirm',
                                                            2 => 'Dispatched',
                                                            3 => 'Arrived',
                                                            4 => 'Completed',
                                                            5 => 'Canceled'
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

                                                    <p class="badge {{ $statusColors[$order->status] ?? 'bg-dark' }}">
                                                        {{ $statusLabels[$order->status] ?? 'Unknown' }}
                                                    </p>
                                                </td>


                                                <td>Rs: {{ $order->total_payment ?? '--' }}</td>

                                                <td>
                                                    {{-- <a href="{{ route('orders.show', ['shop' => $shop->name, 'order' => $order->id]) }}"
                                                        class="btn btn-sm btn-primary">View</a> --}}
                                                    <a href="{{ route('orders.edit', ['shop' => $shop->name, 'order' => $order->id]) }}"
                                                        class="">Order Detail</a>
                                                    {{-- <form
                                                        action="{{ route('orders.destroy', ['shop' => $shop->name, 'order' => $order->id]) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                    </form> --}}
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
