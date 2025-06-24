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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('course_id')->nullable()->constrained();
            $table->decimal('total_price', 8, 2)->default(0.00);
            $table->decimal('discount', 8, 2)->default(0.00);
            $table->string('title')->nullable();
            $table->integer('qty')->default(1);
            $table->decimal('unit_price', 8, 2)->default(0.00);
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
        Schema::dropIfExists('invoices');
    }
};
