@extends('layouts.app')

@section('content')
<div class="container publicContainerWithNoPadding">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p>Public Album List</p>
                    <div class="group-buttons">
                        <a href="{{route('index')}}" class="btn btn-dark btn-sm">
                            <i id="homeOrBack" class="fas fa-sync"></i>
                        </a>
                        <button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#stats">
                            <i class="fas fa-chart-bar"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body indexCardBodyStyle">
                        <livewire:search-dropdown />
                        <livewire:load-more-album />
                {{-- fin card body --}}
                </div>
            </div>

        </div>
    </div>
</div>
      <!-- The Modal -->
      <div class="modal fade" id="stats">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content text-white">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Cyberpunkwaifus statistics</h4>
              <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                    <div class="container mt-3">
                        <p>General statistics collected from album content (private albums will not be counted)</p>
                        <ul class="list-group">
                          <li class="list-group-item d-flex justify-content-between align-items-center text-white">
                            Total Public Albums
                            <span class="badge badge-dark"><i class="fas fa-book"></i><span class="badge badge-dark">{{$stats['totalPublicAlbums']}}</span></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center text-white">
                            Total Public Images
                            <span class="badge badge-dark"><i class="fas fa-images"></i><span class="badge badge-dark">{{$stats['totalPublicImages']}}</span></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center text-white">
                            Total Public Videos
                            <span class="badge badge-dark"><i class="fas fa-film"></i><span class="badge badge-dark">{{$stats['totalPublicVideos']}}</span></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center text-white">
                            Total Public Comments
                            <span class="badge badge-dark"><i class="fas fa-comments"></i></i><span class="badge badge-dark">{{$stats['totalPublicComments']}}</span></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center text-white">
                            Total Views
                            <span class="badge badge-dark"><i class="fas fa-eye"></i><span class="badge badge-dark">{{$stats['totalPublicViews']}}</span></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center text-white">
                            Total Size
                            <span class="badge badge-dark"><i class="fas fa-hdd"></i><span class="badge badge-dark">{{$stats['totalAlbumSize']}}</span></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center text-white">
                            Last update at
                            <span class="badge badge-dark"><i class="fas fa-redo-alt"></i><span class="badge badge-dark">{{$stats['lastUpdateAlbum']}}</span></span>
                          </li>
                        </ul>
                          <div class="mt-4">
                            <small>
                            <p>Also, you can access to old cbpw software  <a class="text-white" href="https://old.cyberpunkwaifus.xyz/gallery/waifus">HERE</a></p>
                            </small>
                          </div>
                      </div>

            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>

          </div>
        </div>
      </div>

      <script>
          /*
        $(document).ready(function(){

          $(document).on('keyup', '#search', function(){
          var query = $(this).val();
          fetch_customer_data(query);
         });

         function fetch_customer_data(query = ''){
        $.ajax({
           url:"{{ route('album.getAjaxAlbums') }}",
           method:'GET',
           data:{query:query},
           dataType:'json',
           success:function(data){
if(data.paginationType == 0){
    $('#albumsBox').html(data.output);
               // $(".page-load-status").hide();
                //$("#livewireAjaxLoadMore").hide();
                $("#homeOrBack").removeClass('fas fa-sync');
                $("#homeOrBack").addClass('fas fa-arrow-left');
}else{
    $('#albumsBox').html(data.output);
               //$("#livewireAjaxLoadMore").show();
                $("#homeOrBack").removeClass('fas fa-arrow-left');
                $("#homeOrBack").addClass('fas fa-sync');
}


             }
           })
         }
      });
      */
        </script>
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
    function randomColors() {
  return '#' + Math.floor(Math.random() * 16777215).toString(16);
}
function randomize() {
  document.getElementById('livewireAjaxLoadMore').style.backgroundColor = randomColors();
}
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

