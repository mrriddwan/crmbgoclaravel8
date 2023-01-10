<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'IT', 
            'email' => 'admin@bluedale.com.my', 
            'password' => 'AdminBluedale987',
            'email_password' => 'AdminBluedale987',
        ]);

        User::create([
            'name' => 'Media 3', 
            'email' => 'media3@gmail.com', 
            'password' => 'media3bluedale',
            'email_password' => 'media3bluedale',
            'user_cat_id' => random_int(1,3),
        ]);
        
        User::create([
            'name' => 'James', 
            'email' => 'james@gmail.com', 
            'password' => 'james123',
            'email_password' => 'james123',
            'user_cat_id' => random_int(1,3),
        ]);

        User::create([
            'name' => 'Ali', 
            'email' => 'ali@gmail.com', 
            'password' => 'ali123',
            'email_password' => 'ali123',
            'user_cat_id' => random_int(1,3),
        ]);

        User::create([
            'name' => 'Abu', 
            'email' => 'abu@gmail.com', 
            'password' => 'abu123',
            'email_password' => 'abu123',
            'user_cat_id' => random_int(1,3),
        ]);

        User::create([
            'name' => 'Chong', 
            'email' => 'chong@gmail.com', 
            'password' => 'chong123',
            'email_password' => 'chong123',
            'user_cat_id' => random_int(1,3),
        ]);

        User::create([
            'name' => 'Siti', 
            'email' => 'siti@gmail.com', 
            'password' => 'siti123',
            'email_password' => 'siti123',
            'user_cat_id' => random_int(1,3),
        ]);

        User::create([
            'name' => 'Ahmad', 
            'email' => 'ahmad@gmail.com', 
            'password' => 'ahmad123',
            'email_password' => 'ahmad123',
            'user_cat_id' => random_int(1,3),
        ]);

        User::create([
            'name' => 'Harry', 
            'email' => 'harry@gmail.com', 
            'password' => 'harry123',
            'email_password' => 'harry123',
            'user_cat_id' => random_int(1,3),
        ]);

        User::create([
            'name' => 'Lydia', 
            'email' => 'lydia@gmail.com', 
            'password' => 'lydia123',
            'email_password' => 'lydia123',
            'user_cat_id' => random_int(1,3),
        ]);

        // User::factory(20)->create();
    }
}
