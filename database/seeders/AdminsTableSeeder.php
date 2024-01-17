<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::query()->firstOrCreate(
            [
                'email' => config('admin.email'),
            ],
            [
                'name' => config('admin.name'),
                'email' => config('admin.email'),
                'password' => Hash::make(config('admin.password'))
            ]
        );
    }
}
