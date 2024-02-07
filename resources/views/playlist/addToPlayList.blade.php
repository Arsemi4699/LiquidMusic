@extends('layouts.userApp')

@section('content')
    <div>
        <h3 class="text__color__primary fs-1 mb-3">
            افزودن به لیست پخش:
            </h3>
        @foreach ($Playlists as $playlist)
            @livewire('playlist.add-to-play-list', ['playlist' => $playlist, 'musicId' => $musicId])
        @endforeach
    </div>
@endsection
