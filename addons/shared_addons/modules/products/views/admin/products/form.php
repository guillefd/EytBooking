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
	<h4><?php echo sprintf(lang('products_edit_title'), $post->name); ?></h4>
	<?php endif; ?>
</section>
<section class="item">
<?php echo form_open(uri_string(), 'class="crud"'); ?>

<div class="tabs">
	<ul class="tab-menu">
		<li><a href="#products-setup-tab"><span><?php echo lang('products_setup_label'); ?></span></a></li>
		<li><a href="#products-info-tab"><span><?php echo lang('products_info_label'); ?></span></a></li>                
		<li><a href="#products-images-tab"><span><?php echo lang('products_images_label'); ?></span></a></li>
		<li><a href="#products-prices-tab"><span><?php echo lang('products_prices_label'); ?></span></a></li>                
	</ul>
	
	<!-- Info tab -->
	<div class="form_inputs" id="products-setup-tab">		
		<fieldset>	
		<ul> 
            <li class="even">
				<label for="category_id"><?php echo lang('products_category_label'); ?> <span>*</span></label>
				<div class="input">
                 <?php echo form_dropdown('category_id', array(''=>'') + $cat_products_array, $post->category_id,' data-placeholder="'.lang('products_no_category_select_label').'" id="category_id" ') ?>					
				</div>
			</li>
			<li class="even">
				<label for="name"><?php echo lang('products_name_label'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('name', htmlspecialchars_decode($post->name), 'maxlength="100" id="name"'); ?></div>				
			</li>
			<li>
				<label for="slug"><?php echo lang('products_slug_label'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('slug', $post->slug, 'maxlength="100" class="width-20"'); ?></div>
			</li> 			                                                                                  
			<li class="even">
				<label for="account_id"><?php echo lang('products_account_label'); ?> <span>*</span></label>
				<div class="input">
                                    <?php echo form_input('account', htmlspecialchars_decode($post->account), ' placeholder="'.lang('products_Ajax').'" id="accountAjax"'); ?>
                                    <?php echo  form_hidden('account_id', $post->account_id , 'id="account_id" '); ?>  
                                </div>				
			</li>                         
			<li class="even">
				<label for="location_id"><?php echo lang('products_location_label'); ?> <span></span></label>
				<div class="input">
                                    <?php echo form_input('location', htmlspecialchars_decode($post->location), ' placeholder="'.lang('products_Ajax').'" id="locationAjax"'); ?>				
                                    <?php echo  form_hidden('location_id', $post->location_id , 'id="location_id" '); ?>                                      
			<li class="even">
				<label for="space_id"><?php echo lang('products_space_label'); ?> <span></span></label>                                    
                                <div class="input">                                    
                                    <?php echo form_input('space', htmlspecialchars_decode($post->space), ' placeholder="'.lang('products_Ajax').'" id="spaceAjax"'); ?>
                                    <?php echo  form_hidden('space_id', $post->space_id , 'id="space_id" '); ?>
                                </div>				                                
			</li>                    			
			<li class="even">
				<label for="keywords"><?php echo lang('products_keywords_label'); ?></label>
				<div class="input"><?php echo form_input('keywords', $post->keywords, 'id="keywords"') ?></div>
			</li>                        
			<li class="even">
				<label for="status"><?php echo lang('products_status_label');?></label>
                                    <div class="checker"><span class><?php echo form_checkbox('status', 1, $post->status == 1, ' id="product_status" '); ?></span><?php echo lang('products_active'); ?></div>
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
				<div class="input">
                    <table class="f_table"><tr>
                    <td>
	                    <?php echo form_dropdown('dd_features', array(''=>'') + $features_array,'','class="med" data-placeholder="'.lang('products_no_features_select_label').'"') ?>					
	                    <?php echo form_hidden('f_id','',' id = "f_id"'); ?>  
	                    <?php echo form_input('usageunit','',' placeholder="'.lang('products_usageunit').'" class="f_small" id="usageunit" disabled'); ?>    
	                    <?php echo form_input('f_qty','',' placeholder="'.lang('products_qty').'" class="tiny" id="f_qty"'); ?>                      
                    </td>
                    <td>
                    	<?php echo form_textarea(array('id' => 'f_description', 'name' => 'f_description', 'class' => 'f_tiny', 'placeholder' =>lang('products_f_description') )); ?>	
                    </td>    
                    <td>
                    	<?php echo anchor('', lang('products_add'),'id="f_add" class="btn gray"'); ?> 
                    </td></tr></table>
                    <span><?php echo lang('products_features_list'); ?></span>
                    <!--<div id="f_itemBox" class="f_itemBox"></div>-->
                    <table class="f_table"><tr><th></th><th></th><th></th><th></th></tr><tbody id="f_itemBox"></tbody></table>   
                    <?php echo form_hidden('features',$post->features,' id="features"'); ?> 
                </div>
			</li>                         
			<li>
				<label for="intro"><?php echo lang('products_intro_label'); ?></label>
				<div class="input">
					<br style="clear: both;" />
					<?php echo form_textarea(array('id' => 'intro', 'name' => 'intro', 'value' => $post->intro, 'rows' => 3, 'class'=>'med')); ?>
				</div>
			</li>			
			<li class="even editor">
				<label for="body"><?php echo lang('products_content_label'); ?></label>				
				<div class="input">
					<br style="clear: both;" />
					<?php echo form_textarea(array('id' => 'body', 'name' => 'body', 'value' => $post->body, 'rows' => 6)); ?>    
				</div>
			</li>                                              
		</ul>		
		</fieldset>	                        
        </div>        |
             
	<!-- Info images -->
        <div class="form_inputs" id="products-images-tab">
            <fieldset>	    	            
                <ul>		
                </ul>		
            </fieldset>	
        </div>        

        <!-- Prices tab -->
        <div class="form_inputs" id="products-prices-tab">
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

<style type="text/css">
form.crudli.date-meta div.selector {
    float: left;
    width: 30px;
}
form.crud li.date-meta div input#datepicker { width: 8em; }
form.crud li.date-meta div.selector { width: 5em; }
form.crud li.date-meta div.selector span { width: 1em; }
form.crud li.date-meta label.time-meta { min-width: 4em; width:4em; }
</style>