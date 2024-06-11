<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->warn('Creating user roles...');
        Role::make(['name' => 'advertiser'])->save();
        Role::make(['name' => 'billboard_owner'])->save();
        $this->command->info('User roles created.');

        $advertiserRole = Role::findByName('advertiser');
        $billboardOwnerRole = Role::findByName('billboard_owner');

        $this->command->warn('Assigning permissions to user roles...');
        $advertiserRole->givePermissionTo([
            'create_campaign',
            'delete_campaign',
            'view_campaign',
            'update_campaign',
            'view_any_campaign',

            'create_brand',
            'delete_brand',
            'view_brand',
            'update_brand',

            'view_billboard',
            'view_any_billboard',

            'create_payment',
            'delete_payment',
            'view_payment',
            'update_payment',
            'view_any_payment',

        ]);

        $billboardOwnerRole->givePermissionTo([
            'create_billboard',
            'delete_billboard',
            'view_billboard',
            'update_billboard',
            'view_any_billboard',

            'view_billboard::owner',
            'create_billboard::owner',
            'delete_billboard::owner',
            'update_billboard::owner',

        ]);

        $this->command->info('Permissions assigned to user roles.');

    }
}
