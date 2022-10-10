<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->required();
            $table->string('subtitle', 255)->nullable();
            $table->unsignedSmallInteger('year_published')->zerofill()->nullable();
            $table->unsignedInteger('edition')->nullable();
            $table->string('isbn_10', 10)->nullable();
            $table->string('isbn_13', 13)->nullable();
            $table->unsignedSmallInteger('height')->nullable();
            $table->boolean('on_loan')->default(false);
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
        Schema::dropIfExists('books');
    }
};
