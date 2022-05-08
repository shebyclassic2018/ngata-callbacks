@extends('layouts.frontend.frontend')
@push('css_before')
    <style>
    .home-page {
        height: calc(100% - 76px)
    }

    </style>
@endpush
@section('content')
    <div class="home-page flex pt-3">
        <div class="left-side-bar h-100 " style="width: 250px">
            <a class="dropdown-item text-center" href="#">{{Auth::user()->name}}</a>
            <a class="dropdown-item text-center" href="#">{{Auth::user()->email}}</a>
            <div class="dropdown-divider"></div>
            @yield('left-content')
        </div>
        <div class="right-side-bar flex-1 overflow-auto" style="background: #fcfcfc">
            @yield('right-content')
        </div>
    </div>
@stop

@push('js_after')
@endpush
