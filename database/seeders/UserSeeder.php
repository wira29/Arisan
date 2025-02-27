<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = \Spatie\Permission\Models\Role::all();

        $roles->each(function ($role) {
            $user = User::factory(['email' => $role->name . '@gmail.com'])->create();
            $user->assignRole($role);
        });
    }
}
