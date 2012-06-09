<?php
/* Article Fixture generated on: 2011-11-05 18:13:35 : 1320513215 */

/**
 * ArticleFixture
 *
 */
class ArticleFixture extends CakeTestFixture
{

/**
 * Fields
 *
 * @var array
 */
	public $fields = array
		(
			'id' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
			'title' => array('type' => 'string', 'null' => false, 'length' => 200),
			'content' => array('type' => 'text', 'null' => false),
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
				'id' => 1,
				'title' => 'This is my title',
				'content' => 'There are many like it, but this one is mine.',
			),
			array
			(
				'id' => 2,
				'title' => 'This is my other title',
				'content' => 'But this one has no references in it. Sorry about that old chap.',
			),
		);
}
