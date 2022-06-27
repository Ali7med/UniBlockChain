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
        Schema::create('phase2s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id');
            $table->foreignId('phase1_id');
            $table->foreignId('user_id')->nullable();
            $table->foreignId('operation_id');
            $table->string('hash');
            $table->boolean('sended')->default(false);
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
        Schema::dropIfExists('phase2s');
    }
};
