<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUjianPesertaTable extends Migration {

	public function up()
	{
		Schema::create('ujian_peserta', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('ujian_id');
			$table->integer('peserta_id');
			$table->string('soal_ids')->nullable();
			$table->string('status')->nullable();
			$table->integer('nilai_pilihan')->nullable();
			$table->integer('nilai_esay')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('ujian_peserta');
	}
}