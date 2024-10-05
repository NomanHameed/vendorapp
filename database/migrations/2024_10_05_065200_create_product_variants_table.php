<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable();
            $table->string('product_variant_id')->nullable();
            $table->string('shopify_product_id')->nullable();
            $table->string('title')->nullable();
            $table->string('price')->nullable();
            $table->string('position')->nullable();
            $table->string('inventory_policy')->nullable();
            $table->string('option1')->nullable();
            $table->string('option2')->nullable();
            $table->string('option3')->nullable();
            $table->boolean('taxable')->default(false);
            $table->string('barcode')->nullable();
            $table->string('fulfillment_service')->nullable();
            $table->string('grams')->nullable();
            $table->string('inventory_management')->nullable();
            $table->boolean('requires_shipping')->default(false);
            $table->string('sku')->nullable();
            $table->string('weight')->nullable();
            $table->string('weight_unit')->nullable();
            $table->string('inventory_item_id')->nullable();
            $table->string('inventory_quantity')->nullable();
            $table->string('old_inventory_quantity')->nullable();
            $table->string('admin_graphql_api_id')->nullable();
            $table->string('image_id')->nullable();
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
        Schema::dropIfExists('product_variants');
    }
}
