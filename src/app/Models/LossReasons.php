<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LossReasons extends Model
{
    use HasFactory;
    
    public function leads()
    {
        return $this->hasMany(LeadsModel::class);
    }
}
