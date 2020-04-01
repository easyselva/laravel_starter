@extends('layouts.app')
@section('title', 'Login - '.Helpers::settings('site_full_name'))
@section('section_post_css')
<link href="{{ url('assets/css/login.css') }}" rel="stylesheet" type="text/css" />
<style>  
.login-bg {
    @if(Storage::exists(Helpers::settings('login_background')))
    background: url('{{ asset(Storage::url(Helpers::settings('login_background'))) }}');
    @else
    background: url('{{ url('assets/media/slide1.jpg') }}');
    @endif
    background-size: cover;
}
</style>
@stop
@section('section_js')
<script src="{{ url('assets/plugins/toastr/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/jquery/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/jquery-validation/jquery.validate.min.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function() {
    $('.login-form').validate();   
    @if (session('status'))
       toastr.success('{{ session('status') }}');
    @endif
    });		
  </script>
@stop
@section('body')
<div class="m__login">
    <div class="row m-0">
        <div class="col-md-6 p-0">
            <div class="login-bg">
                @if(Storage::exists(Helpers::settings('login_logo')))
                <img alt="Logo" class="login-logo" src="{{ asset(Storage::url(Helpers::settings('login_logo'))) }}" />
                @else
                <img alt="Logo" class="login-logo" src="{{ asset('assets/media/logo.png') }}" />
                @endif
            </div>
        </div>
        <div class="col-md-6 d-flex  align-items-center justify-content-center">
            <div class="login-container">
                <div class="login-content">

                    <h1 class="login-title">Login - {{ Helpers::settings('site_full_name') }}</h1>
                    <p class="login-subtitle">E-learn - {{ Helpers::settings('site_short_name') }}</p>
                    <form action="{{ url('login') }}" method="post" class="login-form" autocomplete="off">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="mb-4 ">
                                    <input class="form-control required m__input" type="text" autocomplete="off"
                                        placeholder="User Name" name="user_name" required="" aria-required="true">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="mb-4 ">
                                    <input class="form-control required m__input" type="password" autocomplete="off"
                                        placeholder="Password" name="password" required="" aria-required="true">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <div class="rem-password">
                                    <label class="rememberme m__checkbox m__with-label">
                                        <input type="checkbox" name="remember" value="1">
                                        <span></span>
                                    </label> Remember me
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <button class="btn login-btn" type="submit">Sign In</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="login-footer">
                <div class="row m-0 p-0">
                    <div class="col-md-5">
                        <ul class="login-social">
                            <li>
                                <a target="_blank" href="#">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="#">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="#">
                                    <i class="fa fa-youtube"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-7">
                        <div class="login-copyright text-right">
                            <p>Copyright &copy; {{ Helpers::settings('site_full_name') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




