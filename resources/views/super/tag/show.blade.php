@extends('layouts.app')
@section('content')
<div class="container mt-4">
<livewire:super.attach-tag :albumId="$album->id"/>
</div>
@endsection
