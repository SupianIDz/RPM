<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\User\Enums\Role;
use App\User\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run() : void
    {
        $this->call([
            ProductSeeder::class,
        ]);

        collect(Role::cases())->each(function (Role $role) {
            \App\User\Models\Role::create([
                'name' => $role,
            ]);
        });

        /**
         * @var User $user
         */
        $user = User::factory()->create([
            'name'     => 'Supian M',
            'email'    => 'supianidz@gmail.com',
            'password' => bcrypt('exploded'),
        ]);

        $user->assignRole(Role::ADMIN);

        /**
         * @var User $user
         */
        $user = User::factory()->create([
            'name'     => 'Admin',
            'email'    => 'rpm@example.com',
            'password' => bcrypt('secret'),
        ]);

        $user->assignRole(Role::ADMIN);

        User::factory()->create([
            'name'     => 'Cashire',
            'email'    => 'cashire@example.com',
            'password' => bcrypt('secret'),
        ])
            ->assignRole(Role::CASHIER);

        User::factory()->create([
            'name'     => 'Mechanic',
            'email'    => 'mechanic@example.com',
            'password' => bcrypt('secret'),
        ])
            ->assignRole(Role::MECHANIC);

        User::factory()->create([
            'name'     => 'Inventory',
            'email'    => 'inventory@example.com',
            'password' => bcrypt('secret'),
        ])
            ->assignRole(Role::INVENTORY);

        collect([
            Role::CASHIER->value   => 3,
            Role::INVENTORY->value => 3,
            Role::MECHANIC->value  => 1,
        ])
            ->each(function ($count, $role) {
                User::factory($count)->create()->each(function (User $user) use ($role) {
                    $user->assignRole($role);
                });
            });
    }
}
