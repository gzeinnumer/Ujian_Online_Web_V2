<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUjianTable extends Migration {

	public function up()
	{
		Schema::create('ujian', function(Blueprint $table) {
			$table->increments('id');
			$table->string('nama');
			$table->text('deskripsi')->nullable();
			$table->timestamp('waktu_mulai')->nullable();
			$table->timestamp('waktu_akhir')->nullable();
			$table->integer('user_id');
			$table->integer('jumlah_pilihan');
			$table->integer('jumlah_esay');
			$table->string('api_token')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('ujian');
	}
}