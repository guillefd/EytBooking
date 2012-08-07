<!-- JAVASCRIPT GLOBAL VARS -->
<script>

    
</script>
<!-- END JAVASCRIPT GLOBAL VARS -->

<section class="title">
	<!-- We'll use $this->method to switch between accounts.create & accounts.edit -->
	<h4><?php echo lang('accounts:'.$this->method.'_contact'); ?>: <? echo $name; ?></h4>
</section>

<section class="item">

	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>

<div class="tabs">        
    <ul class="tab-menu">
            <li><a href="#contacts-info-tab"><span><?php echo lang('accounts:info'); ?></span></a></li>                        
            <li><a href="#contacts-address-tab"><span><?php echo lang('accounts:address'); ?></span></a></li>                             
    </ul>      	
    
    <div class="form_inputs" id="contacts-info-tab">
        <fieldset>	
		<ul>
                    <li class="<?php echo alternator('', 'even'); ?>">
                            <label for="name"><?php echo lang('accounts:name'); ?> <span>*</span></label>
                            <div class="input">
                                <?php echo form_input('name', set_value('name', $name), 'class="width-15" placeholder="'.lang('accounts:name').'"'); ?>
                                <?php echo form_input('surname', set_value('surname', $surname), 'class="width-15" placeholder="'.lang('accounts:surname').'"'); ?>
                            </div>                            
                    </li>
                    <li class="<?php echo alternator('', 'even'); ?>">
                            <label for="account"><?php echo lang('accounts:account_ws'); ?> <span>*</span></label>
                            <div class="input">
                                <?php echo form_input('account', set_value('account', $account), ' id="accountAjax" class="width-15" placeholder="'.lang('accounts:account_auto').'" '); ?>
                                <?php echo form_hidden('account_id', set_value('account_id',$account_id),'id="account_id" '); ?>                                                    
                            </div>
                    </li>
                    <li class="<?php echo alternator('', 'even'); ?>">
                            <label for="title"><?php echo lang('accounts:section'); ?> <span></span></label>
                            <div class="input">
                                <?php echo form_input('title', set_value('title', $title), 'class="width-15" placeholder="'.lang('accounts:title').'"'); ?>    
                                <?php echo form_input('section', set_value('section', $section), 'class="width-15" placeholder="'.lang('accounts:section').'"'); ?>
                                <?php echo form_input('position', set_value('position', $position), 'class="width-15" placeholder="'.lang('accounts:position').'"'); ?>
                            </div>
                    </li>                    
                    <li class="<?php echo alternator('', 'even'); ?>">
                            <label for="phone"><?php echo lang('accounts:phones'); ?> <span></span></label>
                            <div class="input">
                                <?php echo form_input('phone_area_code', set_value('phonecode', $phone_area_code), 'class="width-15" placeholder="'.lang('accounts:phonecode').'"'); ?>    
                                <?php echo form_input('phone', set_value('phone', $phone), 'class="width-15" placeholder="'.lang('accounts:phone').'"'); ?>
                                <?php echo form_input('fax', set_value('fax', $fax), 'class="width-15" placeholder="'.lang('accounts:fax').'"'); ?>
                            </div>
                    </li>
                    <li>
                            <label for="email"><?php echo lang('accounts:email'); ?> <span></span></label>
                            <div class="input">
                                <?php echo form_input('email', set_value('email', $email), 'class="width-15" placeholder="'.lang('accounts:email').'"'); ?>
                            </div>
                    </li>                  
            </ul>
        </fieldset>        
    </div>    
    
    <div class="form_inputs" id="contacts-address-tab">
        <fieldset>
            <ul>
                    <li class="<?php echo alternator('', 'even'); ?>">
                            <label for="address"><?php echo lang('accounts:address'); ?> <span></span></label>
                            <div class="input">
                                <?php echo form_input('address_l1', set_value('address_l1', $address_l1), 'class="width-15"; placeholder="'.lang('accounts:address_l1').'"'); ?>
                                <?php echo form_input('address_l2', set_value('address_l2', $address_l2), 'class="width-15"; placeholder="'.lang('accounts:address_l2').'"'); ?>
                                <?php echo form_input('area', set_value('area', $area), 'class="width-15"; placeholder="'.lang('accounts:area').'"'); ?>                                
                            </div>                            
                    </li>
                    <li class="even">
                    <label for="City"><?php echo lang('accounts:cityauto');?> <span>*</span></label>
                    <div class="input">
                        <?php echo  form_input('City', set_value('City',$City),'id="CityAjax" style="width:442px" placeholder="'.lang('accounts:city_placeholder').'"'); ?>
                        <?php echo  form_hidden('CityID', set_value('CityID',$CityID),'id="CityID" placeholder="'.lang('accounts:cityid').'"'); ?>                    
                        <?php echo  form_input('zipcode', set_value('$zipcode',$zipcode),'placeholder="'.lang('accounts:zipcode').'"'); ?>
                    </div>
                    </li>
                    <li>
                        <label><?php echo lang('accounts:webservice_lat_lng'); ?></label>
                        <div class="input">
                            <?php echo anchor('', lang('accounts:ws'),'id="btn_ws_latlng" class="btn gray"'); ?>                                                                
                            <?php echo form_dropdown('ws_address', array(lang('accounts:ws_list')),'','data-placeholder="'.lang('accounts:address_no_select').'" id="ws_address"') ?>                             
                        </div>
                    </li>
                    <li class="even">
                    <label for="Latitude"><?php echo lang('accounts:latlng');?> <span> </span></label>
                    <div class="input">
                        <?php echo  form_input('Latitude', $Latitude,'id="Latitude" placeholder="'.lang('accounts:latitude').'"'); ?>
                        <?php echo  form_input('Longitude', $Longitude,'id="Longitude" placeholder="'.lang('accounts:longitude').'"'); ?>                    
                        <?php echo  form_input('latlng_precision', $latlng_precision,'id="latlng_precision" readonly="readonly" placeholder="'.lang('accounts:latlng_precision').'"'); ?>
                    </div>
                    </li>
            </ul>
        </fieldset>
    </div>    

		
    <div class="buttons">
            <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
    </div>
		
	<?php echo form_close(); ?>
</div>  
</section>