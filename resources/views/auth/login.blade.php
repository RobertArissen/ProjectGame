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
        <div class="container mx-auto h-full flex justify-center items-center">
        <div class="w-1/3">
            <h1 class="font-hairline mb-6 text-center">GameNaam</h1>
            <div class="border-blue p-8 border-t-4 bg-white mb-6 shadow-lg">
                 <form role="form" method="POST" action="/login">
                  @if ($errors->any())
                      @foreach ($errors->all() as $error)
                          <div class="mb-2">{{$error}}</div>
                      @endforeach
                  @endif

                  {!! csrf_field() !!}

                  <login-compontent></login-compontent>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
  </body>
</html>
