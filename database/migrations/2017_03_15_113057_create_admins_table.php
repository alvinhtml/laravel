<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment("名称");
            $table->string('email')->unique()->comment("邮箱");
            $table->string('password', 255);
            $table->integer('type')->default(0)->comment("类型");
            $table->integer('ouid')->default(0)->comment("部门");
            $table->integer('state')->default(0)->comment("状态");
            $table->text('desp')->nullable()->comment("描述");
            //$table->foreign('ouid')->references('id')->on('ou');
            $table->rememberToken();
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
        Schema::dropIfExists('admins');
    }
}
