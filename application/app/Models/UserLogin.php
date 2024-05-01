<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    protected $guarded = ['id'];

    public function Advertiser()
    {
        return $this->belongsTo(Advertiser::class,'user_id');
    }
    public function publisher()
    {
        return $this->belongsTo(Publisher::class,'user_id');
    }
}
