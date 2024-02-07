@extends('layouts.userApp')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center p-3">
            <h3 class="text__color__primary fs-1 mb-3">
                {{ $playlistName }}
            </h3>
            <form action="{{ route('DeletePlayList') }}" method="POST">
                @csrf
                @method('delete')
                <input type="hidden" name="id" value="{{ $id }}">
                <button class="btn btn-danger" type="submit" onclick="return confirm('از حذف لیست اطمینان دارید؟')">
                    حذف لیست پخش
                </button>
            </form>
        </div>
        <section>
            <ul class="p-0">
                @foreach ($MusicsInPlayList as $Music)
                    <li wire:key="{{ $Music->id }}">
                        @livewire('ListItem', ['type' => 'playlistItem', 'item' => $Music, 'list' => $ListOfIdsforMusicList, 'fromPlaylist' => $id], key('mucom-' . Carbon\Carbon::now()->microsecond))
                    </li>
                @endforeach
            </ul>
        </section>
    </div>
@endsection
