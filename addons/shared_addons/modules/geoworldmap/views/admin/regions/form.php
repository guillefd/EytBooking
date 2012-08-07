<section class="title">
	<?php if ($this->controller == 'admin_regions' && $this->method === 'edit'): ?>
	<h4><?php echo sprintf(lang('geo_region_edit_title'), $region->Region);?></h4>
	<?php else: ?>
	<h4><?php echo lang('geo_region_create_title');?></h4>
	<?php endif; ?>
</section>

<section class="item">
<?php echo form_open($this->uri->uri_string(), 'class="crud" id="newregion"'); ?>     
    
<div class="form_inputs">
    
    <? // solo mostrar en vista crear regoin
      if($this->controller!= 'admin_regions'): ?>
        <div id="msg" class="alert error"></div>
    <? endif ?>

	<ul>
            <li>
                <label for="CountryID"><?php echo lang('geo_country_label'); ?> <span>*</span></label>
                <div class="input">
                <?php echo form_dropdown('CountryID', array(lang('geo_country_no_select_label')) + $countries, @$region->CountryID,'data-placeholder="'.lang('geo_country_no_select_label').'" ') ?>
                </div>   
            </li>    
            <li>
                    <label for="Region"><?php echo lang('geo_region_label'); ?> <span>*</span></label>
                    <div class="input"><?php echo form_input('Region', htmlspecialchars_decode($region->Region), 'maxlength="100"'); ?></div>				
            </li>	                                                                    
            <li>
                    <label for="Code"><?php echo lang('geo_region_code_label'); ?> <span></span></label>
                    <div class="input"><?php echo form_input('Code', htmlspecialchars_decode($region->Code), 'maxlength="100"'); ?></div>	
            </li>             
	</ul>
	
</div>

	<div><? $this->load->view('admin/partials/buttons', array('buttons' => array('save') )); ?>
            <a href="<?=site_url() ?>admin/geoworldmap/countries" class="btn gray cancel">Cancelar</a>
        </div>

<?php echo form_close(); ?>
</section>