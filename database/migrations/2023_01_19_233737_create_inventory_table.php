<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_farm')->nullable();
            $table->unsignedBigInteger('id_type')->default(0);
            $table->unsignedBigInteger('id_box')->default(0);
            $table->unsignedBigInteger('id_section')->nullable()->default(0);
            $table->unsignedBigInteger('id_scaffold')->nullable()->default(0);
            $table->unsignedBigInteger('id_inventory_master')->default(0);

            $table->date('date');
            $table->string('scaffold', 50)->nullable()->default(0);
            $table->float('master')->default(0);
            $table->tinyInteger('type')->default(1);
            $table->float('qty')->default(0);
            $table->tinyInteger('status')->default(1);

            $table->timestamps();

            $table->foreign('id_type')->references('id')->on('types');
            $table->foreign('id_box')->references('id')->on('boxes');
            $table->foreign('id_inventory_master')->references('id')->on('inventory_master');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory');
    }
}
