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
                            <p>Status: Super Admin</p>
                            @elseif ($muser->type == config('myconfig.privileges.admin'))
                            <p>Status: Normal User</p>
                            @elseif ($muser->type == config('myconfig.privileges.admin++'))
                            <p>Status: Premium User</p>
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
                            <a href="{{route('super.user.index')}}" class="btn btn-danger btn-sm disabled">Ban</a>
                            <a data-dismiss="modal" wire:click="deleteUser({{$muser->id}})" class="btn btn-danger btn-sm disabled">Delete User</a>
                            @if($muser->type == config('myconfig.privileges.admin'))
                            <button data-dismiss="modal" wire:click="changePrivileges({{$muser->id}})" class="btn btn-success btn-sm">Upgrade</button>
                            @elseif($muser->type == config('myconfig.privileges.admin++'))
                            <button data-dismiss="modal" wire:click="changePrivileges({{$muser->id}})" class="btn btn-danger btn-sm">Downgrade</button>
                            @elseif($muser->type == config('myconfig.privileges.ban'))
                            <button class="btn btn-danger btn-sm disabled">Banned</button>
                            @endif
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
