<table border="0" class="table-list" id="indexTable">
        <thead>
        <tr>
                <th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
                <th><?php echo lang('features:name'); ?></th>
                <th><?php echo lang('features:category_label'); ?></th>
                <th><?php echo lang('features:cat_product'); ?></th>
                <th><?php echo lang('features:usageunit'); ?></th>    
                <th><?php echo lang('features:description'); ?></th>                                
                <th><?php echo lang('features:group'); ?></th>                                
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
                <?php foreach ($features as $feature): ?>
                <tr>
                        <td><?php echo form_checkbox('action_to[]', $feature->id); ?></td>
                        <td><?php echo $feature->name; ?></td>
                        <td><?php echo $feature->cat_feature; ?></td>                                        
                        <td><?php echo $feature->cat_product; ?></td>
                        <td><?php echo $feature->usageunit; ?></td>
                        <td><?php echo $feature->description; ?></td>
                        <td><?php echo $feature->group; ?></td>
                        <td class="align-center buttons buttons-small" width="190px">
                                <?php echo anchor('admin/products/features/preview/' . $feature->id, lang('global:view'), 'rel="modal-med" class="btn green" target="_blank"'); ?>
                                <?php echo anchor('admin/products/features/edit/' . $feature->id, lang('global:edit'), 'class="btn orange edit "'); ?>
                                <?php echo anchor('admin/products/features/delete/' . $feature->id, lang('global:delete'), 'class="confirm red btn delete"') ;?>
                        </td>
                </tr>
                <?php endforeach; ?>
        </tbody>
</table>
