<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Traits\HasImagesToSeed;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    use HasImagesToSeed;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subDir = 'avatars';

        Storage::disk('public')->deleteDirectory($subDir);
        Storage::disk('public')->makeDirectory($subDir);

        $this->copyImageToStorage('default-avatar.jpg', $subDir);

        User::factory(5)->create();

        User::factory()->create([
            'name'     => 'admin',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
