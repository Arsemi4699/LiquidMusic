<?php

namespace App\Http\Controllers;

use App\Models\BeatsPack;
use Illuminate\Support\Facades\Auth;

class BeatsCloudController extends Controller
{
    public function create()
    {
        return view('BeatsCloud.NewBeats');
    }
    public function index()
    {
        $user = Auth::user();
        $MusicsInBeats = $user->songs()->get();

        $usedSpace = count($MusicsInBeats);
        $cloudSize = $user->music_limit;
        $BeatsPack = BeatsPack::all();
        $ListOfIdsforMusicList = MakeListofIds($MusicsInBeats);
        return view('BeatsCloud.BeatsCloudMain', compact('MusicsInBeats', 'ListOfIdsforMusicList', 'BeatsPack', 'usedSpace', 'cloudSize'));
    }
}
