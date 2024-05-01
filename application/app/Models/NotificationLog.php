<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    public function advertiser(){
    	return $this->belongsTo(Advertiser::class,'user_id');
    }
    public function publisher(){
    	return $this->belongsTo(Publisher::class,'user_id');
    }
}
