<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DomainVerifcation extends Model
{
    use HasFactory;

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function statusBadge($status){
        $html = '';
        if($this->status == 1){
            $html = '<span class="badge badge--success">'.trans('Varified').'</span>';
        }elseif($this->status == 2){
            $html = '<span class="badge badge--warning">'.trans('Pending').'</span>';
        }else{
            $html = '<span class="badge badge--danger">'.trans('Unvarified').'</span>';
        }

        return $html;
    }
}
