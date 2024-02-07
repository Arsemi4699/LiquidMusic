@extends('layouts.userApp')

@section('content')
    <section class="mb-5">
        @php
            $ListOfIdsforTopViews = MakeListofIds($TopViews);
        @endphp
        @if (count($TopViews))
            <section class="my-4">
                <h3 class="text__color__primary fs-1 mb-3">پربازدید ترین آهنگ ها هفته:</h3>
                <ul class="d-flex gap-3 needs__scroll p-0" id="most__view__list">
                    @foreach ($TopViews as $TopView)
                        <li wire:key='{{ $TopView->id }}'>
                            @livewire('ListItem', ['type' => 'TopViewed', 'item' => $TopView, "list" => $ListOfIdsforTopViews], key($TopView->id))
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif
        @php
            $ListOfIdsforTopLikes = MakeListofIds($TopLikes);
        @endphp
        @if (count($TopLikes))
            <section class="my-4">
                <h3 class="text__color__primary fs-1 mb-3">محبوب ترین آهنگ ها هفته:</h3>
                <ul class="d-flex gap-3 needs__scroll p-0" id="most__liked__list">
                    @foreach ($TopLikes as $TopLike)
                        <li wire:key='{{ $TopView->id }}'>
                            @livewire('ListItem', ['type' => 'TopLiked', 'item' => $TopLike, "list" => $ListOfIdsforTopLikes], key($TopView->id))
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif
    </section>
    <section>
        @if (count($TopArtists))
            <section class="my-4">
                <h3 class="text__color__primary fs-1 mb-3">محبوب ترین هنرمندان:</h3>
                <ul class="d-flex gap-3 needs__scroll p-0" id="top_artists__list">
                @foreach ($TopArtists as $TopArtist)
                    <li>
                        <a class="top__artist__card text__color__dark text-decoration-none text__color__primary" wire:navigate href="{{ route('user.artistShow',['id' => $TopArtist->id]) }}">
                            <img class="top__artist__card__img" src="{{ asset('storage/images/avatars/' . $TopArtist->file_path_profile_img) }}" alt="">
                            <div class="top__artist__card__info" >
                                <div>
                                    <h4 class="top__artist__card__info__music fw-bold fs-3 text__color__dark" >{{$TopArtist->name}}</h4>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-bookmark-star-fill no__line__height fs-3 text__color__dark"></i>
                                    <span class="no__line__height fs-3 text__color__dark" >{{$TopArtist->total_subs}}</span>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
                </ul>
            </section>
        @endif
    </section>
@endsection

@section('script__content')
    freeScroll('most__view__list');
    freeScroll('most__liked__list');
    freeScroll('top_artists__list');
    freeScroll('playlist__recent__list');
    freeScroll('recently__viewed__list');
@endsection
