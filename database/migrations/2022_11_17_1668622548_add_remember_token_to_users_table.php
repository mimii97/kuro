<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class AddRememberTokenToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->double('kuro_balance_wallet')->nullable();
            $table->rememberToken(); // use this for field after specific column.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            /*$table->dropColumn('vote_revenue');
            $table->dropColumn('kuro_balance_wallet');

            $table->dropColumn('remember_token');*/
        });
    }
}