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
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('salute_name')->nullable();
            $table->string('titel_name')->nullable();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('slug')->nullable();
            $table->string('designation')->nullable();
            $table->string('institute')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('street_address')->nullable();
            $table->string('city')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->nullable();
            $table->text('teaser')->nullable();
            $table->longText('description')->nullable();
            $table->string('promo_video_url')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('banner_url')->nullable();
            $table->string('website_url')->nullable();
            $table->string('fb_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('category')->nullable();
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
        Schema::dropIfExists('authors');
    }
};
