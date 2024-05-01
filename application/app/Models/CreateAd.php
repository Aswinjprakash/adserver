<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreateAd extends Model
{
    use HasFactory;


    public function advertiser()
    {
        return $this->belongsTo(Advertiser::class,'advertiser_id');
    }

    public function type()
    {
        return $this->belongsTo(AdType::class,'ad_type_id');
    }

    public function publishers()
    {
        return $this->belongsToMany(Publisher::class,'publisher_ads');
    }
    public function analytic()
    {
        return $this->hasMany(Analytic::class,'ad_id');
    }

    public function publisherAd()
    {
        return $this->hasMany(PublisherAd::class,'create_ad_id');
    }

    public function statusBadge($status){
        $html = '';
        if($this->status == 1){
            $html = '<span class="badge badge--success">'.trans('Active').'</span>';
        }elseif($this->status == 2){
            $html = '<span class="badge badge--warning">'.trans('Pending').'</span>';
        }else{
            $html = '<span class="badge badge--danger">'.trans('Deactivate').'</span>';
        }

        return $html;
    }
}
