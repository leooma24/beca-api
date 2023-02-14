<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScaffoldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scaffolds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_box')->default(0);
            $table->string('name', 50)->nullable()->default('');
            $table->float('master')->default(0);
            $table->float('qty')->default(0);
            $table->float('kilograms')->default(0);
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
        Schema::dropIfExists('scaffolds');
    }
}
