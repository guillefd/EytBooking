<section class="title">
	<h4><?php echo lang('accounts:accounts'); ?></h4>
</section>

<section class="item">

<?php if ($accounts) : ?>

<?php echo $this->load->view('admin/partials/filters'); ?>

<div id="filter-stage">

	<?php echo form_open('admin/accounts/action'); ?>

	<?php echo $this->load->view('admin/partials/accounts'); ?>

	<?php echo form_close(); ?>
	
</div>

<?php else : ?>
	<div class="no_data"><?php echo lang('accounts:currently_no_items'); ?></div>
<?php endif; ?>

</section>