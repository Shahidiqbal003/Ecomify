@extends('template.main')
@section('title', 'Contact Us')
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
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Message</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contacts as $key => $contact)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <p>
                                                        @php
                                                            $createdAt = \Carbon\Carbon::parse($contact->created_at);
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
                                                <td>{{ $contact->name ?? '--' }}</td>
                                                <td>{{ $contact->email ?? '--' }}</td>
                                                <td>{{ $contact->phone ?? '--' }}</td>
                                                <td>{{ $contact->comment ?? '--' }}</td>

                                                <td>
                                                    <!-- Unique modal trigger -->
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-toggle="modal" data-target="#contactModal{{ $contact->id }}">
                                                        View
                                                    </button>

                                                    <!-- Delete form -->
                                                    <form
                                                        action="{{ route('contact.destroy', ['shop' => $shop->name, 'contact' => $contact->id]) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>

                                            <!-- Unique Modal for Each Contact -->
                                            <div class="modal fade" id="contactModal{{ $contact->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="modalTitle{{ $contact->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalTitle{{ $contact->id }}">
                                                                @php
                                                                    $createdAt = \Carbon\Carbon::parse(
                                                                        $contact->created_at,
                                                                    );
                                                                    if ($createdAt->isToday()) {
                                                                        echo 'Today, ' . $createdAt->format('h:i A');
                                                                    } elseif ($createdAt->isYesterday()) {
                                                                        echo 'Yesterday, ' .
                                                                            $createdAt->format('h:i A');
                                                                    } else {
                                                                        echo $createdAt->format('l, h:i A'); // 'Friday, 02:41 AM'
                                                                    }
                                                                @endphp
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <h6>Name:</h6>
                                                                    <p>{{ $contact->name ?? '--' }}</p>
                                                                </div>
                                                                <div class="col-6">
                                                                    <h6>Email:</h6>
                                                                    <p>{{ $contact->email ?? '--' }}</p>
                                                                </div>
                                                                <div class="col-6">
                                                                    <h6>Phone:</h6>
                                                                    <p>{{ $contact->phone ?? '--' }}</p>
                                                                </div>
                                                                <div class="col-12">
                                                                    <h6>Message:</h6>
                                                                    <p>{{ $contact->comment ?? '--' }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
