<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('links', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->comment('//名称');
            $table->string('title')->default('')->comment('//标题');
            $table->string('url')->default('')->comment('//链接');
            $table->integer('no_order')->default(0)->comment('//排序');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::drop('links');
    }
}
