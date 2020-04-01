<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta
    name="viewport" 
    content="minimum-scale=1, initial-scale=1, width=device-width, shrink-to-fit=no"
  />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TRNDit</title>
    <link rel="manifest" href="{{ url("manifest.json") }}" />
    <!-- Styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" />
 
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
<div id="root">

</div>

<!-- Scripts -->
<script src="{{ asset(mix('/js/app.js')) }}"></script>
</body>
</html>