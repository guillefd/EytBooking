<!-- JAVASCRIPT GLOBAL VARS -->
<script>
    var ADD_DAY_PROV_ERROR_MSG = "<? echo lang('accounts:add_prov_error_msg') ?>";
    var ADD_DAY_PROV_TIMEERROR_MSG = "<? echo lang('accounts:add_prov_time_error_msg') ?>";    
    var weekday = new Array(7);
    
    weekday[1] = "<? echo lang('accounts:monday') ?>";
    weekday[2] = "<? echo lang('accounts:tuesday') ?>";
    weekday[3] = "<? echo lang('accounts:wednesday') ?>";
    weekday[4] = "<? echo lang('accounts:thursday') ?>";
    weekday[5] = "<? echo lang('accounts:friday') ?>";
    
</script>
<!-- END JAVASCRIPT GLOBAL VARS -->

<section class="title">
	<!-- We'll use $this->method to switch between accounts.create & accounts.edit -->
	<h4><?php echo lang('accounts:'.$this->method); ?> : <? echo $name; ?></h4>
</section>

<section class="item">

	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>

<div class="tabs">        
    <ul class="tab-menu">
            <li><a href="#accounts-info-tab"><span><?php echo lang('accounts:info'); ?></span></a></li>
            <li><a href="#accounts-contact-tab"><span><?php echo lang('accounts:contact'); ?></span></a></li>                            
            <li><a href="#accounts-address-tab"><span><?php echo lang('accounts:address'); ?></span></a></li>                
            <li><a href="#accounts-fiscal-tab"><span><?php echo lang('accounts:fiscal'); ?></span></a></li>                        
            <li><a href="#accounts-prov-tab"><span><?php echo lang('accounts:prov_info'); ?></span></a></li>               
    </ul>      
		
    <div class="form_inputs" id="accounts-info-tab">
        <fieldset>
	
		<ul>
                    <li class="<?php echo alternator('', 'even'); ?>">
                            <label for="name"><?php echo lang('accounts:name'); ?> <span>*</span></label>
                            <div class="input"><?php echo form_input('name', set_value('name', $name), 'class="width-15"'); ?></div>
                    </li>
                    <li class="<?php echo alternator('', 'even'); ?>">
                            <label for="account_type"><?php echo lang('accounts:account_type'); ?> <span>*</span></label>
                            <div class="input"><?php echo form_dropdown('account_type',$account_type_array,set_value('account_type',$account_type),'data-placeholder="'.lang('accounts:account_type').'" id="account_type"') ?></div>                                                         
                    </li>                    
                    <li class="<?php echo alternator('', 'even'); ?>">
                            <label for="industry"><?php echo lang('accounts:industry'); ?> <span></span></label>
                            <div class="input"><?php echo form_input('industry', set_value('industry', $industry), 'class="width-15"'); ?></div>
                    </li>                                           
                   
		</ul>
		</fieldset>
		</div>     

    <div class="form_inputs" id="accounts-contact-tab">
        <fieldset>
            <ul>
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
    
    <div class="form_inputs" id="accounts-address-tab">
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
    
    <div class="form_inputs" id="accounts-fiscal-tab">
        <fieldset>
            <ul>
                    <li class="<?php echo alternator('', 'even'); ?>">
                            <label for="razon_social"><?php echo lang('accounts:razon_social'); ?> <span></span></label>
                            <div class="input"><?php echo form_input('razon_social', set_value('name', $razon_social), 'class="width-15"'); ?></div>
                    </li>                
                    <li class="<?php echo alternator('', 'even'); ?>">
                            <label for="cuit"><?php echo lang('accounts:cuit'); ?> <span></span></label>
                            <div class="input"><?php echo form_input('cuit', set_value('cuit', $cuit), 'class="width-15"'); ?></div>
                    </li> 
                    <li>
                        <label for="iva"><?php echo lang('accounts:iva'); ?> <span></span></label>                                                    
                        <div class="input">
                            <?php echo form_dropdown('iva', $cond_iva_array,set_value('iva',$iva),'data-placeholder="'.lang('accounts:select_iva').'" id="iva"') ?>                             
                        </div>                    
                    </li>    
                    <li>
                        <label for="iibb"><?php echo lang('accounts:iibb'); ?> <span></span></label>                                                    
                        <div class="input">
                            <?php echo form_input('iibb', set_value('iibb', $iibb), 'class="width-15"'); ?>
                        </div>                    
                    </li>                      
            </ul>
        </fieldset>
    </div>     

    <div class="form_inputs" id="accounts-prov-tab">
        <fieldset>
            <ul>
                    <li class="<?php echo alternator('', 'even'); ?>">
                            <label for="pago_proveedores_mail"><?php echo lang('accounts:pago_proveedores'); ?> <span></span></label>
                            <div class="input">
                                <?php echo form_input('pago_proveedores_mail', set_value('pago_proveedores_mail', $pago_proveedores_mail), 'class="width-15" placeholder="'.lang('accounts:pago_proveedores_mail').'"'); ?>
                                <?php echo form_input('pago_proveedores_tel', set_value('pago_proveedores_tel', $pago_proveedores_tel), 'class="width-15" placeholder="'.lang('accounts:pago_proveedores_tel').'"'); ?>
                            </div>                            
                    </li>                 
                    <li>
                            <label for="pago_prov_dias_horarios"><?php echo lang('accounts:pago_proveedores_dias'); ?> <span></span></label>
                            <div class="input">                                                        
                                <?php echo form_dropdown('pago_prov_dia', $week_array,'','data-placeholder="'.lang('accounts:day').'" style="width:100px" id="pago_prov_dia" ') ?>
                                <?php echo form_dropdown('pago_prov_desde', $hour_array,'','id="pago_prov_desde" data-placeholder="'.lang('accounts:from').'" style="width:100px" ') ?>
                                <?php echo form_dropdown('pago_prov_hasta', $hour_array,'','id="pago_prov_hasta" data-placeholder="'.lang('accounts:to').'" style="width:100px"') ?>
                                <?php echo anchor('', lang('accounts:add'),'id="btn_dates" class="btn gray"'); ?>                                   
                                <br>
                                <?php echo form_hidden('pago_proveedores_dias_horarios', set_value('pago_proveedores_dias_horarios', $pago_proveedores_dias_horarios), ''); ?>                                                                                           
                                <div id="itemBox" class="itemBox"><span><?php echo lang('accounts:pago_proveedores_dias'); ?></span><br></div>
                            </div>  
                    </li>
                    <li>
                            <label for="pago_proveedores_forma_de_pago"><?php echo lang('accounts:pago_proveedores_forma_de_pago'); ?> <span></span></label>
                            <div class="input">                                                        
                                <?php echo form_dropdown('pago_proveedores_forma_de_pago', $forma_de_pago_array, set_value('pago_proveedores_forma_de_pago',$pago_proveedores_forma_de_pago),'data-placeholder="'.lang('accounts:pago_proveedores_forma_de_pago').'" id="pago_proveedores_forma_de_pago" ') ?>
                            </div>  
                    </li>                    
                    <li>
                        <label for="pago_proveedores_detalle"><?php echo lang('accounts:pago_proveedores_detalle'); ?><span></span></label>
                        <div class="input">
                            <?php echo form_textarea('pago_proveedores_detalle', set_value('pago_proveedores_detalle', $pago_proveedores_detalle), 'class="width-15"'); ?>
                        </div>
                    </li>
                    <li class="<?php echo alternator('', 'even'); ?>">
                            <label for="cuentas_por_cobrar_mail"><?php echo lang('accounts:cuentas_por_cobrar'); ?> <span></span></label>
                            <div class="input">
                                <?php echo form_input('cuentas_por_cobrar_mail', set_value('cuentas_por_cobrar_mail', $cuentas_por_cobrar_mail), 'class="width-15" placeholder="'.lang('accounts:cuentas_por_cobrar_mail').'"'); ?>
                                <?php echo form_input('cuentas_por_cobrar_tel', set_value('cuentas_por_cobrar_tel', $cuentas_por_cobrar_tel), 'class="width-15" placeholder="'.lang('accounts:cuentas_por_cobrar_tel').'"'); ?>
                            </div>                            
                    </li>   
                    <li>
                        <label for="cuentas_por_cobrar_detalle"><?php echo lang('accounts:cuentas_por_cobrar_detalle'); ?><span></span></label>
                        <div class="input">
                            <?php echo form_textarea('cuentas_por_cobrar_detalle', set_value('cuentas_por_cobrar_detalle', $cuentas_por_cobrar_detalle), 'class="width-15"'); ?>
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