@extends('layouts.userApp')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center p-3">
            <h3 class="text__color__primary fs-1 mb-3">
                لیست های پخش:
            </h3>
            <a wire:navigate href="{{ route('NewPlayList') }}" class="xxl-d-block xxl-w-100 text-decoration-none">
                <button class="static__new__playlist__btn fs-4">لیست جدید</button>
                <div>
                    <i class="bi bi-plus-square-fill new__playlist__btn__i fs-1 text__color__primary"></i>
                </div>
            </a>
        </div>
        @foreach ($Playlists as $playlist)
            @php
                $lastMusicInPL = DB::table('song_in_playlist')
                    ->select('music_id as id')
                    ->where('list_id', $playlist->id)
                    ->orderByDesc('updated_at')
                    ->first();
                $img = 'playlistDef.jpg';
                if (isset($lastMusicInPL->id)) {
                    $firstSong = DB::table('songs')
                        ->select('img_path_name')
                        ->where('id', $lastMusicInPL->id)
                        ->first();
                    $img = $firstSong->img_path_name;
                }

                $countMusics = DB::table('song_in_playlist')
                    ->where('list_id', $playlist->id)
                    ->count();
            @endphp
            <a wire:navigate href="{{ route('APlayList', ['id' => $playlist->id]) }}" dir="ltr"
                class="list_result_item p-3">
                <div class="music_list_item_info">
                    <img class="music_list_item_cover" src="{{ asset('storage/images/covers/' . $img) }}" alt="">
                    <h4 class="text__color__primary fs-5 lh-sm text-start">{{ $playlist->name }}</h4>
                </div>
                <div>
                    <h4 dir="rtl" class="text__color__primary fs-5 lh-sm text-start">{{ $countMusics . ' آهنگ ' }}</h4>
                </div>
            </a>
        @endforeach
    </div>
@endsection
