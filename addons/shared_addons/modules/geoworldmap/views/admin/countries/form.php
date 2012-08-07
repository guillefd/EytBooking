<section class="title">
<?php if ($this->method == 'create'): ?>
	<h4><?php echo lang('geo_country_create_title'); ?></h4>
<?php else: ?>
	<h4><?php echo sprintf(lang('geo_country_edit_title'), $country->Country); ?></h4>
<?php endif; ?>
</section>

<section class="item">
	
<?php echo form_open(uri_string(), 'class="crud"'); ?>

<div class="tabs">

	<ul class="tab-menu">
		<li><a href="#geoworldmap-info-tab"><span><?php echo lang('geo_country_info_label'); ?></span></a></li>                              
	</ul>
	
	<!-- Info tab -->
	<div class="form_inputs" id="geoworldmap-info-tab">		
		<fieldset>	
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
                        <li>
                            <label><?php echo lang('ws_webservice_country_label'); ?></label>
                            <div class="input">
                                <?php echo anchor('', lang('ws_autocomplete_btn_label'),'id="btn_ws_latlng" class="btn gray"'); ?>                                                                
				<?php echo form_dropdown('ws_countries', array(lang('ws_countries_list_label')),'','data-placeholder="'.lang('ws_countries_no_select_label').'" id="ws_countries"') ?>                             
                            </div>
                        </li>                        
			<li class="even">
				<label><?php echo lang('geo_country_latlng_label'); ?> <span></span></label>
				<div class="input">
                                    <?php echo form_input('Latitude', $country->Latitude, 'maxlength="100" id="Latitude" placeholder="'.lang('geo_city_lat_label').'"'); ?>				
                                    <?php echo form_input('Longitude', $country->Longitude, 'maxlength="100" id="Longitude" placeholder="'.lang('geo_city_long_label').'"'); ?>
                                </div>				
			</li>   
			<li>                        
				<label><?php echo lang('ws_webservice_info_label'); ?> <span></span></label>
				<div class="input">
                                <?php echo anchor('', lang('ws_autocomplete_btn_label'),'id="btn_ws_political" class="btn gray"'); ?>                                                                                                    
				</div>
			</li>                          
			<li class="even">
				<label><?php echo lang('geo_country_political_label'); ?> <span></span></label>
				<div class="input">
                                    <?php echo form_input('Capital', $country->Capital, 'maxlength="100" id="Capital" placeholder="'.lang('geo_country_capital_label').'"'); ?>				
                                    <?php echo form_input('Population', $country->Population, 'maxlength="100" id="Population" placeholder="'.lang('geo_country_population_label').'"'); ?>
                                </div>				
			</li>                         
			<li class="even">
				<label><?php echo lang('geo_country_codes_label'); ?> <span></span></label>
				<div class="input"><?php echo form_input('FIPS104', htmlspecialchars_decode($country->FIPS104), 'maxlength="4" id="FIPS104" placeholder="'.lang('geo_country_fips104_label').'"'); ?>				
                                                   <?php echo form_input('ISO2', htmlspecialchars_decode($country->ISO2), 'maxlength="4" id="ISO2" placeholder="'.lang('geo_country_iso2_label').'"'); ?>
                                                   <?php echo form_input('ISO3', htmlspecialchars_decode($country->ISO3), 'maxlength="4" id="ISO3" placeholder="'.lang('geo_country_iso3_label').'"'); ?>
                                                   <?php echo form_input('ISON', htmlspecialchars_decode($country->ISON), 'maxlength="4" id="ISON" placeholder="'.lang('geo_country_ison_label').'"'); ?>                                    
                                                   <?php echo form_input('Internet', htmlspecialchars_decode($country->Internet), 'maxlength="4" id="Internet" placeholder="'.lang('geo_country_internet_label').'"'); ?></div>                                
			</li>
			<li class="even">
				<label><?php echo lang('geo_country_currency_label'); ?> <span></span></label>
				<div class="input">
                                    <?php echo form_input('Currency', $country->Currency, 'maxlength="100" id="Currency" placeholder="'.lang('geo_country_currency_label').'"'); ?>				
                                    <?php echo form_input('CurrencyCode', $country->CurrencyCode, 'maxlength="100" id="CurrencyCode" placeholder="'.lang('geo_country_currencycode_label').'"'); ?>
                                </div>				
			</li>
			<li class="even">
				<label><?php echo lang('geo_country_phonecode_label'); ?> <span></span></label>
				<div class="input">
                                    <?php echo form_input('PhoneCode', $country->PhoneCode, 'maxlength="4" id="PhoneCode" placeholder="'.lang('geo_country_phonecode_label').'"'); ?>
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