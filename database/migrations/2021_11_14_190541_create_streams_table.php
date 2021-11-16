<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('streams', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->integer('user_id');
            $table->string('user_login');
            $table->string('user_name');
            $table->integer('game_id')->nullable()->index();
            $table->string('game_name');
            $table->string('type');
            $table->string('title');
            $table->integer('viewer_count');
            $table->timestamp('started_at');
            $table->string('language');
            $table->text('thumbnail_url');
            $table->boolean('is_mature')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('streams');
    }
}
