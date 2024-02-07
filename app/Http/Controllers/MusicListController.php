<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MusicListController extends Controller
{
    public function LikedMusics()
    {
        $Liked = DB::table('likes')
        ->select('user_id', 'music_id as id', 'updated_at')
        ->where('user_id', Auth::user()->id)
        ->orderByDesc('updated_at')
        ->get();
        $ListOfIdsforLiked = MakeListofIds($Liked);
        return view('music.myMusic', compact('Liked', 'ListOfIdsforLiked'));
    }

    public function ViewedMusics()
    {
        $Viewed = DB::table('views')
        ->select('user_id', 'music_id as id', 'updated_at')
        ->where('user_id', Auth::user()->id)
        ->orderByDesc('updated_at')
        ->get();
        $ListOfIdsforViewed = MakeListofIds($Viewed);
        return view('music.myMusic', compact('Viewed', 'ListOfIdsforViewed'));
    }

    public function index()
    {
        return view('music.musicList');
    }
}
