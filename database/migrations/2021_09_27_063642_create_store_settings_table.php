<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->unsignedBigInteger('account_number')->nullable();
            $table->string('api_key', 255)->nullable();
            $table->string('profile_email')->nullable();
            $table->unsignedBigInteger('profile_id')->nullable();
            $table->string('profile_name', 255)->nullable();
            $table->string('profile_type')->nullable();
            $table->boolean('is_canada')->nullable();
            $table->boolean('order_active')->nullable();
            $table->boolean('update_active')->nullable();

            $table->string('new_product')->nullable();
            $table->string('marrgin_type')->nullable();
            $table->float('price_margin')->nullable();
            $table->boolean('import_cats')->default(0);
            $table->boolean('import_brands')->default(0);

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
        Schema::dropIfExists('store_settings');
    }
}
