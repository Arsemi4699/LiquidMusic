<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MusicList extends Component
{
    public $MusicList;
    public $gettingType = 1;
    public $ListOfIdsforMusicList = [];

    public function getMusicByViews()
    {
        $this->gettingType = 1;
        $this->MusicList = DB::table('views')
        ->join('songs', 'views.music_id' , '=' , 'songs.id')
        ->join('users', 'songs.owner_id' , '=' , 'users.id')
        ->select('music_id as id', 'users.role' , 'songs.owner_id' , DB::raw('COUNT(*) as total'))
        ->where('role', 'artist')
        ->orWhere('owner_id', Auth::user()->id)
        ->groupBy('id')
        ->orderByDesc('total')
        ->get();
        $this->ListOfIdsforMusicList = MakeListofIds($this->MusicList);
    }

    public function getMusicByLikes()
    {
        $this->gettingType = 2;
        $this->MusicList = DB::table('likes')
        ->join('songs', 'likes.music_id' , '=' , 'songs.id')
        ->join('users', 'songs.owner_id' , '=' , 'users.id')
        ->select('music_id as id', 'users.role' , 'songs.owner_id' , DB::raw('COUNT(*) as total'))
        ->where('role', 'artist')
        ->orWhere('owner_id', Auth::user()->id)
        ->groupBy('id')
        ->orderByDesc('total')
        ->get();
        $this->ListOfIdsforMusicList = MakeListofIds($this->MusicList);
    }

    public function getMusicRandom()
    {
        $this->gettingType = 3;
        $this->MusicList = DB::table('songs')
        ->join('users', 'songs.owner_id' , '=' , 'users.id')
        ->select('users.role', 'songs.owner_id', 'songs.id as id')
        ->where('role', 'artist')
        ->orWhere('owner_id', Auth::user()->id)
        ->inRandomOrder()
        ->get();
        $this->ListOfIdsforMusicList = MakeListofIds($this->MusicList);
    }

    public function mount()
    {
        $this->gettingType = 1;
        $this->getMusicByViews();
    }
    public function render()
    {
        return view('livewire.music-list');
    }
}
