<?php

namespace Database\Seeders;

use App\Models\Transactions;
use Illuminate\Database\Seeder;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $time = \Carbon\Carbon::now();

        for ($x = 0; $x <= 5; $x++) {

            $developer = new Transactions();

            $developer->transaction_identifier = "UYVB678IUVY2";

            $developer->lat = rand(-6.745414, -6.725414);
            $developer->long = rand(39.239074, 39.289074);
            $developer->amount = 9000 * $x;
            $developer->start_time = $time->addHour($x);
            $developer->status = 0;

            $developer->type = "CASH_OUT";

            $developer->origin_name = "Test user 1";
            $developer->dest_name = "Wakala 2";

            $developer->description = "Withdrawal";
            $developer->is_fraud = 0;
            $developer->is_flagged_fraud = 0;
            
            $developer->save();
        }


    }
}
