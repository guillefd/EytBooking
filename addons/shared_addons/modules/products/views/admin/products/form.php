<!-- JAVASCRIPT GLOBAL VARS -->
<script>
    var MSG_QUERY_FEATURES_FAIL = "<? echo lang('products_features_fail') ?>";
    var MSG_QUERY_EMPTY = "<? echo lang('products_empty_query_fail') ?>";
    var MSG_SELECT = "<? echo lang('products_select') ?>";
    var MSG_ADD_ITEM_ERROR = "<? echo lang('products_add_feature_empty') ?>";
    var MSG_ALERT_CATEGORY_CHANGE = "<? echo lang('products_change_category_feature_alert') ?>";
    var LABEL_DELETE = "<? echo lang('products_delete') ?>";    
    var LABEL_EDIT = "<? echo lang('products_edit') ?>";     
    
</script>
<!-- END JAVASCRIPT GLOBAL VARS -->

<section class="title">
	<?php if ($this->method == 'create'): ?>
	<h4><?php echo lang('products_create_title'); ?></h4>
	<?php else: ?>
	<h4><?php echo sprintf(lang('products_edit_title'), $product->name); ?></h4>
	<?php endif; ?>
</section>
<section class="item">
<?php echo form_open(uri_string(), 'class="crud"'); ?>
<div class="tabs">
	<ul class="tab-menu">
		<li><a href="#products-setup-tab"><span><?php echo lang('products_setup_label'); ?></span></a></li>
		<li><a href="#products-info-tab"><span><?php echo lang('products_info_label'); ?></span></a></li>                
		<li><a href="#products-images-tab"><span><?php echo lang('products_images_label'); ?></span></a></li>        
	</ul>
	
	<!-- Info tab -->
	<div class="form_inputs" id="products-setup-tab">		
		<fieldset>	
		<ul> 
            <li class="even">
				<label for="category_id"><?php echo lang('products_category_label'); ?> <span>*</span></label>
				<div class="input">
                 <?php echo form_dropdown('category_id', array(''=>'') + $cat_products_array, $product->category_id,' data-placeholder="'.lang('products_no_category_select_label').'" id="category_id" ') ?>					
				</div>
			</li>
			<li class="even">
				<label for="name"><?php echo lang('products_name_label'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('name', htmlspecialchars_decode($product->name), 'maxlength="100" id="name"'); ?></div>				
			</li>
			<li>
				<label for="slug"><?php echo lang('products_slug_label'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('slug', $product->slug, 'maxlength="100" class="width-20"'); ?></div>
			</li> 			                                                                                  
			<li class="even">
				<label for="account_id"><?php echo lang('products_account_label'); ?> <span>*</span></label>
				<div class="input">
                    <?php echo form_input('account', htmlspecialchars_decode($product->account), ' placeholder="'.lang('products_Ajax').'" id="accountAjax"'); ?>
                    <?php echo  form_hidden('account_id', $product->account_id , 'id="account_id" '); ?>  
                </div>				
			</li>                         
			<li class="even">
				<label for="location_id"><?php echo lang('products_location_label'); ?> <span></span></label>
				<div class="input">
                    <?php echo form_input('location', htmlspecialchars_decode($product->location), ' placeholder="'.lang('products_Ajax').'" id="locationAjax"'); ?>				
                    <?php echo  form_hidden('location_id', $product->location_id , 'id="location_id" '); ?>
                </div>
             </li>                                      
			<li class="even">
				<label for="space_id"><?php echo lang('products_space_label'); ?> <span></span></label>                                    
                <div class="input">                                    
                    <?php echo form_input('space', htmlspecialchars_decode($product->space), ' placeholder="'.lang('products_Ajax').'" id="spaceAjax"'); ?>
                    <?php echo  form_hidden('space_id', $product->space_id , 'id="space_id" '); ?>
                </div>				                                
			</li>                    			
			<li class="even">
				<label for="keywords"><?php echo lang('products_keywords_label'); ?></label>
				<div class="input"><?php echo form_input('keywords', $product->keywords, 'id="keywords"') ?></div>
			</li>                        
			<li class="even">
				<label for="status"><?php echo lang('products_status_label');?></label>
                <div class="checker"><span class><?php echo form_checkbox('status', 1, $product->status == 1, ' id="product_status" '); ?></span><?php echo lang('products_active'); ?></div>
			</li>                          
		</ul>		
		</fieldset>		
	</div>

	<!-- Infos tab -->
	<div class="form_inputs" id="products-info-tab">
            <fieldset>	
            <ul>
            <li class="even">
				<label for="features"><?php echo lang('products_features_label'); ?> <span>*</span></label>
                    <table class="f_table"><tr>
                    <td>
	                    <?php echo form_dropdown('dd_features', $features_array,'','class="med" data-placeholder="'.lang('products_no_features_select_label').'"') ?>					
	                    <?php echo form_hidden('f_id','',' id = "f_id"'); ?>  
	                    <?php echo form_input('usageunit','',' placeholder="'.lang('products_usageunit').'" class="f_small" id="usageunit" disabled'); ?>    
	                    <?php echo form_input('f_qty','',' placeholder="'.lang('products_qty').'" class="tiny" id="f_qty"'); ?>                      
	                    <?php echo form_dropdown('dd_isOptional', array(''=>'','0'=>'no','1'=>'si'),'','class="small" data-placeholder="'.lang('products_no_features_isOptional_label').'"') ?>
                    </td>
                    <td>
                    	<?php echo form_textarea(array('id' => 'f_description', 'name' => 'f_description', 'class' => 'f_tiny', 'placeholder' =>lang('products_f_description') )); ?>	
                    </td>                        <td>
                    	<?php echo anchor('', lang('products_add'),'id="f_add" class="btn gray"'); ?> 
                    </td></tr></table>
                    <span><?php echo lang('products_features_list'); ?></span>
                    <!--<div id="f_itemBox" class="f_itemBox"></div>-->
                    <table class="tableBox max"><tr><th>Nombre</th><th>Magnitud</th><th>Cantidad</th><th>Descripcion</th><th>Opcional</th><th width="75px">Eliminar</th></tr><tbody id="f_itemBox"></tbody></table>   
                    <?php echo form_hidden('features',$product->features,' id="features"'); ?> 
			</li>                         
			<li>
				<label for="intro"><?php echo lang('products_intro_label'); ?> <span>*</span></label>
				<div class="input">
					<br style="clear: both;" />
					<?php echo form_textarea(array('id' => 'intro', 'name' => 'intro', 'value' => $product->intro, 'rows' => 3, 'class'=>'med')); ?>
				</div>
			</li>			
			<li class="even editor">
				<label for="body"><?php echo lang('products_content_label'); ?> <span>*</span></label>				
				<div class="input">
					<br style="clear: both;" />
					<?php echo form_textarea(array('id' => 'body', 'name' => 'body', 'value' => $product->body, 'rows' => 6)); ?>    
				</div>
			</li>                                              
		</ul>		
		</fieldset>	                        
        </div>                    
	<!-- Info images -->
        <div class="form_inputs" id="products-images-tab">
            <fieldset>	    	            
                <ul>		
                </ul>		
            </fieldset>	
        </div>        
</div>
<div class="buttons float-right padding-top">
	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))); ?>
</div>
<?php echo form_close(); ?>
</section>

