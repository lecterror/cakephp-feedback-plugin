<?php
App::uses('FeedbackAppController', 'Feedback.Controller');
/**
 * Comments Controller
 *
 * @property CommentsComponent $Comments
 */
class CommentsController extends FeedbackAppController
{
	public $components = array('Feedback.Comments');

	public function add($foreign_model, $foreign_id)
	{
		if (empty($foreign_model) ||
			empty($foreign_id) ||
			!$this->request->is('post')
			)
		{
			$this->redirect('/');
		}

		App::uses($foreign_model, 'Model');
		$Model = ClassRegistry::init($foreign_model);

		if (!($Model instanceof Model))
		{
			$this->redirect('/');
		}

		if ($Model->hasAny(array($Model->primaryKey => $foreign_id)) == false)
		{
			$this->redirect('/');
		}

		if ($this->request->data['Comment']['foreign_model'] != $foreign_model ||
			$this->request->data['Comment']['foreign_id'] != $foreign_id)
		{
			$this->redirect('/');
		}

		$this->request->data['Comment']['foreign_table'] = $Model->name;
		$this->request->data['Comment']['foreign_id'] = $foreign_id;
		$this->request->data['Comment']['user_id'] = $this->Auth->user('id');
		$this->request->data['Comment']['author_ip'] = $this->request->clientIp();

		if (!$this->Comment->save($this->request->data))
		{
			$this->set('validation_errors', $this->Comment->validationErrors);
			return;
		}

		if ($this->request->data['Comment']['remember_info'])
		{
			$this->Comments->saveInfo();
		}
		else
		{
			$this->Comments->forgetInfo();
		}

		$this->redirect($this->request->referer().'#comment-'.$this->Comment->id);
	}
}
