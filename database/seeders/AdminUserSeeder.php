<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'status' => 'Active',
            'role_name' => 'Admin',
            'email' => 'admin@admin.com',
            'avatar' => 'photo_defaults.jpg',
            'password' => bcrypt('123456'),
        ]);
    }
}
