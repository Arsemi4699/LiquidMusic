<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MusicListController extends Controller
{
    public function LikedMusics()
    {
        $curUser = User::find(Auth::user()->id);
        $Liked = $curUser->getLikedMusics();
        $ListOfIdsforLiked = MakeListofIds($Liked);
        return view('music.myMusic', compact('Liked', 'ListOfIdsforLiked'));
    }

    public function ViewedMusics()
    {
        $curUser = User::find(Auth::user()->id);
        $Viewed = $curUser->getViewedMusics();
        $ListOfIdsforViewed = MakeListofIds($Viewed);
        return view('music.myMusic', compact('Viewed', 'ListOfIdsforViewed'));
    }

    public function index()
    {
        return view('music.musicList');
    }
}
