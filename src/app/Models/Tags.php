<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;

    public function leads()
    {
        return $this->belongsToMany(LeadsModel::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Companies::class);
    }

    public function contacts()
    {
        return $this->belongsToMany(Contacts::class);
    }
}
