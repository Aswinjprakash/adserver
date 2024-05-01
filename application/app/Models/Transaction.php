<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = "transactions";

    protected  $guarded = ['id'];

    public function advertiser()
    {
        return $this->belongsTo(Advertiser::class,'user_id');
    }
    public function publisher()
    {
        return $this->belongsTo(Publisher::class,'publisher_id');
    }

}
