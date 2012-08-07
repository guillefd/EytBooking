<section class="title">
	<h4><?php echo lang('geo_countries_list_title'); ?></h4>
</section>

<section class="item">

<?php if ($countries) : ?>

<?php echo $this->load->view('admin/partials/countries_filters'); ?>

<div id="filter-stage">

	<?php echo form_open('admin/geoworldmap/action'); ?>

		<?php echo $this->load->view('admin/tables/countries'); ?>

	<?php echo form_close(); ?>
	
</div>

<?php else : ?>
	<div class="no_data"><?php echo lang('geo_currently_no_countries'); ?></div>
<?php endif; ?>

</section>