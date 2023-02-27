<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePesertaTable extends Migration {

	public function up()
	{
		Schema::create('peserta', function(Blueprint $table) {
			$table->increments('id');
			$table->string('nama');
			$table->string('email')->unique();
			$table->string('password');
			$table->string('phone');
			$table->string('no_induk')->unique()->nullable();
			$table->rememberToken('rememberToken');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('peserta');
	}
}