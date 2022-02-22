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
        Schema::create('final_sheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId("student_id");
            $table->foreignId("college_id");
            $table->foreignId("stage_id");
            $table->foreignId("year_id");
            $table->float('average')->default(0);
            $table->float('avg_1st_rank')->default(0);
            $table->foreignId('study_type_id')->default(1);
            $table->foreignId('graduation_degree_id')->default(1);
            $table->string('number_date_graduation_degree')->default('');
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
        Schema::dropIfExists('final_sheets');
    }
};
