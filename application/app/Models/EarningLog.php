<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EarningLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'publisher_id',
        'ad_id',
        'date'
    ];
    public function ad()
    {
        return $this->belongsTo(CreateAd::class,'ad_id');
    }
    public function publisher()
    {
        return $this->belongsTo(Publisher::class,'publisher_id');
    }
}
