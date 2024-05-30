<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $table = "artist_wallet";
    protected $guarded = [];

    public function artist()
    {
        return $this->hasOne(User::class, 'id', 'artist_id');
    }
}
