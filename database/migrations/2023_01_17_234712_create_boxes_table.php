<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_size')->default(0);
            $table->unsignedBigInteger('id_presentation')->default(0);

            $table->string('code', 50);
            $table->string('name', 100);
            $table->float('kilograms', 8, 2);
            $table->float('price', 8, 2);
            $table->float('cost', 8, 2)->default(0);
            $table->longText('description')->nullable();
            $table->float('stock', 10, 2)->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('id_size')->references('id')->on('sizes');
            $table->foreign('id_presentation')->references('id')->on('presentations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boxes');
    }
}
