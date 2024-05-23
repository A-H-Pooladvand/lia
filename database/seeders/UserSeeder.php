<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'              => 'Amirhossein',
            'email'             => 'a.h.pooladvand@gmail.com',
            'mobile'            => '09125878084',
            'email_verified_at' => Carbon::now(),
            'password'          => 12345678
        ]);
    }
}
