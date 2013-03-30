<fieldset id="filters">
	<legend><?php echo lang('global:filters'); ?></legend>
	<?php $atr = array("id"=>"form_filter"); ?>
	<?php echo form_open('admin/products/ajax_filter',$atr); ?>
	<?php echo form_hidden('f_module', $module_details['slug']); ?>
		<ul>  
			<li>
             	<?php echo lang('products_search_key_label'); ?>                            
				<?php echo form_input('f_keywords','','placeholder="'.lang('products_search_key_placeholder').'"'); ?>
        		<?php echo '&nbsp;'.lang('products_accountowner_label'); ?>
        		<?php echo form_input('f_account','',' class="medium" id="f_account" placeholder="'.lang('products_ajax_label').'"'); ?>
                <?php echo form_hidden('f_account_id'); ?>				
        		<?php echo lang('products_category_sh_label'); ?> 				
                <?php echo form_dropdown('f_category_id', array(''=>lang('products_all_label')) + $cat_products_array, '',' style="width: 200px;" data-placeholder="'.lang('products_no_category_select_label').'" ') ?>					
        		<?php echo '&nbsp;'.lang('products_status_sh_label'); ?>       
				<?php echo form_dropdown('f_status', $dd_status, '',' style="width: 110px;" ') ?>					        		
        		<?php echo '&nbsp;'.lang('products_include_deleted_label'); ?>    
				<?php echo form_dropdown('f_deleted', $dd_yes_no, '',' style="width: 60px;" ') ?>	                       				
    		</li>                    		
			<li><?php echo anchor(current_url() . '/', lang('buttons.cancel'), 'class="btn gray cancel" id="btnCancel"'); ?></li>
		</ul>
	<?php echo form_close(); ?>
</fieldset>