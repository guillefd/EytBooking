<section class="title">
	<h4><?php echo lang('features:list_title'); ?></h4>
</section>

<section class="item">
	
<?php if ($features): ?>
    
    <?php echo $this->load->view('admin/features/partials/filters'); ?>
    
    <div id="filter-stage">

        <?php echo form_open('admin/products/features/delete'); ?>

        <?php echo $this->load->view('admin/features/partials/features'); ?>

        <?php echo form_close(); ?>
        
    </div>  
    <div class="table_action_buttons">
        <?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
    </div>       

<?php else: ?>
        <div class="no_data"><?php echo lang('features:no_list'); ?></div>
<?php endif; ?>
        
</section>