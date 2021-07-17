@extends('layouts.app')

@section('content')
        <section class="mainLogo">
            <div class="container">
                    <livewire:search-dropdown />
            </div>
        </section>

    <livewire:load-more-album />


      <script type="text/javascript">
       $(document).ready(function() {
           if ($.cookie('pop') == null) {
               $('#stats').modal('show');
               $.cookie('pop', '1');
           }
       });
      </script>
<script>
    $(document).ready(function(){
         masonryStart();
        document.addEventListener("scroll", function(){
         masonryStart();
        });
        document.addEventListener("click", function(){
         masonryStart();
        });
        document.addEventListener("mouseover", function(){
         masonryStart();
         //randomize();
        });
        document.addEventListener("mouseout", function(){
         masonryStart();
        });
    });
    </script>
    <script>
    function masonryStart(){
        var $grid = $('.photos').masonry({
        itemSelector: '.masonry',
        // use element for option
        //  columnWidth: '.masonry',
        FitWidth: true,
        percentPosition: true,
        transitionDuration: 0
        });
    // layout Masonry after each image loads
    //$grid.imagesLoaded().progress( function() {
    //$(".progress-bar").css({"width": "100%"});
        $grid.imagesLoaded( function() {
        //$(".progress").hide();
        //$(".photos").show();
        $grid.masonry('layout');
        });
    }
    </script>

@endsection

