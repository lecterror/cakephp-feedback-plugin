<?php
App::uses('Rating', 'Feedback.Model');

/**
 * Rating Test Case
 *
 */
class RatingTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('plugin.feedback.rating', 'app.foreign');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Rating = ClassRegistry::init('Rating');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Rating);

		parent::tearDown();
	}

}
