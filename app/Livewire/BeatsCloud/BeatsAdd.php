<?php

namespace App\Livewire\BeatsCloud;

use Carbon\Carbon;
use App\Models\Song;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use wapmorgan\Mp3Info\Mp3Info;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class BeatsAdd extends Component
{
    use WithFileUploads;

    #[Rule('required')]
    public $title;
    #[Rule('required|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav|max:51200')]
    public $songFile;
    #[Rule('required|image|dimensions:ratio=1/1|max:2048')]
    public $image;

    public $usedSpace = null;
    public $cloudSize = null;

    public function create()
    {
        $this->validate();
        $imageName = 'img_' . Carbon::now()->microsecond . '.' . $this->image->extension();
        $this->image->storeAs('images/covers', $imageName, 'public');
        $songFileName = 'aud_' . Carbon::now()->microsecond . '.' . $this->songFile->extension();
        $this->songFile->storeAs('musics/songs', $songFileName, 'public');
        $audio = new Mp3Info('./storage/musics/songs/' . $songFileName);
        Song::create([
            'name' => $this->title,
            'owner_id' => Auth::user()->id,
            'img_path_name' => $imageName,
            'file_path_name' => $songFileName,
            'file_duration' => $audio->duration
        ]);
        session()->flash('success','موزیک با موفقیت به بیتس کلود شما افزوده شد!');
        $this->redirect('/BeatsCloud' , navigate: true);
    }
    public function render()
    {
        if ($this->usedSpace == null)
        {
            $this->usedSpace = DB::table('songs')
            ->where('owner_id', Auth::user()->id)
            ->count();
        }
        if ($this->cloudSize == null)
        {
            $this->cloudSize = Auth::user()->music_limit;
        }

        if ($this->usedSpace >= $this->cloudSize)
        {
            session()->flash('CloudOutOfSize', 'ظرفیت بیتس کلود شما به اتمام رسیده!');
            $this->redirect('/BeatsCloud' , navigate: true);
        }
        return view('livewire.beats-cloud.beats-add');
    }
}
