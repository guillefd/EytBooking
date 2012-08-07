
// global
var img_loader = '<img src="' + IMG_PATH + 'loader.gif" style="margin:5px;" id="loader" alt="" /></div>';
var img_loader_2 = '<img src="' + IMG_PATH + 'indicator.gif" style="margin:5px;" id="loader" alt="" /></div>';


$(document).ready(function(){   
    
        $("#accountAjax").autocomplete({
                source: function( request, response ) {
		        $("#accountAjax").after(img_loader_2);                    
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
                        $( "#accountAjax" ).val( ui.item.label );
                        return false;
                },                        
                minLength: 3,
                select: function( event, ui ) {                                
                        $('input[name="account_id"]').val(ui.item.accountid);  
                },
                open: function() {
                        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
                },
                close: function() {
                        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
                }
        });
        

        $( "#CityAjax" ).autocomplete({
                source: function( request, response ) {
                        $("#CityAjax").after(img_loader_2);                     
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
                        $('input[name="CityID"]').val(ui.item.cityid);
                        if(ui.item.cityphonecode!=null)
                        {    
                            $('input[name="phone_area_code"]').val('+' + ui.item.countryphonecode + '.' + ui.item.cityphonecode);
                        }    
                },
                open: function() {
                        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
                },
                close: function() {
                        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
                }
        });



});

