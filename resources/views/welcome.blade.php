<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  </head>
  <body class="bg-grey-lighter h-screen font-montserrat">

    <div id="app" class="h-screen">
      <login-compontent></login-compontent>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
  </body>
</html>
