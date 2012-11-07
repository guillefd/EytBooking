<section class="title">
	<?php if ($this->controller == 'admin_categories' && $this->method === 'edit'): ?>
	<h4><?php echo sprintf(lang('cat_edit_title'), $category->title);?></h4>
	<?php else: ?>
	<h4><?php echo lang('cat_create_title');?></h4>
	<?php endif; ?>
</section>

<section class="item">
<?php echo form_open($this->uri->uri_string(), 'class="crud" id="categories"'); ?>

<div class="form_inputs">

	<ul>
            <li class="even">
                <label for="type"><?php echo lang('cat_type_label'); ?><span> *</span></label>
                <div class="input"><?php echo form_dropdown('type_id',array(''=>'') + $type_array, set_value('type_id',$category->type_id),' data-placeholder="'.lang('cat_select_label').'"id="type_id" class="med" ') ?></div>
            </li>            
            <li class="even">
                <label for="title"><?php echo lang('cat_title_label');?> <span>*</span></label>
                <div class="input"><?php echo  form_input('title', $category->title); ?></div>
            </li>
            <li>
                <label for="description"><?php echo lang('cat_description_label'); ?> <span>*</span></label>
                <br style="clear: both;" />
                <?php echo form_textarea(array('id' => 'description', 'name' => 'description', 'value' => $category->description, 'rows' => 3, 'class' => 'wysiwyg-simple')); ?>
            </li>                
	</ul>
	
</div>

	<div><?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?></div>

<?php echo form_close(); ?>
</section>