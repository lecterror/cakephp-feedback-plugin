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
?>
<section class="comments-container">
	<header>
		<h2><?php echo __('Comments'); ?></h2>
	</header>
	<div class="comment-list">
		<?php foreach ($comments as $comment): ?>
			<article class="comment-content">
				<a id="comment-<?php echo $comment['id']; ?>"></a>
				<div class="comment-body">
					<?php echo nl2br(Sanitize::html($comment['content'])); ?>
				</div>
				<div class="comment-author">
					<span class="comment-gravatar">&nbsp;<?php echo $this->Comments->Gravatar->image($comment['author_email']); ?></span>
					<span class="comment-name"><?php echo Sanitize::html($comment['author_name']); ?></span>
					<?php
					// permalink
					$timestamp = $this->Comments->Time->timeAgoInWords($comment['created'], array('format' => 'Y/m/d H:i'));
					$permalink = $this->Html->link($timestamp, '#comment-'.$comment['id'], array('title' => __('Permalink')));
					?>
					<span class="comment-metadata"><?php echo $permalink; ?></span>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
</section>