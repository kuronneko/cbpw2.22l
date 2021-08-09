<div>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4 text-white rounded">
@if(Auth::check() && Auth::user()->type == config('myconfig.privileges.super'))
<div class="btn-group btn-block">
    @if($option == 'albums')
    <a wire:loading.remove wire:target="changeOption('albums')" wire:click="changeOption('albums')" class="btn btn-danger btn-sm userMenuBtn text-white " href="#"><i class="fas fa-book"></i> Albums</a>
    <a wire:loading wire:target="changeOption('albums')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></i> Albums</a>
    @else
    <a wire:loading.remove wire:target="changeOption('albums')" wire:click="changeOption('albums')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="fas fa-book"></i> Albums</a>
    <a wire:loading wire:target="changeOption('albums')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></i> Albums</a>
    @endif
    @if($option == 'likes')
    <a wire:loading.remove wire:target="changeOption('likes')" wire:click="changeOption('likes')" class="btn btn-danger btn-sm userMenuBtn text-white" href="#"><i class="fas fa-heart"></i> Likes</a>
    <a wire:loading wire:target="changeOption('likes')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></i> Likes</a>
    @else
    <a wire:loading.remove wire:target="changeOption('likes')" wire:click="changeOption('likes')" class="btn blackBtn btn-sm userMenuBtn text-white" href="#"><i class="fas fa-heart"></i> Likes</a>
    <a wire:loading wire:target="changeOption('likes')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></i> Likes</a>
    @endif

    @if($option == 'tags')
    <a wire:loading.remove wire:target="changeOption('tags')" wire:click="changeOption('tags')" class="btn btn-danger btn-sm userMenuBtn text-white " href="#"><i class="fas fa-tags"></i> Tags</a>
    <a wire:loading wire:target="changeOption('tags')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></i> Tags</a>
    @else
    <a wire:loading.remove wire:target="changeOption('tags')" wire:click="changeOption('tags')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="fas fa-tags"></i> Tags</a>
    <a wire:loading wire:target="changeOption('tags')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></i> Tags</a>
    @endif
    @if($option == 'users')
    <a wire:loading.remove wire:target="changeOption('users')" wire:click="changeOption('users')" class="btn btn-danger btn-sm userMenuBtn text-white " href="#"><i class="fas fa-users"></i> Users</a>
    <a wire:loading wire:target="changeOption('users')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></i> Users</a>
    @else
    <a wire:loading.remove wire:target="changeOption('users')" wire:click="changeOption('users')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="fas fa-users"></i> Users</a>
    <a wire:loading wire:target="changeOption('users')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></i> Users</a>
    @endif

    @if($option == 'messages')
    <a wire:loading.remove wire:target="changeOption('messages')" wire:click="changeOption('messages')" class="btn btn-danger btn-sm userMenuBtn text-white" href="#"><i class="fas fa-envelope"></i> Messages</a>
    <a wire:loading wire:target="changeOption('messages')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></i> Messages</a>
    @else
    <a wire:loading.remove wire:target="changeOption('messages')" wire:click="changeOption('messages')" class="btn blackBtn btn-sm userMenuBtn text-white" href="#"><i class="fas fa-envelope"></i> Messages</a>
    <a wire:loading wire:target="changeOption('messages')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></i> Messages</a>
    @endif
    @if($option == 'activity')
    <a wire:loading.remove wire:target="changeOption('activity')" wire:click="changeOption('activity')" class="btn btn-danger btn-sm userMenuBtn text-white" href="#"><i class="fas fa-server"></i> Activity</a>
    <a wire:loading wire:target="changeOption('activity')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></i> Activity</a>
    @else
    <a wire:loading.remove wire:target="changeOption('activity')" wire:click="changeOption('activity')" class="btn blackBtn btn-sm userMenuBtn text-white" href="#"><i class="fas fa-server"></i> Activity</a>
    <a wire:loading wire:target="changeOption('activity')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></i> Activity</a>
    @endif
</div>
@else
<div class="btn-group btn-block">
    @if(auth()->user()->type != config('myconfig.privileges.usewr'))
    @if($option == 'albums')
    <a wire:loading.remove wire:target="changeOption('albums')" wire:click="changeOption('albums')" class="btn btn-danger btn-sm userMenuBtn text-white " href="#"><i class="fas fa-book"></i> Albums</a>
    <a wire:loading wire:target="changeOption('albums')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></i> Albums</a>
    @else
    <a wire:loading.remove wire:target="changeOption('albums')" wire:click="changeOption('albums')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="fas fa-book"></i> Albums</a>
    <a wire:loading wire:target="changeOption('albums')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></i> Albums</a>
    @endif
    @else
    <a class="btn blackBtn btn-sm userMenuBtn text-white disabled" href="#"><i class="fas fa-book"></i> Albums</a>
    <a class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></i> Albums</a>
    @endif

    @if($option == 'likes')
    <a wire:loading.remove wire:target="changeOption('likes')" wire:click="changeOption('likes')" class="btn btn-danger btn-sm userMenuBtn text-white" href="#"><i class="fas fa-heart"></i> Likes</a>
    <a wire:loading wire:target="changeOption('likes')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></i> Likes</a>
    @else
    <a wire:loading.remove wire:target="changeOption('likes')" wire:click="changeOption('likes')" class="btn blackBtn btn-sm userMenuBtn text-white" href="#"><i class="fas fa-heart"></i> Likes</a>
    <a wire:loading wire:target="changeOption('likes')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></i> Likes</a>
    @endif
    @if($option == 'messages')
    <a wire:loading.remove wire:target="changeOption('messages')" wire:click="changeOption('messages')" class="btn btn-danger btn-sm userMenuBtn text-white" href="#"><i class="fas fa-envelope"></i> Messages</a>
    <a wire:loading wire:target="changeOption('messages')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></i> Messages</a>
    @else
    <a wire:loading.remove wire:target="changeOption('messages')" wire:click="changeOption('messages')" class="btn blackBtn btn-sm userMenuBtn text-white" href="#"><i class="fas fa-envelope"></i> Messages</a>
    <a wire:loading wire:target="changeOption('messages')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></i> Messages</a>
    @endif
    @if($option == 'activity')
    <a wire:loading.remove wire:target="changeOption('activity')" wire:click="changeOption('activity')" class="btn btn-danger btn-sm userMenuBtn text-white" href="#"><i class="fas fa-server"></i> Activity</a>
    <a wire:loading wire:target="changeOption('activity')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></i> Activity</a>
    @else
    <a wire:loading.remove wire:target="changeOption('activity')" wire:click="changeOption('activity')" class="btn blackBtn btn-sm userMenuBtn text-white" href="#"><i class="fas fa-server"></i> Activity</a>
    <a wire:loading wire:target="changeOption('activity')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#"><i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i></i> Activity</a>
    @endif
</div>
@endif
</nav>
<div id="">
    @if($option == 'albums')
    <livewire:admin.album-gestor/>
    @elseif ($option == 'likes')
    <livewire:admin.like-gestor/>
    @elseif ($option == 'tags')
    <livewire:super.tag-gestor />
    @elseif ($option == 'users')
    <livewire:super.user-gestor-table />
    <livewire:super.user-gestor/>
    @elseif ($option == 'messages')
    <i class="text-white">Under Construnction</i>
    @elseif ($option == 'activity')
    <i class="text-white">Under Construnction</i>
    @endif
</div>

</div>
