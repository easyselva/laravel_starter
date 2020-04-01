<div class="modal-dialog @if(isset($modal_class)) {{ $modal_class }} @endif" role="document" id="ajax-container">

        <div class="modal-content">
    
    
    
               
    
            {{ Form::open(['url' => url('ajax_login/login'),'id'=>'login_form', 'files' => true,'class'=>'form-vertical 
    validate_form loginpage  '.($type=='login'? 'showform':''), 'method' => 'post','autocomplete'=>'off']) }}
    
    
        <div class="text-center">
    @if(Storage::disk('public')->exists(Helpers::settings('login_logo')))
                            <img alt="Logo" class="login-logo" src="{{ asset(Storage::url(Helpers::settings('login_logo'))) }}" />
                            @else
                            <img alt="Logo" class="login-logo" src="{{ asset('assets/media/logo.png') }}" />
                            @endif
    <h4 class="text-center m-2">Login : {{ Helpers::settings('site_short_name') }}</h4>
        </div>
    
        <div class="s3-section ">
                            <div class="s3-section-body container">
                           <fieldset class="form-horizontal  ">
                               <div class="row pt-5 pb-5">
                                   <div class="col-md-10 offset-1">
                                       <div class="form-group" id="email_id" >
                                        <label for="email">Enter your Email/Mobile No</label>
                                           {!! Form::input('text','email',null, ['class' => 'form-control m-input required  mb-3 p-2' ,
                                           'placeholder' => 'Email/Mobile No', 'autocomplete'=>"nope" ])
                                           !!}
                                          <span class="help-text mb-3"> Note: After entering you will receive OTP.</span>
                                        </div>
                                        </div>
                                        </div>
                           </fieldset>
                                   </div></div>
    
    
    
    
    
    
    
        <div class="text-center mb-5">
        <button type="button" class="btn btn-danger ajax-close">Close</button>
        <button id="login_btn" type="submit" class="btn btn-primary "><i class="fa fa-check"></i> Submit</button>
            </div>
    
    
    
            {{ Form::close() }}
    
    
    
            {{ Form::open(['url' => url('ajax_login/otp'),'id'=>'otp_form', 'files' => true,'class'=>'form-vertical
    validate_form  loginpage '.$type, 'method' => 'post','autocomplete'=>'off' ]) }}
    
    
        <div class="text-center">
    @if(Storage::disk('public')->exists(Helpers::settings('login_logo')))
                            <img alt="Logo" class="login-logo" src="{{ asset(Storage::url(Helpers::settings('login_logo'))) }}" />
                            @else
                            <img alt="Logo" class="login-logo" src="{{ asset('assets/media/logo.png') }}" />
                            @endif
    <h4 class="text-center m-2">OTP : {{ Helpers::settings('site_short_name') }}</h4>
        </div>
    
        <div class="s3-section">
                            <div class="s3-section-body">
                           <fieldset class="form-horizontal  ">
                               <div class="row pt-5 pb-5">
                                   <div class="col-md-10 offset-1">
                                       <div class="form-group" id="otp_no" >
                                        <label for="email">Enter THE OTP</label>
                                           {!! Form::input('text','otp_no',null, ['class' => 'form-control m-input required mb-3 p-2' ,
                                           'placeholder' => 'Enter OTP', 'autocomplete'=>"nope" ])
                                           !!}

      <a href="javascript:void()" class="help-text mb-3" id="resend_otp" style="display:none;">Resend OTP</a>

      <span class="help-text mb-3" id="timer_help" style="display:none;"> <span id="timer"></span> Seconds </span>

                                       
                                      
                                        </div>
                                        </div>
                                        </div>
                           </fieldset>
                                   </div></div>
    
    
    
    
    
    
    
        <div class="text-center mb-5">
        <button type="button" class="btn btn-warning back-login-form" >Go Back</button>
            <button id="otp_btn" type="button" class="btn btn-primary "><i class="fa fa-check"></i> Submit OTP </button>
        </div>
     
    
    
            {{ Form::close() }}
    
    
    
            {{ Form::open(['url' => url('ajax_login/ajaxregister'),'id'=>'register_form', 'files' => true,'class'=>'form-vertical
    validate_form  loginpage '.($type=='register'? 'showform':''), 'method' => 'post','autocomplete'=>'off' ]) }}
    
    
        <div class="text-center">
    @if(Storage::disk('public')->exists(Helpers::settings('login_logo')))
                            <img alt="Logo" class="login-logo" src="{{ asset(Storage::url(Helpers::settings('login_logo'))) }}" />
                            @else
                            <img alt="Logo" class="login-logo" src="{{ asset('assets/media/logo.png') }}" />
                            @endif
    <h4 class="text-center m-2">REGISTER : {{ Helpers::settings('site_short_name') }}</h4>
        </div>
    
        <div class="s3-section">
                            <div class="s3-section-body">
                           <fieldset class="form-horizontal  ">
                               <div class="row mt-3">
                                   <div class="col-md-10 offset-1">
                                       <div class="form-group" id="otp_no" >
                                            <label for="email">Enter your Email</label>
                                 
                                           {!! Form::input('text','email',null, ['class' => 'form-control m-input required mb-3 p-2' ,
                                           'placeholder' => 'Enter your email', 'autocomplete'=>"nope" ])
                                           !!}
                                        </div>
                                        </div>
                                        </div>
    
                                        <div class="row  mt-2">
                                   <div class="col-md-10 offset-1">
                                       <div class="form-group" id="otp_no" >
                                            <label for="email">Enter your mobile no</label>
                                 
                                           {!! Form::input('text','mobile_no',null, ['class' => 'form-control m-input required mb-3 p-2' ,
                                           'placeholder' => 'Enter your mobile no', 'autocomplete'=>"nope" ])
                                           !!}
                                        </div>
                                        </div>
                                        </div>
    
                                        <div class="row  mt-2">
                                   <div class="col-md-10 offset-1">
                                       <div class="form-group" id="name" >
                                            <label for="email">Enter your name</label>
                                 
                                           {!! Form::input('text','display_name',null, ['class' => 'form-control m-input required mb-3 p-2' ,
                                           'placeholder' => 'Enter your Name', 'autocomplete'=>"nope" ])
                                           !!}
                                        </div>
                                        </div>
                                        </div>
    
    
    
                           </fieldset>
                                   </div></div>
    
    
    
    
    
    
    
        <div class="text-center mb-5">
     
        <button type="button" class="btn btn-danger ajax-close" >Close</button>
    
        <button id="register_btn" type="button" class="btn btn-primary "><i class="fa fa-check"></i> Submit </button>
        </div>
    
    
    
            {{ Form::close() }}
    
    
    
        </div>
    </div>
    <script>

function setDisabled() {
    $("#resend_otp").css("display", 'inline-block');
}


function timer(remaining) {

    
    $("#timer_help").css("display", 'block');
    


  var m = Math.floor(remaining / 60);
  var s = remaining % 60;
  m = m < 10 ? '0' + m : m;
  s = s < 10 ? '0' + s : s;


  document.getElementById('timer').innerHTML = m + ':' + s;
  remaining -= 1;
  if(remaining >= 0) {
    setTimeout(function() {
        timer(remaining);
    }, 1000);
    return;
  }

 // if(!timerOn) {
    // Do validate stuff here
 //   return;
 // }
 
$("#timer_help").css("display", 'none');


}




        $(function () {

            $('.ajax-popup').magnificPopup({
                type: 'ajax',
                midClick: true,
                modal: true
            });

            $("#login_form").validate({
                ignore: []
            });
            $("#register_form").validate({
                ignore: []
            });

            $("#otp_form").validate({
                ignore: []
            });


            $(".back-login-form").click(function (event) {
                $("#login_form").css('display', 'block');
                $("#otp_form").css('display', 'none');
            });


            $("#login_btn").click(function (event) {
                $("#login_btn").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
                $("#login_btn").toggleClass("s3-spinner");
                event.preventDefault();
                var frm = $('#login_form');
                var formData = new FormData($('#login_form')[0]);
                if (frm.valid()) {
                    $.ajax({
                        type: frm.attr('method'),
                        url: frm.attr('action'),
                        data: formData,
                        contentType: false, // The content type used when sending data to the server.
                        cache: false, // To unable request pages to be cached
                        processData: false, // To send DOMDocument or non processed data file it is set to false
                        success: function (response) {
                            $("#login_btn").html('<i class="fa fa-check"></i> Login');
                            $("#login_btn").attr("disabled", false);
                            if (response.status === true) {
                                toastr.success(response.notification);

                                $("#login_form").css('display', 'none');
                                $("#otp_form").css('display', 'block');

                               

                                window.setTimeout(setDisabled,30000);
                                timer(30);


                            } else {
                                $("#login_btn").html('<i class="fa fa-check"></i> Login');
                                $("#login_btn").attr("disabled", false);
                                toastr.error(response.notification);
                            }
                        },
                        error: function (data) {
                            $("#login_btn").html('<i class="fa fa-check"></i> Login');
                            $("#login_btn").attr("disabled", false);
                            toastr.error("Oops... Something went wrong!" + data);
                        },
                    });
                } else {
                    $("#login_btn").html('<i class="fa fa-check"></i> Login');
                    $("#login_btn").attr("disabled", false);
                }
            });


            $("#otp_btn").click(function (event) {
                $("#otp_btn").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
                $("#otp_btn").toggleClass("s3-spinner");
                event.preventDefault();
                var frm = $('#otp_form');
                var formData = new FormData($('#otp_form')[0]);
                if (frm.valid()) {
                    $.ajax({
                        type: frm.attr('method'),
                        url: frm.attr('action'),
                        data: formData,
                        contentType: false, // The content type used when sending data to the server.
                        cache: false, // To unable request pages to be cached
                        processData: false, // To send DOMDocument or non processed data file it is set to false
                        success: function (response) {
                            $("#otp_btn").html('<i class="fa fa-check"></i> Submit OTP');
                            $("#otp_btn").attr("disabled", false);
                            if (response.status === true) {
                                toastr.success(response.notification);

                                // $("#login_form").css('display','none');
                                // $("#otp_form").css('display','block');
                                $("#login_status").html(response.content);



                                $('.ajax-popup').magnificPopup({
                                    type: 'ajax',
                                    midClick: true,
                                    modal: true
                                });


                                $.magnificPopup.close();

                                window.location.href = "{{ url('reservation') }}";


                            } else {
                                $("#otp_btn").html('<i class="fa fa-check"></i> Submit OTP');
                                $("#otp_btn").attr("disabled", false);
                                toastr.error(response.notification);
                            }
                        },
                        error: function (data) {
                            $("#otp_btn").html('<i class="fa fa-check"></i> Login');
                            $("#otp_btn").attr("disabled", false);
                            toastr.error("Oops... Something went wrong!" + data);
                        },
                    });
                } else {
                    $("#otp_btn").html('<i class="fa fa-check"></i> Submit OTP');
                    $("#otp_btn").attr("disabled", false);
                }
            });

            $("#register_btn").click(function (event) {
                $("#register_btn").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
                $("#register_btn").toggleClass("s3-spinner");
                event.preventDefault();
                var frm = $('#register_form');
                var formData = new FormData($('#register_form')[0]);
                if (frm.valid()) {
                    $.ajax({
                        type: frm.attr('method'),
                        url: frm.attr('action'),
                        data: formData,
                        contentType: false, // The content type used when sending data to the server.
                        cache: false, // To unable request pages to be cached
                        processData: false, // To send DOMDocument or non processed data file it is set to false
                        success: function (response) {
                            $("#register_btn").html('<i class="fa fa-check"></i> Register');
                            $("#register_btn").attr("disabled", false);
                            if (response.status === true) {
                                toastr.success(response.notification);



                                $("#register_form").css('display', 'none');

                                $("#otp_form").css('display', 'block');

                                window.setTimeout(setDisabled, 30000);
                                timer(30);


                            } else {
                                $("#register_btn").html('<i class="fa fa-check"></i> Register');
                                $("#register_btn").attr("disabled", false);
                                toastr.error(response.notification);
                            }
                        },
                        error: function (data) {
                            $("#register_btn").html('<i class="fa fa-check"></i> Register');
                            $("#register_btn").attr("disabled", false);
                            toastr.error("Oops... Something went wrong!" + data);
                        },
                    });
                } else {
                    $("#register_btn").html('<i class="fa fa-check"></i> Register');
                    $("#register_btn").attr("disabled", false);
                }
            });



            $("#resend_otp").click(function (event) {
                $("#resend_otp").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
                $("#resend_otp").toggleClass("s3-spinner");
                event.preventDefault();
            
                    $.ajax({
                        type: 'get',
                        url: "{{ url('resend_otp') }}",
                        contentType: false, // The content type used when sending data to the server.
                        cache: false, // To unable request pages to be cached
                        processData: false, // To send DOMDocument or non processed data file it is set to false
                        success: function (response) {
                            $("#resend_otp").css('display','none');

                            if (response.status === true) {
                                toastr.success(response.notification);

                            } else {
                                
                                toastr.error(response.notification);
                            }
                        },
                        error: function (data) {
                            $("#resend_otp").css('display','none');
                            toastr.error("Oops... Something went wrong!" + data);
                        },
                    });
               
            });







        }); 
        </script>
    
    @if(isset($custom_scripts))
    @include($custom_scripts)
    @endif