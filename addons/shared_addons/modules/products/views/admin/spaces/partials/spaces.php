<table border="0" class="table-list" id="indexTable">
        <thead>
        <tr>
                <th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
                <th><?php echo lang('rooms:rooms'); ?></th>
                <th><?php echo lang('rooms:description'); ?></th>                              
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
                <?php foreach ($rooms as $room): ?>
                <tr>
                        <td><?php echo form_checkbox('action_to[]', $room->room_id); ?></td>
                        <td><?php echo $room->name; ?></td>
                        <td><?php echo $room->description; ?>...</td>                                        
                        <td class="align-center buttons buttons-small" width="190px">
                                <?php echo anchor('admin/products/rooms/preview/' . $location->id, lang('global:view'), 'rel="modal-med" class="btn green" target="_blank"'); ?>
                                <?php echo anchor('admin/products/rooms/edit/' . $location->id, lang('global:edit'), 'class="btn orange edit "'); ?>
                                <?php echo anchor('admin/products/rooms/delete/' . $location->id, lang('global:delete'), 'class="confirm red btn delete"') ;?>
                        </td>
                </tr>
                <?php endforeach; ?>
        </tbody>
</table>