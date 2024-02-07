<div>
    @if ($song)
        <div class="curser__to__pointer ItIsAMusic" wire:contextmenu='moreOptions'>
            @if ($type == 'TopViewed' || $type == 'TopLiked')
                <div class="top__card" wire:click='sendingMusicToPlayer({{ $song->id }})'>
                    <img class="top__card__img" src="{{ asset('storage/images/covers/' . $song->img_path_name) }}" alt="">
                    <div class="top__card__info" >
                        <div>
                            <h4 class="top__card__info__music fw-bold fs-3" >{{$song->name}}</h4>
                            <h4 class="top__card__info__artist fs-3">{{ $artist }}</h4>
                        </div>
                        <div class="d-flex align-items-center gap-2 position-absolute bottom-0 start-0 p-3">
                            <span class="no__line__height fs-3 text__color__side" >{{$cnt}}</span>
                            <i class="bi @if ($type == 'TopViewed')
                            bi-eye-fill
                            @else
                            bi-heart-fill
                            @endif  no__line__height fs-3 text__color__side"></i>
                        </div>
                    </div>
                </div>
            @elseif ($type == 'ListItem')
                <div dir="ltr" class="music_list_item" wire:click='sendingMusicToPlayer({{ $song->id }})'>
                    <div class="music_list_item_info">
                        <img class="music_list_item_cover" src="{{ asset('storage/images/covers/' . $song->img_path_name) }}" alt="">
                        <div class="music_list_item_names">
                            <h4  class="text__color__primary fs-5 lh-sm text-start" >{{$song->name}}</h4>
                            <span class="text__color__primary fs-6 lh-sm text-start">{{ $artist }}</span>
                        </div>
                    </div>
                    <div class="music_list_item_time">
                        <span dir="rtl" class="text__color__primary fs-6 mx-1 no__line__height">
                            {{timeToAgo($song->created_at)}}
                        </span>
                        <span class="text__color__primary fs-5 mx-1 no__line__height">
                            {{TimeFormat($song->file_duration)}}
                        </span>
                    </div>
                </div>
            @elseif ($type == 'searchMusicItem')
                <h4 class="text__color__primary fs-5 lh-sm text-nowrap" wire:click='sendingMusicToPlayer({{ $song->id }})'>{{ $song->name }}</h4>
            @elseif ($type == 'snapRViewsItem')
                <div class="d-flex justify-content-between align-items-center" wire:click='sendingMusicToPlayer({{ $song->id }})'>
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('storage/images/covers/' . $song->img_path_name) }}" class="viewed__music__li__photo"></img>
                        <div class="list__text__wrap">
                            <p class="text__color__primary fs-4 lh-sm">{{$song->name}}</p>
                            <p class="text__color__side fs-4s text-nowrap">{{$artist}}</p>
                        </div>
                    </div>
                    @php
                        $seenSince = Illuminate\Support\Facades\DB::table('views')
                        ->select('*')
                        ->where('user_id', Auth::user()->id)
                        ->where('music_id', $song->id)
                        ->first();
                    @endphp
                    <span class="text__color__side fs-5 last__time">{{timeToAgo($seenSince->updated_at)}}</span>
                </div>
            @elseif ($type == 'ListItemLiked')
                <div dir="ltr" class="music_list_item">
                    <div class="music_list_item_info" wire:click='sendingMusicToPlayer({{ $song->id }})'>
                        <img class="music_list_item_cover" src="{{ asset('storage/images/covers/' . $song->img_path_name) }}" alt="">
                        <div class="music_list_item_names">
                            <h4  class="text__color__primary fs-5 lh-sm text-start" >{{$song->name}}</h4>
                            <span class="text__color__primary fs-6 lh-sm text-start">{{ $artist }}</span>
                        </div>
                    </div>
                    <div>
                        <i wire:click='likeDislikeMusic' class="curser__to__pointer bi @if($liked) bi-heart-fill @else bi-heart @endif fs-2 text__color__primary"></i>
                    </div>
                </div>
            @elseif ($type == 'ListItemViewed')
                <div dir="ltr" class="music_list_item" wire:click='sendingMusicToPlayer({{ $song->id }})'>
                    <div class="music_list_item_info">
                        <img class="music_list_item_cover" src="{{ asset('storage/images/covers/' . $song->img_path_name) }}" alt="">
                        <div class="music_list_item_names">
                            <h4  class="text__color__primary fs-5 lh-sm text-start" >{{$song->name}}</h4>
                            <span class="text__color__primary fs-6 lh-sm text-start">{{ $artist }}</span>
                        </div>
                    </div>
                    <div class="music_list_item_time">
                        <span dir="rtl" class="text__color__primary fs-6 mx-1 no__line__height">
                            @php
                            $seenSince = Illuminate\Support\Facades\DB::table('views')
                            ->select('*')
                            ->where('user_id', Auth::user()->id)
                            ->where('music_id', $song->id)
                            ->first();
                            @endphp
                            {{timeToAgo($seenSince->updated_at)}}
                        </span>
                    </div>
                </div>
            @elseif ($type == 'playlistItem')
                <div dir="ltr" class="music_list_item">
                    <div class="music_list_item_info" wire:click='sendingMusicToPlayer({{ $song->id }})'>
                        <img class="music_list_item_cover" src="{{ asset('storage/images/covers/' . $song->img_path_name) }}" alt="">
                        <div class="music_list_item_names">
                            <h4  class="text__color__primary fs-5 lh-sm text-start" >{{$song->name}}</h4>
                            <span class="text__color__primary fs-6 lh-sm text-start">{{ $artist }}</span>
                        </div>
                    </div>
                    <div>
                        <i wire:click='RemoveFromPlayList' class="curser__to__pointer bi bi-x-square fs-4 text-danger"></i>
                    </div>
                </div>
            @elseif ($type == 'beatsItem')
                <div dir="ltr" class="music_list_item">
                    <div class="music_list_item_info" wire:click='sendingMusicToPlayer({{ $song->id }})'>
                        <img class="music_list_item_cover" src="{{ asset('storage/images/covers/' . $song->img_path_name) }}" alt="">
                        <div class="music_list_item_names">
                            <h4  class="text__color__primary fs-5 lh-sm text-start" >{{$song->name}}</h4>
                            <span class="text__color__primary fs-6 lh-sm text-start">{{ $artist }}</span>
                        </div>
                    </div>
                    <div>
                        <i wire:click='RemoveFromBeats' wire:confirm="از حذف موزیک {{$song->name}} اطمینان دارید؟" class="curser__to__pointer bi bi-x-square fs-4 text-danger"></i>
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
