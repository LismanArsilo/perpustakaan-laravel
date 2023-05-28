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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title')->required();
            $table->string('author')->nullable();
            $table->string('publisher')->nullable();
            $table->char('publisher_year', 4)->nullable();
            $table->unsignedBigInteger('cate_id')->required();
            $table->foreign('cate_id')->references('id')->on('categories')->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
            $table->index('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['cate_id']);
            $table->dropIfExists('books');
        });
    }
};
