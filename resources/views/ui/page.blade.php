@extends('template.ui-main')
@section('title', ucwords(str_replace('_', ' ', $page)))
@section('content')

<style>
    p{
        color: rgb(101, 101, 101);
    }
</style>
<section>
    <div class="container">
        <div class="m-auto p-5 w-75">
            <h2 class="fs-1 pb-4 text-capitalize">{{ ucwords(str_replace('_', ' ', $page)) }}</h2>
            <p class="text-muted">
                {!! $storePage->$page ?? 'Content Coming Soon...' !!}
            </p>
        </div>
    </div>
</section>

@endsection

