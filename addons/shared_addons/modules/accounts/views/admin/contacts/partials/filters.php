<fieldset id="filters">
	
	<legend><?php echo lang('global:filters'); ?></legend>
	<?php $atr = array("id"=>"form_filter"); ?>
	<?php echo form_open('admin/accounts/contacts/ajax_filter',$atr); ?>

	<?php echo form_hidden('f_module', $module_details['slug']); ?>
		<ul>  
			<li>
                        <?php echo lang('accounts:contacts:search_key_label'); ?>                            
			<?php echo form_input('f_keywords'); ?>
        		<?php echo lang('accounts:account'); ?>
        		<?php echo form_input('f_account'); ?>
                        <?php echo form_hidden('f_account_id'); ?>                            
    		</li>                    		
			<li><?php echo anchor(current_url() . '/', lang('buttons.cancel'), 'class="cancel" id="btnCancel"'); ?></li>
		</ul>
	<?php echo form_close(); ?>
</fieldset>