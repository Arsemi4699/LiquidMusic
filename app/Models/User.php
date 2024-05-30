<?php

namespace App\Models;

use App\Models\Song;
use App\Models\Wallet;
use App\Models\BankAcc;
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

    public function songs()
    {
        return $this->hasMany(Song::class, 'owner_id');
    }

    public function playlists()
    {
        return $this->hasMany(Playlist::class, 'owner_id');
    }

    public function bankAcc()
    {
        return $this->hasOne(BankAcc::class, 'artist_id');
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'artist_id');
    }

    public function likedSongs() {
        return $this->belongsToMany(Song::class, 'likes', 'user_id', 'music_id')->withPivot('updated_at');
    }

    public function viewedSongs() {
        return $this->belongsToMany(Song::class, 'views', 'user_id', 'music_id')->withPivot('updated_at');
    }

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
        $Liked = $this->likedSongs()
        ->orderByDesc('pivot_updated_at')
        ->get();
        return $Liked;
    }

    public function getViewedMusics() {
        $Viewed = $this->viewedSongs()
        ->orderByDesc('pivot_updated_at')
        ->get();
        return $Viewed;
    }
}
