<?php
/* Comment Test cases generated on: 2011-11-20 21:29:55 : 1321820995*/
App::uses('Comment', 'Feedback.Model');

/**
 * Comment Test Case
 *
 */
class CommentTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('plugin.feedback.comment', 'app.foreign', 'app.user');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Comment = ClassRegistry::init('Comment');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Comment);

		parent::tearDown();
	}

}
