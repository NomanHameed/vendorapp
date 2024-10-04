<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->string('order_number')->nullable();
            $table->string('total_price')->nullable();
            $table->string('subtotal_price')->nullable();
            $table->string('total_weight')->nullable();
            $table->string('total_tax')->nullable();
            $table->string('currency')->nullable();
            $table->string('financial_status')->nullable();
            $table->string('total_discounts')->nullable();
            $table->string('total_items_price')->nullable();
            $table->boolean('trackpod_posted')->nullable();
            $table->longText('object')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
