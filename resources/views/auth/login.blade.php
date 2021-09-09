@extends('layouts.app')

@section('content')


<div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary">
    <div class="row wd-100p mx-auto text-center">
        <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
            <img src="{{ asset('images/bg_img.png') }}" class="my-auto ht-xl-70p wd-md-100p wd-xl-70p mx-auto"
                alt="logo">
        </div>
    </div>
</div>
<!-- The content half -->
<div class="col-md-6 col-lg-6 col-xl-5 bg-white">
    <div class="login d-flex align-items-center py-2">
        <!-- Demo content-->
        <div class="container p-0">
            <div class="row">
                <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                    <div class="card-sigin">
                        <div class="mb-5 d-flex"> <a href="index.html"><img src="{{ asset('images/Flex Logo Arm Only.png') }}"
                                    class="sign-favicon ht-40" alt="logo"></a>
                            <h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">Flex<span> Gymnasium</span></h1>
                        </div>
                        <div class="card-sigin">
                            <div class="main-signup-header">
                                <h2>Welcome back!</h2>
                                <h5 class="font-weight-semibold mb-4">Please sign in to continue.</h5>
                                <form action="{{route('login')}}" method="POST" class="login-form">
                                    @csrf
                                    <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                                    <div class="form-group @error('email') has-danger @enderror">
                                        <label>Username</label>
                                        <input class="form-control" placeholder="Enter your username" type="text"
                                            name="email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('password') has-danger @enderror">
                                        <label>Password</label>
                                        <input class="form-control" placeholder="Enter your password" type="password"
                                            value="" name="password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="ckbox">
                                            <input  type="checkbox" name="remember"
                                                id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <span>{{ __('Remember Me') }}</span>
                                        </label>
                                    </div>
                                    <button class="btn btn-main-primary btn-block login-btn" type="submit">Sign In</button>
                                    <div class="main-signin-footer mt-5">
                                        <p><a href="#">Forgot password?</a></p>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End -->
    </div>
</div><!-- End -->


@endsection
@push('scripts')
{{-- @if(GetCaptchaStatus()!="false")
<script src="https://www.google.com/recaptcha/api.js?render={{ GetCaptchaKeys()['captcha_sitekey'] }}"></script>

@endif
<script>
    $(document).ready(function () {

    $('.login-btn').click(function (e) {
        e.preventDefault();
        var captcha_status = "{{ GetCaptchaStatus() }}";
        console.log(captcha_status);

        if (captcha_status != "false" || captcha_status != false) {
            grecaptcha.ready(function () {
                grecaptcha.execute('{{GetCaptchaKeys()['captcha_sitekey']}}', {
                        action: 'submit'
                    }).then(function (token) {
                    // Add your logic to submit to your backend server here.
                    document.getElementById('g-recaptcha-response').value = token;
                    $('.login-form').submit();
                });
            });
        } else {
            $('.login-form').submit();
        }

    });
    });


</script> --}}

@endpush
