<!DOCTYPE html>
<html>
  <head>
    <title>Game</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
    <script>$(function() { Isometric.load() });</script>
  </head>
  <body class="bg-black">
    <canvas id="isocanvas"></canvas>
  </body>
</html>
