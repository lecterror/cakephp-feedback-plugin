<?php

App::uses('ModelBehavior', 'Model');

class CommentableBehavior extends ModelBehavior
{
	public function setup(Model $Model, array $settings)
	{
		$Model->bindModel
			(
				array
				(
					'hasMany' => array
					(
						'Comment' => array
						(
							'className'		=> 'Feedback.Comment',
							'conditions'	=> sprintf('Comment.foreign_model = \'%s\'', $Model->name),
							'foreignKey'	=> 'foreign_id',
						)
					)
        		),
				false
			);
	}

	public function cleanup(Model $Model)
	{
		$Model->unbindModel(array('hasMany' => array('Comment')), false);
	}
}
