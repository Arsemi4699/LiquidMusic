<?php

namespace App\Livewire\Playlist;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CreatePlayList extends Component
{
    #[Rule('required')]
    public $title;

    public $musicId = null;

    public function store()
    {
        $this->validate();
        DB::table('playlists')->Insert([
            'owner_id' => Auth::user()->id,
            'name' => $this->title,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        if ($this->musicId) {
            $list_id = DB::table('playlists')
                ->where('owner_id', Auth::user()->id)
                ->first()->id;
            DB::table('song_in_playlist')->Insert([
                'list_id' => $list_id,
                'music_id' => $this->musicId,
                'updated_at' => Carbon::now()
            ]);
        }
        session()->flash('success', 'لیست با موفقیت افزوده شد!');
        $this->redirect('/Playlists', navigate: true);
    }
    public function mount($musicId = null)
    {
        $this->musicId = $musicId;
    }
    public function render()
    {
        return view('livewire.playlist.create-play-list');
    }
}
