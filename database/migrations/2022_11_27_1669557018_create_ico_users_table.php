<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateIcoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ico_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('amount');
            $table->enum('status',['joined','pending']);
            $table->enum('purchase_method',['pancakeswap','indoex','kuro_team'])->nullable();
            $table->foreignId("user_id")->constrained("users")->references("id");
            $table->foreignId("i_c_o_id")->constrained("i_c_os")->references("id");
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
        Schema::dropIfExists('ico_users');
    }
}