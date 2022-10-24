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
        Permission::create(['name' => 'create contact']);
        Permission::create(['name' => 'edit contact']);
        Permission::create(['name' => 'delete contact']);
       
        Permission::create(['name' => 'create todo']);
        Permission::create(['name' => 'insert todo']);
        Permission::create(['name' => 'edit todo']);
        Permission::create(['name' => 'delete todo']);

        Permission::create(['name' => 'create followup']);
        Permission::create(['name' => 'edit followup']);
        Permission::create(['name' => 'delete followup']);

        Permission::create(['name' => 'create forecast']);
        Permission::create(['name' => 'edit forecast']);
        Permission::create(['name' => 'delete forecast']);

        Permission::create(['name' => 'create project']);
        Permission::create(['name' => 'edit project']);
        Permission::create(['name' => 'delete project']);

        Permission::create(['name' => 'create billboard']);
        Permission::create(['name' => 'edit billboard']);
        Permission::create(['name' => 'delete billboard']);

        Permission::create(['name' => 'create tempboard']);
        Permission::create(['name' => 'edit tempboard']);
        Permission::create(['name' => 'delete tempboard']);

        Permission::create(['name' => 'view admin']);
        Permission::create(['name' => 'view contact']);
        Permission::create(['name' => 'view todo']);
        Permission::create(['name' => 'view followup']);
        Permission::create(['name' => 'view forecast']);
        Permission::create(['name' => 'view project']);
        Permission::create(['name' => 'view performance']);

        Permission::create(['name' => 'view contact summary']);
        Permission::create(['name' => 'view forecast summary']);
        Permission::create(['name' => 'view billboard/tempboard']);

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
        $role2->givePermissionTo(
            'create contact',
            'edit contact',
            'delete contact',

            'create todo',
            'insert todo',
            'edit todo',
            'delete todo',

            'create followup',
            'edit followup',
            'delete followup',

            'create forecast',
            'edit forecast',
            'delete forecast',

            'create project',
            'edit project',
            'delete project',

            'create billboard',
            'edit billboard',
            'delete billboard',

            'create tempboard',
            'edit tempboard',
            'delete tempboard',

            'view contact',
            'view todo',
            'view followup',
            'view forecast',
            'view project',
            'view performance',
            'view contact summary',
            'view forecast summary',
            'view billboard/tempboard',
            );

        $user2 = User::where('id','=', 3)->first();
        $user2->assignRole($role2);


        $role3 = Role::create(['name' => 'user']);
        $role3->givePermissionTo(
            'create contact',
            'edit contact',
            'delete contact',

            'insert todo',
            'edit todo',
            'delete todo',

            'create followup',
            'edit followup',
            'delete followup',

            'create forecast',
            'edit forecast',
            'delete forecast',

            'view contact',
            'view todo',
            'view followup',
            'view forecast',
        );

        $user3 = User::where('id','=', 4)->first();
        $user3->assignRole($role3);

    }
}
