<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpLog extends Model
{
    use HasFactory;
    protected $table = 'ip_logs';

    public function ad()
    {
        return $this->belongsTo(CreateAd::class,'ad_id');
    }

    public function ip()
    {
        return $this->belongsTo(IpChart::class,'ip_id');
    }
}
