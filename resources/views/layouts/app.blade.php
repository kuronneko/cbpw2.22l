<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!-- <script src="{asset('js/app.js')}" defer></script> -->
    <script type="text/javascript" src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/dropzone.js')}}"></script>
    <script type="text/javascript" src="{{asset('https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js')}}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous" rel="stylesheet">

    <!-- Styles -->
    <!-- <link href="{asset('css/app.css')}" rel="stylesheet"> -->
    <link href="{{ asset('css/style.css')}}" rel="stylesheet" >
    <link href="{{ asset('css/dropzone.min.css')}}" rel="stylesheet" >
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css')}}" rel="stylesheet" />

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script>
        Dropzone.options.mydropzone = {
            headers:{
                'X-CSRF-TOKEN' : "{{csrf_token()}}"
            },
            //dictDefaultMessage: "Arrastre una imagen al recuadro para subirlo",
            acceptedFiles: "image/*",
            maxFilesize: 100,
            maxFiles: 100,
        };
    </script>
    <script>
        $(document).ready(function(){
    $(document).on('click', '.getAlbumData', function(){
    var albumId = $(this).attr("id");
    $.ajax({
        headers:{
        'X-CSRF-TOKEN' : "{{csrf_token()}}"
    },
    url:"{{ route('album.fetchAlbum') }}",
    method:"POST",
    data:{albumId:albumId},
    dataType:"json",
    success:function(data){
    $('#albumId').val(data.id);
    //$('#deleteAlbum').attr('action', controllerPath);
    $('#albumName').text('[Album:'+data.name+']');
    $('#myModal').modal('show');
    }
    });
    });
});
</script>
</body>
</html>
