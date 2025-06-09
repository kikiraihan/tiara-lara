<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin@gmail.com'),
        ]);

        // $this->call(KupvaProfilSeeder::class);
        // $this->call(KupvaNraSeeder::class);
        // $this->call(PjpProfilSeeder::class);
        // $this->call(PjpNraSeeder::class);
        // $this->call(ModelMachineLearningSeeder::class);
        // $this->call(ValidationDatasetModelSeeder::class);
    }
}
