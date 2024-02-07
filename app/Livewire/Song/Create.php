<?php

namespace App\Livewire\Song;

use Carbon\Carbon;
use App\Models\Song;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use wapmorgan\Mp3Info\Mp3Info;
use Illuminate\Support\Facades\Auth;


class Create extends Component
{
    use WithFileUploads;

    #[Rule('required')]
    public $title;
    #[Rule('required|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav|max:51200')]
    public $songFile;
    #[Rule('required|image|dimensions:ratio=1/1|max:2048')]
    public $image;

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
        $this->redirect(route('musicCenter'));
    }

    public function render()
    {
        return view('livewire.song.create')->extends('layouts.studioApp')->section('PageContnet');
    }
}
