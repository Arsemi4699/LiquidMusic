<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $TopViews = DB::table('views')
            ->join('songs', 'views.music_id', '=', 'songs.id')
            ->join('users', 'songs.owner_id', '=', 'users.id')
            ->select('music_id as id', 'views.updated_at', 'users.role', DB::raw('COUNT(*) as total'))
            ->where('role', 'artist')
            ->where('views.updated_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $TopLikes = DB::table('likes')
            ->join('songs', 'likes.music_id', '=', 'songs.id')
            ->join('users', 'songs.owner_id', '=', 'users.id')
            ->select('music_id as id', 'likes.updated_at', 'users.role', DB::raw('COUNT(*) as total'))
            ->where('role', 'artist')
            ->where('likes.updated_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $TopArtists = DB::table('subs')
            ->join('users', 'users.id', '=', 'subs.artist_id')
            ->select('users.*', DB::raw('COUNT(*) as total_subs'))
            ->where('users.role', 'artist')
            ->groupBy('users.id')
            ->orderByDesc('total_subs')
            ->limit(5)
            ->get();

        return view('home', compact('TopViews', 'TopLikes', 'TopArtists'));
    }
    public function policy()
    {
        return view('policy');
    }
}
