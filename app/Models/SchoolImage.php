<?php

namespace App\Models;

use App\Models\School;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolImage extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function school(){
        return $this->belongsTo(School::class);
    }

}
