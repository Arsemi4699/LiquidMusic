<?php

namespace App\Livewire\MusicPlayer;

use Carbon\Carbon;
use App\Models\Song;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Player extends Component
{
    public $name;
    public $musicId = null;
    public $owner;
    public $imgPath;
    public $songList;
    public $isPlaying = false;
    public $Liked;
    public $update = false;
    public $file_src;
    public $fileDuration;
    public $currList = [];
    public $currMusicIndx = 0;
    public $mode = 0;
    #[On('update-player'), Renderless]
    public function updatePlayer($songId, $list)
    {
        try {
            $song = Song::find($songId);
            $prevId = $this->musicId;

            $user = Auth::user();
            $artist_id = $song->owner_id;
            if ($user->role == 'subscriber' || ($user->role == 'basic' && ($user->id == $artist_id))) {
                if ($this->musicId != $song->id) {

                    if (DB::table('views')->where('user_id', Auth::user()->id)->where('music_id', $songId)->doesntExist()) {
                        DB::table('views')->Insert([
                            'user_id' => Auth::user()->id,
                            'music_id' => $songId,
                            'updated_at' => Carbon::now()
                        ]);
                    } else {
                        DB::table('views')
                            ->where('user_id', Auth::user()->id)
                            ->where('music_id', $songId)
                            ->update(['updated_at' => Carbon::now()]);
                    }
                    $this->isPlaying = false;
                    $this->musicId = $song->id;
                    $this->name = $song->name;
                    $this->owner = User::find($song->owner_id)->name;
                    $this->imgPath = $song->img_path_name;
                    $this->update = true;
                    $this->file_src = $song->file_path_name;
                    $this->fileDuration = $song->file_duration;
                    if ($list != null)
                        $this->currList = $list;
                    $this->currMusicIndx = array_search($song->id, $this->currList);
                    if (DB::table('likes')->where('user_id', Auth::user()->id)->where('music_id', $this->musicId)->doesntExist())
                        $this->Liked = false;
                    else
                        $this->Liked = true;
                    if ($prevId)
                        $this->dispatch('pause-play-music', $this->isPlaying);
                    $this->render();
                }
            }
        } catch (\Throwable $th) {
            session()->flash('error', 'پخش موزیک با شکست مواجه شد!');
            $this->redirect('/home', navigate: true);
        }
    }

    #[On('remove-from-player'), Renderless]
    public function removeFromList($removedId)
    {
        $list_length = count($this->currList);
        $posRemoved = array_search($removedId, $this->currList);
        if ($list_length > 1) {
            unset($this->currList[$posRemoved]);
            $this->currList = array_values($this->currList);
            if ($list_length > $this->currMusicIndx + 1 && $posRemoved == $this->currMusicIndx) {
                $this->nextMusic();
            } else if ($this->currMusicIndx > 0 && $posRemoved == $this->currMusicIndx) {
                $this->prevMusic();
            }
        } else {
            $this->currMusicIndx = 0;
            $this->musicId = null;
            $this->currList = [];
            $this->render();
        }
    }

    #[On('changeMode'), Renderless]
    public function changeMode()
    {
        $this->mode = $this->mode + 1;
        if ($this->mode > 3)
            $this->mode = 0;
    }

    public function pausePlayMusic()
    {
        if (!$this->isPlaying)
            $this->isPlaying = true;
        else
            $this->isPlaying = false;
        $this->dispatch('pause-play-music', $this->isPlaying);
    }

    #[On('PPR'), Renderless]
    public function musicEnded()
    {
        $this->pausePlayMusic();
        if ($this->mode == 1) {
            $this->MountCheck();
        }
        if ($this->mode == 2) {
            $this->nextMusic();
        } else if ($this->mode == 3) {
            $randId;
            do {
                $randId = rand(0, count($this->currList) - 1);
            } while ($this->currMusicIndx == $randId);
            $this->updatePlayer($this->currList[$randId], null);
        }
    }

    #[On('MountedOnPlayer'), Renderless]
    public function MountCheck()
    {
        if ($this->mode != 0) {
            $this->pausePlayMusic();
        }
    }

    #[On('addMusicOnQ'), Renderless]
    public function pushMusicOnFrontOfQ($newID)
    {
        if ($newID != -1) {
            if (count($this->currList)) {
                $inserted = array($newID);
                array_splice($this->currList, $this->currMusicIndx + 1, 0, $inserted);
            } else {
                $this->updatePlayer($newID, [$newID]);
            }
        }
    }

    #[On('NextMusic'), Renderless]
    public function nextMusic()
    {
        if ($this->currMusicIndx + 1 <= count($this->currList) - 1) {
            $this->updatePlayer($this->currList[$this->currMusicIndx + 1], null);
        }
    }

    #[On('PrevMusic'), Renderless]
    public function prevMusic()
    {
        if ($this->currMusicIndx - 1 >= 0) {
            $this->updatePlayer($this->currList[$this->currMusicIndx - 1], null);
        }
    }

    #[On('likeDislikeMusic'), Renderless]
    public function likeDislikeMusic()
    {
        try {
            if (!$this->Liked) {
                DB::table('likes')->Insert([
                    'user_id' => Auth::user()->id,
                    'music_id' => $this->musicId,
                    'updated_at' => Carbon::now()
                ]);
                $this->Liked = true;
            } else {
                DB::table('likes')
                    ->where('user_id', Auth::user()->id)
                    ->where('music_id', $this->musicId)
                    ->delete();
                $this->Liked = false;
            }
        } catch (\Throwable $th) {
            session()->flash('error', 'لایک موزیک با شکست مواجه شد!');
            $this->redirect('/home', navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.music-player.player');
    }

    public function rendered()
    {
        $this->dispatch('rendered', $this->isPlaying);
        if ($this->update) {
            $this->dispatch('player-updated', asset('storage/musics/songs/' . $this->file_src), $this->fileDuration, $this->Liked, $this->musicId, $this->mode);
            $this->update = false;
        }
    }
}
