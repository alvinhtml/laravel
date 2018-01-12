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
            $table->integer('type')->nullable()->index()->comment("类型");
            $table->integer('ou_id')->nullable()->unsigned()->index()->comment("部门");
            $table->string('os')->nullable()->comment("操作系统");
            $table->string('hostname')->nullable()->comment("主机名");
            $table->integer('user_id')->nullable()->unsigned()->comment("user");
            $table->integer('state')->index()->comment("状态");
            $table->text('desp')->nullable()->comment("描述");
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
