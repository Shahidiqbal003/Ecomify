@extends('template.main')
@section('title', 'Pages')
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
                                <table class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Page</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $pagesList = [
                                                'about' => 'About Us',
                                                'contact' => 'Contact',
                                                'faq' => 'FAQ',
                                                'how_to_order' => 'How to Order',
                                                'shipping_details' => 'Shipping Details',
                                                'payment_details' => 'Payment Details',
                                                'privacy_policy' => 'Privacy Policy',
                                                'return_refund' => 'Return & Refund',
                                                'terms_of_service' => 'Terms of Service'
                                            ];
                                        @endphp

                                        @foreach ($pagesList as $key => $page)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $page }}</td>
                                                <td>
                                                    <a href="{{ route('pages.edit', ['shop' => request()->route('shop'), 'page' => $key]) }}"
                                                        class="btn btn-primary btn-sm">Update Content</a>
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
