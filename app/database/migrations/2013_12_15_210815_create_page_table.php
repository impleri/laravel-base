<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePageTable extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up()
	{
		Schema::create('pages', function(Blueprint $table)
		{
			$table->increments('id')->primary();
			$table->string('slug')->index();
			$table->string('title');
			$table->tinyInteger('status');
			$table->text('body');
			$table->timestamps();
			$table->sotDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down()
	{
		Schema::drop('pages');
	}
}
