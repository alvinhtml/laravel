<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terms', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->unique()->comment("名称");
            $table->integer('type')->index()->comment("类型");
            $table->integer('ou_id')->unsigned()->index()->comment("部门");
            $table->string('os')->comment("操作系统");
            $table->string('hostname')->comment("主机名");
            $table->integer('user_id')->unsigned()->comment("user");
            $table->integer('state')->index()->comment("状态");
            $table->text('desp')->comment("描述");
            $table->foreign('ou_id')->references('id')->on('ous');
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
        Schema::dropIfExists('terms');
    }
}
