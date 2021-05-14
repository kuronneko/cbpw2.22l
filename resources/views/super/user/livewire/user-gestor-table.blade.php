<div>

    @if ( session('message') )
    <div class="alert alert-info">{{ session('message') }}</div>
  @endif
    <div class="table-responsive">
    <table class="table table-dark table-hover">
        <thead>
            <tr>
            <th scope="col">ID</th>
            <th scope="col">Avatar</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Privileges</th>
            <th scope="col">Last Login</th>
            <th scope="col">Last IP</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <th scope="row">{{ $user->id }}</th>
                <td><img src="{{config('myconfig.img.url')}}{{$user->avatar}}" class="avatarNav" alt="avatar"></td>
                <td>
                    @if ($user->type == config('myconfig.privileges.super'))
                    <strong><a href="#" wire:click.prevent="userEdit({{$user->id}})" class="text-warning"><small>[S] </small>{{ $user->name }}</a></strong>
                    @elseif ($user->type == config('myconfig.privileges.admin'))
                    <strong><a href="#" wire:click.prevent="userEdit({{$user->id}})" class="text-danger"><small>[R] </small>{{ $user->name }}</a></strong>
                    @elseif ($user->type == config('myconfig.privileges.admin++'))
                    <strong><a href="#" wire:click.prevent="userEdit({{$user->id}})" class="text-info"><small>[P] </small>{{ $user->name }}</a></strong>
                    @elseif ($user->type == config('myconfig.privileges.admin+++'))
                    <strong><a href="#" wire:click.prevent="userEdit({{$user->id}})" class="text-success"><small>[P+] </small>{{ $user->name }}</a></strong>
                    @endif
                </td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->type }}</td>
                <td>{{ $user->last_login_at }}</td>
                <td>{{ $user->last_login_ip }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{$users->links()}}
{{-- fin card body --}}

</div>
