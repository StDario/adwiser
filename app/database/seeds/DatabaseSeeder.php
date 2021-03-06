<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
		$this->call('QuestionsTableSeeder');
		$this->call('AdvicesTableSeeder');
		$this->call('ReviewsTableSeeder');
	}

}