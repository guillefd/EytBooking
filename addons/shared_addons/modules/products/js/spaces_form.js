
// global
var img_loader = '<img src="' + IMG_PATH + 'loader.gif" style="margin:5px;" id="loader" alt="" /></div>';
var img_loader_2 = '<img src="' + IMG_PATH + 'indicator.gif" style="margin:5px;" id="loader" alt="" /></div>';


$(document).ready(function(){  
    
    //watcher input dimentions
    $('input[name="width"]').change(function() {    
        checkData(this);
    });
    $('input[name="heigth"]').change(function() {    
        checkData(this);
    });
    $('input[name="length"]').change(function() {    
        checkData(this);
    });
    $('input[name="square_mt"]').change(function() {    
        checkData(this);
    });    
    

    $("#locationAjax").autocomplete({
        source: function( request, response ) {
                $("#locationAjax").after(img_loader_2);                    
                $.ajax({
                        url: SITE_URL + 'admin/products/locations_autocomplete_ajax',
                        dataType: "json",
                        data: {
                                limit: 20,
                                term: request.term
                        },
                        success: function( data ) {
                                response( $.map( data.locations, function( item ) {
                                        return {
                                                label: item.name + " [ " + item.account + " | " + item.City + " ]",
                                                value: item.name + " [ " + item.account + " | " + item.City + " ]",
                                                locationid: item.id                                                              
                                        }
                                }));
                                $('#loader').remove(); 
                        }
                });
            },
            focus: function( event, ui ) {
                    $( "#locationAjax" ).val( ui.item.label );
                    return false;
            },                        
            minLength: 3,
            select: function( event, ui ) {                                
                    $('input[name="location_id"]').val(ui.item.locationid);  
            },
            open: function() {
                    $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                    $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
        
        
   
   
   
   
});