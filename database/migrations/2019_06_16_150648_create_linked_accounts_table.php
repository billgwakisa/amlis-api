<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkedAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linked_accounts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_account_id')->unsigned();
            $table->foreign('user_account_id')->references('id')->on('user_accounts');


            $table->string('account_number');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');

            //0 - inactive // 1 - active
            $table->integer('status');

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
        Schema::dropIfExists('linked_accounts');
    }
}
