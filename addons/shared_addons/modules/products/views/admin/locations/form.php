<section class="title">
	<?php if ($this->controller == 'admin_locations' && $this->method === 'edit'): ?>
	<h4><?php echo sprintf(lang('location:edit_title'), $location->title);?></h4>
	<?php else: ?>
	<h4><?php echo lang('location:create_title');?></h4>
	<?php endif; ?>
</section>

<section class="item">
<?php echo form_open($this->uri->uri_string(), 'class="crud" id="locations"'); ?>

    
<div class="tabs">    
    
    <ul class="tab-menu">
            <li><a href="#locations-info-tab"><span><?php echo lang('location:info_label'); ?></span></a></li>
            <li><a href="#locations-address-tab"><span><?php echo lang('location:location_label'); ?></span></a></li>                
            <li><a href="#locations-contact-tab"><span><?php echo lang('location:contact_label'); ?></span></a></li>               
    </ul>    
    
    <div class="form_inputs" id="locations-info-tab">
        <fieldset>
	<ul>
		<li class="even">
		<label for="title"><?php echo lang('location:name_label');?> <span>*</span></label>
		<div class="input"><?php echo  form_input('name', $location->name); ?></div>
		</li>

                <li>
                <label for="intro"><?php echo lang('location:intro_label'); ?> <span>*</span></label>
                <br style="clear: both;" />
                <?php echo form_textarea(array('id' => 'intro', 'name' => 'intro', 'value' => $location->intro, 'rows' => 2, 'class' => 'wysiwyg-simple')); ?>
                </li>                
                
                <li class="even editor">
                        <label for="description"><?php echo lang('location:description_label'); ?></label>				
                        <div class="input">
                                <?php echo form_dropdown('type', array(
                                        'html' => 'html',
                                        'markdown' => 'markdown',
                                        'wysiwyg-simple' => 'wysiwyg-simple',
                                        'wysiwyg-advanced' => 'wysiwyg-advanced',
                                ), $location->type); ?>
                        </div>				
                        <br style="clear:both"/>				
                        <?php echo form_textarea(array('id' => 'description', 'name' => 'description', 'value' => $location->description, 'rows' => 30, 'class' => $location->type)); ?>				
                </li>
        </ul>
        </fieldset>
    </div>
    <div class="form_inputs" id="locations-address-tab">
        <fieldset>
            <ul>    
		<li class="even">
		<label for="address"><?php echo lang('location:address_label');?> <span> </span></label>
		<div class="input">
                    <?php echo  form_input('address_l1', $location->address_l1,'placeholder="'.lang('location:addressl1_placeholder_label').'"'); ?>
                    <?php echo  form_input('address_l2', $location->address_l2,'placeholder="'.lang('location:addressl2_placeholder_label').'"'); ?>                    
                    <?php echo  form_input('area', $location->area,'placeholder="'.lang('location:area_label').'"'); ?>
                </div>
		</li>
		<li class="even">
                <label for="City"><?php echo lang('location:cityauto_label');?> <span> </span></label>
                <div class="input">
                    <?php echo  form_input('City', $location->City,'id="CityAjax" style="width:442px" placeholder="'.lang('location:city_placeholder_label').'"'); ?>
                    <?php echo  form_hidden('CityID', $location->CityID,'id="CityID" placeholder="'.lang('location:cityid_label').'"'); ?>                    
                    <?php echo  form_input('zipcode', $location->zipcode,'placeholder="'.lang('location:zipcode_label').'"'); ?>
                </div>
		</li>
                <li>
                    <label><?php echo lang('location:webservice_lat_lng_label'); ?></label>
                    <div class="input">
                        <?php echo anchor('', lang('location:ws_label'),'id="btn_ws_latlng" class="btn gray"'); ?>                                                                
                        <?php echo form_dropdown('ws_address', array(lang('location:ws_list_label')),'','data-placeholder="'.lang('location:address_no_select_label').'" id="ws_address"') ?>                             
                    </div>
                </li>
		<li class="even">
                <label for="Latitude"><?php echo lang('location:latlng_label');?> <span> </span></label>
                <div class="input">
                    <?php echo  form_input('Latitude', $location->Latitude,'id="Latitude" placeholder="'.lang('location:latitude_label').'"'); ?>
                    <?php echo  form_input('Longitude', $location->Longitude,'id="Longitude" placeholder="'.lang('location:longitude_label').'"'); ?>                    
                    <?php echo  form_input('latlng_precision', $location->latlng_precision,'id="latlng_precision" readonly="readonly" placeholder="'.lang('location:latlng_precision_label').'"'); ?>
                </div>
		</li>                
        </ul>
        </fieldset>
    </div> 
    <div class="form_inputs" id="locations-contact-tab">
        <fieldset>
            <ul>     
               	<li class="even">
		<label for="phone"><?php echo lang('location:phone_label');?> <span></span></label>
		<div class="input">
                    <?php echo  form_input('phone_area_code', $location->phone_area_code,'placeholder="'.lang('location:phonearea_label').'" '); ?>
                    <?php echo  form_input('phone', $location->phone,'placeholder="'.lang('location:phone_label').'"'); ?>
                    <?php echo  form_input('fax', $location->fax,'placeholder="'.lang('location:fax_label').'"'); ?>
                </div>
		</li>                    
		<li class="even">
		<label for="mobile"><?php echo lang('location:mobile_label');?> <span></span></label>
		<div class="input"><?php echo  form_input('mobile', $location->mobile,'placeholder="'.lang('location:mobile_label').'"'); ?></div>
		</li>
               	<li class="even">
		<label for="chat"><?php echo lang('location:chat_label');?> <span></span></label>
		<div class="input">
                    <?php echo  form_input('chat_hotmail', $location->chat_hotmail,'placeholder="'.lang('location:hotmail_label').'" '); ?>
                    <?php echo  form_input('chat_gmail', $location->chat_gmail,'placeholder="'.lang('location:gmail_label').'"'); ?>
                    <?php echo  form_input('chat_skype', $location->chat_skype,'placeholder="'.lang('location:skype_label').'"'); ?>
                </div>
		</li> 
               	<li class="even">
		<label for="social"><?php echo lang('location:social_label');?> <span></span></label>
		<div class="input">
                    <?php echo  form_input('social_twitter', $location->social_twitter,'placeholder="'.lang('location:twitter_label').'" '); ?>
                    <?php echo  form_input('social_facebook', $location->social_facebook,'placeholder="'.lang('location:facebook_label').'"'); ?>
                    <?php echo  form_input('social_google', $location->social_google,'placeholder="'.lang('location:google_label').'"'); ?>
                </div>
		</li>                  
	</ul>
        </fieldset>    	
    </div>
</div>

	<div><?php $this->load->view('admin/partials/buttons', array('buttons' => array('save','save_exit','cancel') )); ?></div>

<?php echo form_close(); ?>
</section>