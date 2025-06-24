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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('titel_name')->nullable();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('slug')->nullable();
            $table->string('street_address')->nullable();
            $table->string('city')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->nullable();
            $table->text('teaser')->nullable();
            $table->longText('description')->nullable();
            $table->string('image_url')->nullable();
            $table->string('banner_url')->nullable();
            $table->string('website_url')->nullable();
            $table->string('fb_url')->nullable();
            $table->string('instagram_url')->nullable();
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
        Schema::dropIfExists('students');
    }
};
