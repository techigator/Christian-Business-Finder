<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $existingAdmin = User::where('type', 'admin')->first();
        if ($existingAdmin) {
            $existingAdmin->delete();
        }

        User::create([
            'id' => 1,
            'type' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@cbf.com',
            'password' => hash::make('admin!@#')
        ]);
    }
}
