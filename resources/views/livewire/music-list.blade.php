<div>
    <div class="top_list_controller" dir="ltr">
        <button wire:click='getMusicByViews' class="top_list_controller_btn @if ($gettingType == 1) selected_btn @endif" id="TopViewsBtn">بازدید</button>
        <button wire:click='getMusicByLikes' class="top_list_controller_btn @if ($gettingType == 2) selected_btn @endif" id="TopLikesBtn">علاقه مندی</button>
        <button wire:click='getMusicRandom' class="top_list_controller_btn @if ($gettingType == 3) selected_btn @endif" id="RandomBtn">تصادفی</button>
    </div>
    <section>
        <ul class="p-0">
            @foreach ($MusicList as $Music)
                <li wire:key="{{$Music->id}}">
                    @livewire('ListItem', ['type' => 'ListItem', 'item' => $Music, "list" => $ListOfIdsforMusicList], key('mucom-' . Carbon\Carbon::now()->microsecond))
                </li>
            @endforeach
        </ul>
    </section>
</div>
