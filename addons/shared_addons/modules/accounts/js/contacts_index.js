


// global
var img_loader = '<img src="' + IMG_PATH + 'loader.gif" style="float:right; margin:5px;" id="loader" alt="" /></div>';
var img_loader_2 = '<img src="' + IMG_PATH + 'indicator.gif" style="float:right; margin:5px;" id="loader" alt="" /></div>';
var target = SITE_URL + 'admin/accounts/contacts';
var target_filter = SITE_URL + 'admin/accounts/contacts/ajax_filter';


$(document).ready(function(){      
                
        var select_filter = $('input[name="f_account_id"]');
        var input_filter = $('input[name="f_keywords"]');
        $('#btnCancel').attr('class','cancel');


        //input filter action - keypress
        input_filter.keypress(function() {
            $('#loader').remove();
            input_filter.after(img_loader);  
            doAjaxQuery(select_filter,input_filter,target_filter);            
        });


        // pagination links action - click
        $(document).on('click','div.pagination ul li a',function (){
            var link = $(this).attr('href');
            $(this).removeAttr('href');
            doAjaxQuery(select_filter,input_filter,link);
            
        });


        //input autocomplete - accounts
        $('input[name="f_account"]').autocomplete({
			source: function( request, response ) {
				input_filter.after(img_loader_2); 
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
                                doAjaxQuery(select_filter,input_filter,target_filter);                                  
			},
			open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}
		});        
        
        
    
});
