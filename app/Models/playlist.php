<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class playlist extends Model
{
    protected $table = "playlists";
    protected $guarded = [];

    use HasFactory;

    public function getAllMusics() {
        $MusicsInPlayList = DB::table('song_in_playlist')
            ->select('music_id as id', 'updated_at')
            ->where('list_id', $this->id)
            ->orderByDesc('updated_at')
            ->get();
        return $MusicsInPlayList;
    }
}
