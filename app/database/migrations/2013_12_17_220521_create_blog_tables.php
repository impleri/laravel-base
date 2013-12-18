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
			$table->integer('parent_id')->nullable()->index();
      		$table->integer('lft')->nullable()->index();
      		$table->integer('rgt')->nullable()->index();
      		$table->integer('depth')->nullable()->index();
      		$table->timestamps();
		});

		Schema::create('post_tags', function(Blueprint $table)
		{
			$table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
			$table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
			$table->primary(array('post_id', 'tag_id'));
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down()
	{
		Schema::drop('post_tags');
		Schema::drop('series');
		Schema::drop('tags');
		Schema::drop('posts');
	}
}
