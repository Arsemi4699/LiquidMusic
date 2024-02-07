<div>
    <div id="searchBar">
        <div class="search_bar">
            <input dir="ltr" class="search_bar_input" wire:model.live='searchQ' type="text">
            <i  class="bi-search text__color__secondary search_bar_icon"></i>
        </div>
        @if (count($result) && strlen($searchQ) > 0)
            <div class="search_bar bg__color__secondary flex-column " id="searchBarRes">
                @foreach ($result as $sresult)
                    @if ($searchOn == 'artist')
                        <a wire:navigate href="{{ route('user.artistShow',['id' => $sresult->id]) }}" dir="ltr" class="search_result_item" wire:key="arta{{$sresult->id}}">{{ $sresult->name }}</a>
                    @elseif ($searchOn == 'music')
                    <div dir="ltr" class="search_result_item" wire:key="musdiv-{{$sresult->id}}">
                        @livewire('ListItem', ['type' => 'searchMusicItem', 'item' => $sresult, "list" => [$sresult->id]], key('muscom-' . Carbon\Carbon::now()->microsecond))
                    </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
