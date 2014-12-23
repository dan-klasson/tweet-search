<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTweetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tweets', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
		    $table->increments('id', true);
		    $table->integer('search_id')->unsigned();
			$table->char('username', 50);
			$table->string('tweet', 140);
			$table->string('profile_pic', 240);
			$table->char('geo_lat', 50);
			$table->char('geo_lng', 50);
			$table->dateTime('updated_at');
			$table->dateTime('created_at');
		});
		Schema::table('tweets', function($table) {
		   $table->foreign('search_id')->references('id')->on('searches')->onDelete('cascade');
	   });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tweets', function(Blueprint $table)
		{
			$table->dropForeign('tweet_search_id_foreign');
		});
		Schema::drop('tweets');
	}

}
