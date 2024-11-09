<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUserAccountIdFromMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchants', function (Blueprint $table) {
            //
//            $table->dropForeign(['user_account_id']);
//            $table->dropColumn('user_account_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('merchants', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('user_account_id')->unsigned();
//            $table->foreign('user_account_id')->references('id')->on('user_accounts');
        });
    }
}
