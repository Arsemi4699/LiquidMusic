<div>
    <div wire:click='addToPlaylist' dir="ltr" class="curser__to__pointer list_result_item p-3">
        <div class="music_list_item_info">
            <img class="music_list_item_cover" src="{{asset('storage/images/covers/' . $img)}}" alt="">
            <h4 class="text__color__primary fs-5 lh-sm text-start">{{$name}}</h4>
        </div>
    </div>
</div>
