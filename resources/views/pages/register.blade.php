@extends('layouts.frontend.frontend')
@push('css_before')
    <style>

    </style>
@endpush
@section('content')
    <form id="login" class="register-form" method="post">
        @csrf
        <h1>Register</h1>
        <fieldset id="inputs">
            <small id="phone_txt" style="color: #b5121f"></small>
            <input id="phone" type="phone" name="phone" placeholder="Phone number" autofocus required>
            <small id="email_txt" style="color: #b5121f"></small>
            <input id="email" type="email" name="email" placeholder="Email address" required>
            <small id="password_txt" style="color: #b5121f"></small>
            <input id="password" type="password" name="password" placeholder="Password" required>
            <small id="cpass_txt" style="color: #b5121f"></small>
            <input id="cpass" type="password" name="password_confirmation" placeholder="Confirm password" required>
            <div class="pb-2"><small id="confirm_txt" style="color: #b5121f; font-size: 12px;"></small></div>
            <div class="pb-2">
                <div class="alert alert-info">
                    Provide correct information, after clicking send verification button below,
                    you will not be able to change any information above.</div>
            </div>
            <button type="button" id="send_otp" class="btn btn-danger mb-2" style="font-size: 12px">Send verification
                code</button>
            <input id="code" type="number" name="code" placeholder="Verification code eg. 678978" required>
        </fieldset>
        <fieldset id="actions">
            <button style="font-size: 12px" type="submit" id="submit" class="btn btn-success submit">Register</button>
            <a href="{{ route('login') }}">Login</a>
        </fieldset>
    </form>
@stop

@push('js_after')
    <script>
        $(document).ready(function() {
            loginClient()   
            $('#send_otp').on('click', function() {
                formValidation();
                sendOTPCODES()
            });
        })

        function loginClient() {
            $('#login').on('submit', function(e) {
                e.preventDefault();
                phone = $('#phone').val();
                email = $('#email').val();
                password = $('#password').val();
                code = $('#code').val();
                data = {
                    _token: _token,
                    phone: phone,
                    email: email,
                    password: password,
                    code: code
                }
                $.post("{{ route('loginClient') }}", data, function(res) {
                    console.log(res);

                    if(res.status === 'valid user') {
                        $('.submit').removeAttr('id').attr('disabled', 'disabled');
                        sec = 10;
                        x = setInterval(() => {
                            sec = sec - 1;
                            $('.submit').html('Redirecting in ' + sec + ' seconds...');
                            if (sec == 0) {
                                $('.submit').html("<span class='fa fa-circle-notch fa-spin'></span> Redirecting...")
                                clearInterval(x);
                                setTimeout(() => {
                                    $.post("{{route('authenticate')}}", {
                                        _token: _token,
                                        email: email,
                                        password: password
                                    }, function(res) {
                                        console.log(res);
                                        window.open("{{route('userKeys')}}", '_SELF');
                                    })
                                }, 3000);
                            }
                            
                            
                        }, 1000);
                    }
                })
            })
        }

        function sendOTPCODES() {
            phone = $('#phone').val();
            email = $('#email').val();
            password = $('#password').val();
            cpass = $('#cpass').val();
            data = {
                _token: _token,
                phone: phone,
                email: email,
                password: password
            }
            if (password == cpass) {
                $('#send_otp').html("<span class='fa fa-circle-notch fa-spin'></span>")
                $('#confirm_txt').text('')
                $.post("{{ route('create') }}", data, function(res) {
                    console.log(res);
                    responseValidation(res);

                    if (res === 'success') {
                        $('#send_otp').html("<i class='fa fa-check'></i> Code sent</span>").attr('disabled',
                            'disabled')
                        disable_inputs();
                        return;
                    }
                    $('#send_otp').html("Send verification code")
                })
            } else {
                $('#confirm_txt').text('Password do not match')
            }
        }

        function disable_inputs() {
            $('#email').attr('readonly', 'readonly')
            $('#phone').attr('readonly', 'readonly')
            $('#password').attr('readonly', 'readonly')
            $('#cpass').attr('readonly', 'readonly')
        }


        function responseValidation(status) {
            switch (status) {
                case 'is_email_exists':
                    $('#email_txt').text('This email already exists');
                    $('#phone_txt').text('');
                    break;
                case 'is_phone_exists':
                    $('#phone_txt').text('This phone already exists')
                    $('#email_txt').text('');
                    break;
                case 'both_exist':
                    $('#phone_txt').text('This phone already exists')
                    $('#email_txt').text('This email already exists');
                    break;
                case 'Invalid phone number':
                    $('#phone_txt').text('Invalid phone number provided')
                    break;
                case 'create failed':
                    $('#confirm_txt').text('Registration failed, try again!')
                    break;
            }
        }

        function formValidation() {
            if ($("#phone").val().length == 0) {
                $('#phone_txt').text('Field is required *')
                return;
            } else {
                $('#phone_txt').text('')
            }

            if ($("#email").val().length == 0) {
                $('#email_txt').text('Field is required *')
                return;
            } else {
                $('#phone_txt').text('')
            }

            if ($("#password").val().length == 0) {
                $('#password_txt').text('Field is required *')
                return;
            } else {
                $('#password_txt').text('')
            }

            if ($("#cpass").val().length == 0) {
                $('#cpass_txt').text('Field is required *')
                return;
            } else {
                $('#cpass_txt').text('')
            }
        }
    </script>
@endpush
