<?php

use Illuminate\Database\Migrations\Migration;

class CabinetSetupUploadsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Creates the uploads table
        Schema::create('uploads', function($table)
        {
            $table->increments('id');
            $table->string('filename');
            $table->string('path');
            $table->integer('size');
            $table->string('extension');
            $table->string('mimetype');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('parent_id')->unsigned()->index(); // If this is a child file, it'll be referenced here.
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('uploads');
    }

}
