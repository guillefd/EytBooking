<table border="0" class="table-list" id="indexTable">
        <thead>
        <tr>
                <th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
                <th><?php echo lang('feature:label'); ?></th>
                <th><?php echo lang('feature:intro_label'); ?></th>
                <th><?php echo lang('feature:slugSH_label'); ?></th>
                <th><?php echo lang('feature:account_label'); ?></th>    
                <th><?php echo lang('feature:city_label'); ?></th>                                
                <th><?php echo lang('feature:phone_label'); ?></th>                                
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
                        <td><?php echo form_checkbox('action_to[]', $feature->id); ?></td>
                        <td><?php echo $feature->name; ?></td>
                        <td><?php echo $feature->intro; ?>...</td>                                        
                        <td><?php echo $feature->slug; ?></td>
                        <td><?php echo $feature->account; ?></td>
                        <td><?php echo $feature->City; ?></td>
                        <td><?php echo $feature->phone; ?></td>
                        <td class="align-center buttons buttons-small" width="190px">
                                <?php echo anchor('admin/products/features/preview/' . $feature->id, lang('global:view'), 'rel="modal-med" class="btn green" target="_blank"'); ?>
                                <?php echo anchor('admin/products/features/edit/' . $feature->id, lang('global:edit'), 'class="btn orange edit "'); ?>
                                <?php echo anchor('admin/products/features/delete/' . $feature->id, lang('global:delete'), 'class="confirm red btn delete"') ;?>
                        </td>
                </tr>
                <?php endforeach; ?>
        </tbody>
</table>
