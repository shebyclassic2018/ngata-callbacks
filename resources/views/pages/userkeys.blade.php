@extends('pages.home')
@push('css_before')
<style>
  input[readonly] {
    background-color: red;
}
</style>
@endpush

@section('title', 'User keys')
@section('left-content')
@include('pages.left-menu-items')
@stop
@section('right-content')
    <div class="block">
        <div class="block-header block-header-default">
            <div class="block-title fs-xs">user keys</div>
        </div>
        <div class="block-content ">
            <div class="row pb-3">
                <div class="col-sm-10">API Key</div>
                <div class="col-sm-2 text-right pointer"><span id="copy">Copy</span></div>
                <div class="col-sm-12">
                    <input name="" class="w-100 p-2 form-control fs-xs" id="" value="{{ _api_key() }}" readonly>
                </div>
            </div>

            <div class="row pb-3">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-10">Client ID</div>
                        <div class="col-sm-2 text-right pointer"><span id="copy">Copy</span></div>
                        <div class="col-sm-12">
                            <input name="" class="w-100 p-2 form-control fs-xs" id="" value="{{_client_id() }}"
                                readonly>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-10">Client secret key</div>
                        <div class="col-sm-2 text-right pointer"><span id="copy">Copy</span></div>
                        <div class="col-sm-12">
                            @if (_api_key_status() === 'Pending')
                            <input type="password" name="" class="w-100 p-2 form-control fs-xs" id="" value="{{ _client_secret_key() }}"
                            readonly>
                            @else
                            <input type="text" name="" class="w-100 p-2 form-control fs-xs" id="" value="{{ _client_secret_key() }}"
                                readonly>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pb-1">
                <div class="col-sm-12">
                       To make your client secret key active, please contact us. <br>
                       Phone: +255 759 333 777 <br>
                       Email: info@ngata.co.tz <br>
                       For information visit <a href="https://homes.ngata.co.tz/contact-us">https://homes.ngata.co.tz/contact-us</a>
                </div>
            </div>

            <div class="row pb-4">
                <div class="col-sm-12">
                    <div class="block">
                        <div class="block-content">
                            <span class="fa fa-warning text-warning"></span> Warning!
                            <hr>
                            <p class="fs-xs">
                                Dear customer, Keys above contains sensitive information concerning with your account
                                authentication. please do not share them to anyone (unauthourised).
                                To use the API please follows the steps as analysed on our API documentation.
                                <center class="text-muted"><b>Thank You</b></center>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js_after')
@endpush
