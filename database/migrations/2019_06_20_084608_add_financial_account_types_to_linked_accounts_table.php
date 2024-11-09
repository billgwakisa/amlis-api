<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFinancialAccountTypesToLinkedAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('linked_accounts', function (Blueprint $table) {

            //Financial Account Type
            $table->unsignedBigInteger('financial_account_type_id')->unsigned();
            $table->foreign('financial_account_type_id')->references('id')->on('financial_account_types');

            //We also need the linked institution
            $table->unsignedBigInteger('financial_institution_id')->unsigned();
            $table->foreign('financial_institution_id')->references('id')->on('financial_institutions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('linked_accounts', function (Blueprint $table) {
            //
            $table->dropForeign(['financial_account_type_id']);
            $table->dropColumn('financial_account_type_id');

            $table->dropForeign(['financial_institution_id']);
            $table->dropColumn('financial_institution_id');
        });
    }
}
