<?php

namespace App\Livewire\Playlist;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class AddToPlayList extends Component
{
    public $img;
    public $name;
    public $id;
    public $targetMusicId;
    public function addToPlaylist()
    {
        try {
            if (DB::table('song_in_playlist')->where('music_id', $this->targetMusicId)->where('list_id', $this->id)->doesntExist()) {
                DB::table('song_in_playlist')->Insert([
                    'list_id' => $this->id,
                    'music_id' => $this->targetMusicId,
                    'updated_at' => Carbon::now()
                ]);
                session()->flash('success', 'با موفقیت به لیست افزوده شد!');
                $this->redirect('/Playlists', navigate: true);
            } else {
                session()->flash('success', 'موزیک در لیست موجود است!');
                $this->redirect('/Playlists', navigate: true);
            }
        } catch (\Throwable $th) {
            session()->flash('error', 'افزودن موزیک با شکست مواجه شد!');
            $this->redirect('/Playlists', navigate: true);
        }
    }
    public function mount($playlist, $musicId)
    {
        $lastMusicInPL = DB::table('song_in_playlist')
            ->select('music_id as id')
            ->where('list_id', $playlist->id)
            ->orderByDesc('updated_at')
            ->first();
        $this->id = $playlist->id;
        $this->targetMusicId = $musicId;
        $this->name = $playlist->name;
        $this->img = 'playlistDef.jpg';
        if (isset($lastMusicInPL->id)) {
            $firstSong = DB::table('songs')
                ->select('img_path_name')
                ->where('id', $lastMusicInPL->id)
                ->first();
            $this->img = $firstSong->img_path_name;
        }
    }
    public function render()
    {
        return view('livewire.playlist.add-to-play-list');
    }
}
