<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'file_path_profile_img',
        'subscribe_ends',
        'music_limit'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function getTopArtist() {
        $TopArtist = DB::table('subs')
        ->join('users', 'users.id', '=', 'subs.artist_id')
        ->select('users.*', DB::raw('COUNT(*) as total_subs'))
        ->where('users.role', 'artist')
        ->groupBy('users.id')
        ->orderByDesc('total_subs')
        ->limit(5)
        ->get();
        return $TopArtist;
    }

    public function getLikedMusics() {
        $Liked = DB::table('likes')
        ->select('user_id', 'music_id as id', 'updated_at')
        ->where('user_id', $this->id)
        ->orderByDesc('updated_at')
        ->get();
        return $Liked;
    }

    public function getViewedMusics() {
        $Viewed = DB::table('views')
        ->select('user_id', 'music_id as id', 'updated_at')
        ->where('user_id', $this->id)
        ->orderByDesc('updated_at')
        ->get();
        return $Viewed;
    }

    public function getUserPlaylists() {
        $Playlists = DB::table('playlists')
            ->select('name', 'id')
            ->where('owner_id', $this->id)
            ->get();
        return $Playlists;
    }
}
