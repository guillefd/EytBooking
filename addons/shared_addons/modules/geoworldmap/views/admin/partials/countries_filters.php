<fieldset id="filters">
	
	<legend><?php echo lang('global:filters'); ?></legend>
	
	<?php echo form_open('admin/geoworldmap/countries/ajax_filter'); ?>

	<?php echo form_hidden('f_module', $module_details['slug']); ?>
		<ul>  
			<li>
        		<?php echo lang('geo_continent_label', 'f_continent'); ?>
        		<?php echo form_dropdown('f_continent', array(0 => lang('global:select-all')) + $continents); ?>
    		</li>                    		
			<li><?php echo form_input('f_keywords'); ?></li>
			<li><?php echo anchor(current_url() . '/', lang('buttons.cancel'), 'class="cancel"'); ?></li>
		</ul>
	<?php echo form_close(); ?>
</fieldset>

