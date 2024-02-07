<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ArtistList extends Component
{
    public $ArtistList;
    public $gettingType = 1;
    public function getArtistByViews()
    {
        $this->gettingType = 1;
        $this->ArtistList = DB::table('views')
        ->join('songs', 'songs.id', '=', 'views.music_id')
        ->join('users', 'users.id', '=', 'songs.owner_id')
        ->select('users.*', DB::raw('COUNT(*) as total_views'))
        ->where('users.role', 'artist')
        ->groupBy('users.id')
        ->orderByDesc('total_views')
        ->get();
    }
    public function getArtistByLikes()
    {
        $this->gettingType = 2;
        $this->ArtistList = DB::table('likes')
        ->join('songs', 'songs.id', '=', 'likes.music_id')
        ->join('users', 'users.id', '=', 'songs.owner_id')
        ->select('users.*', DB::raw('COUNT(*) as total_likes'))
        ->where('users.role', 'artist')
        ->groupBy('users.id')
        ->orderByDesc('total_likes')
        ->get();
    }
    public function getArtistBySubs()
    {
        $this->gettingType = 3;
        $this->ArtistList = DB::table('subs')
        ->join('users', 'users.id', '=', 'subs.artist_id')
        ->select('users.*', DB::raw('COUNT(*) as total_subs'))
        ->where('users.role', 'artist')
        ->groupBy('users.id')
        ->orderByDesc('total_subs')
        ->get();
    }
    public function getArtistRandom()
    {
        $this->gettingType = 4;
        $this->ArtistList = DB::table('users')
        ->where('users.role', 'artist')
        ->inRandomOrder()
        ->get();
    }

    public function mount()
    {
        $this->gettingType = 1;
        $this->ArtistList = DB::table('views')
        ->join('songs', 'songs.id', '=', 'views.music_id')
        ->join('users', 'users.id', '=', 'songs.owner_id')
        ->select('users.*', DB::raw('COUNT(*) as total_views'))
        ->where('users.role', 'artist')
        ->groupBy('users.id')
        ->orderByDesc('total_views')
        ->get();
    }
    public function render()
    {
        return view('livewire.artist-list');
    }
}
