@extends('layouts.app')

@section('content')
<div class="container publicContainerWithNoPadding">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card bg-dark text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p>Public Album List</p>
                    <div class="group-buttons">
                        <a href="{{route('index')}}" class="btn btn-secondary btn-sm">
                            <i id="homeOrBack" class="fas fa-sync"></i>
                        </a>
                        <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#stats">
                            <i class="fas fa-chart-bar"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body indexCardBodyStyle">
                        <div class="form-group">
                          <input type="text" name="search" id="search" class="form-control bg-dark text-white searchBarIndex" placeholder="Search albums by name" />
                        </div>

    <livewire:load-more />


                {{-- fin card body --}}
                </div>
            </div>

        </div>
    </div>
</div>
      <!-- The Modal -->
      <div class="modal fade" id="stats">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content bg-dark text-white">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Cyberpunkwaifus statistics</h4>
              <button type="button" class="close bg-dark text-white" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                    <div class="container mt-3">
                        <p>General statistics collected from album content (private albums will not be counted)</p>
                        <ul class="list-group">
                          <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                            Total Public Albums
                            <span class="badge badge-secondary"><i class="fas fa-book"></i><span class="badge badge-secondary">{{$stats['totalPublicAlbums']}}</span></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                            Total Public Images
                            <span class="badge badge-secondary"><i class="fas fa-images"></i><span class="badge badge-secondary">{{$stats['totalPublicImages']}}</span></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                            Total Public Videos
                            <span class="badge badge-secondary"><i class="fas fa-film"></i><span class="badge badge-secondary">{{$stats['totalPublicVideos']}}</span></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                            Total Public Comments
                            <span class="badge badge-secondary"><i class="fas fa-comments"></i></i><span class="badge badge-secondary">{{$stats['totalPublicComments']}}</span></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                            Total Size
                            <span class="badge badge-secondary"><i class="fas fa-hdd"></i><span class="badge badge-secondary">{{$stats['totalAlbumSize']}}</span></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                            Last update at
                            <span class="badge badge-secondary"><i class="fas fa-redo-alt"></i><span class="badge badge-secondary">{{$stats['lastUpdateAlbum']}}</span></span>
                          </li>
                        </ul>
                      </div>

            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

          </div>
        </div>
      </div>
      <script>

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
            $('#albumsBox').html(data.output);
                $('#albumsBox').html(data.output);
                $("#livewireAjaxLoadMore").hide();
                $("#homeOrBack").removeClass('fas fa-sync');
                $("#homeOrBack").addClass('fas fa-arrow-left');
           }
          })
         }
        });

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
    $(".photos").show();
    $grid.masonry('layout');
    });
    });
    </script>

@endsection

