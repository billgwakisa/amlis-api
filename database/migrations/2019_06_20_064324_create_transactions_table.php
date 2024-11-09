<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->string('transaction_identifier');

            $table->decimal('lat', '12', '8');
            $table->decimal('long', '14', '8');

            $table->string('type');
            $table->string('origin_name');
            $table->string('dest_name');

            $table->decimal('amount', 11, 2);

            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable(true);

            //0 - initiated //1 - successful // 2 - awaiting response
            $table->integer('status');
            $table->string('description');

            $table->boolean('is_fraud');
            $table->boolean('is_flagged_fraud');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
