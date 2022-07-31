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
        Schema::create('gateway_data_all_stages', function (Blueprint $table) {
            $table->id();
            $table->integer('doc_id')->nullable();
            $table->integer('student_id')->nullable();
            $table->integer('university_id')->nullable();
            $table->integer('college_id')->nullable();
            $table->integer('section_id')->nullable();
            $table->integer('stage_id')->nullable();
            $table->text('hash')->nullable();
            $table->text('prev_hash')->nullable();
            $table->text('chain_hash')->nullable();
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
        Schema::dropIfExists('node_gateway_all_stages');
        Schema::dropIfExists('gateway_data_all_stages');
    }
};
