<div id="container" >
    <div id="content-body" style="padding: 10px">
        
        <section class="title" style="width: 850px">
            <h4><span class="titlePrev"><?php echo lang('features:title_label').': '; ?></span>
                <span class="titlePrev"><?php echo lang('features:title_label').': '; ?></span>
            </h4>            
        </section>
        <section class="item" style="width: 850px">

            <?php echo form_open(uri_string()); ?>


                    <!-- Info tab -->
                    <div class="form_inputs">		
                            <fieldset>	
                            <ul>
                                    <li>
                                            <label for="name"><?php echo lang('features:name'); ?> <span>*</span></label>
                                            <div class="input"><?php echo form_input('name', '') ?></div>
                                    </li>                     
                            </ul>		
                            </fieldset>		
                    </div>
            <div class="buttons float-right padding-top">
                    <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
            </div>
            <?php echo form_close(); ?>                                  
        </section>
    </div>
</div>