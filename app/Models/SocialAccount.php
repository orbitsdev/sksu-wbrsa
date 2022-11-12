<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'provider_user_id',
        'provider'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
