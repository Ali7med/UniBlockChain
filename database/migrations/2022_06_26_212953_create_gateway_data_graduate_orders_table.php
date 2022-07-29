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
        Schema::create('gateway_data_graduate_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('university_id')->nullable();
            $table->integer('college_id')->nullable();
            $table->integer('section_id')->nullable();
            $table->integer('stage_id')->nullable();
            $table->text('hash')->nullable();
            $table->text('en_hash')->nullable();
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
        Schema::dropIfExists('gateway_data_graduate_orders');
        Schema::dropIfExists('node_gateway_graduate_orders');

    }
};
