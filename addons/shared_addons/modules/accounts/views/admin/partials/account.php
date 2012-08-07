<div id="container" >
    <div id="content-body" style="padding: 10px">
        <section class="title" style="width: 850px">
            <h4><span class="titlePrev"><?php echo lang('accounts:account').': '.$account->name; ?></span>
                <span class="titlePrev"><?php echo lang('accounts:account_type').': '.$account->account_type; ?></span>
                <?php if(!empty($account->industry))echo '<span class="titlePrev">'.lang('accounts:industry').': '.$account->industry.'</span>'; ?>               
            </h4>            
        </section>
        <section class="item" style="width: 850px">
        <table class="blue">
                <tfoot>
                        <tr>
                                <!--<td colspan="6">
                                        <div class="inner">Footer</div>
                                </td>-->
                        </tr>
                </tfoot>
		<tbody>
                 		<tr>
					<td><strong><?php echo lang('accounts:address_l1')?></strong></td>
					<td><?php echo $account->address_l1.' '.$account->address_l2; ?></td>                                        
					<td><strong><?php echo lang('accounts:area')?></strong></td>                                         
					<td><?php echo $account->area; ?></td>  
					<td><strong><?php echo lang('accounts:city')?></strong></td>                                         
					<td><?php echo $account->City; ?><? echo !empty($account->zipcode) ? ' ('.$account->zipcode.')' : '' ?></td>  
                                </tr>                                
				<tr>
					<td><strong><?php echo lang('accounts:phone')?></strong></td>
					<td><? echo !empty($account->phone_area_code) ? '('.$account->phone_area_code.') ' : '' ?><?php echo $account->phone; ?></td>                                        
					<td><strong><?php echo lang('accounts:fax')?></strong></td>                                         
					<td><? echo !empty($account->phone_area_code) ? '('.$account->phone_area_code.') ' : '' ?><?php echo $account->fax; ?></td>  
					<td><strong><?php echo lang('accounts:email')?></strong></td>                                         
					<td><?php echo $account->email; ?></td>  
                                </tr>
                                <tr>
                                    <td colspan="6" class="subtitle"><div><? echo lang('accounts:fiscal'); ?></div></td>
                                </tr>
				<tr>
					<td><strong><?php echo lang('accounts:razon_social')?></strong></td>
					<td><?php echo $account->razon_social; ?></td>                                        
					<td><strong><?php echo lang('accounts:cuit_label')?></strong></td>                                         
					<td><?php echo $account->cuit; ?></td>   
					<td><strong><?php echo lang('accounts:iva')?></strong></td>                                         
					<td><?php echo $account->iva; ?></td>  
                                </tr> 
                                <tr>
                                    <td colspan="6" class="subtitle"><div><? echo lang('accounts:pago_proveedores'); ?></div></td>
                                </tr> 
				<tr>
					<td><strong><?php echo lang('accounts:pago_proveedores_mail')?></strong></td>
					<td><?php echo $account->pago_proveedores_mail; ?></td>                                        
					<td><strong><?php echo lang('accounts:pago_proveedores_tel')?></strong></td>                                         
					<td><?php echo $account->pago_proveedores_tel; ?></td>   
					<td><strong><?php echo lang('accounts:pago_proveedores_horario')?></strong></td>                                         
					<td><?php echo $account->pago_proveedores_dias_horarios; ?></td>  
                                </tr>
                                <tr>
					<td><strong><?php echo lang('accounts:pago_proveedores_detalle')?></strong></td>                                         
					<td colspan="5"><?php echo $account->pago_proveedores_detalle; ?></td>  
                                </tr>                                
                                <tr>
                                    <td colspan="6" class="subtitle"><div><? echo lang('accounts:cuentas_por_cobrar'); ?></div></td>
                                </tr>                                 
				<tr>
					<td><strong><?php echo lang('accounts:cuentas_por_cobrar_mail')?></strong></td>
					<td><?php echo $account->cuentas_por_cobrar_mail; ?></td>                                        
					<td><strong><?php echo lang('accounts:cuentas_por_cobrar_tel')?></strong></td>                                         
					<td><?php echo $account->cuentas_por_cobrar_tel; ?></td>   
					<td><strong><?php echo lang('accounts:cuentas_por_cobrar_detalle')?></strong></td>                                         
					<td><?php echo $account->cuentas_por_cobrar_detalle; ?></td>  
                                </tr>                                  
		</tbody>
	</table>            
        </section>
    </div>
</div>

