<table border="0" class="table-list" id="indexTable">
        <thead>
        <tr>
                <th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
                <th><?php echo lang('location:label'); ?></th>
                <th><?php echo lang('location:intro_label'); ?></th>
                <th><?php echo lang('location:slugSH_label'); ?></th>
                <th><?php echo lang('location:account_label'); ?></th>    
                <th><?php echo lang('location:city_label'); ?></th>                                
                <th><?php echo lang('location:phone_label'); ?></th>                                
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
                <?php foreach ($locations as $location): ?>
                <tr>
                        <td><?php echo form_checkbox('action_to[]', $location->id); ?></td>
                        <td><?php echo $location->name; ?></td>
                        <td><?php echo $location->intro; ?>...</td>                                        
                        <td><?php echo $location->slug; ?></td>
                        <td><?php echo $location->account; ?></td>
                        <td><?php echo $location->City; ?></td>
                        <td><?php echo $location->phone; ?></td>
                        <td class="align-center buttons buttons-small" width="190px">
                                <?php echo anchor('admin/products/locations/preview/' . $location->id, lang('global:view'), 'rel="modal-med" class="btn green" target="_blank"'); ?>
                                <?php echo anchor('admin/products/locations/edit/' . $location->id, lang('global:edit'), 'class="btn orange edit "'); ?>
                                <?php echo anchor('admin/products/locations/delete/' . $location->id, lang('global:delete'), 'class="confirm red btn delete"') ;?>
                        </td>
                </tr>
                <?php endforeach; ?>
        </tbody>
</table>
