@extends('layouts.userApp')

@section('content')
    <div>
        @livewire('Search', ['searchOn' => 'music'])
    </div>
    <div>
        @livewire('music-list')
    </div>
@endsection
