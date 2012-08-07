<table id="indexTable">
    <thead>
            <tr>
                    <th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
                    <th><?php echo lang('accounts:name'); ?></th>                            
                    <th class="collapse"><?php echo lang('accounts:account'); ?></th>
                    <th class="collapse"><?php echo lang('accounts:city'); ?></th>                                
                    <th class="collapse"><?php echo lang('accounts:phone'); ?></th>                                
                    <th class="collapse"><?php echo lang('accounts:email'); ?></th>                                
                    <th width="180"></th>
            </tr>
    </thead>
    <tfoot>
            <tr>
                    <td colspan="7">
                            <div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
                    </td>
            </tr>
    </tfoot>
    <tbody>
            <?php foreach ($contacts as $contact) : ?>
                    <tr>
                            <td><?php echo form_checkbox('action_to[]', $contact->contact_id); ?></td>
                            <td><?php echo $contact->name.' '.$contact->surname; ?></td>
                            <td class="collapse"><?php echo $contact->account ?></td>
                            <td class="collapse"><?php echo $contact->City ?></td>                            
                            <td class="collapse"><?php echo $contact->phone ?></td>
                            <td class="collapse"><?php echo $contact->email ?></td>
                            
                            <td>
                                    <?php echo anchor('admin/accounts/contacts/preview/' . $contact->contact_id, lang('global:view'), 'rel="modal-small" class="btn green" target="_blank"'); ?>
                                    <?php echo anchor('admin/accounts/contacts/edit/' . $contact->contact_id, lang('global:edit'), 'class="btn orange edit"'); ?>
                                    <?php echo anchor('admin/accounts/contacts/delete/' . $contact->contact_id, lang('global:delete'), array('class'=>'confirm btn red delete')); ?>
                            </td>
                    </tr>
            <?php endforeach; ?>
    </tbody>
</table>

<!--<div class="table_action_buttons">
        <?php // $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
</div>-->