<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Song;
use App\Models\User;
use App\Models\Admin;
use App\Notifications\ReportedSongRemoved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminPanelController extends Controller
{
    public function reports()
    {
        $highReports = DB::table('reports')
            ->where('level', 'high')
            ->where('status', 0)
            ->orderBy('created_at', 'asc')
            ->get();

        $medReports = DB::table('reports')
            ->where('level', 'medium')
            ->where('status', 0)
            ->orderBy('created_at', 'asc')
            ->get();

        $lowReports = DB::table('reports')
            ->where('level', 'low')
            ->where('status', 0)
            ->orderBy('created_at', 'asc')
            ->get();

        $allReports = $highReports->concat($medReports)->concat($lowReports);
        return view('admin.panels.reports', compact('allReports'));
    }

    public function deleteReportedMusic(Request $req)
    {
        try {
            $song = Song::findOrFail($req->id);
            $owner_id = $song->owner_id;
            $song_name = $song->name;
            $song->delete();
            $owner = User::findOrFail($owner_id);
            $owner->notify(new ReportedSongRemoved($song_name));
            return redirect()->back()->with('success', 'با موفقیت حذف شد!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'حذف شکست خورد!');
        }
    }

    public function financial()
    {
        $BankRequests = DB::table('artist_bank')
            ->where('status', 0)
            ->oldest()
            ->get();
        $PayoffRequests = DB::table('payoffs')
            ->join('artist_bank', 'payoffs.artist_id', '=', 'artist_bank.artist_id')
            ->select(
                'payoffs.*',
                'artist_bank.CID',
                'artist_bank.ownerFName',
                'artist_bank.ownerLName',
                'artist_bank.accountNum',
                'artist_bank.BankCardNum',
                'artist_bank.ShabaNum',
                'artist_bank.status as artist_bank_status',
                'artist_bank.created_at as artist_bank_created_at',
                'artist_bank.updated_at as artist_bank_updated_at'
            )
            ->where('artist_bank.status', 1)
            ->where('payoffs.status', 0)
            ->orderBy('payoffs.created_at', 'desc')
            ->get();

        $transactions = DB::table('transaction')
            ->orderBy('created_at', 'desc')
            ->simplePaginate(20);

        return view('admin.panels.financial', compact('BankRequests', 'PayoffRequests', 'transactions'));
    }

    public function rejectBank(Request $req)
    {
        DB::table('artist_bank')
            ->where('artist_id', $req->id)
            ->update([
                'status' => 2,
                'updated_at' => Carbon::now()
            ]);
        session()->flash('success', 'عملیات با موفقیت انجام شد!');
        return redirect()->route('admin.financial');
    }
    public function acceptBank(Request $req)
    {
        try {
            DB::beginTransaction();
            DB::table('artist_bank')
                ->where('artist_id', $req->id)
                ->update([
                    'status' => 1,
                    'updated_at' => Carbon::now()
                ]);
            if (DB::table('artist_wallet')->where('artist_id', $req->id)->doesntExist())
                DB::table('artist_wallet')
                    ->insert([
                        'artist_id' => $req->id,
                        'balance' => 0,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            session()->flash('success', 'عملیات با موفقیت انجام شد!');
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'عملیات شکست خورد!');
        }
        return redirect()->route('admin.financial');
    }
    public function acceptPayoff(Request $req)
    {
        DB::table('payoffs')
            ->where('id', $req->id)
            ->update([
                'status' => 1,
                'updated_at' => Carbon::now()
            ]);
        session()->flash('success', 'عملیات با موفقیت انجام شد!');

        return redirect()->route('admin.financial');
    }

    public function adminManager()
    {
        $admins = Admin::all();
        return view('admin.panels.adminManager', compact('admins'));
    }

    public function addNewAdmin()
    {
        return view('admin.panels.adminManager.createNewAdmin');
    }
    public function createAdmin(Request $req)
    {
        $req->validate([
            'title' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => 'required',
        ]);

        Admin::create([
            'name' => $req->title,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'role' => $req->role
        ]);
        session()->flash('success', 'عملیات با موفقیت انجام شد!');
        return redirect()->route('admin.adminManager');
    }
    public function editAdmin(Request $req)
    {
        $admin = Admin::find($req->id);
        return view('admin.panels.adminManager.editAdmin', compact('admin'));
    }
    public function updateAdmin(Request $req)
    {
        $req->validate([
            'title' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => 'required',
        ]);
        $admin = Admin::find($req->id);
        $admin->update([
            'name' => $req->title,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'role' => $req->role
        ]);
        session()->flash('success', 'عملیات با موفقیت انجام شد!');
        return redirect()->route('admin.adminManager');
    }
    public function deleteAdmin(Request $req)
    {
        $admin = Admin::find($req->id);
        $admin->delete();
        session()->flash('success', 'عملیات با موفقیت انجام شد!');
        return redirect()->route('admin.adminManager');
    }


    public function plansManager()
    {
        $plans = DB::table('sub_plans')
            ->get();
        $packs = DB::table('beats_pack')
            ->get();
        return view('admin.panels.plansManager', compact('plans', 'packs'));
    }

    public function addNewPlans()
    {
        return view('admin.panels.plansManager.subPlans.createNewPlans');
    }
    public function createPlans(Request $req)
    {
        $req->validate([
            'title' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'gt:999'],
            'duration' => ['required', 'numeric', 'gt:0']
        ]);
        DB::table('sub_plans')
            ->insert([
                'name' => $req->title,
                'price_T' => $req->price,
                'duration_D' => $req->duration,
            ]);

        session()->flash('success', 'عملیات با موفقیت انجام شد!');
        return redirect()->route('admin.plansManager');
    }
    public function editPlans(Request $req)
    {

        $plan = DB::table('sub_plans')->find($req->id);
        return view('admin.panels.plansManager.subPlans.editPlans', compact('plan'));
    }
    public function updatePlans(Request $req)
    {
        $req->validate([
            'title' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'gt:999'],
            'duration' => ['required', 'numeric', 'gt:0']
        ]);
        DB::table('sub_plans')
            ->where('id', $req->id)
            ->update([
                'name' => $req->title,
                'price_T' => $req->price,
                'duration_D' => $req->duration,
            ]);
        session()->flash('success', 'عملیات با موفقیت انجام شد!');
        return redirect()->route('admin.plansManager');
    }
    public function deletePlans(Request $req)
    {
        DB::table('sub_plans')->where('id', $req->id)->delete();
        session()->flash('success', 'عملیات با موفقیت انجام شد!');
        return redirect()->route('admin.plansManager');
    }

    public function addNewPacks()
    {
        return view('admin.panels.plansManager.beatsPack.createNewPacks');
    }
    public function createPacks(Request $req)
    {
        $req->validate([
            'title' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'gt:999'],
            'size' => ['required', 'numeric', 'gt:0']
        ]);
        DB::table('beats_pack')
            ->insert([
                'name' => $req->title,
                'price_T' => $req->price,
                'pack_size' => $req->size,
            ]);

        session()->flash('success', 'عملیات با موفقیت انجام شد!');
        return redirect()->route('admin.plansManager');
    }
    public function editPacks(Request $req)
    {
        $pack = DB::table('beats_pack')->find($req->id);
        return view('admin.panels.plansManager.beatsPack.editPacks', compact('pack'));
    }
    public function updatePacks(Request $req)
    {
        $req->validate([
            'title' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'gt:999'],
            'size' => ['required', 'numeric', 'gt:0']
        ]);
        DB::table('beats_pack')
            ->where('id', $req->id)
            ->update([
                'name' => $req->title,
                'price_T' => $req->price,
                'pack_size' => $req->size,
            ]);
        session()->flash('success', 'عملیات با موفقیت انجام شد!');
        return redirect()->route('admin.plansManager');
    }
    public function deletePacks(Request $req)
    {
        DB::table('beats_pack')->where('id', $req->id)->delete();
        session()->flash('success', 'عملیات با موفقیت انجام شد!');
        return redirect()->route('admin.plansManager');
    }


    public function index()
    {

        $totalUser = DB::select('select COUNT(*) as total from users where role <> 3')[0]->total;

        $totalMusic = DB::table('songs')
            ->join('users', 'songs.owner_id', 'users.id')
            ->select('users.role', DB::raw('COUNT(*) as total'))
            ->where('users.role', 'artist')
            ->first()->total;

        $totalArtist = DB::select('select COUNT(*) as total from users where role = 3')[0]->total;

        $Musics = DB::table('views')
            ->join('songs', 'views.music_id', '=', 'songs.id')
            ->join('users', 'songs.owner_id', '=', 'users.id')
            ->select('music_id as id', 'users.name as owner_name', 'songs.name as song_name', 'songs.img_path_name as img', 'views.updated_at', 'users.role', DB::raw('COUNT(*) as total'))
            ->where('role', 'artist')
            ->where('views.updated_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('id')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return view('admin.panels.dashboard', compact('totalUser', 'totalMusic', 'totalArtist', 'Musics'));
    }
}
