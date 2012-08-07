<section class="title">
	<?php if ($this->controller == 'admin_countries' && $this->method === 'edit'): ?>
	<h4><?php echo sprintf(lang('geo_country_edit_title'), $country->title);?></h4>
	<?php else: ?>
	<h4><?php echo lang('geo_country_create_title');?></h4>
	<?php endif; ?>
</section>

<section class="item">
<?php echo form_open($this->uri->uri_string(), 'class="crud" id="newcountry"'); ?>     
    
<div class="form_inputs">
    
    <div id="msg" class="alert error"></div>

	<ul>
            <li class="even">
                    <label for="Country"><?php echo lang('geo_country_label'); ?> <span>*</span></label>
                    <div class="input"><?php echo form_input('Country', htmlspecialchars_decode($country->Country), 'maxlength="100" id="Country"'); ?></div>				
            </li>	                                                                    
            <li>
                    <label for="MapReference"><?php echo lang('geo_continent_label'); ?> <span>*</span></label>
                    <div class="input">
                    <?php echo form_dropdown('MapReference', array(lang('geo_countinent_no_select_label')) + $continents, @$country->MapReference,'data-placeholder="'.lang('geo_countinent_no_select_label').'"') ?>
                    </div>
            </li>             
	</ul>
	
</div>

	<div><?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?></div>

<?php echo form_close(); ?>
</section>