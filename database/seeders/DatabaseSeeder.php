<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('user_roles')->insert([
            'title' => 'admin'
        ]);

        DB::table('user_roles')->insert([
            'title' => 'client'
        ]);

        $adminRoleId = DB::table('user_roles')
            ->where('title', 'admin')
            ->value('id');

        DB::table('users')->insert([
            'user_role_id' => $adminRoleId,
            'login' => 'Admin',
            'email' => 'admin@example.com',
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'middle_name' => 'Admin',
            'phone' => '8(900)900-90-90',
            'password' => 'KorokNET',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
