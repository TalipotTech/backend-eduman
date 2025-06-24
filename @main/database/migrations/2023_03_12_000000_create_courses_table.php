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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained();
            $table->string('title');
            $table->string("slug")->nullable();
            $table->string('money_sign')->default('$');
            $table->decimal('price', 8, 2)->default(0.00);
            $table->decimal('discount', 8, 2)->default(0.00);
            $table->text('settings_data')->nullable();
            $table->text('teaser')->nullable();
            $table->text('more_info')->nullable();
            $table->text('language')->nullable();
            $table->string("level")->nullable();
            $table->string("credit")->nullable();
            $table->string("duration")->nullable();
            $table->longText('description')->nullable();
            $table->string('image_url')->nullable();
            $table->string('video_url')->nullable();
            $table->string('document_url')->nullable();
            $table->boolean('is_featured')->default(0);
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
        Schema::dropIfExists('courses');
    }
};
