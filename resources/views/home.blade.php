@extends('layouts.front_page')
@section('title', Helpers::settings('site_full_name'))
@push('pre_css')
<style>
.home-banner-area {
    background-image: url('{{ url('assets/media/misc/2.jpg') }}');
    background-position: center center;
    background-size: cover;
    background-repeat: no-repeat;
    padding: 170px 0 130px;
    color: #fff;
}
.home-banner-area:before {
    position: absolute;
    top: 0px;
    content: ' ';
    bottom: 0px;
    width: 100%;
    background-color: #485461;
    background-image: linear-gradient(315deg, #485461 0%, #28313b 74%);
    opacity: 0.3;
}

.home-banner-wrap {
    max-width: 520px;padding-left:20px;
}
.home-banner-wrap h2 {
    font-size: 44px;
    font-weight: 600;
    line-height: 1;
    margin-bottom: 10px;
    text-shadow: 0 2px 4px rgba(41,48,59,.55);
}
.home-banner-wrap p {
    font-size: 18px;
    line-height: 34px;
    margin-bottom: 30px;
    text-shadow: 0 2px 4px rgba(41,48,59,.55);
}
.home-banner-wrap input[type="text"] {
    font-size: 20px;
    height: 50px;
    padding: 11px 17px;
    border: none;
    border-radius: 3px 0 0 3px;
    font-weight: 300;
}
.home-fact-area {
    padding: 15px 0;
    margin-bottom: 50px;
}
.home-fact-box .text-box {
    padding: 10px 0 10px 63px;
}
.home-fact-box .text-box h4 {
    font-size: 17px;
    font-weight: 700;
    margin-bottom: 2px;
    letter-spacing: 0.5px;
}
.home-fact-box .text-box p {
    font-size: 15px;
    margin-bottom: 0;
}
.home-fact-box svg
{
width:40px;
height:40px;
position: absolute;
    top: 10px;
}
.home-fact-box svg path
{
fill:#fff;
}

</style>
@endpush
@push('js')
	<!-- begin::Global Config(global config for global JS sciprts) -->
	<script>
		 @if (session('message'))
         toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};

toastr.success('{{ session('message') }}');
        @endif
        </script>
        
@endpush
@section('body_class','')
@section('content')
<section class="home-banner-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="home-banner-wrap">
                        <h2>Tamizha </h2>
                        <p>Learning Management System</p>
                        <form class="" action="#" method="get" autocomplete="off">
                            <div class="input-group search-box">
                                <input type="text" class="form-control" name="search_string" placeholder="What Do You Want To Learn?">
                                <div class="input-group-append">
                                    <button class="btn search-icon" type="submit">@include('icons.search')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</section>
<section class="home-fact-area has-gradient">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 d-flex">
                <div class="home-fact-box mr-md-auto ml-md-auto mr-auto">
                    @include('icons.archive')
                    <div class="text-box">
                        <h4>Offline Courses</h4>
                        <p>Explore A Variety Of Topics</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 d-flex">
                <div class="home-fact-box mr-md-auto ml-md-auto mr-auto">
                    @include('icons.blackboard')
                    <div class="text-box">
                        <h4>Online Courses</h4>
                        <p>Explore A Variety of Experts</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 d-flex">
                <div class="home-fact-box mr-md-auto ml-md-auto mr-auto">
                        @include('icons.timer')
                    <div class="text-box">
                        <h4>Live Webinar</h4>
                        <p>Life time free access</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section id="top_courses" class="pb-100">
        <header class="text-center mb-70 position-relative">
                <h2 class="background-bg-title bottom-line-center position-relative">
                    <span class="heading-bg-text">{{  Helpers::settings('site_short_name') }}</span>
                   Top Courses
                </h2>
            </header>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 text-center">
                   Coming soon
                </div>
              </div>
        </div>
    </section>



<section id="workshop" class="download pt-100 pb-100 has-gradient text-center">
        <span class="text-bg">{{  Helpers::settings('site_short_name') }}</span>
        <div class="container   position-relative">
            <header class="text-center mb-5">
                <h2 class="bottom-line-center bl-white">Coming Free Webinars</h2>
            </header>
            <div class="offset-md-3 col-md-6 col-xs-12">
                    <p class="lead text-center">Whether you're looking for a quick, on-the-fly, free webinar solution or you need all the best bells and whistles to get the job done.</p>
                    <div class="header-button">
                      <a href="#" class="download-btn"><i class="fa fa-android"></i> Visit Webinar</a>
                    </div>
                  </div>

        </div>
    </section>

    <section id="testimonials" class="testimonials pt-100 pb-100">
            <div class="container text-center">
                    <header class="text-center mb-70 position-relative">
                            <h2 class="background-bg-title bottom-line-center position-relative">
                                <span class="heading-bg-text">{{  Helpers::settings('site_short_name') }}</span>
                                What our clients say
                            </h2>
                        </header>
               <div class="container-fluid">
                    <div class="row">
  
                     <!--testimonial Item-->
                     <div class="item col-md-4 col-sm-6 col-xs-12">
                        <div class="testimonial-item has-shadow">
                           <div class="inner-box">
                           <figure class="author-thumb rounded-circle"><img class="rounded-circle" src="{{  url('assets/media/misc/placeholder.png') }}" alt="image"></figure>
                              <div class="text">Thanks for visiting our reviews page. Stay tuned to hear more about our guest satisfaction</div>
                              <div class="info">Client Name - <span class="designation">Designation</span></div>
                              <div class="quote-icon">@include('icons.quote')</div>
                           </div>
                        </div>
                     </div>

                     <div class="item col-md-4 col-sm-6 col-xs-12">
                            <div class="testimonial-item has-shadow">
                               <div class="inner-box">
                               <figure class="author-thumb rounded-circle"><img class="rounded-circle" src="{{  url('assets/media/misc/placeholder.png') }}" alt="image"></figure>
                                  <div class="text">Thanks for visiting our reviews page. Stay tuned to hear more about our guest satisfaction</div>
                                  <div class="info">Client Name - <span class="designation">Designation</span></div>
                                  <div class="quote-icon">@include('icons.quote')</div>
                               </div>
                            </div>
                         </div>

                         <div class="item col-md-4 col-sm-6 col-xs-12">
                                <div class="testimonial-item has-shadow">
                                   <div class="inner-box">
                                   <figure class="author-thumb rounded-circle"><img class="rounded-circle" src="{{  url('assets/media/misc/placeholder.png') }}" alt="image"></figure>
                                      <div class="text">Thanks for visiting our reviews page. Stay tuned to hear more about our guest satisfaction</div>
                                      <div class="info">Client Name - <span class="designation">Designation</span></div>
                                      <div class="quote-icon">@include('icons.quote')</div>
                                   </div>
                                </div>
                             </div>
  
                  </div>
               </div>
            </div>               
          </section>    


@stop
