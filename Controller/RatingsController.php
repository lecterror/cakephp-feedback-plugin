<?php
App::uses('FeedbackAppController', 'Feedback.Controller');
/**
 * Comments Controller
 * 
 * @property RatingsComponent $Ratings
 * @property Rating $Rating
 */
class RatingsController extends FeedbackAppController
{
	public $components = array('Feedback.Ratings');

	public function beforeFilter()
	{
		parent::beforeFilter();

		if ($this->request->params['action'] == 'add')
		{
			$this->viewClass = 'Json';
			$this->response->type('json');
		}
	}

	public function add($foreign_model, $foreign_id)
	{
		if (empty($foreign_model) ||
			empty($foreign_id) ||
			!$this->request->is('post') ||
			!$this->request->is('ajax')
			)
		{
			return $this->redirect('/');
		}

		$modelClass = $model = $foreign_model;

		if (strpos($foreign_model, '.') !== false)
		{
			list($model, $modelClass) = pluginSplit($foreign_model, true);
			$model .= $modelClass;
		}

		App::uses($model, 'Model');
		$this->loadModel($model);

		if (!($this->{$modelClass} instanceof $modelClass))
		{
			return $this->redirect('/');
		}

		$row_exists = $this->{$modelClass}->hasAny
			(
				array($this->{$modelClass}->primaryKey => $foreign_id)
			);

		if (!$row_exists)
		{
			return $this->redirect('/');
		}

		$cookie = $this->Ratings->readRatingCookie($modelClass);

		if (isset($cookie[$foreign_id]))
		{
			$output = array
				(
					'success' => false,
					'message' => __('You cannot vote more than once!'),
					'data' => array(),
				);

			$this->set('output', $output);
			return;
		}

		if ($this->request->data['Rating']['foreign_model'] != $modelClass ||
			$this->request->data['Rating']['foreign_id'] != $foreign_id)
		{
			return $this->redirect('/');
		}

		$this->request->data['Rating']['foreign_table'] = $this->{$modelClass}->name;
		$this->request->data['Rating']['foreign_id'] = $foreign_id;
		$this->request->data['Rating']['author_ip'] = $this->request->clientIp();

		$this->Rating->create();

		if (!$this->Rating->save($this->request->data))
		{
			$this->log(serialize($this->Rating->validationErrors));

			$output = array
				(
					'success' => false,
					'message' => __('There was an error while saving your vote'),
					'data' => array(),
				);
			$this->set('output', $output);
			return;
		}

		$cookie[$foreign_id] = $this->request->data['Rating']['rating'];
		$this->Ratings->writeRatingCookie($modelClass, $cookie);

		$updated = $this->{$modelClass}->read(null, $foreign_id);

		$output = array
			(
				'success' => true,
				'message' => __('Thanks for voting!'),
				'data' => $updated['RatingSummary'],
			);
		$this->set('output', $output);
	}
}
