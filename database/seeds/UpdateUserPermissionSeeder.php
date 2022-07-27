<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UpdateUserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::updateOrCreate(['name' => 'create-product'],['name' => 'create-product']);
        Permission::updateOrCreate(['name' => 'delete-product'],['name' => 'delete-product']);
        Permission::updateOrCreate(['name' => 'update-product'],['name' => 'update-product']);
        Permission::updateOrCreate(['name' => 'view-products'],['name' => 'view-products']);

        Permission::updateOrCreate(['name' => 'create-sp-voucher'],['name' => 'create-sp-voucher']);
        Permission::updateOrCreate(['name' => 'delete-sp-voucher'],['name' => 'delete-sp-voucher']);
        Permission::updateOrCreate(['name' => 'update-sp-voucher'],['name' => 'update-sp-voucher']);
        Permission::updateOrCreate(['name' => 'view-sp-vouchers'],['name' => 'view-sp-vouchers']);

        Permission::updateOrCreate(['name' => 'create-jv-voucher'],['name' => 'create-jv-voucher']);
        Permission::updateOrCreate(['name' => 'delete-jv-voucher'],['name' => 'delete-jv-voucher']);
        Permission::updateOrCreate(['name' => 'update-jv-voucher'],['name' => 'update-jv-voucher']);
        Permission::updateOrCreate(['name' => 'view-jv-vouchers'],['name' => 'view-jv-vouchers']);

    }
}
