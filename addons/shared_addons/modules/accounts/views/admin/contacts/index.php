<section class="title">
	<h4><?php echo lang('accounts:contacts'); ?></h4>
</section>

<section class="item">

<?php if ($contacts) : ?>

<?php echo $this->load->view('admin/contacts/partials/filters'); ?>

<div id="filter-stage">

	<?php echo form_open('admin/accounts/contacts/action'); ?>

	<?php echo $this->load->view('admin/contacts/partials/contacts'); ?>

	<?php echo form_close(); ?>
	
</div>

<?php else : ?>
	<div class="no_data"><?php echo lang('accounts:currently_no_contacts'); ?></div>
<?php endif; ?>

</section>