<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
//        $developer = new User();
//        $developer->name = 'Test Amin User';
//        $developer->email = 'test@mponte.com';
//        $developer->password = bcrypt('secret@123');
//        $developer->save();
//
//        $developer->assignRole('admin');

        $developer = new User();
        $developer->name = 'AMLIS Test User';
        $developer->email = 'amlistest@olduvailabs.co.tz';
        $developer->password = bcrypt('secret@123');
        $developer->save();

        // $developer->assignRole('admin');
    }
}
