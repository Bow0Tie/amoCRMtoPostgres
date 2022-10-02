<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;

    public function leads()
    {
        return $this->hasMany(LeadsModel::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contacts::class);
    }
}
