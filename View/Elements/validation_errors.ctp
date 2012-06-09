<?php $this->layout = 'comment.error'; ?>
<div id="validation-errors">
	<?php foreach ($validation_errors as $field): ?>
		<?php foreach ($field as $index => $error): ?>
			<p><?php echo $error; ?></p>
		<?php endforeach; ?>
	<?php endforeach; ?>
</div>
<p><?php echo __('Please go back and try again'); ?></p>