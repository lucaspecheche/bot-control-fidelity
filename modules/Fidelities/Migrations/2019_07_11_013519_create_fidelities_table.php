<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFidelitiesTable extends Migration
{
    public function up()
    {
        Schema::create('fidelities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->timestamp('startAt')->default(now());
            $table->integer('amount');
            $table->integer('remainder');
            $table->unsignedInteger('user_id');

            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fidelities');
    }
}
