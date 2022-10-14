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
            'name' => 'Admin', 
            'email' => 'admin@gmail.com', 
            'password' => bcrypt('admin123'),
            'email_password' => bcrypt('admin123'),
        ]);

        User::create([
            'name' => 'Media 3', 
            'email' => 'media3@gmail.com', 
            'password' => bcrypt('media3bluedale'),
            'email_password' => bcrypt('media3bluedale'),
        ]);
        
        User::create([
            'name' => 'James', 
            'email' => 'james@gmail.com', 
            'password' => bcrypt('james123'),
            'email_password' => bcrypt('james123'),
        ]);

        User::create([
            'name' => 'Ali', 
            'email' => 'ali@gmail.com', 
            'password' => bcrypt('ali123'),
            'email_password' => bcrypt('ali123'),
        ]);

        User::create([
            'name' => 'Abu', 
            'email' => 'abu@gmail.com', 
            'password' => bcrypt('abu123'),
            'email_password' => bcrypt('abu123'),
        ]);

        User::create([
            'name' => 'Chong', 
            'email' => 'chong@gmail.com', 
            'password' => bcrypt('chong123'),
            'email_password' => bcrypt('chong123'),
        ]);

        User::create([
            'name' => 'Siti', 
            'email' => 'siti@gmail.com', 
            'password' => bcrypt('siti123'),
            'email_password' => bcrypt('siti123'),
        ]);

        User::create([
            'name' => 'Ahmad', 
            'email' => 'ahmad@gmail.com', 
            'password' => bcrypt('ahmad123'),
            'email_password' => bcrypt('ahmad123'),
        ]);

        User::create([
            'name' => 'Harry', 
            'email' => 'harry@gmail.com', 
            'password' => bcrypt('harry123'),
            'email_password' => bcrypt('harry123'),
        ]);

        User::create([
            'name' => 'Lydia', 
            'email' => 'lydia@gmail.com', 
            'password' => bcrypt('lydia123'),
            'email_password' => bcrypt('lydia123'),
        ]);

        // User::factory(20)->create();
    }
}
