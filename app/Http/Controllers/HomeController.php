<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Song;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $TopViews = Song::getTopViewsOfWeek();

        $TopLikes = Song::getTopLikesOfWeek();

        $TopArtists = User::getTopArtist();

        return view('home', compact('TopViews', 'TopLikes', 'TopArtists'));
    }
    public function policy()
    {
        return view('policy');
    }
}
