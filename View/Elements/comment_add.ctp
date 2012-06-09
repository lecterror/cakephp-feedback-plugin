<div class="comment form">
	<h2><?php echo __('Add a comment'); ?></h2>
	<?php
	echo $this->Form->create
		(
			'Feedback.Comment',
			array
			(
				'url' => array
				(
					'plugin' => 'feedback',
					'controller' => 'comments',
					'action' => 'add',
					$foreign_model,
					$foreign_id
				)
			)
		);
	echo $this->Form->input('Comment.author_name', array('label' => __('Name')));
	echo $this->Form->input('Comment.author_email', array('label' => __('Email')));
	echo $this->Form->input('Comment.author_website', array('label' => __('Website')));
	echo $this->Form->input('Comment.hairy_pot', array('type' => 'hidden'));
	echo $this->Form->input('Comment.content', array('label' => __('Comments')));
	echo $this->Form->input('Comment.foreign_model', array('type' => 'hidden', 'value' => $foreign_model));
	echo $this->Form->input('Comment.foreign_id', array('type' => 'hidden', 'value' => $foreign_id));
	echo $this->Form->input('Comment.remember_info', array('type' => 'checkbox', 'label' => __('Remember my info')));

	echo $this->Form->end(__('Save comment'));
	?>
</div>
