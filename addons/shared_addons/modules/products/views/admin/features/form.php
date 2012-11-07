<section class="title">
<?php if ($this->method == 'create'): ?>
	<h4><?php echo lang('features:create_title'); ?></h4>
<?php else: ?>
	<h4><?php echo sprintf(lang('features:edit_title'), $feature->title); ?></h4>
<?php endif; ?>
</section>

<section class="item">
	
<?php echo form_open(uri_string(), 'class="crud"'); ?>

<div class="tabs">

	<ul class="tab-menu">
		<li><a href="#features-info-tab"><span><?php echo lang('features:info_label'); ?></span></a></li>
	</ul>
	
	<!-- Info tab -->
	<div class="form_inputs" id="features-info-tab">		
		<fieldset>	
		<ul>
			<li class="even">
				<label for="name"><?php echo lang('features:name'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('name', $feature->name) ?></div>
			</li>                     
                        <li class="even">
				<label for="cat_product_id"><?php echo lang('features:cat_product'); ?> <span>*</span></label>
				<div class="input">
                                    <?php echo form_dropdown('cat_product_id',array(''=>'') + $cat_products_multiarray,set_value('cat_product_id',$feature->cat_product_id),' data-placeholder="'.lang('features:select_cat').'"id="cat_product_id"') ?>
                                    <?php echo anchor('admin/products/features/cat_feature_form', lang('features:add_cat'), 'rel="modal-form-small" class="btn gray" target="_blank"'); ?>                                     
                                </div>				
			</li>                         
			<li class="even">
				<label for="cat_feature_id"><?php echo lang('features:cat_feature'); ?> <span>*</span></label>
				<div class="input">
                                    <?php echo form_dropdown('cat_feature_id',array(''=>'') + $cat_features_array,set_value('cat_feature_id',$feature->cat_feature_id),'data-placeholder="'.lang('features:select_cat').'" id="cat_feature_id"') ?>
                                    <?php echo anchor('admin/products/features/cat_feature_form', lang('features:add_cat'), 'rel="modal-small" class="btn gray" target="_blank"'); ?>                                    
                                </div>                                                         
			</li>                    				           
			<li class="even">
				<label for="usageunit_id"><?php echo lang('features:usageunit_value'); ?> <span>*</span></label>
				<div class="input">
                                    <?php echo form_dropdown('usageunit_id',array(''=>'') + $usageunit_array,set_value('usageunit_id',$feature->usageunit_id),'data-placeholder="'.lang('features:select_usageunit').'" id="usageunit_id"') ?>                                                   
                                    <?php echo anchor('admin/products/features/cat_feature_form', lang('features:add_unit'), 'rel="modal-small" class="btn gray" target="_blank"'); ?> <br>                                    
                                    <?php echo form_input('value', $feature->value,'placeholder="'.lang('features:default_value').'" ') ?>
                                </div>
			</li>                         
			<li class="even">
				<label for="description"><?php echo lang('features:description'); ?></label>
				<div class="input"><?php echo form_textarea('description', $feature->description, 'class="med"') ?></div>
			</li>                       
			<li class="even">
				<label for="group"><?php echo lang('features:group'); ?> <span></span></label>
				<div class="input"><?php echo form_input('group', $feature->group) ?></div>
			</li> 
		</ul>		
		</fieldset>		
	</div>

</div>

<div class="buttons float-right padding-top">
	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
</div>

<?php echo form_close(); ?>

</section>