<div>
        <div class="btn-group btn-block mb-4">
            @if(auth()->user()->type != config('myconfig.privileges.usewr'))
            @if($option == 'albums')
            <a wire:click="changeOption('albums')" class="btn btn-dark btn-sm " href="#"><i class="fas fa-book"></i> Albums</a>
            @else
            <a wire:click="changeOption('albums')" class="btn btn-danger btn-sm " href="#"><i class="fas fa-book"></i> Albums</a>
            @endif
            @else
            <a class="btn btn-danger btn-sm disabled" href="#"><i class="fas fa-book"></i> Albums</a>
            @endif

            @if($option == 'likes')
            <a wire:click="changeOption('likes')" class="btn btn-dark btn-sm" href="#"><i class="fas fa-heart"></i> Likes</a>
            @else
            <a wire:click="changeOption('likes')" class="btn btn-danger btn-sm" href="#"><i class="fas fa-heart"></i> Likes</a>
            @endif
            @if($option == 'messages')
            <a wire:click="changeOption('messages')" class="btn btn-dark btn-sm" href="#"><i class="fas fa-envelope"></i> Messages</a>
            @else
            <a wire:click="changeOption('messages')" class="btn btn-danger btn-sm" href="#"><i class="fas fa-envelope"></i> Messages</a>
            @endif
            @if($option == 'activity')
            <a wire:click="changeOption('activity')" class="btn btn-dark btn-sm" href="#"><i class="fas fa-server"></i> Activity</a>
            @else
            <a wire:click="changeOption('activity')" class="btn btn-danger btn-sm" href="#"><i class="fas fa-server"></i> Activity</a>
            @endif
        </div>

        @if($option == 'albums')
        <livewire:admin.album-gestor/>
        @elseif ($option == 'likes')
        <livewire:admin.like-gestor/>
        @elseif ($option == 'messages')

        @elseif ($option == 'activity')

        @endif

</div>
