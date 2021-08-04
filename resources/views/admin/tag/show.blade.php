@extends('layouts.app')
@section('content')
<div class="container mt-4">
<livewire:admin.attach-tag :albumId="$album->id"/>
</div>
@endsection
