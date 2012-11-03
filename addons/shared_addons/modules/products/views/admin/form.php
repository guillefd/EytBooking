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
		<li><a href="#products-features-tab"><span><?php echo lang('products_features_label'); ?></span></a></li>
		<li><a href="#products-images-tab"><span><?php echo lang('products_images_label'); ?></span></a></li>
		<li><a href="#products-prices-tab"><span><?php echo lang('products_prices_label'); ?></span></a></li>                
	</ul>
	
	<!-- Info tab -->
	<div class="form_inputs" id="products-setup-tab">		
		<fieldset>	
		<ul>                    
                        <li class="even">
				<label for="type_id"><?php echo lang('products_type_label'); ?> <span>*</span></label>
				<div class="input">
				<?php echo form_dropdown('type_id', array(''=>'') + $type_array, $post->type_id,' data-placeholder="'.lang('products_no_type_select_label').'"') ?>
				</div>
			</li>                     
                        <li class="even">
				<label for="category_id"><?php echo lang('products_category_label'); ?> <span>*</span></label>
				<div class="input">
                                    <?php echo form_dropdown('category_id', array(''=>'') + $cat_products_array, $post->category_id,' data-placeholder="'.lang('products_no_category_select_label').'"') ?>					
				</div>
			</li>                    
			<li class="even">
				<label for="location_id"><?php echo lang('products_location_label'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('location_id', htmlspecialchars_decode($post->location_id), 'id="location_id"'); ?></div>				
			</li>                    			
			<li class="even">
				<label for="keywords"><?php echo lang('products_keywords_label'); ?></label>
				<div class="input"><?php echo form_input('keywords', $post->keywords, 'id="keywords"') ?></div>
			</li>                        
			<li class="even">
				<label for="comments_enabled"><?php echo lang('products_comments_enabled_label');?></label>
				<div class="input"><?php echo form_checkbox('comments_enabled', 1, ($this->method == 'create' && ! $_POST) or $post->comments_enabled == 1, 'id="comments_enabled"'); ?></div>
			</li>                          

		</ul>		
		</fieldset>		
	</div>

	<!-- Infos tab -->
	<div class="form_inputs" id="products-info-tab">
            <fieldset>	
            <ul>            
			<li class="even">
				<label for="name"><?php echo lang('products_name_label'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('name', htmlspecialchars_decode($post->name), 'maxlength="100" id="name"'); ?></div>				
			</li>
			<li>
				<label for="slug"><?php echo lang('products_slug_label'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('slug', $post->slug, 'maxlength="100" class="width-20"'); ?></div>
			</li> 
			<li>
				<label for="intro"><?php echo lang('products_intro_label'); ?></label>
				<br style="clear: both;" />
				<?php echo form_textarea(array('id' => 'intro', 'name' => 'intro', 'value' => $post->intro, 'rows' => 5, 'class' => 'wysiwyg-simple')); ?>
			</li>			
			<li class="even editor">
				<label for="body"><?php echo lang('products_content_label'); ?></label>				
				<div class="input">
					<?php echo form_dropdown('type', array(
						'html' => 'html',
						'markdown' => 'markdown',
						'wysiwyg-simple' => 'wysiwyg-simple',
						'wysiwyg-advanced' => 'wysiwyg-advanced',
					), $post->type); ?>
				</div>				
				<br style="clear:both"/>				
				<?php echo form_textarea(array('id' => 'body', 'name' => 'body', 'value' => $post->body, 'rows' => 30, 'class' => $post->type)); ?>				
			</li>                                              
		</ul>		
		</fieldset>	                        
        </div>        
        
	<!-- Features tab -->
	<div class="form_inputs" id="products-features-tab">
	
		<fieldset>
		
		<ul>

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