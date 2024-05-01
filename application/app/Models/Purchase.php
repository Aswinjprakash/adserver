<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    public function advertiser()
    {
        return $this->belongsTo(Advertiser::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
