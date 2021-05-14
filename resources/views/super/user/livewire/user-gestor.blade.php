<div>
@if($muser)
<div wire:ignore.self class="modal fade" id="userPreview">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-white">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">User Preview</h4>
            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="text-center">
                <div class="avatarContainer">
                 <img src="{{config('myconfig.img.url')}}{{$muser->avatar}}" class="avatar mb-4" alt="">
                </div>
            </div>
                  <div>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <p>Username: {{$muser->name}}</p>
                        </li>
                        <li class="list-group-item">
                            <p>Email: {{$muser->email}}</p>
                        </li>
                        <li class="list-group-item">
                            @if ($muser->type == config('myconfig.privileges.super'))
                            <p class="text-warning">Status: Super Admin</p>
                            @elseif ($muser->type == config('myconfig.privileges.admin'))
                            <p class="text-danger">Status: Restrincted User</p>
                            @elseif ($muser->type == config('myconfig.privileges.admin++'))
                            <p class="text-info">Status: Premium User</p>
                            @elseif ($muser->type == config('myconfig.privileges.admin+++'))
                            <p class="text-success">Status: Premium User+</p>
                            @endif
                        </li>
                        <li class="list-group-item">
                            <p>Last login: {{$muser->last_login_at}}</p>
                        </li>
                        <li class="list-group-item">
                            <p>Last login IP: {{$muser->last_login_ip}}</p>
                        </li>
                    </ul>
                  </div>
                    <div>
                        @if ($muser->type == config('myconfig.privileges.super'))

                        @else
                        <div class="text-center">
                            <small><div class="hr-sect text-white">Options</div></small>
                            <a data-dismiss="modal" wire:click="deleteUser({{$muser->id}})" class="btn btn-danger btn-sm disabled"><i class="fas fa-user-times"></i></a>
                            <button data-dismiss="modal" wire:click="restrinctedUser({{$muser->id}})" class="btn btn-danger btn-sm"><i class="fas fa-user-lock"></i></button>
                            <button data-dismiss="modal" wire:click="premiumUser({{$muser->id}})" class="btn btn-info btn-sm"><i class="fas fa-user"></i></button>
                            <button data-dismiss="modal" wire:click="premiumUserPlus({{$muser->id}})" class="btn btn-success btn-sm"><i class="fas fa-user-plus"></i></button>
                        </div>
                        @endif
                    </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>
@endif

<script>
    window.addEventListener('show-modal', event =>{
        $('#userPreview').modal('show')
        });
</script>
</div>
