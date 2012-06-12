<?php

App::uses('FeedbackAppModel', 'Feedback.Model');

/**
 * Comment Model
 *
 * @property Foreign $Foreign
 * @property User $User
 */
class Comment extends FeedbackAppModel
{
	
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array
		(
			'foreign_model' => array
			(
				'notempty' => array
				(
					'rule' => array('notempty'),
					'allowEmpty' => false,
					'required' => true,
				),
			),
			'foreign_id' => array
			(
				'notempty' => array
				(
					'rule' => array('notempty'),
					'allowEmpty' => false,
					'required' => true,
				),
			),
			'author_name' => array
			(
				'notempty' => array
				(
					'rule' => array('notempty'),
					'message' => 'Name cannot be empty',
					'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'author_email' => array
			(
				'notempty' => array
				(
					'rule' => array('notempty'),
					'message' => 'E-mail address cannot be empty',
					'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
				'email' => array
				(
					'rule' => array('email'),
					'message' => 'E-mail address is not valid',
				)
			),
			'author_ip' => array
			(
				'ip' => array
				(
					'rule' => array('ip'),
					'message' => 'Invalid IP address',
					'allowEmpty' => true,
				)
			),
			'content' => array
			(
				'notempty' => array
				(
					'rule' => array('notempty'),
					'message' => 'Comment cannot be empty',
					'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array
		(
			'User' => array
			(
				'className' => 'User',
				'foreignKey' => 'user_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
			)
		);

	public $actsAs = array
		(
			'Feedback.Polymorphic' => array
			(
				'modelField'	=> 'foreign_model',
				'foreignKey'	=> 'foreign_id'
			),
			'Feedback.Honeypot' => array
			(
				'field' => 'hairy_pot',
				'message' => 'E-mail address is not valid',
				'errorField' => 'author_email',
			),
		);

	public $order = 'Comment.created ASC';
}
