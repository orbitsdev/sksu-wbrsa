<?php
namespace App\Traits;

use App\Models\Permission;
use App\Traits;

trait HasPermissions {


    

    public function hasRoles($roles)
    {
        // if($this->roles()->whereIn('name', $roles)->first()){
        //     return true;
        // }
        // return false;

        return $this->roles()->whereIn('name', $roles)->count();
    }


    public function hasPermissionTo($permissions)
    {

        return $this->permissions()->whereIn('name', $permissions)->count() || $this->roles()->whereHas('permissions', function ($q) use ($permissions) {
            $q->whereIn('name', $permissions);
        })->count();


    }

    public function getPermissionIdByName($permissions){
        return Permission::whereIn('name', $permissions)->get()->pluck('id');
    }

    public  function givePermissionTo($permissions){
        
        $this->permissions()->attach($this->getPermissionIdByName($permissions));
    }

     public function setPermissionsTo($permissions){
        $this->permissions()->sync($this->getPermissionIdByName($permissions));
     }

     public function detachPermissions($permissions){
        $this->permissions()->detach($permissions);
     }
}