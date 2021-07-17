<div>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4 text-white">
@if(Auth::check() && Auth::user()->type == config('myconfig.privileges.super'))
<div class="btn-group btn-block">
    @if($option == 'albums')
    <a wire:click="changeOption('albums')" class="btn btn-danger btn-sm userMenuBtn text-white " href="#content"><i class="fas fa-book"></i> Albums</a>
    @else
    <a wire:click="changeOption('albums')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#content"><i class="fas fa-book"></i> Albums</a>
    @endif
    @if($option == 'likes')
    <a wire:click="changeOption('likes')" class="btn btn-danger btn-sm userMenuBtn text-white" href="#content"><i class="fas fa-heart"></i> Likes</a>
    @else
    <a wire:click="changeOption('likes')" class="btn blackBtn btn-sm userMenuBtn text-white" href="#content"><i class="fas fa-heart"></i> Likes</a>
    @endif

    @if($option == 'tags')
    <a wire:click="changeOption('tags')" class="btn btn-danger btn-sm userMenuBtn text-white " href="#content"><i class="fas fa-tags"></i> Tags</a>
    @else
    <a wire:click="changeOption('tags')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#content"><i class="fas fa-tags"></i> Tags</a>
    @endif
    @if($option == 'users')
    <a wire:click="changeOption('users')" class="btn btn-danger btn-sm userMenuBtn text-white " href="#content"><i class="fas fa-users"></i> Users</a>
    @else
    <a wire:click="changeOption('users')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#content"><i class="fas fa-users"></i> Users</a>
    @endif

    @if($option == 'messages')
    <a wire:click="changeOption('messages')" class="btn btn-danger btn-sm userMenuBtn text-white" href="#content"><i class="fas fa-envelope"></i> Messages</a>
    @else
    <a wire:click="changeOption('messages')" class="btn blackBtn btn-sm userMenuBtn text-white" href="#content"><i class="fas fa-envelope"></i> Messages</a>
    @endif
    @if($option == 'activity')
    <a wire:click="changeOption('activity')" class="btn btn-danger btn-sm userMenuBtn text-white" href="#content"><i class="fas fa-server"></i> Activity</a>
    @else
    <a wire:click="changeOption('activity')" class="btn blackBtn btn-sm userMenuBtn text-white" href="#content"><i class="fas fa-server"></i> Activity</a>
    @endif
</div>
@else
<div class="btn-group btn-block">
    @if(auth()->user()->type != config('myconfig.privileges.usewr'))
    @if($option == 'albums')
    <a wire:click="changeOption('albums')" class="btn btn-danger btn-sm userMenuBtn text-white " href="#content"><i class="fas fa-book"></i> Albums</a>
    @else
    <a wire:click="changeOption('albums')" class="btn blackBtn btn-sm userMenuBtn text-white " href="#content"><i class="fas fa-book"></i> Albums</a>
    @endif
    @else
    <a class="btn blackBtn btn-sm userMenuBtn text-white disabled" href="#content"><i class="fas fa-book"></i> Albums</a>
    @endif

    @if($option == 'likes')
    <a wire:click="changeOption('likes')" class="btn btn-danger btn-sm userMenuBtn text-white" href="#content"><i class="fas fa-heart"></i> Likes</a>
    @else
    <a wire:click="changeOption('likes')" class="btn blackBtn btn-sm userMenuBtn text-white" href="#content"><i class="fas fa-heart"></i> Likes</a>
    @endif
    @if($option == 'messages')
    <a wire:click="changeOption('messages')" class="btn btn-danger btn-sm userMenuBtn text-white" href="#content"><i class="fas fa-envelope"></i> Messages</a>
    @else
    <a wire:click="changeOption('messages')" class="btn blackBtn btn-sm userMenuBtn text-white" href="#content"><i class="fas fa-envelope"></i> Messages</a>
    @endif
    @if($option == 'activity')
    <a wire:click="changeOption('activity')" class="btn btn-danger btn-sm userMenuBtn text-white" href="#content"><i class="fas fa-server"></i> Activity</a>
    @else
    <a wire:click="changeOption('activity')" class="btn blackBtn btn-sm userMenuBtn text-white" href="#content"><i class="fas fa-server"></i> Activity</a>
    @endif
</div>
@endif
</nav>

<div id="content">
    @if($option == 'albums')
    <livewire:admin.album-gestor/>
    @elseif ($option == 'likes')
    <livewire:admin.like-gestor/>
    @elseif ($option == 'tags')
    <div class="card text-white">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Tag Gestor</span>
        </div>
        <div class="card-body">
            <livewire:super.tag-gestor />
        </div>
    </div>
    @elseif ($option == 'users')
    <div class="card text-white">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Users Gestor</span>
        </div>
        <div class="card-body">
            <livewire:super.user-gestor-table />
            <livewire:super.user-gestor/>
        {{-- fin card body --}}
        </div>
    </div>
    @elseif ($option == 'messages')
    <span class="text-white">Under Construnction</span>
    @elseif ($option == 'activity')
    <span class="text-white">Under Construnction</span>
    @endif
</div>

</div>
