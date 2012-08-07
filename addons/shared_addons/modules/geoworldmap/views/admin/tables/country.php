<div id="container">
    <div id="content-body">
        <section class="title">
            <h4><?php echo lang('geo_country_title').': '.$country->Country; ?> (<?=$country->MapReference ?>)</h4>            
        </section>
        <section class="item">
        <table class="blue">
		<thead>
			<tr>                            
				<th width="200">Parámetro</th>
                                <th>Info</th>
                                <th>Mapa</th>                                
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="3">
					<div></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
				<tr>
					<td><strong>ID</strong></td>
					<td><?php echo $country->CountryId; ?></td>
                                        <td rowspan="7"><img src="http://maps.google.com/maps/api/staticmap?center=<?=$country->Latitude ?>,<?=$country->Longitude ?>&zoom=3&size=450x300&sensor=false&markers=<?=$country->Country ?>" </td>
                                </tr>
				<tr>
					<td><strong>Nombre</strong></td>
					<td><?php echo $country->Country; ?></td>
                                </tr>                                
				<tr>
					<td><strong>Codigo ISO2 ISO3</strong></td>
					<td><?php echo $country->ISO2; ?> | <?php echo $country->ISO3; ?></td>
                                </tr>
				<tr>
					<td><strong>Codigo Telefónico</strong></td>
					<td><?php echo $country->PhoneCode; ?></td>
                                </tr>                                
				<tr>
					<td><strong>Capital</strong></td>
					<td><?php echo $country->Capital; ?></td>
                                </tr>                                
				<tr>
					<td><strong>Moneda</strong></td>
					<td><?php echo $country->Currency; ?></td>
                                </tr>                                
				<tr>
					<td><strong>Población</strong></td>
					<td><?php echo $country->Population; ?></td>
                                </tr>                                                                                                   				
				<tr>
					<td><strong>Latitud</strong></td>
					<td><?php echo $country->Latitude; ?></td>
                                </tr>    
				<tr>
					<td><strong>Longitud</strong></td>
					<td><?php echo $country->Longitude; ?></td>
                                </tr>                                    
		</tbody>
	</table>            
        </section>
    </div>
</div>



