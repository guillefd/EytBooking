        <table>
		<thead>
			<tr>
				<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
				<th><?php echo lang('geo_city_label'); ?></th>                            
				<th class="collapse"><?php echo lang('geo_region_label'); ?></th>         
				<th class="collapse"><?php echo lang('geo_country_label'); ?></th>                                
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
			<?php foreach ($cities as $city) : ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $city->CityId); ?></td>
					<td><?php echo $city->City; ?></td>
					<td class="collapse"><?php echo $city->region; ?></td>
					<td class="collapse"><?php echo $city->country; ?></td>
					<td>
						<?php echo anchor('admin/geoworldmap/preview/' . $city->CityId, lang('global:view'), 'rel="modal-large" class="iframe btn green" target="_blank"'); ?>
						<?php echo anchor('admin/geoworldmap/edit/' . $city->CityId, lang('global:edit'), 'class="btn orange edit"'); ?>
						<?php //echo anchor('admin/blog/delete/' . $city->City, lang('global:delete'), array('class'=>'confirm btn red delete')); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div class="table_action_buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete', 'publish'))); ?>
	</div>