<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePilihanTable extends Migration {

	public function up()
	{
		Schema::create('pilihan', function(Blueprint $table) {
			$table->increments('id');
			$table->text('isi');
			$table->tinyInteger('benar')->default('0');
			$table->integer('soal_id');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('pilihan');
	}
}