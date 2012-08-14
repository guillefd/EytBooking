<section class="title">
	<h4><?php echo lang('location:list_title'); ?></h4>
</section>

<section class="item">
	
<?php if ($locations): ?>
    
    <?php echo $this->load->view('admin/locations/partials/filters'); ?>
    
    <div id="filter-stage">

        <?php echo form_open('admin/products/locations/delete'); ?>

        <?php echo $this->load->view('admin/locations/partials/locations'); ?>

        <?php echo form_close(); ?>
        
    </div>  
    <div class="table_action_buttons">
        <?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
    </div>       

<?php else: ?>
        <div class="no_data"><?php echo lang('location:no_categories'); ?></div>
<?php endif; ?>
        
</section>