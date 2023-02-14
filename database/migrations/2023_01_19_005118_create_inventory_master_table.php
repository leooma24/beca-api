<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_master', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_farm')->nullable();
            $table->unsignedBigInteger('id_type')->default(0);

            $table->date('date');
            $table->string('customer')->nullable()->default('');
            $table->string('driver')->nullable()->default('');
            $table->string('batch', 50)->default('');
            $table->longText('description')->nullable();
            $table->tinyInteger('status')->default(1);

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
        Schema::dropIfExists('inventory_master');
    }
}
