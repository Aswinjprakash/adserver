<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analytic extends Model
{
    protected $guarded = [];

    public function scopeIncrease()
    {
       return $this->count +=1;
    }

    public function advertiser()
    {
        return $this->belongsTo(Advertiser::class);
    }

    public function ad()
    {
        return $this->belongsTo(CreateAd::class,'ad_id');
    }
}
