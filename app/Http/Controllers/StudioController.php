<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\User;
use App\Models\Payoff;
use App\Models\BankAcc;
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

            $artist = User::findOrFail($req->artistID);

            DB::beginTransaction();

            $wallet = $artist->wallet;

            $balance = ($wallet != null) ? $wallet->balance : 0;

            if ($balance >= $req->payoff) {
                $newPayoff = new Payoff;
                $newPayoff->fill([
                    'artist_id' => $req->artistID,
                    'money' => $req->payoff
                ]);
                $newPayoff->save();

                $wallet->update([
                        'balance' => $balance - $req->payoff
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

        $artist = User::findOrFail($req->artistID);
        $bank = $artist->bankAcc;

        $bank->update([
                'status' => 3
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

        $artist = User::findOrFail($req->artistID);
        $bank = $artist->bankAcc;
        if ($bank == null) {
            $newBankAcc = new BankAcc;
            $newBankAcc->fill([
                'artist_id' => $req->artistID,
                'CID' => $req->cnumber,
                'ownerFName' => $req->fname,
                'ownerLName' => $req->lname,
                'accountNum' => $req->anumber,
                'BankCardNum' => $req->cardnumber,
                'ShabaNum' => $req->shaba,
                'status' => 0
            ]);
            $newBankAcc->save();
        } else {
            $bank->update([
                    'CID' => $req->cnumber,
                    'ownerFName' => $req->fname,
                    'ownerLName' => $req->lname,
                    'accountNum' => $req->anumber,
                    'BankCardNum' => $req->cardnumber,
                    'ShabaNum' => $req->shaba,
                    'status' => 0
                ]);
        }
        return redirect()->route('studioBilling');
    }

    public function billing()
    {
        $artist = Auth::user();
        $monetizeTH = 0;
        $valid = false;
        $seted = false;
        $confirmed = 0;
        $ownerFullname = "";
        $shaba = 0;

        $followers = $artist->followedByUsers()->count();

        $valid = ($monetizeTH <= $followers) ? true : false;
        if ($valid) {
            $bankInfoRow = $artist->bankAcc;
            if ($bankInfoRow == null)
                $seted = false;
            else {
                $seted = true;
                $confirmed = $bankInfoRow->status;
                $ownerFullname = $bankInfoRow->ownerFName . " " . $bankInfoRow->ownerLName;
                $shaba = $bankInfoRow->ShabaNum;
            }
        }

        $wallet = $artist->wallet;

        $balance = ($wallet != null) ? $wallet->balance : 0;

        $payOffLogs = $artist->payoffs()
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('studio.billing', compact('valid', 'seted', 'confirmed', 'balance', 'ownerFullname', 'shaba', 'payOffLogs'));
    }

    public function profile()
    {
        $artist = Auth::user();
        $followers = $artist->followedByUsers()->count();

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
        $artist = Auth::user();
        $ArtistMusics = $artist->songs()->orderByDesc('created_at')->get();

        $lastMViews = DB::table('views')
            ->join('songs', 'views.music_id', '=', 'songs.id')
            ->where('songs.owner_id', $artist->id)
            ->where('views.updated_at', '>=', Carbon::now()->subDays(30))
            ->count();


        $last2MViews = DB::table('views')
            ->join('songs', 'views.music_id', '=', 'songs.id')
            ->where('songs.owner_id', $artist->id)
            ->where('views.updated_at', '>=', Carbon::now()->subDays(60))
            ->count();

        $twoMounAge = $last2MViews - $lastMViews;

        $growingRateViews = 0;
        if ($twoMounAge)
            $growingRateViews = (($lastMViews - $twoMounAge) / $twoMounAge) * 100;

        $Artistfollowers = $artist->followedByUsers()->count();


        $wallet = $artist->wallet;
        $payoffs = $artist->payoffs()->sum('money');

        $balance = ($wallet != null) ? $payoffs + $wallet->balance : 0;
        return view('studio.studioDash', compact('ArtistMusics', 'lastMViews', 'growingRateViews', 'Artistfollowers', 'balance'));
    }
}
