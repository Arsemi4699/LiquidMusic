<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function reportMusic(Request $req)
    {
        $music =  Song::find($req->id);
        $user = Auth::user();
        if ($music->owner_id != $user->id) {
            $id = $req->id;
            $name = $music->name;
            return view('user.report', compact('id', 'name'));
        } else {
            session()->flash('error', 'شما نمی توانید آهنگ خودتان را گزارش کنید!');
            return redirect()->route('BeatsCloud');
        }
    }
    public function submitReportMusic(Request $req)
    {
        $req->validate([
            'info' => ['max:175'],
            'level' => ['required'],
            'type' => ['required'],
        ]);
        $level = $req->level;
        if ($level != "low" && $level != "medium" && $level != "high")
            $level = 'low';

        $type = $req->type;
        if ($type != "Copyright" && $type != "ChildAbuse" && $type != "Violence" && $type != "Unethical" && $type != "Other")
            $type = 'Other';
        try {
            DB::table('reports')
                ->insert([
                    'music_id' => $req->id,
                    'type' => $type,
                    'level' => $level,
                    'info' => $req->info,
                    'status' => 0,
                    'created_at' => Carbon::now()
                ]);
            session()->flash('success', 'گزارش شما با موفقیت ثبت شد!');
        } catch (\Throwable $th) {
            session()->flash('error', 'ثبت گزارش با شکست مواجه شد!');
        }

        return redirect()->route('home');
    }
}
