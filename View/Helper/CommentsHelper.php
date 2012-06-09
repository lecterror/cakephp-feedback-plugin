<?php

App::uses('AppHelper', 'View/Helper');
App::uses('Sanitize', 'Utility');

class CommentsHelper extends AppHelper
{
	public $helpers = array('Html', 'Form', 'Time', 'Goodies.Gravatar');

	private $_defaultOptions = array
		(
			'model'		=> null,
			'showForm'	=> true,
		);
	
	function __construct(View $view, $settings = array())
	{
		parent::__construct($view, $settings);

		if (!empty($this->request->params['models']))
		{
			$this->_defaultOptions['model'] = key($this->request->params['models']);
		}
	}


	/**
	 * 
		// ol comments-container
			// li comment
				// div comment-body
					// div comment-author
						// gravatar
						// name
						// metadata
	 */
	function display_for(array $data, array $options = array())
	{
		$options = array_merge($this->_defaultOptions, $options);

		if (empty($options['model']))
		{
			throw new CakeException(__('Missing model for %s::%s() call', __CLASS__, __FUNCTION__));
		}

		$output = '';

		if (isset($data['Comment']) && !empty($data['Comment']))
		{
			$output .= $this->_View->element('Feedback.comment_index', array('comments' => $data['Comment']));
		}

		if ($options['showForm'])
		{
			App::uses($options['model'], 'Model');
			$Model = ClassRegistry::init($options['model']);

			if (empty($Model))
			{
				throw new CakeException(__('Missing model for %s::%s() call', __CLASS__, __FUNCTION__));
			}

			$output .= $this->form($options['model'], $data[$options['model']][$Model->primaryKey]);
		}

		return $output;
	}

	public function form($foreign_model, $foreign_id)
	{
		App::uses($foreign_model, 'Model');
		$Model = ClassRegistry::init($foreign_model);

		if (empty($Model))
		{
			throw new CakeException(__('Missing model for %s::%s() call', __CLASS__, __FUNCTION__));
		}

		if (!$Model->hasAny(array($Model->primaryKey => $foreign_id)))
		{
			throw new CakeException(__('Missing item with id %d for %s::%s() call', $foreign_id, __CLASS__, __FUNCTION__));
		}

		$options = compact('foreign_model', 'foreign_id');
		return $this->_View->element('Feedback.comment_add', $options);
	}
}