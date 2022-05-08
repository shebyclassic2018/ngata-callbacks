@extends('layouts.frontend.frontend')
@push('css_before')
    <style>
       
    </style>
@endpush
@section('content')
    <form id="login" action="{{route('authenticate')}}" method="POST">
        @csrf
        <h1>Log In</h1>
        <fieldset id="inputs">
            <input type="hidden" name="agent" value="web">
            <input id="email" type="email" name="email" placeholder="Email address" autofocus required>
            <input id="password" name="password" type="password" placeholder="Password" required>
        </fieldset>
        <fieldset id="actions">
            <input type="submit" id="submit" value="Log in">
            <a href="#">Forgot your password?</a><a href="{{route('register')}}">Register</a>
        </fieldset>
    </form>
@stop

@push('js_after')
@endpush
