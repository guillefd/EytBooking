	<table>
		<thead>
			<tr>
				<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
				<th><?php echo lang('products_post_label'); ?></th>
				<th class="collapse"><?php echo lang('products_category_label'); ?></th>
				<th class="collapse"><?php echo lang('products_date_label'); ?></th>
				<th class="collapse"><?php echo lang('products_written_by_label'); ?></th>
				<th><?php echo lang('products_status_label'); ?></th>
				<th width="180"></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="7">
					<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach ($products as $post) : ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $post->product_id); ?></td>
					<td><?php echo $post->title; ?></td>
					<td class="collapse"><?php echo $post->category_title; ?></td>
					<td class="collapse"><?php echo format_date($post->created_on); ?></td>
					<td class="collapse">
					<?php if (isset($post->display_name)): ?>
						<?php echo anchor('user/' . $post->author_id, $post->display_name, 'target="_blank"'); ?>
					<?php else: ?>
						<?php echo lang('products_author_unknown'); ?>
					<?php endif; ?>
					</td>
					<td><?php echo lang('products_'.$post->status.'_label'); ?></td>
					<td>
						<?php echo anchor('admin/products/preview/' . $post->product_id, lang($post->status == 'live' ? 'global:view' : 'global:preview'), 'rel="modal-large" class="iframe btn green" target="_blank"'); ?>
						<?php echo anchor('admin/products/edit/' . $post->product_id, lang('global:edit'), 'class="btn orange edit"'); ?>
						<?php echo anchor('admin/products/delete/' . $post->product_id, lang('global:delete'), array('class'=>'confirm btn red delete')); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div class="table_action_buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete', 'publish'))); ?>
	</div>