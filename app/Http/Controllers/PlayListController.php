<?php

namespace App\Http\Controllers;

use App\Models\playlist;
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
        $Playlists = $user->getUserPlaylists();
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
        $playlist = playlist::find($id);
        $playlistName = $playlist->name;
        $MusicsInPlayList = $playlist->getAllMusics();
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
        $Playlists = $user->getUserPlaylists();
        return view('playlist.playlists', compact('Playlists'));
    }
}
