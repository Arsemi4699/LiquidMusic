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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function songs() {
        return $this->belongsToMany(Song::class, 'song_in_playlist', 'list_id', 'music_id')->withPivot('updated_at');
    }
}
