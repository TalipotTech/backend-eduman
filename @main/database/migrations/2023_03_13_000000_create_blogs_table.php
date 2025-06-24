<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained();
            $table->foreignId('author_id')->nullable()->constrained();
            $table->string("title")->nullable();
            $table->text("teaser")->nullable();
            $table->text("content")->nullable();
            $table->string("image")->nullable();
            $table->string("slug")->nullable();
            $table->string("meta_title")->nullable();
            $table->text("meta_description")->nullable();
            $table->string("meta_image")->nullable();
            $table->string("status")->nullable();
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
        Schema::dropIfExists('blogs');
    }
};
