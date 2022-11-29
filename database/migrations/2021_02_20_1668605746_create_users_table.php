<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->string('user_name')->unique();
            $table->integer('age');
            $table->foreignId("group_id")->default('2')->constrained("admin_groups")->references("id");
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->foreignId("vote_plan_id")->nullable()->constrained("vote_plans")->references("id");
            $table->foreignId("b_f_o_t_plan_id")->nullable()->constrained("b_f_o_t_plans")->references("id");
            $table->double('vote_revenue')->nullable();
            $table->double('bfot_revenue')->nullable();

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
        Schema::dropIfExists('users');
    }
}