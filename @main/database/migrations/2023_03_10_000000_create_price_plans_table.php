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
        Schema::create('price_plans', function (Blueprint $table) {
            $table->id();
            $table->string("type")->nullable();
            $table->string("title")->nullable();
            $table->string('money_sign')->default('$');
            $table->decimal('amount', 8, 2)->default(0.00);
            $table->string("duration")->default(1);
            $table->string("details")->nullable();
            $table->text("features")->nullable(); //
            $table->string("badge_text")->nullable();
            $table->boolean("is_highlighted")->default(0);
            $table->string("category")->nullable();
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
        Schema::dropIfExists('price_plans');
    }
};
