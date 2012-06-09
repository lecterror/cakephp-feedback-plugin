<section class="comments-container">
	<header>
		<h2><?php echo __('Comments'); ?></h2>
	</header>
	<?php foreach ($comments as $comment): ?>
		<div class="comment-list">
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
		</div>
	<?php endforeach; ?>
</section>