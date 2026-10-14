<?php

namespace Database\Seeders;

use App\Enum\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->role(UserRole::Admin)->create([
            'name' => 'Administrator',
            'email' => 'admin@email.com',
            'password' => 'password',
        ]);

        $authors = [
            [
                'name' => 'Andi Pratama',
                'email' => 'andi@email.com',
            ],
            [
                'name' => 'Siti Rahma',
                'email' => 'siti@email.com',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@email.com',
            ],
        ];

        foreach ($authors as $author) {
            User::factory()
                ->role(UserRole::Author)
                ->create([
                    ...$author,
                    'password' => 'password',
                ]);
        }
    }
}
