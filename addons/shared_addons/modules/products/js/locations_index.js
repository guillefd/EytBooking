
// global
var img_loader = '<img src="' + IMG_PATH + 'loader.gif" style="float:right; margin:5px;" id="loader" alt="" /></div>';
var img_loader_2 = '<img src="' + IMG_PATH + 'indicator.gif" style="float:right; margin:5px;" id="loader" alt="" /></div>';
var target = SITE_URL + 'admin/accounts/contacts';
var target_filter = SITE_URL + 'admin/products/locations/ajax_filter';

$(document).ready(function(){ 
   
        var account_filter = $('input[name="f_account_id"]')
        var city_filter = $('input[name="f_city_id"]')
        var keyword_filter = $('input[name="f_keywords"]');
        $('#btnCancel').attr('class','cancel');
   
        //input filter action - keypress
        keyword_filter.keypress(function() {
            $('#loader').remove();
            keyword_filter.after(img_loader_2);  
            doAjaxQuery(keyword_filter, account_filter, city_filter, target_filter);            
        }); 
        
        
//input autocomplete - accounts
        $('input[name="f_account"]').autocomplete({
			source: function( request, response ) {
				keyword_filter.after(img_loader_2); 
                                $.ajax({
					url: SITE_URL + 'admin/accounts/accounts_autocomplete_ajax',
					dataType: "json",
					data: {
						limit: 20,
						term: request.term
					},
                                        success: function( data ) {
                                                response( $.map( data.accounts, function( item ) {
                                                        return {
                                                                label: item.name + " (" + item.razon_social + ")",
                                                                value: item.name + " (" + item.razon_social + ")",
                                                                accountid: item.account_id                                                              
                                                        }       
                                                }));
                                                $('#loader').remove();  
                                        }
				});
			},
                        focus: function( event, ui ) {
                               $( "#f_account" ).val( ui.item.label );
                               return false;
                        },                        
			minLength: 3,
			select: function( event, ui ) {                                
                                $('input[name="f_account_id"]').val(ui.item.accountid);
                                doAjaxQuery(keyword_filter, account_filter, city_filter, target_filter);                                  
			},
			open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}
		});                

                //Autocomplete Cities
		$('input[name="f_city"]').autocomplete({
			source: function( request, response ) {
				$(keyword_filter).after(img_loader_2); 
                                $.ajax({
					url: SITE_URL + 'admin/geoworldmap/cities/autocomplete_ajax',
					dataType: "json",
					data: {
						limit: 50,
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
                                                $('#loader').remove(); 
					}
				});
			},
                        focus: function( event, ui ) {
                               $( "#CityAjax" ).val( ui.item.label );
                               return false;
                        },                        
			minLength: 3,
			select: function( event, ui ) {                                
                                $('input[name="f_city_id"]').val(ui.item.cityid);
                                doAjaxQuery(keyword_filter, account_filter, city_filter, target_filter);                                 
			},
			open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}
		}); 
        
   
});

