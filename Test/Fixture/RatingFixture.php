<?php

/**
 * RatingFixture
 *
 */
class RatingFixture extends CakeTestFixture
{

/**
 * Fields
 *
 * @var array
 */
	public $fields = array
		(
			'id' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
			'foreign_table' => array('type' => 'string', 'null' => false, 'length' => 100),
			'foreign_id' => array('type' => 'integer', 'null' => false),
			'author_ip' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
			'rating' => array('type' => 'float', 'null' => false),
			'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
			'indexes' => array('ix_ratings_foreign_data' => array('column' => array('foreign_id', 'foreign_table'), 'unique' => 0)),
			'tableParameters' => array()
		);

/**
 * Records
 *
 * @var array
 */
	public $records = array
		(
			array
			(
				'id' => '1',
				'foreign_table' => 'Article',
				'foreign_id' => '1',
				'author_ip' => '127.0.0.1',
				'rating' => '0.5',
				'created' => '2012-06-03 22:19:40'
			),
			array
			(
				'id' => '2',
				'foreign_table' => 'Article',
				'foreign_id' => '1',
				'author_ip' => '127.0.0.1',
				'rating' => '4.5',
				'created' => '2012-06-03 22:19:40'
			),
		);
}
