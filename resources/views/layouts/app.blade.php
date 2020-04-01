<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
	<title>@yield('title', config('sis.title', 'Dashboard'))</title>
	<meta name="description" content="@yield('description', config('sis.description', ''))">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	@if(Storage::disk('public')->exists(Helpers::settings('favicon')))
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset(Storage::url(Helpers::settings('favicon'))) }}" />
	@else
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/media/favicon.png') }}" />
	@endif

    <meta name="csrf-token" content="{{ csrf_token() }}">

	<!--begin::Fonts -->
	<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
	<script>
			WebFont.load({
				google: {
					"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
				},
				active: function() {
					sessionStorage.fonts = true;
				}
			});
	</script>
   
   
	<link href="{{ url('assets/plugins/line-awesome/css/line-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
    <link href="{{ url('assets/plugins/animate.css') }}" rel="stylesheet">
	<link href="{{ url('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	
	@yield('section_pre_css')
	
	<link href="{{ url('assets/css/style.css') }}" rel="stylesheet">
	<link href="{{ url('assets/css/theme.css') }}" rel="stylesheet">

	@yield('section_post_css')
</head>
<body class="@yield('body_class')">

@yield('body')

@yield('section_js')
</body>
</html>