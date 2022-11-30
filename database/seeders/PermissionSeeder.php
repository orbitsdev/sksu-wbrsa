<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // osas   
        // 1. manage-school-year 
        // 2. manage-application-requirements
        // 3. manage-sbo

        // RESPONSE FROM CAMPUS DIRECTOR
        // 3. review applicaiton form from campus director and reuirements  [approve or return ]  return to sbo-adviser if campus direcot miss the  the requirements
        // 4. create endorsement list of clubs and organization qualified for accredetations t- vpaa

        // student-body-organization (officers)
        // 1. fill-out-application-requirement
        
        // sbo-adviser 
        // 1. review applications - from sbo (officers) | aprrove / return 
        // 2. submit letter to campus director with application documents

        // campus directo/deans
        // 1. review letter and endorsement application - from sbo-adviser |  aprrove / return 
        // 2. recommend aprooved application of student to osas
        
        // vpaa
        // 1. aprrove list of clubs and organizations from osas
        // 2. issue certificate of accrediation  - pass to sbo-adviser


        $permissions = [
            //DEVELOPER
            
            //OSAS
            'manage-school-year', 
            'manage-sbo', 
            'manage-application', 
            'review-application-from-campus-director',
            'create-qualified-club-and-organizations-list',
            'endorse-qualified-club-and-organization-list-to-vpaa',
            //SBO-OFFICERS,
            'fill-out-application',
            //SBO-ADVISER,
            'review-applications-from-sbo',
            'recommend-application-to-campus-director',
            //CAMPUS DIRECTOR
            'review-letters-from-sbo-adviser',
            'review-application-from-sbo-adviser',
            'recommend-approve-application-to-osas',
            'manage-roles',
            //VPAA
            'aprrove-list-clubs-organizations-from-osas',
            'create-accreditation-certificate',


        
        ];

    foreach($permissions as $permission){
        Permission::create([
            'name'=> $permission,
            'slug'=> $permission,
        ]);
    }

    }
}
