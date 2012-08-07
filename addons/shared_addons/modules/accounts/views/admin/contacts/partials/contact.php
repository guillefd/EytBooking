<div id="container" >
    <div id="content-body" style="padding: 10px">
        <section class="title" style="width: 850px">
            <h4><span class="titlePrev"><?php echo lang('accounts:contact').': '.$contact->name; ?></span>
                <span class="titlePrev"><?php echo lang('accounts:account').': '.$contact->account; ?></span>
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
					<td><strong><?php echo lang('accounts:title')?></strong></td>
					<td><?php echo $contact->title; ?></td>                                        
					<td><strong><?php echo lang('accounts:section')?></strong></td>                                         
					<td><?php echo $contact->section; ?></td>  
					<td><strong><?php echo lang('accounts:position')?></strong></td>                                         
					<td><?php echo $contact->position; ?></td>  
                                </tr>                     
                 		<tr>
					<td><strong><?php echo lang('accounts:address_l1')?></strong></td>
					<td><?php echo $contact->address_l1.' '.$contact->address_l2; ?></td>                                        
					<td><strong><?php echo lang('accounts:area')?></strong></td>                                         
					<td><?php echo $contact->area; ?></td>  
					<td><strong><?php echo lang('accounts:city')?></strong></td>                                         
					<td><?php echo $contact->City; ?><? echo !empty($contact->zipcode) ? ' ('.$contact->zipcode.')' : '' ?></td>  
                                </tr>                                
				<tr>
					<td><strong><?php echo lang('accounts:phone')?></strong></td>
					<td><? echo !empty($contact->phone_area_code) ? '('.$contact->phone_area_code.') ' : '' ?><?php echo $contact->phone; ?></td>                                        
					<td><strong><?php echo lang('accounts:fax')?></strong></td>                                         
					<td><? echo !empty($contact->phone_area_code) ? '('.$contact->phone_area_code.') ' : '' ?><?php echo $contact->fax; ?></td>  
					<td><strong><?php echo lang('accounts:email')?></strong></td>                                         
					<td><?php echo $contact->email; ?></td>  
                                </tr>                                 
		</tbody>
	</table>            
        </section>
    </div>
</div>

