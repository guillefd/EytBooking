        <table>
		<thead>
			<tr>
				<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
				<th><?php echo lang('geo_country_label'); ?></th>   
				<th class="collapse"><?php echo lang('geo_country_isocode_label'); ?></th>                                  
				<th class="collapse"><?php echo lang('geo_country_capital_label'); ?></th>         
				<th class="collapse"><?php echo lang('geo_country_currency_label'); ?></th>                                
				<th class="collapse"><?php echo lang('geo_country_population_label'); ?></th>                                  
				<th width="250"></th>
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
			<?php foreach ($countries as $country) : ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $country->CountryId); ?></td>
					<td><?php echo $country->Country; ?></td>
					<td class="collapse"><?php echo $country->ISO2; ?> / <?php echo $country->ISO3; ?></td>
					<td class="collapse"><?php echo $country->Capital; ?></td>
					<td class="collapse"><?php echo $country->Currency; ?></td>
					<td class="collapse"><?php echo $country->Population; ?></td>                                       
					<td>
						<?php echo anchor('admin/geoworldmap/countries/preview/' . $country->CountryId, lang('global:view'), 'rel="modal-large" class="iframe btn green" target="_blank"'); ?>
						<?php echo anchor('admin/geoworldmap/countries/edit/' . $country->CountryId, lang('global:edit'), 'class="btn orange edit"'); ?>
						<?php echo anchor('admin/geoworldmap/regions/' . $country->CountryId, lang('geo_view_regions_label'), array('class'=>'btn green')); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div class="table_action_buttons">
		<?php //$this->load->view('admin/partials/buttons', array('buttons' => array('delete', 'publish'))); ?>
	</div>