<table id="indexTable">
    <thead>
            <tr>
                    <th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
                    <th><?php echo lang('accounts:name'); ?></th>                            
                    <th class="collapse"><?php echo lang('accounts:account_type'); ?></th>         
                    <th class="collapse"><?php echo lang('accounts:city'); ?></th>                                
                    <th class="collapse"><?php echo lang('accounts:phone'); ?></th>                                
                    <th class="collapse"><?php echo lang('accounts:razon_social'); ?></th>                                
                    <th class="collapse"><?php echo lang('accounts:cuit_label'); ?></th>                                
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
            <?php foreach ($accounts as $account) : ?>
                    <tr>
                            <td><?php echo form_checkbox('action_to[]', $account->account_id); ?></td>
                            <td><?php echo $account->name; ?></td>
                            <td class="collapse"><?php echo $account->account_type; ?></td>
                            <td class="collapse"><?php echo $account->City ?></td>
                            <td class="collapse"><?php echo $account->phone ?></td>                            
                            <td class="collapse"><?php echo $account->razon_social ?></td>
                            <td class="collapse"><?php echo $account->cuit ?></td>
                            
                            <td>
                                    <?php echo anchor('admin/accounts/preview/' . $account->account_id, lang('global:view'), 'rel="modal-med" class="btn green" target="_blank"'); ?>
                                    <?php echo anchor('admin/accounts/edit/' . $account->account_id, lang('global:edit'), 'class="btn orange edit"'); ?>
                                    <?php echo anchor('admin/accounts/delete/' . $account->account_id, lang('global:delete'), array('class'=>'confirm btn red delete')); ?>
                            </td>
                    </tr>
            <?php endforeach; ?>
    </tbody>
</table>

<!--<div class="table_action_buttons">
        <?php //$this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
</div>-->