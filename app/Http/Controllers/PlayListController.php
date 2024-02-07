<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PlayListController extends Controller
{
    public function AddToPlayList($id)
    {
        $Playlists = DB::table('playlists')
            ->select('name', 'id')
            ->where('owner_id', Auth::user()->id)
            ->get();
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
        $playlistName = DB::table('playlists')
            ->where('id', $id)
            ->first()->name;

        $MusicsInPlayList = DB::table('song_in_playlist')
            ->select('music_id as id', 'updated_at')
            ->where('list_id', $id)
            ->orderByDesc('updated_at')
            ->get();
        $ListOfIdsforMusicList = MakeListofIds($MusicsInPlayList);
        return view('playlist.playlistSingle', compact('playlistName', 'MusicsInPlayList', 'ListOfIdsforMusicList', 'id'));
    }
    public function deletePlayList(Request $req)
    {
        try {
            DB::table('playlists')
                ->where('owner_id', Auth::user()->id)
                ->where('id', $req->id)
                ->delete();
            session()->flash('success', 'لیست با موفقیت حذف شد!');
        } catch (\Throwable $th) {
            session()->flash('error', 'حذف لیست با شکست مواجه شد!');
        }
        return redirect()->route('PlayLists');
    }
    public function index()
    {
        $Playlists = DB::table('playlists')
            ->select('name', 'id')
            ->where('owner_id', Auth::user()->id)
            ->get();
        return view('playlist.playlists', compact('Playlists'));
    }
}
