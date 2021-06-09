<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowersTable extends Migration
{
    public function up(): void
    {
        Schema::create('followers', function (Blueprint $table) {

            $table->uuid('owner_id')->comment('На кого подписан');
            $table->uuid('follower_id')->comment('Кто подписан');

            $table->primary(['owner_id', 'follower_id']);

            $table->foreign('owner_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('follower_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('followers');
    }
}
