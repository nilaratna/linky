<?php echo $this->element('board_details'); ?>
<h3 class="left"><?php echo $topic['Topic']['title']; ?>&nbsp;&nbsp;
	<?php if(AuthComponent::user('id') && AuthComponent::user('role') != 'student'): ?>
	<small>
		<?php echo $this->Html->link('edit this category','/categories/edit/'.$topic['Topic']['id']); ?>
	</small>
	<?php endif; ?>
</h3>
<span class="clear"></span>
<p><?php echo !empty($topic['Topic']['description']) ? $topic['Topic']['description']: ''; ?></p>
<?php echo $this->Html->link('Add Photo(s) to this category','/boards/'.$board['Board']['id'].'/categories/'.$topic['Topic']['id'].'/add_photos',array('class' => 'btn')); ?>
<section id="feed">
	<?php if(!empty($topic['TopicPhoto'])): ?>
	<?php foreach($topic['TopicPhoto'] as $photo): ?>
	<article>
		<?php if(!empty($photo['url'])) echo $this->Html->image($photo['url'], array('class' => 'left')); ?>
		<?php if(!empty($photo['filename'])) echo $this->Html->image($photo['filepath'].$photo['filename'], array('class' => 'left')); ?>
		<p class="left">
			<?php if(!empty($photo['description'])) echo nl2br($photo['description']).'<br />'; ?>
			<small>Posted by <?php echo $photo['anonymous'] ? 'anonymous' : $photo['User']['username']; ?> <em><?php echo date('F j,Y g:i a',strftime($photo['created'])); ?></em></small>
			<?php if(AuthComponent::user('id') && AuthComponent::user('id') == $photo['user_id']): ?>
			<?php echo $this->Html->link('edit','/photos/edit/'.$photo['id']); ?>
			<?php endif; ?>
			<?php if(!empty($photo['Badge'])): ?>
			<?php foreach($photo['Badge'] as $b): ?>
				<p>
					<?php echo $b['title'];
						if(AuthComponent::user('id') && AuthComponent::user('role') != 'student'){
							echo $this->Html->link('revoke badge?','/badges/revoke/'.$photo['id'].'/'.$b['id']);
						}
					?>
				</p>
			<?php endforeach; ?>
			<?php endif; ?>
			<?php if(!empty($photo['Comment'])): ?>
			<?php foreach($photo['Comment'] as $c): ?>
				<p>
					<?php echo nl2br($c['comment']); ?>
					<small>Posted by <?php echo $c['User']['username']; ?> <em><?php echo date('F j,Y g:i a',strftime($c['created'])); ?></em>
					</small>
				</p>
			<?php endforeach; ?>
			<?php endif; ?>
			<?php if(AuthComponent::user('id')): ?>
			<?php echo $this->Html->link('add comment','/comments/create/'.$photo['id']); ?>
				<?php if(AuthComponent::user('role') != 'student'):
						echo $this->Form->create('Badges', array('controller' => 'badges','action' => 'award'));
						echo $this->Form->input(
							'TopicPhoto.id',
							array(
								'type' => 'hidden',
								'value' => $photo['id']
								)
							);
						echo $this->Form->input(
							'Badge.id',
							array(
								'type' => 'select',
								'options' => $badges
								)
							);
						echo $this->Form->submit('Award Badge');
						echo $this->Form->end();
					endif;
				endif; ?>
		</p>
		<span class="clear"></span>
	</article>
	<?php endforeach; ?>
	<?php endif; ?>
</section>