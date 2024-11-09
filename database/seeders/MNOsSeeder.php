<?php

namespace Database\Seeders;

use App\Models\MNO;
use Illuminate\Database\Seeder;

class MNOsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $developer = new MNO();
        $developer->name = 'Vodacom';
        $developer->description = 'MNO in Tanzania';
        $developer->save();

        $developer = new MNO();
        $developer->name = 'Tigo';
        $developer->description = 'MNO in Tanzania';
        $developer->save();

        $developer = new MNO();
        $developer->name = 'Zantel';
        $developer->description = 'MNO in Tanzania';
        $developer->save();

        $developer = new MNO();
        $developer->name = 'Halotel';
        $developer->description = 'MNO in Tanzania';
        $developer->save();
    }
}
