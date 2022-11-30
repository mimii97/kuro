<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNumPrizesToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('num_vote_plan_paid_prizes')->default(0);
            $table->integer('num_bfot_plan_paid_prizes')->default(0);
            $table->integer('num_paid_votes')->default(0);
            $table->integer('paid_vote_plan_balance')->default(0);
            $table->integer('num_paid_refs')->default(0);
            $table->integer('paid_bfot_plan_balance')->default(0);
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
            //
        });
    }
}
