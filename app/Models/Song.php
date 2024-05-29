<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Song extends Model
{
    use HasFactory;

    protected $table = "songs";
    protected $guarded = [];

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
