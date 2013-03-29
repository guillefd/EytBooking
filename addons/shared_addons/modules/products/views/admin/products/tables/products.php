	<table>
		<thead>
			<tr>
				<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
				<th><?php echo lang('products_name_label'); ?></th>
				<th><?php echo lang('products_slug_label'); ?></th>
				<th><?php echo lang('products_category_label'); ?></th>
				<th><?php echo lang('products_accountowner_label'); ?></th>
				<th><?php echo lang('products_createdon_label'); ?></th>
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
			<?php foreach ($products as $product) : ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $product->product_id); ?></td>
					<td><?php echo $product->name; ?></td>
					<td><?php echo $product->slug; ?></td>
					<td><?php echo get_category_name_byid($product->category_id); ?></td>
					<td><?php echo get_account_by_spaceID($product->space_id,'name'); ?></td>
					<td><?php echo format_date($product->created_on); ?></td>
					<td><?php echo get_statusText_by_status_id($product->active) ?></td>
					<td>
						<?php echo anchor('admin/products/preview/' . $product->product_id, lang('global:view'), 'rel="modal-large" class="iframe btn green" target="_blank"'); ?>
						<?php echo anchor('admin/products/edit/' . $product->product_id, lang('global:edit'), 'class="btn orange edit"'); ?>
						<?php echo anchor('admin/products/delete/' . $product->product_id, lang('global:delete'), array('class'=>'confirm btn red delete')); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div class="table_action_buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete', 'publish'))); ?>
	</div>
