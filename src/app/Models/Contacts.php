<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    use HasFactory;

    public function company()
    {
        return $this->belongsTo(Companies::class);
    }

    public function leads()
    {
        return $this->belongsToMany(LeadsModel::class);
    }

    public function tegs()
    {
        return $this->belongsToMany(Tags::class);
    }
}
