
<section class="title">
	<h4><?php echo lang('spaces:list_title'); ?></h4>
</section>

<section class="item">

<?php if ($spaces) : ?>

<?php echo $this->load->view('admin/spaces/partials/filters'); ?>

<div id="filter-stage">

        <?php echo form_open('admin/products/spaces/delete'); ?>

        <?php echo $this->load->view('admin/spaces/partials/spaces'); ?>

	<?php echo form_close(); ?>
	
</div>

<?php else : ?>
	<div class="no_data"><?php echo lang('spaces:no_list'); ?></div>
<?php endif; ?>

</section>
