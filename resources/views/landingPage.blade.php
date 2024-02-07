@extends('layouts.startApp')

@section('content')
    <section class="stats mt-4" dir="rtl">
        <div class="stats__block">
            @php
                $totalUser = Illuminate\Support\Facades\DB::select('select COUNT(*) as total from users where role <> 3')[0]->total;
            @endphp
            <p class="stats__name">شنونده</p>
            <p class="stats__number" id="number__listen" data-value={{ $totalUser }}></p>
        </div>
        <div class="stats__block">
            @php
                $totalMusic = Illuminate\Support\Facades\DB::table('songs')
                    ->join('users', 'songs.owner_id', 'users.id')
                    ->select('users.role', Illuminate\Support\Facades\DB::raw('COUNT(*) as total'))
                    ->where('users.role', 'artist')
                    ->first()->total;
            @endphp
            <p class="stats__name">موزیک</p>
            <p class="stats__number " id="number__music" data-value={{ $totalMusic }}></p>
        </div>
        <div class="stats__block">
            @php
                $totalArtist = Illuminate\Support\Facades\DB::select('select COUNT(*) as total from users where role = 3')[0]->total;
            @endphp
            <p class="stats__name">هنرمند</p>
            <p class="stats__number" id="number__artist" data-value={{ $totalArtist }}></p>
        </div>
    </section>
    <section class="content__anounced" dir="rtl">
        <h3 class="text__color__primary fs-1 mt-4 mb-2">برترین هنرمندان:</h3>
        <ul class="content__list needs__scroll">
            @php
                $TopArtists = Illuminate\Support\Facades\DB::table('subs')
                    ->join('users', 'users.id', '=', 'subs.artist_id')
                    ->select('users.*', DB::raw('COUNT(*) as total_subs'))
                    ->where('users.role', 'artist')
                    ->groupBy('users.id')
                    ->orderByDesc('total_subs')
                    ->limit(10)
                    ->get();
            @endphp
            @foreach ($TopArtists as $TopArtist)
                <li class="content__list__item">
                    <img src="{{ asset('storage/images/avatars/' . $TopArtist->file_path_profile_img) }}"
                        class="content__list__item__photo">
                </li>
            @endforeach

        </ul>
    </section>
    <section class="content__anounced content__end" dir="rtl">
        <h3 class="text__color__primary fs-1 mt-4 mb-2">برترین آثار:</h3>
        <ul class="content__list needs__scroll">
            @php
                $TopMusics = Illuminate\Support\Facades\DB::table('views')
                    ->join('songs', 'views.music_id', '=', 'songs.id')
                    ->join('users', 'songs.owner_id', '=', 'users.id')
                    ->select('music_id as id', 'users.role', 'songs.owner_id', DB::raw('COUNT(*) as total'))
                    ->where('role', 'artist')
                    ->groupBy('id')
                    ->orderByDesc('total')
                    ->limit(10)
                    ->get();

            @endphp
            @foreach ($TopMusics as $TopView)
                @php
                    $song = App\Models\Song::find($TopView->id);
                @endphp
                <li class="content__list__item">
                    <img src="{{ asset('storage/images/covers/' . $song->img_path_name) }}"
                        class="content__list__item__photo">
                </li>
            @endforeach
        </ul>
    </section>
    <section class="user__starting__panel">
        <div class="">
            <a href="{{ route('login') }}" class="btn__link btn__login">ورود</a>
        </div>
        <div class="">
            <a href="{{ route('register') }}" class="btn__link btn__reg">ثبت نام</a>
        </div>
    </section>
@endsection
