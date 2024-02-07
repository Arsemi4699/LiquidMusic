@extends('layouts.userApp')

@section('content')
    <div>
        <h3 class="text__color__primary fs-1 mb-3">
            @isset($Liked) لیست علاقه مندی ها: @endisset
            @isset($Viewed) پخش اخیر: @endisset
            </h3>
        <ul class="p-0">
            @isset($Liked)
                @foreach ($Liked as $LikedItem)
                <li wire:key="{{$LikedItem->id}}">
                    @livewire('ListItem', ['type' => 'ListItemLiked', 'item' => $LikedItem, "list" => $ListOfIdsforLiked], key($LikedItem->id))
                </li>
                @endforeach
            @endisset
            @isset($Viewed)
                @foreach ($Viewed as $ViewedItem)
                    <li wire:key="{{$ViewedItem->id}}">
                        @livewire('ListItem', ['type' => 'ListItemViewed', 'item' => $ViewedItem, "list" => $ListOfIdsforViewed], key($ViewedItem->id))
                    </li>
                @endforeach
            @endisset

        </ul>
    </div>
@endsection
