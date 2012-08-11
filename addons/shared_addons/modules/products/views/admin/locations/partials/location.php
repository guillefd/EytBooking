<div id="container" >
    <div id="content-body" style="padding: 10px">
        <section class="title" style="width: 850px">
            <h4><span class="titlePrev"><?php echo lang('location:label').': '.$location->name; ?></span>
                <span class="titlePrev"><?php echo lang('location:account_label').': '.$location->account; ?></span>
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
					<td><strong><?php echo lang('location:name_label')?></strong></td>
					<td><?php echo $location->name; ?></td>                                          
					<td><strong><?php echo lang('location:account_label')?></strong></td>                                         
					<td colspan="3"><?php echo $location->account; ?></td>  
                                </tr>       
                 		<tr>
					<td><strong><?php echo lang('location:address_label')?></strong></td>
					<td><?php echo $location->address_l1.' '.$location->address_l2; ?></td>                                        
					<td><strong><?php echo lang('location:area_label')?></strong></td>                                         
					<td><?php echo $location->area; ?></td>  
					<td><strong><?php echo lang('location:city_label')?></strong></td>                                         
					<td><?php echo $location->City; ?><? echo !empty($location->zipcode) ? ' ('.$location->zipcode.')' : '' ?></td>  
                                </tr>                                
				<tr>
					<td><strong><?php echo lang('location:phone_label')?></strong></td>
					<td><? echo !empty($location->phone_area_code) ? '('.$location->phone_area_code.') ' : '' ?><?php echo $location->phone; ?></td>                                        
					<td><strong><?php echo lang('location:fax_label')?></strong></td>                                         
					<td><? echo !empty($location->phone_area_code) ? '('.$location->phone_area_code.') ' : '' ?><?php echo $location->fax; ?></td>  
					<td><strong><?php echo lang('location:email_label')?></strong></td>                                         
					<td><?php echo $location->email; ?></td>  
                                </tr>
                                <tr>
                                    	<td colspan="6"><strong><?php echo lang('location:intro_label')?></strong></td>                                         
                                </tr>
                                <tr>
                                        <td colspan="6"><?php echo $location->intro; ?></td>  
                                </tr>
                                <tr>
					<td><strong><?php echo lang('location:link_label')?></strong></td>                                         
					<td colspan="5"><?php echo $location->slug; ?></td>                                    
                                </tr>                                
		</tbody>
	</table>            
        </section>
    </div>
</div>

