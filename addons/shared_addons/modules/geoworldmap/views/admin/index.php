<section class="title">
	<h4><?php echo lang('geo_cities_list_title'); ?></h4>
</section>

<section class="item">

<?php if ($cities) : ?>

<?php echo $this->load->view('admin/partials/filters'); ?>

<div id="filter-stage">

	<?php echo form_open('admin/geoworldmap/action'); ?>

		<?php echo $this->load->view('admin/tables/cities'); ?>

	<?php echo form_close(); ?>
	
</div>

<?php else : ?>
	<div class="no_data"><?php echo lang('geo_currently_no_cities'); ?></div>
<?php endif; ?>

</section>