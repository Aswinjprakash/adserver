<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpChart extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function iplogs()
    {
        return $this->hasMany(IpLog::class, 'ip_id', 'id');
    }
}
