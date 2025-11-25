<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'chefcarlo@mailchef.it'],
            [
                'name' => 'Admin Personalizzato',
                'password' => Hash::make('T3enatrena1!'),
                'email_verified_at' => now(),
            ]
        );
    }
}
