<div id="indexView">
	<table>
		<thead>
			<tr>
				<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
				<th><?php echo lang('products_name_label'); ?></th>
				<th><?php echo lang('products_category_label'); ?></th>
				<th><?php echo lang('products_accountowner_label'); ?></th>
				<th><?php echo lang('products_outsourced_label'); ?></th>				
				<th><?php echo lang('products_createdon_label'); ?></th>
				<th><?php echo lang('products_status_label'); ?></th>
				<th width="200"></th>
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
				<tr <?php if($product->deleted==1) echo 'class="deleted";'; ?> >
					<td><?php echo form_checkbox('action_to[]', $product->product_id); ?></td>
					<td><?php echo $product->name; ?></td>
					<td><?php echo get_category_name_byid($product->category_id); ?></td>
					<td><?php echo get_account_by_id($product->account_id,'name'); ?></td>
					<td><?php echo $product->outsourced == 1 ? get_account_by_id($product->seller_account_id,'name') : get_account_by_id($product->account_id,'name'); ?></td>
					<td><?php echo format_date($product->created_on); ?></td>
					<td><?php echo get_statusText_by_status_id($product->active) ?></td>
					<td>
						<?php echo anchor('admin/products/view/' . $product->product_id, lang('global:view'), 'class="btn green"'); ?>
						<?php echo anchor('admin/products/edit/' . $product->product_id, lang('global:edit'), 'class="btn orange edit"'); ?>
					<?php if($product->deleted==1): ?>
						<?php echo anchor('admin/products/undelete/' . $product->product_id, lang('products:undelete'), 'class="confirm btn blue"'); ?>
					<?php else: ?>						
						<?php echo anchor('admin/products/delete/' . $product->product_id, lang('global:delete'), 'class="confirm btn red delete"'); ?>
					<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<!-- 	<div class="table_action_buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete', 'publish'))); ?>
	</div> -->
</div>

