<section class="title">
	<h4><?php echo lang('location:list_title'); ?></h4>
</section>

<section class="item">
	
	<?php if ($locations): ?>

		<?php echo form_open('admin/products/locations/delete'); ?>

		<table border="0" class="table-list">
			<thead>
			<tr>
				<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
				<th><?php echo lang('location:label'); ?></th>
                                <th><?php echo lang('location:intro_label'); ?></th>
				<th><?php echo lang('location:slugSH_label'); ?></th>
				<th><?php echo lang('location:account_label'); ?></th>    
				<th><?php echo lang('location:city_label'); ?></th>                                
				<th><?php echo lang('location:phone_label'); ?></th>                                
				<th width="150"></th>
			</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="3">
						<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach ($locations as $location): ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $location->id); ?></td>
					<td><?php echo $location->name; ?></td>
                                        <td><?php echo $location->intro; ?>...</td>                                        
                                        <td><?php echo $location->slug; ?></td>
                                        <td><?php echo $location->account; ?></td>
                                        <td><?php echo $location->City; ?></td>
                                        <td><?php echo $location->phone; ?></td>
					<td class="align-center buttons buttons-small" width="190px">
                                            	<?php echo anchor('admin/products/locations/view/' . $location->id, lang('global:view'), 'class="btn green view "'); ?>
						<?php echo anchor('admin/products/locations/edit/' . $location->id, lang('global:edit'), 'class="btn orange edit "'); ?>
						<?php echo anchor('admin/products/locations/delete/' . $location->id, lang('global:delete'), 'class="confirm red btn delete"') ;?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<div class="table_action_buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
		</div>

		<?php echo form_close(); ?>

	<?php else: ?>
		<div class="no_data"><?php echo lang('location:no_categories'); ?></div>
	<?php endif; ?>
</section>