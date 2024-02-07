<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ArtistProfile extends Component
{
    public $artist_name;
    public $artist_id;
    public $artist_img;
    public $subed = false;

    public function SubUnSubArtist()
    {
        if (!$this->subed)
        {
            DB::table('subs')->Insert([
                'user_id' => Auth::user()->id,
                'artist_id'=> $this->artist_id,
                'updated_at' => Carbon::now()
            ]);
            $this->subed = true;
        }
        else
        {
            DB::table('subs')
            ->where('user_id', Auth::user()->id)
            ->where('artist_id', $this->artist_id)
            ->delete();
            $this->subed = false;
        }
    }

    public function mount($artist)
    {
        $this->artist_id = $artist->id;
        $this->artist_name = $artist->name;
        $this->artist_img = $artist->file_path_profile_img;
        if (DB::table('subs')->where('user_id', Auth::user()->id)->where('artist_id', $this->artist_id)->doesntExist())
        {
            $this->subed = false;
        }
        else
        {
            $this->subed = true;
        }
    }
    public function render()
    {
        return view('livewire.artist-profile');
    }
}
