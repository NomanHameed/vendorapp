<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('stores')) {
            Schema::create('stores', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('store_id')->nullable();
                $table->string('token')->nullable();
                
                $table->string('store_name')->nullable();
                $table->string('domain')->nullable();
                $table->string('shop_domain')->nullable();

                $table->string('store_owner')->nullable();
                $table->string('email')->nullable();
                $table->string('customer_email')->nullable();
                
                $table->string('address1')->nullable();
                $table->string('address2')->nullable();
                $table->string('city')->nullable();
                $table->string('zip')->nullable();
                $table->string('province')->nullable();
                $table->string('province_code')->nullable();
                $table->string('country')->nullable();
                $table->string('country_code')->nullable();

                $table->unsignedBigInteger('primary_location_id')->nullable();
                $table->string('primary_locale')->nullable();
                $table->double('latitude')->nullable();
                $table->double('longitude')->nullable();

                $table->string('currency')->nullable();
                $table->longText('enabled_presentment_currencies')->nullable();

                $table->string('money_format')->nullable();
                $table->string('plan_display_name')->nullable();
                $table->string('plan_name')->nullable();
                $table->string('force_ssl')->nullable();
                
                $table->string('store_created_at')->nullable();
                $table->string('store_updated_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
