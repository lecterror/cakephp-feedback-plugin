<?php
/**
	CakePHP Feedback Plugin

	Copyright (C) 2012-3827 dr. Hannibal Lecter / lecterror
	<http://lecterror.com/>

	Multi-licensed under:
		MPL <http://www.mozilla.org/MPL/MPL-1.1.html>
		LGPL <http://www.gnu.org/licenses/lgpl.html>
		GPL <http://www.gnu.org/licenses/gpl.html>
*/

App::uses('AppHelper', 'View/Helper');
App::uses('Sanitize', 'Utility');

class CommentsHelper extends AppHelper
{
	public $helpers = array('Html', 'Form', 'Time', 'Goodies.Gravatar');

	public $settings = array(
			'model'		=> null,
			'showForm'	=> true,
                        'elementIndex'	=> 'Feedback.comment_index',
                        'elementForm'	=> 'Feedback.comment_add',
		);
	
	function __construct(View $view, $settings = null)
	{
		parent::__construct($view, $settings);
                if ($this->settings['model']==null && !empty($this->request->params['models']))
		{
			$this->settings['model'] = key($this->request->params['models']);
		}
	}

	/**
	 * Data must contain the row which hasMany comments and an array of comments (optional obviously).
	 * 
	 * Options available:
	 * 
	 *  - model: In case the detection doesn't work, this will override the model.
	 *  - showForm: Whether to show the "add new comment" form or not, defaults to true.
	 *
	 * @param array $data Data to use for comments and comment form
	 * @param array $options Options which override those detected by the helper.
	 * @return string HTML output
	 */
	function display_for(array $data, array $options = array())
	{
		$this->settings = array_merge($this->settings, $options);
                
                if (empty($this->settings['model']))
		{
			throw new CakeException(__('Missing model for %s::%s() call', __CLASS__, __FUNCTION__));
		}

		$output = '';

		if (isset($data['Comment']) && !empty($data['Comment']))
		{
			$output .= $this->_View->element($this->settings['elementIndex'], array('comments' => $data['Comment']));
		}

		if ($this->settings['showForm'])
		{
			App::uses($this->settings['model'], 'Model');
			$Model = ClassRegistry::init($this->settings['model']);

			if (empty($Model))
			{
				throw new CakeException(__('Missing model for %s::%s() call', __CLASS__, __FUNCTION__));
			}

			$output .= $this->form($this->settings['model'], $data[$Model->alias][$Model->primaryKey]);
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
		return $this->_View->element($this->settings['elementForm'], $options);
	}
}