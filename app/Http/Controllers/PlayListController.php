<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PlayListController extends Controller
{
    public function AddToPlayList($id)
    {
        $user = User::find(Auth::user()->id);
        $Playlists = $user->playlists;
        $musicId = $id;
        if ($Playlists->count())
            return view('playlist.addToPlayList', compact('Playlists', 'musicId'));
        else
            return view('playlist.createNewPlaylist', compact('musicId'));
    }
    public function create()
    {
        return view('playlist.createNewPlaylist');
    }
    public function showAPlaylist($id)
    {
        $playlist = Playlist::find($id);
        $playlistName = $playlist->name;
        $MusicsInPlayList = $playlist->songs;
        $ListOfIdsforMusicList = MakeListofIds($MusicsInPlayList);
        return view('playlist.playlistSingle', compact('playlistName', 'MusicsInPlayList', 'ListOfIdsforMusicList', 'id'));
    }
    public function deletePlayList(Request $req)
    {
        try {
            playlist::find($req->id)->delete();
            session()->flash('success', 'لیست با موفقیت حذف شد!');
        } catch (\Throwable $th) {
            session()->flash('error', 'حذف لیست با شکست مواجه شد!');
        }
        return redirect()->route('PlayLists');
    }
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $Playlists = $user->playlists;
        return view('playlist.playlists', compact('Playlists'));
    }
}
