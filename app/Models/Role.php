<?php

namespace App\Models;

use App\Models\User;
use App\Models\Permission;
use App\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory,  HasPermissions;

    protected $fillable = [
        'name',
        'slug'
    ];
    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class,'roles_permissions');
    }

    public function hasPermissions($permissions){
        return $this->permissions()->whereIn('name', $permissions)->count();
    }

}
