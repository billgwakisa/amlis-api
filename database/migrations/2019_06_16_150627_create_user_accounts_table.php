<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_accounts', function (Blueprint $table) {
            $table->id();

            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');

            //0 - inactive //1 - active //2 - under review/investigation
            $table->integer('status');
            $table->string('phone');
//            $table->enum('mno', ['vodacom', 'tigo', 'ttcl', 'airtel', 'halotel']);
            // we'll make this a foreign key with a table of operators

            $table->integer('imei');

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
        Schema::dropIfExists('user_accounts');
    }
}
