<div id="container">
    <div id="content-body">
        <section class="title">
            <h4><?php echo lang('geo_city_title').': '.$city->City; ?> (<?=$city->country ?>)</h4>            
        </section>
        <section class="item">
        <table class="blue">
		<thead>
			<tr>                            
				<th width="200">Parámetro</th>
                                <th width="300">Info</th>
                                <th>Mapa</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="7">
					<div class="inner"></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
				<tr>
					<td><strong>ID</strong></td>
					<td><?php echo $city->CityId; ?></td>
                                        <td rowspan="7"><img src="http://maps.google.com/maps/api/staticmap?center=<?=$city->Latitude ?>,<?=$city->Longitude ?>&zoom=9&size=450x300&sensor=false&markers=<?=$city->City ?>"</td>
                                </tr>
				<tr>
					<td><strong>Nombre</strong></td>
					<td><?php echo $city->City; ?></td>
                                </tr>                                
				<tr>
					<td><strong>region</strong></td>
					<td><?php echo $city->region; ?></td>
                                </tr>  
				<tr>
					<td><strong>Pais</strong></td>
					<td><?php echo $city->country; ?></td>
                                </tr>                                
				<tr>
					<td><strong>Latitude</strong></td>
					<td><?php echo $city->Latitude; ?></td>
                                </tr>                                
				<tr>
					<td><strong>Longitude</strong></td>
					<td><?php echo $city->Longitude; ?></td>
                                </tr>             
				<tr>
					<td><strong>TimeZone</strong></td>
					<td><?php echo $city->timezoneid.' ('.$city->gmt.')'; ?></td>
                                </tr>                                                                                         				
		</tbody>
	</table>            
        </section>
    </div>
</div>



