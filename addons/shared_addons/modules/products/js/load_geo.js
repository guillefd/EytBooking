     

        
$(function() {

		$( "#CityAjax" ).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: SITE_URL + 'admin/geoworldmap/cities/autocomplete_ajax',
					dataType: "json",
					data: {
						limit: 20,
						term: request.term
					},
					success: function( data ) {
						response( $.map( data.cities, function( item ) {
							return {
								label: item.city + ", " + item.region + ", " + item.country,
                                                                value: item.city + ", " + item.region + ", " + item.country,
                                                                cityid: item.id,
                                                                countryphonecode: item.countryphonecode,
                                                                cityphonecode: item.cityphonecode                                                                
                                                        }
						}));
					}
				});
			},
                        focus: function( event, ui ) {
                               $( "#CityAjax" ).val( ui.item.label );
                               return false;
                        },                        
			minLength: 3,
			select: function( event, ui ) {                                
                                $('input[name="CityID"]').val(ui.item.cityid);
                                $('input[name="phone_area_code"]').val('+' + ui.item.countryphonecode + '.' + ui.item.cityphonecode);
			},
			open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}
		});
});
