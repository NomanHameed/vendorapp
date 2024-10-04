<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('lineitem_id')->nullable();
            $table->unsignedBigInteger('shopify_product_id')->nullable();
            $table->unsignedBigInteger('shopify_variant_id')->nullable();
            $table->string('name')->nullable();
            $table->string('quantity')->nullable();
            $table->string('sku')->nullable();
            $table->string('vendor')->nullable();
            $table->string('fulfillment_service')->nullable();
            $table->string('requires_shipping')->nullable();
            $table->string('taxable')->nullable();
            $table->string('grams')->nullable();
            $table->string('price')->nullable();
            $table->string('total_discount')->nullable();
            $table->string('fulfillment_status')->nullable();
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
        Schema::dropIfExists('order_items');
    }
}
