<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeImeiDataValueOnUserAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_accounts', function (Blueprint $table) {
            //
            $table->dropColumn('imei');
        });
        Schema::table('user_accounts', function (Blueprint $table) {
            //
            $table->string('imei');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_accounts', function (Blueprint $table) {
            //
            $table->dropColumn('imei');

        });

        Schema::table('user_accounts', function (Blueprint $table) {
            //
            $table->integer('imei');

        });
    }
}
