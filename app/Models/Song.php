<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\playlist;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Song extends Model
{
    use HasFactory;

    protected $table = "songs";
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function playlists() {
        return $this->belongsToMany(playlist::class, 'song_in_playlist', 'music_id', 'list_id')->withPivot('updated_at');
    }

    public function likedSongs() {
        return $this->belongsToMany(Song::class, 'likes', 'user_id', 'music_id')->withPivot('updated_at');
    }

    public function likedByUsers() {
        return $this->belongsToMany(User::class, 'likes', 'music_id', 'user_id')->withPivot('updated_at');
    }

    public function viewedByUsers() {
        return $this->belongsToMany(User::class, 'views', 'music_id', 'user_id')->withPivot('updated_at');
    }

    public function isOwner($userId) : bool {
        return $this->owner_id == $userId;
    }

    public static function getTopViewsOfWeek()
    {
        $topViewsOfWeek = DB::table('views')
        ->join('songs', 'views.music_id', '=', 'songs.id')
        ->join('users', 'songs.owner_id', '=', 'users.id')
        ->select('music_id as id', 'views.updated_at', 'users.role', DB::raw('COUNT(*) as total'))
        ->where('role', 'artist')
        ->where('views.updated_at', '>=', Carbon::now()->subDays(7))
        ->groupBy('id')
        ->orderByDesc('total')
        ->limit(5)
        ->get();

        return $topViewsOfWeek;
    }
    public static function getTopLikesOfWeek()
    {
        $topLikesOfWeek = DB::table('likes')
            ->join('songs', 'likes.music_id', '=', 'songs.id')
            ->join('users', 'songs.owner_id', '=', 'users.id')
            ->select('music_id as id', 'likes.updated_at', 'users.role', DB::raw('COUNT(*) as total'))
            ->where('role', 'artist')
            ->where('likes.updated_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return $topLikesOfWeek;
    }
}
