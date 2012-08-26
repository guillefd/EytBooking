<table border="0" class="table-list" id="indexTable">
        <thead>
        <tr>
                <th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
                <th><?php echo '('.lang('spaces:denomination').') '.lang('spaces:name'); ?></th>
                <th><?php echo lang('spaces:location_extended'); ?></th>    
                <th><?php echo lang('spaces:city'); ?></th>                        
                <th><?php echo lang('spaces:width'); ?></th>
                <th><?php echo lang('spaces:length'); ?></th>                
                <th><?php echo lang('spaces:square_mt_PH'); ?></th>
                <th><?php echo lang('spaces:shape'); ?></th>
                <th><?php echo lang('spaces:layouts'); ?></th>             
                <th width="150"></th>
        </tr>
        </thead>
        <tfoot>
                <tr>
                        <td colspan="3">
                                <div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
                        </td>
                </tr>
        </tfoot>
        <tbody>
                <?php foreach ($spaces as $space): ?>
                <tr>
                        <td><?php echo form_checkbox('action_to[]', $space->space_id); ?></td>
                        <td><?php echo $space->denomination.': '.$space->name; ?></td>
                        <td><?php echo $space->location_extended; ?></td>                           
                        <td><?php echo $space->city; ?></td>                                                           
                        <td><?php echo $space->width.' '.lang('spaces:mts'); ?></td>                        
                        <td><?php echo $space->length.' '.lang('spaces:mts'); ?></td>
                        <td><?php echo $space->square_mt.' '.lang('spaces:square_mt_PH'); ?></td>
                        <td><?php echo $space->shape; ?></td>
                        <td><?php echo $space->layouts_txt; ?></td>                                                             
                        <td class="align-center buttons buttons-small" width="190px">
                                <?php echo anchor('admin/products/spaces/preview/' . $space->space_id, lang('global:view'), 'rel="modal-med" class="btn green" target="_blank"'); ?>
                                <?php echo anchor('admin/products/spaces/edit/' . $space->space_id, lang('global:edit'), 'class="btn orange edit "'); ?>
                                <?php echo anchor('admin/products/spaces/delete/' . $space->space_id, lang('global:delete'), 'class="confirm red btn delete"') ;?>
                        </td>
                </tr>
                <?php endforeach; ?>
        </tbody>
</table>