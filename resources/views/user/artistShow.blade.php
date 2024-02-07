@extends('layouts.userApp')

@section('content')
    @livewire('artist-profile', ['artist' => $Artist])
    <section>
        <h4 class="text__color__primary fs-1 mb-3 me-3">جدید ترین آثار:</h4>
        <ul class="p-0">
            @foreach ($MusicList as $Music)
                <li>
                    @livewire('ListItem', ['type' => 'ListItem', 'item' => $Music, "list" => $ListOfIdsforMusicList])
                </li>
            @endforeach
        </ul>
    </section>
@endsection
