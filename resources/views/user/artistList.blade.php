@extends('layouts.userApp')

@section('content')
    <div>
        @livewire('Search', ['searchOn' => 'artist'])
    </div>
    <div>
        @livewire('artist-list')
    </div>
@endsection
