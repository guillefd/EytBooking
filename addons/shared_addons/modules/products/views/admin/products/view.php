<section class="title">
	<h4><?php echo lang('product_view_title').' '.$product->name; ?></h4>
</section>
<section class="item">
	<table>
		<thead>
			<tr>
				<th width="250px"><?php echo lang('product_detail_label') ?></th>
				<th></th>
			</tr>	
		</thead>
		<tbody>
			<tr>
				<td><?php echo lang('products_name_label') ?>: </td>
				<td><?php echo $product->name ?></td>
			</tr>				
			<tr>
				<td><?php echo lang('products_slug_label') ?>: </td>
				<td><?php echo $product->slug ?></td>
			</tr>				
			<tr>				
				<td><?php echo lang('products_account_label') ?>: </td>
				<td><?php echo $product->account ?></td>
			</tr>				
			<tr>				
				<td><?php echo lang('products_chk_seller_account_label') ?>: </td>
				<td><?php echo get_enableText_by_id($product->chk_seller_account) ?></td>
			</tr>				
			<tr>				
				<td><?php echo lang('products_seller_account_label') ?>: </td>
				<td><?php echo $product->seller_account ?></td>
			</tr>				
			<tr>				
				<td><?php echo lang('products_location_label') ?>: </td>
				<td><?php echo get_location_name_by_id($product->location_id) ?></td>
			</tr>				
			<tr>				
				<td><?php echo lang('products_space_label') ?>: </td>
				<td><?php echo get_space_name_by_id($product->space_id) ?></td>
			</tr>				
			<tr>				
				<td><?php echo lang('products_status_label') ?>: </td>
				<td><?php echo get_statusText_by_status_id($product->active) ?></td>
			</tr>				
			<tr>				
				<td><?php echo lang('products_intro_label') ?>: </td>
				<td><?php echo $product->intro ?></td>
			</tr>				
			<tr>				
				<td><?php echo lang('products_content_label') ?>: </td>
				<td><?php echo $product->body ?></td>
			</tr>
			<tr>				
				<td><?php echo lang('products_category_label') ?>: </td>
				<td><?php echo get_category_name_byid($product->category_id) ?></td>
			</tr			
		</tbody>
	</table>
    <table class="tableBox max">
    	<th colspan="5"><?php echo lang('products_features_label') ?></th>
    	<tr><th>Nombre</th><th>Magnitud</th><th>Cantidad</th><th>Descripcion</th><th>Opcional</th></tr>
    	<tbody>
    	<?php foreach($features as $f): ?>	
    	<tr>
    		<td><?php echo $f->name ?></td>
    		<td><?php echo convert_usageunitid_to_text($f->usageunit) ?> </td>
    		<td><?php echo $f->value ?></td>
    		<td><?php echo $f->description ?></td>
    		<td><?php echo $dd_yes_no[$f->is_optional] ?></td>
    	</tr>
    	<?php endforeach; ?>
    	</tbody>
    </table> 	
	<div class="buttons float-right padding-top">
		<?php echo anchor('admin/products/', lang('products_btn_return'), 'class="btn green"'); ?>
	</div>
</section>
