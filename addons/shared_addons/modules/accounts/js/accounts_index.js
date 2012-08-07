


// global
var img_loader = '<img src="' + IMG_PATH + 'loader.gif" style="float:right; margin:5px;" id="loader" alt="" /></div>';
var target = SITE_URL + 'admin/accounts';
var target_filter = SITE_URL + 'admin/accounts/ajax_filter';


$(document).ready(function(){      
                
        var select_filter = $('select[name="f_account_type"]');
        var input_filter = $('input[name="f_keywords"]');
        $('#btnCancel').attr('class','cancel');
        
        //watcher select filter - change
        select_filter.change(function() {
            select_filter.after(img_loader);            
            doAjaxQuery(select_filter,input_filter,target_filter);
        });
        
        //input filter action - keypress - activa a partir de 3 caracteres
        input_filter.keypress(function() {
//            if( input_filter.val().length >= 2 )
//            {    
                $('#loader').remove();
                $('#btnCancel').attr('class','cancel btn orange');
                input_filter.after(img_loader);  
                doAjaxQuery(select_filter,input_filter,target_filter);            
//            }
        });
        
        // pagination links action - click
        $(document).on('click','div.pagination ul li a',function (){
            var link = $(this).attr('href');
            $(this).removeAttr('href');
            doAjaxQuery(select_filter,input_filter,link);
            
        });
        
        
    
});
