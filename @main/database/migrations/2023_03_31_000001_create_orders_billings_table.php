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
        Schema::create('order_billings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('price_plan_id')->nullable()->constrained();
            $table->integer('qty')->default(1);
            $table->decimal('total_price', 8, 2)->default(0.00);
            $table->string('payment_method')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('street_address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('zip')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('alt_first_name')->nullable();
            $table->string('alt_last_name')->nullable();
            $table->string('alt_street_address')->nullable();
            $table->string('alt_city')->nullable();
            $table->string('alt_country')->nullable();
            $table->string('alt_zip')->nullable();
            $table->string('alt_email')->nullable();
            $table->string('alt_phone')->nullable();
            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();
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
        Schema::dropIfExists('orders_manual');
    }
};
