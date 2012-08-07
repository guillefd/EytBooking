<section class="title">
<?php if ($this->method == 'create'): ?>
	<h4><?php echo lang('geo_city_create_title'); ?></h4>
<?php else: ?>
	<h4><?php echo sprintf(lang('geo_city_edit_title'), $city->City); ?></h4>
<?php endif; ?>
</section>

<section class="item">
	
<?php echo form_open(uri_string(), 'class="crud"'); ?>

<div class="tabs">

	<ul class="tab-menu">
		<li><a href="#geoworldmap-info-tab"><span><?php echo lang('geo_city_info_label'); ?></span></a></li>                              
	</ul>
	
	<!-- Info tab -->
	<div class="form_inputs" id="geoworldmap-info-tab">		
		<fieldset>	
		<ul>
			<li class="even">
				<label for="City"><?php echo lang('geo_city_label'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('City', htmlspecialchars_decode($city->City), 'maxlength="100" id="title"'); ?></div>				
			</li>	                                                                    
			<li>
				<label for="CountryID"><?php echo lang('geo_country_label'); ?> <span>*</span></label>
				<div class="input">
				<?php echo form_dropdown('CountryID', array(lang('geo_country_no_select_label')) + $countries, @$city->CountryID) ?>
					<?php echo anchor('admin/geoworldmap/countries/create_ajax', lang('geo_country_create_label'),'id="btn_new_country" class="btn gray" target="_blank"'); ?>
				</div>
			</li>
                        <li>                          
                                <label for="RegionID"><?php echo lang('geo_region_label'); ?> <span>*</span></label>
                                <div class="input">
                                <?php echo form_dropdown('RegionID', array(lang('geo_region_pre_no_select_label')) + $regions, @$city->RegionID,'data-placeholder="'.lang('geo_region_no_select_label').'" ') ?>
                                        <?php echo anchor('admin/geoworldmap/regions/create_ajax', lang('geo_region_create_label'),'id="btn_new_region" class="btn gray" target="_blank"'); ?> 
                                </div>
                        </li>
                        <li>
                            <label><?php echo lang('ws_webservice_lat_lng_label'); ?></label>
                            <div class="input">
                                <?php echo anchor('', lang('ws_autocomplete_btn_label'),'id="btn_ws_latlng" class="btn gray"'); ?>                                                                
				<?php echo form_dropdown('ws_cities', array(lang('ws_cities_list_label')),'','data-placeholder="'.lang('ws_cities_no_select_label').'" id="ws_cities"') ?>                             
                            </div>
                        </li>
			<li class="even">
				<label for="Latitude"><?php echo lang('geo_city_latlng_label'); ?> <span></span></label>
				<div class="input">
                                    <?php echo form_input('Latitude', $city->Latitude, 'maxlength="100" id="Latitude" placeholder="'.lang('geo_city_lat_label').'"'); ?>				
                                    <?php echo form_input('Longitude', $city->Longitude, 'maxlength="100" id="Longitude" placeholder="'.lang('geo_city_long_label').'"'); ?>
                                </div>				
			</li>                      
			<li>                        
				<label for="timezoneid"><?php echo lang('geo_timezoneid_label'); ?> <span> *</span></label>
				<div class="input">
                                <?php echo anchor('', lang('ws_autocomplete_btn_label'),'id="btn_ws_timezone" class="btn gray"'); ?>                                                                                                    
				<?php echo form_dropdown('timezoneid', array(lang('geo_timezoneid_no_select_label')) + $timezones, @$city->timezoneid) ?>
				</div>
			</li>
			<li class="even">
				<label for="PhoneCode"><?php echo lang('geo_city_phonecode_label'); ?> <span></span></label>
				<div class="input">
                                    <?php echo form_input('PhoneCode', $city->PhoneCode, 'maxlength="4" id="PhoneCode" placeholder="'.lang('geo_city_phonecode_label').'"'); ?>				
                                </div>				
			</li>                          
		</ul>		
		</fieldset>		
	</div>    
</div>

<div class="buttons float-right padding-top">
	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))); ?>
</div>

<?php echo form_close(); ?>

</section>

<style type="text/css">
form.crudli.date-meta div.selector {
    float: left;
    width: 30px;
}
form.crud li.date-meta div input#datepicker { width: 8em; }
form.crud li.date-meta div.selector { width: 5em; }
form.crud li.date-meta div.selector span { width: 1em; }
form.crud li.date-meta label.time-meta { min-width: 4em; width:4em; }
</style>