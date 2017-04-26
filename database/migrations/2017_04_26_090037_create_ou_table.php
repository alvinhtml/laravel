<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ou', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment("名称");
            $table->integer('ouid')->default(0)->comment("部门");
            $table->string('path')->comment("部门全路径");
            $table->text('desp')->comment("描述");
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
        Schema::dropIfExists('ou');
    }
}
