<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersPostsTable extends Migration
{
    public function up(): void
    {
        Schema::create('users_posts', function (Blueprint $table) {
            $table->uuid('user_id');
            $table->uuid('post_id');

            $table->primary(['user_id', 'post_id']);

            $table->foreign('post_id')
                ->on('posts')
                ->references('id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_posts');
    }
}
