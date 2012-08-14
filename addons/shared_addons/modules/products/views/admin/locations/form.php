<!-- JAVASCRIPT GLOBAL VARS -->
<script>
    var ADD_SOCIAL_ACCOUNT_ERROR_MSG = "<? echo lang('location:add_social_account_error_msg') ?>";   
    
</script>
<!-- END JAVASCRIPT GLOBAL VARS -->


<section class="title">
	<?php if ($this->controller == 'admin_locations' && $this->method === 'edit'): ?>
	<h4><?php echo sprintf(lang('location:edit_title'), $location->name);?></h4>
	<?php else: ?>
	<h4><?php echo lang('location:create_title');?></h4>
	<?php endif; ?>
</section>

<section class="item">
        <?php echo form_open($this->uri->uri_string(), 'class="crud" id="locations"'); ?>
        <div class="btn_right"><?php $this->load->view('admin/partials/buttons', array('buttons' => array('save','cancel') )); ?></div>    
        <div class="tabs">        
            <ul class="tab-menu">
                    <li><a href="#locations-info-tab"><span><?php echo lang('location:info_label'); ?></span></a></li>
                    <li><a href="#locations-address-tab"><span><?php echo lang('location:location_label'); ?></span></a></li>                
                    <li><a href="#locations-contact-tab"><span><?php echo lang('location:contact_label'); ?></span></a></li>               
                    <li><a href="#locations-content-tab"><span><?php echo lang('location:content_label'); ?></span></a></li>                                   
            </ul>        
            <div class="form_inputs" id="locations-info-tab">
                <fieldset>
                <ul>
                    <li class="even">
                        <label for="title"><?php echo lang('location:accountAjax_label');?> <span>*</span></label>
                        <div class="input">
                            <?php echo  form_input('account', $location->account , 'placeholder="'.lang('location:accountAjax').'" id="accountAjax" '); ?>
                            <?php echo  form_hidden('account_id', $location->account_id , 'id="account_id" '); ?>                           
                        </div>
                    </li>                    
                    <li class="even">
                        <label for="title"><?php echo lang('location:name_label');?> <span>*</span></label>
                        <div class="input">
                            <?php echo  form_input('name', $location->name , ' placeholder="'.lang('location:name_label').'" '); ?>
                        </div>
                        <label for="title"><?php echo lang('location:slug_label');?> <span>*</span></label>
                        <div class="input">
                            <?php echo  form_input('slug', $location->slug, ' placeholder="'.lang('location:slug_label').'" readonly'); ?>
                        </div>                
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
                            <label for="City"><?php echo lang('location:cityauto_label');?> <span>*</span></label>
                            <div class="input">
                                <?php echo  form_input('City', $location->City,'id="CityAjax" class="double" placeholder="'.lang('location:city_placeholder_label').'"'); ?>
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
                            <label for="email"><?php echo lang('location:email_label');?> <span></span></label>
                            <div class="input"><?php echo  form_input('email', $location->email,'placeholder="'.lang('location:email_label').'"'); ?></div>
                        </li>                        
                        <li>
                            <label for="chat"><?php echo lang('location:chatSocial_label');?> <span></span></label>
                            <div class="input">
                                <?php echo form_dropdown('dd_social', $social,'','data-placeholder="'.lang('location:social_select_label').'" style="width:150px" id="dd_social"') ?>                                                             
                                <?php echo form_input('user_account','','placeholder="'.lang('location:input_social').'"'); ?>
                                <?php echo anchor('', lang('location:add'),'id="btn_add" class="btn gray"'); ?><br>
                                <div id="itemBox" class="itemBox"><span><?php echo lang('location:social_accounts'); ?></span><br></div>                                
                                <?php echo form_hidden('chatSocial_accounts', $location->chatSocial_accounts,'style="width:550px"'); ?>                                
                            </div>
                        </li>                
                    </ul>
                </fieldset>    	
            </div>
            <div class="form_inputs" id="locations-content-tab">
                <fieldset>
                    <ul>
                    <li>
                        <label for="intro"><?php echo lang('location:intro_short_label'); ?> <span>*</span></label>
                        <br style="clear: both;" />
                        <?php echo form_textarea(array('id' => 'intro', 'name' => 'intro', 'value' => $location->intro, 'rows' => 2)); ?>
                    </li>                          
                    <li class="even editor">
                        <label for="description"><?php echo lang('location:description_long_label'); ?></label>				
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
        </div>

        <div><?php $this->load->view('admin/partials/buttons', array('buttons' => array('save','cancel') )); ?></div>

        <?php echo form_close(); ?>
</section>