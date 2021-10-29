<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\User;

class DefaultPermissionsSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'create-user']);
        Permission::create(['name' => 'delete-users']);
        Permission::create(['name' => 'update-users']);
        Permission::create(['name' => 'view-users']);
        if(User::where('email','admin@gmail.com')->first()== null){
            // gets all permissions via Gate::before rule; see AuthServiceProvider
            $admin = Role::create(['name' => 'superadmin']);
            $u = Role::create(['name' => 'user']);
            $user = new User();
            $user->name = 'admin';
            $user->email = 'admin@gmail.com';
            $user->password = Hash::make('12345678') ;
            $user->save();
            $user->assignRole($admin);

            $user1 = new User();
            $user1->name = 'Test';
            $user1->email = 'user@gmail.com';
            $user1->password = Hash::make('12345678') ;
            $user1->save();
            $user->assignRole($u);
        }
        
    }
}

