<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('social_media')) {
            Schema::create('social_media', function (Blueprint $table) {
                $table->id();
                $table->string('var', 20)->unique();
                $table->string('title');
                $table->string('icon')->nullable();
                $table->string('classname')->nullable();
                $table->text('url')->nullable();
                $table->enum('status', ['A', 'NA'])->nullable();
                $table->string('user_verify')->nullable();
                $table->timestamps();
                $table->timestamp('deleted_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('social_media');
    }
}
