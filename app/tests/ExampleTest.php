<?php

class ExampleTest extends TestCase {
   public function setUp()
   {
      parent::setUp();

      $this->prepareForTests();
   }

   // Create the application
   public function createApplication()
   {
      $unitTesting = true;

      $testEnvironment = 'testing';

      return require __DIR__.'/../../bootstrap/start.php';
   }

   // Migrate the database
   private function prepareForTests()
   {
      Artisan::call('migrate');
   }

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testBasicExample()
	{
		$crawler = $this->client->request('GET', '/');

		$this->assertTrue($this->client->getResponse()->isOk());
	}

}
