<!doctype html>
<html lang="fa">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="{{ url('favicon.ico') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @yield('heading')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @livewireStyles
</head>

<body class="bg__color__primary vh-100">
    <div id="contextMenu">
        <div dir="rtl" class="d-flex flex-column">
            <div id="contextMenuAddQ" class="curser__to__pointer">
                <i class="bi bi-play-fill"></i>
                <span>افزودن به صف</span>
            </div>
            <div class="curser__to__pointer">
                <a wire:navigate href="{{ route('AddToPlayList', ['id' => '-1']) }}" id="contextMenuAddL"
                    class="text-decoration-none text__color__side">
                    <i class="bi bi-plus-square"></i>
                    <span>افزودن به لیست ها</span>
                </a>
            </div>
            <div class="curser__to__pointer">
                <a wire:navigate href="{{ route('ReportMusic', ['id' => '-1']) }}" id="contextMenuReport"
                    class="text-decoration-none text__color__side">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span>گزارش تخلف</span>
                </a>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div id="musicPlayerInjection">
            @persist('music_control_box')
                <div id="MiniPop">
                    <div class="p-3 music__player" id="popUpContainer">
                        <div class="d-flex justify-content-evenly mb-3 p-2 align-items-center">
                            <i id="sec__next__btn"
                                class="bi bi-skip-backward fs-1 text__color__primary next__prev__vis curser__to__pointer"></i>
                            <a id="sec__plist__btn" wire:navigate href="{{ route('AddToPlayList', ['id' => '-1']) }}"
                                class="text-decoration-none">
                                <i
                                    class="next__prev__vis curser__to__pointer bi bi-plus-square fs-2 text__color__primary"></i>
                            </a>
                            <i id="sec__like__btn"
                                class="next__prev__vis curser__to__pointer bi bi-heart fs-2 text__color__primary"></i>
                            <i id="sec__mode__btn"
                                class="next__prev__vis curser__to__pointer bi-arrow-clockwise fs-2 text__color__primary"></i>
                            <i id="sec__prev__btn"
                                class="bi bi-skip-forward fs-1 text__color__primary next__prev__vis curser__to__pointer"></i>
                        </div>
                        <div class="w-100 d-flex align-items-center justify-content-between p-1">
                            <span class="text__color__primary fs-4 m-2 no__line__height"
                                id="sec__player__currentTime">0:0:0</span>
                            <input type="range" class="player__slider" id="sec__player__slider" max=""
                                min="0" value="0">
                            <span class="text__color__primary fs-4 m-2 no__line__height"
                                id="sec__player__totalTime">0:0:0</span>
                        </div>
                    </div>
                </div>
                <livewire:music-player.player />
            @endpersist
        </div>
        <div id="app" class="main__flow h-100">
            <div class="side__menu__left bg__color__secondary" dir="rtl">
                <div class="row">
                    <div class="profile__container">
                        <span class="text__color__primary fs-3 fw-bold">{{ Auth::user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST">@csrf<button class="exit__btn"
                                type="submit"><i
                                    class="bi bi-box-arrow-left text__color__primary fs-3 inline-block"></i></button>
                        </form>
                    </div>
                </div>
                <div class="row">
                    @if (Auth::user()->role != 'subscriber')
                        <div class="alert alert-warning pb-1 pt-3 mb-0 mt-1">
                            <a wire:navigate href=" {{ route('subscriptionPlans') }} " class="text-decoration-none">
                                <p class="text-secondary fs-3 fw-bold lh-sm text-center">هنوز اشتراک تهیه نکردی؟!</p>
                            </a>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
                        <span class="text__color__primary fs-2 fw-bolder">پخش اخیر</span>
                        <a wire:navigate href="{{ route('ViewedMusics') }}" class="text-decoration-none">
                            <span class="text__color__side fs-4">نمایش همه</span>
                        </a>
                    </div>
                    <ul class="list-unstyled d-flex gap-2 side__menu__list needs__scroll" id="recently__viewed__list">
                        @php
                            $recentlyViews = Illuminate\Support\Facades\DB::table('views')
                                ->select('user_id', 'music_id as id', 'updated_at')
                                ->where('user_id', Auth::user()->id)
                                ->orderByDesc('updated_at')
                                ->limit(3)
                                ->get();
                            $ListOfIdsforrecentlyViews = MakeListofIds($recentlyViews);
                        @endphp
                        @foreach ($recentlyViews as $recentlyView)
                            <li wire:key="{{ $recentlyView->id }}">
                                @livewire('ListItem', ['type' => 'snapRViewsItem', 'item' => $recentlyView, 'list' => $ListOfIdsforrecentlyViews], key($recentlyView->id))
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="row">
                    <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
                        <span class="text__color__primary fs-2 fw-bolder">لیست پخش</span>
                        <a wire:navigate href="{{ route('PlayLists') }}" class="text-decoration-none">
                            <span class="text__color__side fs-4">نمایش همه</span>
                        </a>
                    </div>
                    <ul class="d-flex gap-2 side__menu__list needs__scroll" id="playlist__recent__list">
                        @php
                            $Playlists = DB::table('playlists')
                                ->select('name', 'id')
                                ->where('owner_id', Auth::user()->id)
                                ->limit(3)
                                ->get();
                        @endphp
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
                            <li class="d-flex justify-content-between align-items-center">
                                <a dir="rtl" wire:navigate
                                    href="{{ route('APlayList', ['id' => $playlist->id]) }}" dir="ltr"
                                    class="list_result_item p-0">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/images/covers/' . $img) }}"
                                            class="viewed__music__li__photo"></img>
                                        <div class="list__text__wrap">
                                            <p class="text__color__primary fs-3">{{ $playlist->name }}</p>
                                            <p class="text__color__side fs-3 text-nowrap">
                                                {{ $countMusics . ' آهنگ ' }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                        <a wire:navigate href="{{ route('NewPlayList') }}"
                            class="xxl-d-block xxl-w-100 text-decoration-none">
                            <button class="w-100 new__playlist__btn fs-3">لیست جدید</button>
                            <div>
                                <i class="bi bi-plus-square-fill new__playlist__btn__i fs-1 text__color__primary"></i>
                            </div>
                        </a>
                    </ul>
                </div>
            </div>
            <div class="bg__color__primary content__frame" dir="rtl">
                @if (session('doneTrans'))
                    <div class="alert alert-success">
                        {{ session('doneTrans') }}
                    </div>
                @endif
                @if (session('errorOnTrans'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('errorOnTrans') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" dir="rtl">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success" dir="rtl">
                        {{ session('success') }}
                    </div>
                @endif
                @yield('content')
            </div>
            <div class="side__menu__right bg__color__secondary" dir="rtl">
                <div class="logo__container">
                    <img class="logo" src="{{ url('images/fav__icon.png') }}" alt="liquidMusic">
                    <h1 class="logo__title text__color__secondary">Liquid Music</h1>
                </div>
                <span class="menu__header">منو</span>
                <ul class="menu">
                    <li class="menu__item">
                        <a wire:navigate href="{{ route('home') }}" class="text-decoration-none">
                            <i class="bi bi-house text__color__secondary"></i>
                            <span class="menu__item__title text__color__primary">صفحه اصلی</span>
                        </a>
                    </li>
                    <li class="menu__item">
                        <a wire:navigate href="{{ route('MusicList') }}" class="text-decoration-none">
                            <i class="bi bi-search text__color__secondary"></i>
                            <span class="menu__item__title text__color__primary">جستجو آهنگ</span>
                        </a>
                    </li>
                    <li class="menu__item">
                        <a wire:navigate href="{{ route('artistList') }}" class="text-decoration-none">
                            <i class="bi bi-person-up text__color__secondary"></i>
                            <span class="menu__item__title text__color__primary">هنرمندان</span>
                        </a>
                    </li>
                </ul>
                <span class="menu__header">آهنگ های من</span>
                <ul class="menu">
                    <li class="menu__item">
                        <a wire:navigate href="{{ route('LikedMusics') }}" class="text-decoration-none">
                            <i class="bi bi-heart text__color__secondary"></i>
                            <span class="menu__item__title text__color__primary">علاقه مندی</span>
                        </a>
                    </li>
                    <li class="menu__item">
                        <a wire:navigate href="{{ route('BeatsCloud') }}" class="text-decoration-none">
                            <i class="bi bi-cloud text__color__secondary"></i>
                            <span class="menu__item__title text__color__primary">بیتس کلود</span>
                        </a>
                    </li>
                    <li class="menu__item">
                        <a wire:navigate href="{{ route('FollowededArtist') }}" class="text-decoration-none">
                            <i class="bi bi-bookmark-star text__color__secondary"></i>
                            <span class="menu__item__title text__color__primary">دنبال شده</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @livewireScripts

    <script>
        @yield('script__content')

        function freeScroll(list_id) {
            const ele = document.getElementById(list_id);
            if (ele == null)
                return
            ele.style.cursor = 'grab';

            let pos = {
                top: 0,
                left: 0,
                x: 0,
                y: 0
            };

            const mouseDownHandler = function(e) {
                ele.style.cursor = 'grabbing';
                ele.style.userSelect = 'none';

                pos = {
                    left: ele.scrollLeft,
                    top: ele.scrollTop,
                    // Get the current mouse position
                    x: e.clientX,
                    y: e.clientY,
                };

                document.addEventListener('mousemove', mouseMoveHandler);
                document.addEventListener('mouseup', mouseUpHandler);
            };

            const mouseMoveHandler = function(e) {
                // How far the mouse has been moved
                const dx = e.clientX - pos.x;
                const dy = e.clientY - pos.y;

                // Scroll the element
                ele.scrollTop = pos.top - dy;
                ele.scrollLeft = pos.left - dx;
            };

            const mouseUpHandler = function() {
                ele.style.cursor = 'grab';
                ele.style.removeProperty('user-select');

                document.removeEventListener('mousemove', mouseMoveHandler);
                document.removeEventListener('mouseup', mouseUpHandler);
            };

            // Attach the handler
            ele.addEventListener('mousedown', mouseDownHandler);

        }
    </script>

</body>

</html>
