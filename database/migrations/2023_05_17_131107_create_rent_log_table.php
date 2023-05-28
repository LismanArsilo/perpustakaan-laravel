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
        Schema::create('rent_log', function (Blueprint $table) {
            $table->id();
            $table->date('rent_date')->nullable();
            $table->date('return_date')->nullable();
            $table->unsignedBigInteger('user_id')->required();
            $table->unsignedBigInteger('book_id')->required();
            $table->unsignedBigInteger('status_id')->required();
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('book_id')->references('id')->on('books')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('status_id')->references('id')->on('statuses')->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rent_log');
    }
};
