<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadsModel extends Model
{
    use HasFactory;

    public function company()
    {
        return $this->belongsTo(Companies::class);
    }

    public function lossReason()
    {
        return $this->belongsTo(LossReasons::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class);
    }

    public function contacts()
    {
        return $this->belongsToMany(Contacts::class);
    }
}
