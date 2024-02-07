<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Song;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Livewire\MusicPlayer\Player;
use Illuminate\Support\Facades\Auth;

class ListItem extends Component
{

    public $type;
    public $song;
    public $list;
    public $cnt;
    public $artist;
    public $liked;
    public $fromPlaylist = null;

    public function moreOptions()
    {
        $user = Auth::user();
        $artist_id = $this->song->owner_id;
        if ($user->role == 'subscriber' || ($user->role == 'basic' && ($user->id == $artist_id))) {
            $this->dispatch('more-options', $this->song->id);
        } else {
            $this->redirect('/subscriptionPlans', navigate: true);
        }
    }
    public function sendingMusicToPlayer($songId)
    {
        $user = Auth::user();
        $artist_id = $this->song->owner_id;
        if ($user->role == 'subscriber' || ($user->role == 'basic' && ($user->id == $artist_id))) {
            $this->dispatch('update-player', $songId, $this->list);
        } else {
            $this->redirect('/subscriptionPlans', navigate: true);
        }
    }
    public function likeDislikeMusic()
    {
        try {
            if (!$this->liked) {
                DB::table('likes')->Insert([
                    'user_id' => Auth::user()->id,
                    'music_id' => $this->song->id,
                    'updated_at' => Carbon::now()
                ]);
                $this->liked = true;
            } else {
                DB::table('likes')
                    ->where('user_id', Auth::user()->id)
                    ->where('music_id', $this->song->id)
                    ->delete();
                $this->liked = false;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function RemoveFromBeats()
    {
        try {
            DB::table('songs')
                ->where('id', $this->song->id)
                ->delete();
            $this->dispatch('remove-from-player', $this->song->id);
            $this->redirect('/BeatsCloud', navigate: true);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function RemoveFromPlayList()
    {
        try {
            DB::table('song_in_playlist')
                ->where('list_id', $this->fromPlaylist)
                ->where('music_id', $this->song->id)
                ->delete();
            $this->redirect('/Playlist/' . $this->fromPlaylist, navigate: true);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function mount($type, $item, $list, $fromPlaylist = null)
    {
        $this->list = $list;
        $this->type = $type;
        $this->song = Song::find($item->id);
        if (isset($item->total))
            $this->cnt = $item->total;
        else
            $this->cnt = 0;
        if ($type == "ListItemLiked")
            $this->liked = true;
        $this->artist = User::find($this->song->owner_id)->name;
        $this->fromPlaylist = $fromPlaylist;
    }

    public function render()
    {
        return view('livewire.list-item');
    }
}
