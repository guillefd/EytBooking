// global
var img_loader = '<img src="' + IMG_PATH + 'loader.gif" style="float:right; margin:5px;" id="loader" alt="" /></div>';
var img_loader_2 = '<img src="' + IMG_PATH + 'indicator.gif" style="float:right; margin:5px;" id="loader" alt="" /></div>';



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
                

    $("#locationAjax").autocomplete({
        source: function( request, response ) {
            $("#locationAjax").after(img_loader_2);                    
            $.ajax({
                url: SITE_URL + 'admin/products/locations_autocomplete_ajax',
                dataType: "json",
                data: {
                    limit: 20,
                    term: request.term,
                    account: $('input[name="account_id"]').val()
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

    $("#spaceAjax").autocomplete({
        source: function( request, response ) {
            $("#spaceAjax").after(img_loader_2);                    
            $.ajax({
                url: SITE_URL + 'admin/products/spaces_autocomplete_ajax',
                dataType: "json",
                data: {
                    limit: 20,
                    term: request.term,
                    location: $('input[name="location_id"]').val()
                },
                success: function( data ) {
                    response( $.map( data.spaces, function( item ) {
                        return {
                            label: item.name + " [ " + item.account + " | " + item.location + " ]",
                            value: item.name + " [ " + item.account + " | " + item.location + " ]",
                            spaceid: item.space_id                                                              
                        }
                    }));
                    $('#loader').remove(); 
                },
                error: function() {
                    $('#loader').remove();                                         
                }
            });
        },
        focus: function( event, ui ) {
            $( "#spaceAjax" ).val( ui.item.label );
            return false;
        },                        
        minLength: 3,
        select: function( event, ui ) {                                
            $('input[name="space_id"]').val(ui.item.spaceid);  
        },
        open: function() {
            $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
        },
        close: function() {
            $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
        }
    });





    // generate a slug when the user types a title in
    pyro.generate_slug('input[name="name"]', 'input[name="slug"]');
		
    // needed so that Keywords can return empty JSON
    $.ajaxSetup({
        allowEmpty: true
    });

    $('#keywords').tagsInput({
        autocomplete_url:'admin/keywords/autocomplete'
    });
		
    // editor switcher
    $('select[name^=type]').live('change', function() {
        chunk = $(this).closest('li.editor');
        textarea = $('textarea', chunk);
			
        // Destroy existing WYSIWYG instance
        if (textarea.hasClass('wysiwyg-simple') || textarea.hasClass('wysiwyg-advanced')) 
        {
            textarea.removeClass('wysiwyg-simple');
            textarea.removeClass('wysiwyg-advanced');
					
            var instance = CKEDITOR.instances[textarea.attr('id')];
            instance && instance.destroy();
        }
			
			
        // Set up the new instance
        textarea.addClass(this.value);
			
        pyro.init_ckeditor();
			
    });
		
    //ajax create: categories
    $('#products-options-tab ul li:first a').colorbox({
        srollable: false,
        innerWidth: 600,
        innerHeight: 280,
        href: SITE_URL + 'admin/products/categories/create_ajax',
        onComplete: function() {
            $.colorbox.resize();
            $('form#categories').removeAttr('action');
            $('form#categories').live('submit', function(e) {
					
                var form_data = $(this).serialize();
					
                $.ajax({
                    url: SITE_URL + 'admin/products/categories/create_ajax',
                    type: "POST",
                    data: form_data,
                    success: function(obj) {
							
                        if(obj.status == 'ok') {
								
                            //succesfull db insert do this stuff
                            var select = 'select[name=category_id]';
                            var opt_val = obj.category_id;
                            var opt_text = obj.title;
                            var option = '<option value="'+opt_val+'" selected="selected">'+opt_text+'</option>';
								
                            //append to dropdown the new option
                            $(select).append(option);
																
                            // TODO work this out? //uniform workaround
                            $('#products-options-tab li:first span').html(obj.title);
								
                            //close the colorbox
                            $.colorbox.close();
                        } else {
                            //no dice
							
                            //append the message to the dom
                            $('#cboxLoadedContent').html(obj.message + obj.form);
                            $('#cboxLoadedContent p:first').addClass('notification error').show();
                        }
                    }
						
						
                });
                e.preventDefault();
            });
				
        }
    });
});