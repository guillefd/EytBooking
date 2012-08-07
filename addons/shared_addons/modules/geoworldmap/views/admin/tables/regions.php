        <table>
		<thead>
			<tr>
<!--				<th width="20"><?php// echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>-->
				<th><?php echo lang('geo_regions_label'); ?></th>   
				<th class="collapse"><?php echo lang('geo_region_code_label'); ?></th>                                                                  
				<th width="180"></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="7">
<!--					<div class="inner"><?php// $this->load->view('admin/partials/pagination'); ?></div>-->
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach ($regions as $region) : ?>
				<tr>
<!--					<td><?php //echo form_checkbox('action_to[]', $region->RegionID); ?></td>-->
					<td><?php echo $region->Region; ?></td>
					<td class="collapse"><?php echo $region->Code; ?></td>                                     
					<td>
						<?php // echo anchor('admin/geoworldmap/countries/region/preview' . $region->RegionID, lang('global:view'), 'rel="modal-large" class="iframe btn green" target="_blank"'); ?>
						<?php echo anchor('admin/geoworldmap/regions/edit/' . $region->RegionID, lang('global:edit'), 'class="btn orange edit"'); ?>
						<?php //echo anchor('admin/blog/delete/' . $city->City, lang('global:delete'), array('class'=>'confirm btn red delete')); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div class="table_action_buttons">
		<?php //$this->load->view('admin/partials/buttons', array('buttons' => array('delete', 'publish'))); ?>
	</div>