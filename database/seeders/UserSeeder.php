<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $directoryName = 'avatars';

        Storage::disk('public')->deleteDirectory($directoryName);
        Storage::disk('public')->makeDirectory($directoryName);

        $sourcePath      = database_path('seeders/images/default.jpg');
        $destinationPath = "{$directoryName}/default.jpg";

        if (File::exists($sourcePath)) {
            Storage::disk('public')->put($destinationPath, File::get($sourcePath));
        }

        User::factory(5)->create();

        User::factory()->create([
            'name'     => 'admin',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
