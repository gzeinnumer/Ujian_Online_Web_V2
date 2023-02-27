<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSoalTable extends Migration {

	public function up()
	{
		Schema::create('soal', function(Blueprint $table) {
			$table->increments('id');
			$table->text('pertanyaan');
			$table->string('type');
			$table->integer('ujian_id');
			$table->string('a')->nullable();
			$table->string('b')->nullable();
			$table->string('c')->nullable();
			$table->string('d')->nullable();
			$table->string('e')->nullable();
			$table->string('benar')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('soal');
	}
}