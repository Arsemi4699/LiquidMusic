<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StudioController extends Controller
{
    public function MusicCneter()
    {
        $artist = User::find(Auth::user()->id);
        $ArtistMusics = $artist->songs()->orderByDesc('created_at')->get();

        return view('studio.MusicCenter', compact('ArtistMusics'));
    }

    public function setPayoff(Request $req)
    {
        try {
            $req->validate([
                'artistID' => 'required',
                'payoff' => 'required|gt:0',
            ]);

            DB::beginTransaction();

            $balanceC = DB::table('artist_wallet')
                ->where('artist_id', $req->artistID)
                ->first();

            $balance = ($balanceC != null) ? $balanceC->balance : 0;

            if ($balance >= $req->payoff) {
                DB::table('payoffs')
                    ->insert([
                        'artist_id' => $req->artistID,
                        'money' => $req->payoff,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                DB::table('artist_wallet')
                    ->where('artist_id', $req->artistID)
                    ->update([
                        'balance' => $balance - $req->payoff,
                        'updated_at' => Carbon::now()
                    ]);
                session()->flash('payoffDone', 'درخواست با موفقیت ثبت شد!');
            } else {
                session()->flash('errorOnPayoff', 'موجودی ناکافی است!');
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            session()->flash('errorOnPayoff', 'درخواست وجه شکست خورد!');
        }
        return redirect()->route('studioBilling');
    }

    public function resetMonetizeRequest(Request $req)
    {
        $req->validate([
            'artistID' => 'required',
        ]);
        DB::table('artist_bank')
            ->where('artist_id', $req->artistID)
            ->update([
                'status' => 3,
                'updated_at' => Carbon::now()
            ]);

        return redirect()->route('studioBilling');
    }

    public function setMonetizeRequest(Request $req)
    {
        $req->validate([
            'fname' => 'required',
            'lname' => 'required',
            'cnumber' => 'required',
            'anumber' => 'required',
            'cardnumber' => 'required',
            'shaba' => 'required',
            'artistID' => 'required',
        ]);
        if (DB::table('artist_bank')->where('artist_id', $req->artistID)->doesntExist()) {
            DB::table('artist_bank')
                ->insert([
                    'artist_id' => $req->artistID,
                    'CID' => $req->cnumber,
                    'ownerFName' => $req->fname,
                    'ownerLName' => $req->lname,
                    'accountNum' => $req->anumber,
                    'BankCardNum' => $req->cardnumber,
                    'ShabaNum' => $req->shaba,
                    'status' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
        } else {
            DB::table('artist_bank')
                ->where('artist_id', $req->artistID)
                ->update([
                    'CID' => $req->cnumber,
                    'ownerFName' => $req->fname,
                    'ownerLName' => $req->lname,
                    'accountNum' => $req->anumber,
                    'BankCardNum' => $req->cardnumber,
                    'ShabaNum' => $req->shaba,
                    'status' => 0,
                    'updated_at' => Carbon::now()
                ]);
        }
        return redirect()->route('studioBilling');
    }

    public function billing()
    {
        $monetizeTH = 100;

        $valid = false;
        $seted = false;
        $confirmed = 0;
        $ownerFullname = "";
        $shaba = 0;
        $followers = DB::table('subs')
            ->where('artist_id', Auth::user()->id)
            ->count();

        $valid = ($monetizeTH <= $followers) ? true : false;
        if ($valid) {
            $bankInfoRow = DB::table('artist_bank')->where('artist_id', Auth::user()->id)->first();
            if ($bankInfoRow == null)
                $seted = false;
            else {
                $seted = true;
                $confirmed = $bankInfoRow->status;
                $ownerFullname = $bankInfoRow->ownerFName . " " . $bankInfoRow->ownerLName;
                $shaba = $bankInfoRow->ShabaNum;
            }
        }

        $balanceC = DB::table('artist_wallet')
            ->where('artist_id', Auth::user()->id)
            ->first();

        $balance = ($balanceC != null) ? $balanceC->balance : 0;

        $payOffLogs = DB::table('payoffs')
            ->where('artist_id', Auth::user()->id)
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('studio.billing', compact('valid', 'seted', 'confirmed', 'balance', 'ownerFullname', 'shaba', 'payOffLogs'));
    }

    public function profile()
    {
        $artist = Auth::user();
        $followers = DB::table('subs')
            ->where('artist_id', $artist->id)
            ->count();

        return view('studio.profile', compact('artist', 'followers'));
    }

    public function deleteMusic($id)
    {
        try {
            $song = Song::findOrFail($id);
            $song->delete();
            return redirect()->back()->with('success', 'با موفقیت حذف شد!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'حذف شکست خورد!');
        }
    }

    public function profileUpdateName(Request $req)
    {
        $req->validate([
            'name' => 'required',
        ]);
        $artist = User::findOrFail(Auth::user()->id);
        $artist->update([
            'name' => $req->name,
        ]);
        return redirect()->route('studioProfile');
    }

    public function profileUpdateImg(Request $req)
    {
        $file = $req->file('image');
        $req->validate([
            'image' => ['required', 'image', 'max:2048', 'dimensions:ratio=1/1'],
        ]);

        $imageName = 'img_' . Carbon::now()->microsecond . '.' . $file->extension();
        $file->storeAs('images/avatars', $imageName, 'public');

        $artist = User::findOrFail(Auth::user()->id);
        $artist->update([
            'file_path_profile_img' => $imageName,
        ]);
        return redirect()->route('studioProfile');
    }

    public function index()
    {
        $ArtistMusics = DB::table('songs')
            ->where('owner_id', Auth::user()->id)
            ->orderByDesc('created_at')
            ->get();

        $lastMViews = DB::table('views')
            ->join('songs', 'views.music_id', '=', 'songs.id')
            ->where('songs.owner_id', Auth::user()->id)
            ->where('views.updated_at', '>=', Carbon::now()->subDays(30))
            ->count();


        $last2MViews = DB::table('views')
            ->join('songs', 'views.music_id', '=', 'songs.id')
            ->where('songs.owner_id', Auth::user()->id)
            ->where('views.updated_at', '>=', Carbon::now()->subDays(60))
            ->count();

        $twoMounAge = $last2MViews - $lastMViews;

        $growingRateViews = 0;
        if ($twoMounAge)
            $growingRateViews = (($lastMViews - $twoMounAge) / $twoMounAge) * 100;

        $Artistfollowers = DB::table('subs')
            ->where('artist_id', Auth::user()->id)
            ->count();


        $balanceC = DB::table('artist_wallet')
            ->where('artist_id', Auth::user()->id)
            ->first();

        $balance = ($balanceC != null) ? $balanceC->balance : 0;
        return view('studio.studioDash', compact('ArtistMusics', 'lastMViews', 'growingRateViews', 'Artistfollowers', 'balance'));
    }
}
