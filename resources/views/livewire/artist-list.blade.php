<div>
    <div class="top_list_controller" dir="ltr">
        <button wire:click='getArtistByViews' class="top_list_controller_btn @if ($gettingType == 1)
            selected_btn
        @endif" id="TopViewsBtn">بازدید</button>
        <button wire:click='getArtistByLikes' class="top_list_controller_btn @if ($gettingType == 2)
        selected_btn
    @endif" id="TopLikesBtn">علاقه مندی</button>
        <button wire:click='getArtistBySubs' class="top_list_controller_btn @if ($gettingType == 3)
        selected_btn
    @endif" id="TopSubsBtn">دنبال کننده</button>
        <button wire:click='getArtistRandom' class="top_list_controller_btn @if ($gettingType == 4)
        selected_btn
    @endif" id="RandomBtn">تصادفی</button>
    </div>
    <section>
        @foreach ($ArtistList as $Artist)
        <a  wire:navigate href="{{ route('user.artistShow',['id' => $Artist->id]) }}" dir="ltr" class="list_result_item">
            <div class="list_result_item_info">
                <img class="list_result_item_avatar" src="{{ asset('storage/images/avatars/' . $Artist->file_path_profile_img) }}" alt="">
                <p class="text__color__primary fs-5 lh-sm">{{ $Artist->name }}</p>
            </div>
            <div class="list_result_item_count">
                @if ($gettingType == 1)
                    <p class="text__color__primary fs-5 lh-sm">{{ $Artist->total_views }}</p>
                @elseif ($gettingType == 2)
                    <p class="text__color__primary fs-5 lh-sm">{{ $Artist->total_likes }}</p>
                @elseif ($gettingType == 3)
                    <p class="text__color__primary fs-5 lh-sm">{{ $Artist->total_subs }}</p>
                @endif
            </div>
        </a>
        @endforeach
    </section>
</div>
