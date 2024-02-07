<div>
    @if ($musicId != null)
    <section class="music__player" id="player__container">
        <div class="row justify-content-between" id="player__wraper">
            <div class="col-3 d-flex align-items-center gap-4">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('storage/images/covers/' . $imgPath) }}" class="music__player__photo"></img>
                    <div class="d-flex justify-content-between flex-column">
                        <p class="text__color__primary fs-2 text-nowrap" id="music__player__name">{{ $name }}</p>
                        <p class="text__color__side fs-3 text-nowrap" id="music__player__artist">{{ $owner }}</p>
                    </div>
                </div>
                <div class="add__like__playlist">
                    <i wire:click='likeDislikeMusic' id="like__btn" class="curser__to__pointer bi @if ($Liked) bi-heart-fill @else bi-heart @endif fs-2 text__color__primary"></i>
                    <a wire:navigate href="{{ route('AddToPlayList',['id' => $musicId]) }}" class="text-decoration-none">
                        <i class="curser__to__pointer bi bi-plus-square fs-2 text__color__primary"></i>
                    </a>
                    <i wire:click='changeMode' id="mode__btn" class="curser__to__pointer bi @if ($mode == 0) bi-music-note @elseif ($mode == 1) bi-arrow-clockwise @elseif ($mode == 2) bi-music-note-list @elseif ($mode == 3) bi-shuffle @endif fs-2 text__color__primary"></i>
                </div>
            </div>
            <div class="col-6" id="music__control">
                <div class="btns__pack">
                    <i id="next__btn" wire:click='nextMusic' class="bi bi-skip-backward fs-1 text__color__primary next__prev curser__to__pointer"></i>
                    <i id="play__btn" wire:click='pausePlayMusic' class="bi @if ($isPlaying) bi-pause-circle-fill @else bi-play-circle-fill @endif text__color__primary" ></i>
                    <i id="prev__btn" wire:click='prevMusic' class="bi bi-skip-forward fs-1 text__color__primary next__prev curser__to__pointer"></i>
                </div>
                <div class="w-100 d-flex align-items-center justify-content-between player__slider__pack p-1">
                    <span wire:ignore class="text__color__primary fs-4 m-2 no__line__height" id="player__currentTime">0:0:0</span>
                    <input wire:ignore type="range" class="player__slider" id="player__slider" max="{{$fileDuration}}">
                    <span class="text__color__primary fs-4 m-2 no__line__height" id="player__totalTime">{{TimeFormat($fileDuration)}}</span>
                </div>
            </div>
            <div wire:ignore class="col-3" id="sound__control">
                <i class="bi fs-1 text__color__primary " id="sound__speaker"></i>
                <input type="range" min="0" max="100" value="100" class="player__slider" id="sound__slider">
            </div>
        </div>
    </section>
    @endif
</div>

