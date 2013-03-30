var img_loader_2 = '<img src="' + IMG_PATH + 'indicator.gif" style="float:right; margin:5px;" id="loader" alt="" /></div>';


function doAjaxQuery(data)
{
   $('#loader').remove();
   $('#btnCancel').after(img_loader_2);     
   var form_data = {
        f_account_id : data.account_id.val(),  
        f_keywords: data.keyword.val(),
        f_category_id: data.category_id.val(),
        f_status: data.status_id.val(),
        f_deleted: data.deleted.val()
    };

    $.ajax({
        type: "POST",
        url: data.link,
        data: form_data,
        dataType: 'html',
        success: function(result){
            $('#btnCancel').attr('class','cancel btn orange');            
            //replace Table with new values 
            $('#indexView').replaceWith(result);            
            // remove GIF
            $('#loader').remove();                          
        },
        error: function()
        {
            $('#loader').remove(); 
        }
    });         
}


$(document).ready(function(){ 
   
        var f_data = new Object();
        f_data.keyword = $('input[name="f_keywords"]');
        f_data.account_id = $('input[name="f_account_id"]');
        f_data.category_id = $('select[name="f_category_id"]');
        f_data.status_id = $('select[name="f_status"]');    
        f_data.deleted = $('select[name="f_deleted"]');                
        f_data.link = SITE_URL + 'admin/products/ajax_filter';

        $('#btnCancel').attr('class','btn gray cancel');
   
        //WATCHERS - ACTIVATE FILTER
        f_data.keyword.keypress(function() {
            doAjaxQuery(f_data);            
        });       

        f_data.category_id.change(function() {
            doAjaxQuery(f_data);            
        });      

        f_data.status_id.change(function() {
            doAjaxQuery(f_data);            
        });             

        f_data.deleted.change(function() {
            doAjaxQuery(f_data);            
        });

    $("#f_account").autocomplete({
        source: function( request, response ) {
            $("#f_account").after(img_loader_2);                    
            $.ajax({
                url: SITE_URL + 'admin/accounts/accounts_autocomplete_ajax',
                dataType: "json",
                data: {
                    limit: 20,
                    term: request.term
                },
                success: function( data ) {
                        response( $.map( data.accounts, function( item ) {
                        if(item.razon_social=="") { 
                                                    var razonsocial = ''; 
                                                  }
                                                  else{
                                                        razonsocial = ' (' + item.razon_social + ')';   
                                                      }   
                        return {
                                label: item.name + razonsocial,
                                value: item.name + razonsocial,
                                accountid: item.account_id                                                              
                                }
                            })
                        );
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
            doAjaxQuery(f_data); 
        },
        open: function() {
            $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
        },
        close: function() {
            $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
        }
    });        

});        