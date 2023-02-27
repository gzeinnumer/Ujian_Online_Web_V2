<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJawabanTable extends Migration {

	public function up()
	{
		Schema::create('jawaban', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('peserta_id');
			$table->integer('soal_id');
			$table->text('jawaban')->nullable();
			$table->integer('nilai')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('jawaban');
	}
}