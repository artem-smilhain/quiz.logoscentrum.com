<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('answer_id');
            $table->boolean('is_true');
            //
            $table->timestamps();
            //
            $table->engine = 'InnoDB';
            //
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('answer_id')->references('id')->on('answers')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tests');
    }
}
