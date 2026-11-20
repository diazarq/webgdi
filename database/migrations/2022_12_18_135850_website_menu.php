<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WebsiteMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->integer('parent_id');
            $table->enum('menu_type', ['page', 'url']);
            $table->enum('page_type', ['general', 'contact', 'blog_list', 'program_list', 'gallery', 'homepage']);
            $table->mediumText('content')->nullable();
            $table->text('slug')->nullable();
            $table->integer('order')->nullable();
            $table->enum('status_display', ['draft', 'publish']);
            $table->text('url')->nullable();
            $table->enum('footer_display', ['A', 'NA']);
            $table->text('featured_img')->nullable();
            $table->string('user_verify')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
