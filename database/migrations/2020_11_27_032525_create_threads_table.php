<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('channel_id')->constrained();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('body');
            $table->unsignedInteger('replies_count')->default(0);
            $table->unsignedBigInteger('best_reply_id')->nullable();
            $table->boolean('locked')->default(false);
            $table->timestamps();

            $table->index(['user_id', 'replies_count', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('threads');
    }
}
