<!-- JAVASCRIPT GLOBAL VARS -->
<script>
    var ADD_DIMENTION_VALUE_ERROR_MSG = "<? echo lang('spaces:add_dimention_value_error_msg') ?>";       
    
</script>
<!-- END JAVASCRIPT GLOBAL VARS -->

<section class="title">
	<?php if ($this->controller == 'admin_spaces' && $this->method === 'edit'): ?>
	<h4><?php echo sprintf(lang('spaces:edit_title'), $space->name);?></h4>
	<?php else: ?>
	<h4><?php echo lang('spaces:create_title');?></h4>
	<?php endif; ?>
</section>

<section class="item">
        <?php echo form_open($this->uri->uri_string(), 'class="crud"'); ?>
        <div class="btn_right"><?php $this->load->view('admin/partials/buttons', array('buttons' => array('save','cancel') )); ?></div>    
        <div class="tabs">        
            <ul class="tab-menu">
                    <li><a href="#spaces-info-tab"><span><?php echo lang('spaces:info_label'); ?></span></a></li>                                  
            </ul>        
            <div class="form_inputs" id="spaces-info-tab">
                <fieldset>
                <ul>
                    <li class="even">
                        <label for="location"><?php echo lang('spaces:locationAjax');?> <span>*</span></label>
                        <div class="input">
                            <?php echo  form_input('location', $space->location , 'placeholder="'.lang('spaces:Ajax').'" id="locationAjax" '); ?>
                            <?php echo  form_hidden('location_id', $space->location_id ); ?>                           
                        </div>
                    </li>                   
                    <li>
                        <label for="name"><?php echo lang('spaces:denomination').' | '.lang('spaces:name');?> <span>*</span></label>
                        <div class="input">
                            <?php echo form_dropdown('denomination_id',array(''=>'') + $denominations_array,set_value('denomination_id',$space->denomination_id),'data-placeholder="'.lang('spaces:select_denomination').'" style="width:200px" id="denomination_id"') ?>                            
                            <?php echo form_input('name', $space->name , ' placeholder="'.lang('spaces:name').'" '); ?>                            
                        </div>              
                    </li>                    
                    <li class="even">
                        <label for="level"><?php echo lang('spaces:level');?> <span></span></label>
                        <div class="input">
                            <?php echo  form_input('level', $space->level , ' placeholder="'.lang('spaces:level_expl').'" '); ?>
                        </div>              
                    </li>
                   <li class="even">
                        <label for="dimensions">
                            <?php echo lang('spaces:dimensions');?> <span></span>
                        </label>
                        <div class="input">
                            <?php echo form_input('width', $space->width, ' placeholder="'.lang('spaces:width').'" id="width" class="tiny" '); ?>
                            <?php echo form_input('length', $space->length, ' placeholder="'.lang('spaces:length').'" id="length" class="tiny" '); ?>
                            <?php echo form_input('height', $space->height, ' placeholder="'.lang('spaces:height').'" id="height" class="tiny" '); ?>                            
                        </div>              
                       <label for="square_mt"><?php echo lang('spaces:square_mt');?></label>
                       <div class="input">
                            <?php echo  form_input('square_mt', $space->square_mt , ' placeholder="'.lang('spaces:square_mt_PH').'" id="square_mt" class="small"'); ?>                                                       
                       </div>
                    </li>
                    <li>
                        <label for="shape"><?php echo lang('spaces:shape');?> <span></span></label>
                        <div class="input">
                            <?php echo form_dropdown('shape_id',array(0=>'') + $shapes_array,set_value('shape_id',$space->shape_id),'data-placeholder="'.lang('spaces:select').'" style="width:200px" ') ?>                            
                        </div>              
                    </li>                     
                    <li>
                        <label for="layouts"><?php echo lang('spaces:layouts');?> <span></span></label>
                        <div class="input">
                            <?php echo form_dropdown('layouts',array(''=>'') + $layouts_array,set_value('layouts',$space->layouts),'data-placeholder="'.lang('spaces:select').'" style="width:110px" ') ?>                            
                            <?php echo form_input('capacity','',' placeholder="'.lang('spaces:capacity').'" class="small"'); ?>
                            <?php echo anchor('', lang('spaces:add'),'id="btn_add" class="btn gray"'); ?>  
                            <div id="itemBox" class="itemBox"><span><?php echo lang('spaces:layouts'); ?></span><br></div>                                                            
                        </div>              
                    </li> 
                    <li>
                        <label for="facilities"><?php echo lang('spaces:facilities');?> <span></span></label>
                        <div class="input">
                            <?php echo form_dropdown('facilities[]',array(''=>'') + $facilities_array, set_value('facilities[]',$space->facilities),'multiple data-placeholder="'.lang('spaces:facilities_PH').'" style="width:400px" ') ?>                            
                        </div>              
                    </li>                     
                    <li>
                        <label for="intro"><?php echo lang('spaces:description'); ?> <span></span></label>
                        <br style="clear: both;" />
                        <?php echo form_textarea(array('id' => 'description', 'name' => 'description', 'value' => $space->description, 'rows' => 2)); ?>
                    </li>                    
                </ul>
                </fieldset>
            </div>
        </div>

        <div><?php $this->load->view('admin/partials/buttons', array('buttons' => array('save','cancel') )); ?></div>

        <?php echo form_close(); ?>
</section>