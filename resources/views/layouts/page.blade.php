@extends('layouts.app')

@section('section_pre_css')

<link href="{{ url('assets/plugins/sweetalert2/dist/sweetalert2.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/magnific-popup/magnific-popup.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/plugins/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css" />


@stack('pre_css')
@stop

@section('section_post_css')
@stack('css')
@stop


@section('section_js')
<script src="{{ url('assets/plugins/jquery/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/popper/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/jquery-validation/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/select2/dist/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/toastr/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/magnific-popup/magnific-popup.min.js') }}" type="text/javascript"></script>

<script src="{{ url('assets/js/functions.js') }}" type="text/javascript"></script>
<script>

  toastr.options = {
    "closeButton": true,
    "newestOnTop": true,
    "progressBar": true,
   
  };

  

  @if(session('message'))
  toastr.success("{{ session('message') }}");
  @endif

  @if(session('status'))
  toastr.success("{{ session('status') }}");
  @endif


  $(document).ready(function() {
    $('.ajax-popup').magnificPopup({
      type: 'ajax',
      midClick: true,
      modal: true
    });
    $(document).on('click', '.ajax-close', function(e) {
      e.preventDefault();
      $.magnificPopup.close();
    });

    function toggleDropdown(e) {
      $(e.target).closest('a.btn').click();
    }
    $('body').on('mouseenter mouseleave', '.dropdown', toggleDropdown)
      .on('click', '.dropdown-menu a', toggleDropdown);
    $.magnificPopup.instance._onFocusIn = function(e) {
      if ($(e.target).hasClass('select2-search__field')) {
        return true;
      }
      $.magnificPopup.proto._onFocusIn.call(this, e);
    }
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  });
</script>
@stack('js')
<!--begin::Global App Bundle(used by all pages) -->
@stop
@section('body')


<div class="page-wrapper">
  <nav id="sidebar" class="sidebar">
      <div id="sidebar-content" class="sidebar-content">
          <!-- sidebar-brand  -->
          <div class="sidebar-brand">
           
              <a href="{{ url('/') }}" class="logo">
                @if(Storage::disk('public')->exists(Helpers::settings('dashboard_logo')))
                <img alt="Logo" src="{{ asset(Storage::url(Helpers::settings('dashboard_logo'))) }}" />
                @else
                <img alt="Logo" src="{{ asset('assets/media/logo.png') }}" />
                @endif
              </a>
              <i id="sidemenu-link" class="la la-angle-double-left"></i>
          </div>

          @include('layouts.side_menu')

         
      </div>
  </nav>
  <!-- page-content  -->
  <div class="m__content-wrapper">
      <div id="overlay" class="overlay"></div>
     
      @include('layouts.top_menu')

      <div class="m__fluid-container">

          @yield('content')
              
      </div>


<div class="m__footer-container">
    <div class="m__footer-copyright">
        2020 &nbsp;&copy;&nbsp; {{ Helpers::settings('site_full_name') }}
    </div>
    <div class="m__footer-menu">

    </div>

</div>
    


  </div>
  <!-- page-content" -->
</div>
<!-- page-wrapper -->



@stop