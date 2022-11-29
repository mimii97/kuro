<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateReactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('like')->nullable();
            $table->string('dislike')->nullable();
            $table->foreignId("user_id")->constrained("users")->references("id")->onUpdate("cascade");
            $table->foreignId("blog_id")->constrained("blogs")->references("id")->onUpdate("cascade");
            $table->unique(['user_id', 'blog_id']);
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
        Schema::dropIfExists('reactions');
    }
}