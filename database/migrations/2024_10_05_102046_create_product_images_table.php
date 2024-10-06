<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable();
            $table->string('shopify_product_image_id')->nullable();
            $table->string('shopify_product_id')->nullable();
            $table->text('alt')->nullable();
            $table->string('admin_graphql_api_id')->nullable();
            $table->string('width')->nullable();
            $table->string('height')->nullable();
            $table->string('src')->nullable();
            $table->jsonb('variant_ids')->nullable();
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
        Schema::dropIfExists('product_images');
    }
}
