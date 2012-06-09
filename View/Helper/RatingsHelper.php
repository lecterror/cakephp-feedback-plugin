<?php

App::uses('AppHelper', 'View/Helper');
App::uses('Sanitize', 'Utility');

/**
 * @property HtmlHelper $Html
 * @property SessionHelper $Session
 */
class RatingsHelper extends AppHelper
{
	public $helpers = array('Html', 'Session');

	private $models = array();

	function __construct(View $view, $settings = array())
	{
		parent::__construct($view, $settings);
		$this->settings = $settings;
	}

	public function beforeRender($viewFile)
	{
		parent::beforeRender($viewFile);
		$this->models = $this->Session->read('Feedback.RatingModels');

		$options = array('inline' => false);

		$this->Html->script('Feedback.rateit-1.0.4/jquery.rateit.min', $options);
		$this->Html->css('Feedback./js/rateit-1.0.4/rateit', null, $options);
		$this->Html->css('Feedback./js/rateit-1.0.4/bigstars', null, $options);
	}

	function display_for(array $data, array $options = array())
	{
		$output = '';
		$params = $this->prepareParams($data, $options);

		$output .= $this->_View->element
			(
				'Feedback.rating',
				$params
			);

		return $output;
	}

	private function prepareParams($data, $options)
	{
		$model = null;
		$modelClass = null;

		extract($options);

		if (empty($modelClass))
		{
			$modelClass = $model;
		}

		if (empty($model) && empty($modelClass))
		{
			$modelClass = key($this->models);
			$model = current($this->models);
		}

		$random = intval(mt_rand());
		$element_id = 'rating-'.$random;
		$message_id = 'message-'.$random;
		$values_id = 'values-'.$random;
		$id = $data[$modelClass]['id'];
		$submit_url = $this->Html->url
			(
				array
				(
					'plugin' => 'feedback',
					'controller' => 'ratings',
					'action' => 'add',
					$model,
					$id,
				)
			);

		$value = 0;
		$votes = 0;
		$readonly = 'false';

		if (isset($data['RatingSummary']))
		{
			$value = floatval($data['RatingSummary']['total_rating']);
			$votes = floatval($data['RatingSummary']['total_votes']);
		}

		$user_votes = $this->Session->read('Feedback.'.$modelClass.'Ratings');
		$user_vote = 0;
		
		if (isset($user_votes[$id]))
		{
			$readonly = 'true';
			$user_vote = $user_votes[$id];
		}

		return compact
			(
				'data',
				'model',
				'modelClass',
				'submit_url',
				'element_id',
				'message_id',
				'values_id',
				'readonly',
				'value',
				'votes',
				'user_vote'
			);
	}
}
