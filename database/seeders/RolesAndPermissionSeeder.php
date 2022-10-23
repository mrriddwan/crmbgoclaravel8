<?php

namespace Database\Seeders;


use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'create contacts']);
        Permission::create(['name' => 'edit contacts']);
        Permission::create(['name' => 'delete contacts']);
       
        Permission::create(['name' => 'create todos']);
        Permission::create(['name' => 'edit todos']);
        Permission::create(['name' => 'delete todos']);

        Permission::create(['name' => 'view admin']);
        Permission::create(['name' => 'view contactSummary']);
        Permission::create(['name' => 'view forecastSummary']);
        Permission::create(['name' => 'view forecast']);
        Permission::create(['name' => 'view project']);
        Permission::create(['name' => 'view bb/tb']);

        // create roles and assign created permissions

        // this can be done as separate statements
        // or may be done by chaining

        $role_alpha = Role::create(['name' => 'super-admin']);
        $user_admin = User::where('id','=', 1)->first();
        $user_admin->assignRole($role_alpha);
        
        $role1 = Role::create(['name' => 'admin']);
        $role1->givePermissionTo(Permission::all());

        $user1 = User::where('id','=', 2)->first();
        $user1->assignRole($role1);

        $role2 = Role::create(['name' => 'supervisor']);
        $role2->givePermissionTo(['create contacts', 'edit contacts', 'delete contacts']);

        $user2 = User::where('id','=', 3)->first();
        $user2->assignRole($role2);


        $role3 = Role::create(['name' => 'user']);
        $role3->givePermissionTo('create contacts', 'edit contacts');

        $user3 = User::where('id','=', 4)->first();
        $user3->assignRole($role3);

    }
}
