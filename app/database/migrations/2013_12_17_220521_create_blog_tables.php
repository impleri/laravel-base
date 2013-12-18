<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlogTables extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->increments('id')->primary();
			$table->string('slug')->index();
			$table->string('title');
			$table->foreign('author')->references('id')->on('users');
			$table->tinyInteger('status');
			$table->text('body');
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('tags', function(Blueprint $table)
		{
			$table->increments('id')->primary();
			$table->string('slug')->index();
			$table->string('name');
			$table->string('description');
		});

		Schema::create('post_taxonomy'), function(Blueprint $table)
		{
			$table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');

			// Manually create the morph since the _id should be unsigned
			$table->unsignedInteger('termable_id');
			$table->string('termable_type');

			// Ensure no duplicates appear
			$table->primary(array('post_id', 'termable_id', 'termable_type'));
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down()
	{
		Schema::drop('post_taxonomy');
		Schema::drop('series');
		Schema::drop('tags');
		Schema::drop('posts');
	}
}
