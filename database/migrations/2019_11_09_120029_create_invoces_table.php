<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvocesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_headers', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('order_number', 100);
            $table->string('customer', 100);
            $table->string('delivery_address', 100);
            $table->string('total_item', 100);
            $table->string('total_amount', 100);
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     *s
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoces');
    }
}
