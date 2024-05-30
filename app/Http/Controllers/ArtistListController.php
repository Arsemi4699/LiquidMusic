<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ArtistListController extends Controller
{
    public function index()
    {
        return view('user.artistList');
    }

    public function showFollowed()
    {
        $user = Auth::user();
        $Followed = $user->subs()->orderByDesc('pivot_updated_at')->get();
        return view('user.followedArtist', compact('Followed'));
    }

    public function show($id)
    {
        try {
            $Artist = User::findOrFail($id);
            $MusicList = Song::where('owner_id', $id)
                ->orderByDesc('created_at')
                ->get();
            $ListOfIdsforMusicList = MakeListofIds($MusicList);
            return view('user.artistShow', compact('Artist', 'MusicList', 'ListOfIdsforMusicList'));
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
