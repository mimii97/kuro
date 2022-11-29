<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateBFOTPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b_f_o_t_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId("admin_id")->constrained("admins")->onUpdate("cascade")->onDelete("cascade");
            $table->string('type');
            $table->longtext('description');
            $table->integer('num_of_refs_cond');
            $table->double('kuro_balance_cond');
            $table->double('revenue');
			$table->softDeletes();

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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('b_f_o_t_plans');
    }
}