<div>

@if ($stats)
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
                        Total Public Likes
                        <span class="badge badge-dark"><i class="fas fa-heart"></i></i><span class="badge badge-dark">{{$stats['totalPublicLikes']}}</span></span>
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
                  </div>

                  <div class="mt-4">
                    <small><p>Cyberpunkwaifus gallery engine is a LAMP STACk DEMO developed with Laravel8+Livewire+Bootstrap4 technology</p></small>
                  </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
    </div>
@endif
</div>


