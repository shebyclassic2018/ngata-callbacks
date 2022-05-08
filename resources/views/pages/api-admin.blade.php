@extends('pages.home')
@push('css_before')
    <style>
        input[readonly] {
            background-color: red;
        }

    </style>
@endpush

@section('title', 'Admin')
@section('left-content')
    <a class="dropdown-item text-danger" href="{{ route('admin-page') }}"><i class="fa fa-dashboard" aria-hidden="true"></i>
        Dashboard</a>
    <a class="dropdown-item" href="{{ route('documentation') }}"><span class="fa fa-file"></span> API Documentation</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item font-weight-bold" href="{{route('logout')}}"><span class="fa fa-power-off"></span> Logout</a>
@stop
@section('right-content')
    <div class="block">
        <div class="block-header block-header-default">
            <div class="block-title fs-xs">Grant Access</div>
        </div>
        <form method="POST" action="{{route('grant-permission')}}" class="block-content">
            @csrf
            <div class="row">
                <div class="col-sm-8">
                    <input type="email" name="email" class="form-control fs-xs" placeholder="name@example.com" required> 
                </div>
                <div class="col-sm-4">
                    <button class="btn btn-success fs-xs">Grant permission</button>
                </div>
            </div><br>
            @if (\Session::get('message') === 'Verified')
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert alert-success">Permission granted</div>
                    </div>
                </div>
            @elseif (\Session::get('message') === 'Pending')
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-danger">Permission not granted</div>
                </div>
            </div>
            @elseif(\Session::get('message') == 'user not found')
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-info">User with email: <b>{{\Session::get('email')}}</b> not found</div>
                </div>
            </div>
            @endif
            <br>
        </form>
    </div>

    <div class="block">
        <div class="block-header block-header-default">
            <div class="block-title fs-xs">Revoke Access</div>
        </div>
        <form method="POST" action="{{route('revoke-permission')}}" class="block-content">
            @csrf
            <div class="row">
                <div class="col-sm-8">
                    <input type="email" name="email" class="form-control fs-xs" placeholder="name@example.com" required> 
                </div>
                <div class="col-sm-4">
                    <button class="btn btn-warning fs-xs">Revoke permission</button>
                </div>
            </div><br>
            @if (\Session::get('messager') === 'Pending')
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert alert-success">Permission revoked</div>
                    </div>
                </div>
            @elseif (\Session::get('messager') === 'Verified')
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-danger">Permission not revoked</div>
                </div>
            </div>
            @elseif(\Session::get('messager') == 'user not found')
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-info">User with email: <b>{{\Session::get('email')}}</b> not found</div>
                </div>
            </div>
            @endif
            <br>
        </form>
    </div>
@stop

@push('js_after')
@endpush
