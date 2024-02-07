<div>
    <div class="artist_page">
        <div class="artist_page_sub">
            <i wire:click='SubUnSubArtist' class="curser__to__pointer bi @if ($subed) bi-bookmark-star-fill @else bi-bookmark-star @endif fs-1 text__color__primary"></i>
        </div>
        <div class="artist_page_info">
            <h3 class="text__color__primary artist_page_name" >{{ $artist_name }}</h3>
            <img src=" {{ asset('storage/images/avatars/' . $artist_img) }} " alt="" class="artist_page_profile">
        </div>
    </div>
</div>
