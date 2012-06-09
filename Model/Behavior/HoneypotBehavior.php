<?php

class HoneypotBehavior extends ModelBehavior
{
	public function setup(Model $Model, $settings = array())
	{
		if (!isset($this->settings[$Model->alias]))
		{
			$this->settings[$Model->alias] = array('field' => '', 'message' => '', 'errorField' => '');
		}

		$this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], $settings);
	}

	public function beforeValidate(Model $Model)
	{
		extract($this->settings[$Model->alias]);

		if (!isset($Model->data[$Model->alias][$field]) || !empty($Model->data[$Model->alias][$field]))
		{
			$Model->invalidate($errorField, $message);
			$this->log('HoneypotBehavior::beforeValidate() caught: '.serialize($Model->data));
			return false;
		}

		return true;
	}
}
