<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMNOToUserAccountsTable extends Migration
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
            $table->unsignedBigInteger('m_n_o_id')->unsigned();
            $table->foreign('m_n_o_id')->references('id')->on('m_n_o_s');
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
            $table->dropForeign(['m_n_o_id']);
            $table->dropColumn('m_n_o_id');
        });
    }
}
