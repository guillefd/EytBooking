<fieldset id="filters">
	
	<legend><?php echo lang('global:filters'); ?></legend>
	<?php $atr = array("id"=>"form_filter"); ?>
	<?php echo form_open('admin/products/ajax_filter',$atr); ?>

	<?php echo form_hidden('f_module', $module_details['slug']); ?>
		<ul>  
			<li>
            	<?php echo lang('products:search_key_label'); ?>                            
				<?php echo form_input('f_keywords','','placeholder="'.lang('products:search_key_placeholder').'"'); ?>
        		<?php echo '&nbsp;'.lang('products:account_label'); ?>
        		<?php echo form_input('f_account','','id="f_account" class="med" placeholder="'.lang('products:ajax_label').'"'); ?>
                <?php echo form_hidden('f_account_id'); ?>  
        		<?php echo '&nbsp;'.lang('products:city_label'); ?>
        		<?php echo form_input('f_city','','class="med" placeholder="'.lang('products:ajax_label').'" '); ?>
                <?php echo form_hidden('f_city_id'); ?>                            
    		</li>                    		
			<li>
				<?php echo anchor(current_url() . '/', lang('buttons.cancel'), 'class="cancel" id="btnCancel"'); ?>
			</li>
		</ul>
	<?php echo form_close(); ?>
</fieldset>