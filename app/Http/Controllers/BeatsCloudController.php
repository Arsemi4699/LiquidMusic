<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BeatsCloudController extends Controller
{
    public function create()
    {
        return view('BeatsCloud.NewBeats');
    }
    public function index()
    {
        $MusicsInBeats = DB::table('songs')
        ->where('owner_id', Auth::user()->id)
        ->get();

        $usedSpace = count($MusicsInBeats);
        $cloudSize = Auth::user()->music_limit;
        $BeatsPack = DB::table('beats_pack')->get();
        $ListOfIdsforMusicList = MakeListofIds($MusicsInBeats);
        return view('BeatsCloud.BeatsCloudMain', compact('MusicsInBeats', 'ListOfIdsforMusicList', 'BeatsPack', 'usedSpace', 'cloudSize'));
    }
}
