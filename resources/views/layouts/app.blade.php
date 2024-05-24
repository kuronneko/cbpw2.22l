<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta name="author" content="CYBERPUNKWAIFUS">
    <meta name="description" content="CYBERPUNKWAIFUS Demo">
    <meta name="keywords" content="waifus, cute girls, art, images, photos, instagramcuties, instagram, teen, teens, dance, leggings, yoga, model, models, site rip, engine, tiktok, reels">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:description" content="CYBERPUNKWAIFUS Demo">
    <meta property="og:image" content="{{asset('img/previewLogo.gif')}}" />
    <meta property="og:title" content="CYBERPUNKWAIFUS - Demo">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://cyberpunkwaifus.xyz/">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/icon.png')}}" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous" rel="stylesheet">

    <!-- Styles -->
    <!-- <link href="{asset('css/app.css')}" rel="stylesheet"> -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dropzone.min.css')}}" rel="stylesheet" >
    <link href="{{ asset('css/jquery.fancybox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css')}}" rel="stylesheet" >
 @livewireStyles
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm sticky-top">
            <div class="container">
                <a class="navbar-brand " href="{{ url('/') }}">
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
                        <livewire:admin.avatar :userId="auth()->user()->id"/>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a href="{{ url('admin/profile') }}" class="dropdown-item">Profile</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                  document.getElementById('logout-form').submit();">
                                     {{ __('Logout') }}
                                 </a>
                                    @if(Auth::user()->type == config('myconfig.privileges.super'))
                                    <div class="hr-sect">Options</div>
                                    <a href="{{ url('/admin/profile?option=albums#content') }}" class="dropdown-item">Albums</a>
                                    <a href="{{ url('/admin/profile?option=likes#content') }}" class="dropdown-item">Likes</a>
                                    <a href="{{ url('/admin/profile?option=tags#content') }}" class="dropdown-item">Tags</a>
                                    <a href="{{ url('/admin/profile?option=users#content') }}" class="dropdown-item">Users</a>
                                    @endif
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

        <main class="mb-4">
            @yield('content')
        </main>

        <footer class="py-4">
            <div class="container">
                <p><a class="text-white" href="" target="_top">{{ config('myconfig.engine.name') }} {{config('myconfig.engine.version')}}</a> image gallery engine type-blog</p>
                <p>2018-<?php echo date("Y"); ?> © All right reserved</p>
            </div>
        </footer>

    </div>
    <!-- Scripts -->
    <!-- <script src="{asset('js/app.js')}" defer></script> -->
    <script type="text/javascript" src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/dropzone.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.fancybox.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/masonry.pkgd.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/imagesloaded.pkgd.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.cookie.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/infinite-scroll.pkgd.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js')}}"></script>
    <script>
        $('[data-fancybox="images"]').fancybox({
          buttons : [
            'slideShow',
            'download',
            'share',
            'thumbs',
            'close'
          ]
        });
        </script>
          <script>
        $(document).ready(function(){
            var $grid = $('.grid').masonry({
                itemSelector: '.grid-item',
                // use element for option
                //columnWidth: 5,
                FitWidth: true,
                percentPosition: true,
                transitionDuration: 0
                });
        var gridItemCount = $('.grid-item').length;
        if(gridItemCount == 0){
          $(".loadingGif").hide();
          $(".grid").show();
        }
        $grid.imagesLoaded( function() {
          $(".loadingGif").hide();
          $(".grid").show();
        $grid.masonry('layout');
        });
           var msnry = $grid.data('masonry');
                var infScroll = new InfiniteScroll( '.grid', {
                path: '?page=@{{#}}',
                append: '.grid-item',
                outlayer: msnry,
                history: false,
                status: '.page-load-status',
                });
        });
        </script>
        <script>
            var errors = false;
            Dropzone.options.mydropzone = {
                headers:{
                    'X-CSRF-TOKEN' : "{{csrf_token()}}"
                },
                //dictDefaultMessage: "Arrastre una imagen al recuadro para subirlo",
                acceptedFiles: ".png, .jpeg, .jpg, .gif, .mp4, .webm",
                //acceptedFiles: "image/*",
                maxFilesize: 0,
                maxFiles: 100,
                timeout: 0,
                //addRemoveLinks: true,
                init: function (){
            this.on("error", function (file){
                errors = true;
            });
            this.on("queuecomplete", function (file) {
                if(errors) $('#dropzoneMessageProblem').show();
                else $('#dropzoneMessageOK').show();
            });
                   /*
            this.on("success", function (file){
                $('#dropzoneMessageOK').show();
            //file_up_names.push(file.name);
            //alert("El archivo se cargó correctamente");
            });
        */
            /*
            this.on("removedfile", function (file){
            $.post('php/controller/adminController.php',
            {file_name:file.name},
            function(data,status){
            //alert(data);
            });
            });
            */
            }
            };
        </script>
    @livewireScripts
</body>
</html>
