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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained();
            $table->string('title');
            $table->string("slug")->nullable();
            $table->string('type')->nullable();
            $table->string('available_seat')->nullable();
            $table->text('teaser')->nullable();
            $table->longText('description')->nullable();
            $table->string('image_url')->nullable();
            $table->string('video_url')->nullable();
            $table->string('document_url')->nullable();
            $table->dateTime("start_datetime")->nullable();
            $table->dateTime("end_datetime")->nullable();
            $table->string('location')->nullable();
            $table->string('join_url')->nullable();
            $table->dateTime('visible_from')->nullable();
            $table->dateTime('visible_to')->nullable();
            $table->dateTime('registration_start_at')->nullable();
            $table->dateTime('registration_end_at')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('events');
    }
};
