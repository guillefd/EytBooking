// global VAR

var vec=new Array();
var Nitem = -1;

// global
var img_loader = '<img src="' + IMG_PATH + 'loader.gif" style="margin:5px;" id="loader" alt="" /></div>';
var img_loader_2 = '<img src="' + IMG_PATH + 'indicator.gif" style="margin:5px;" id="loader" alt="" /></div>';

$(document).ready(function(){
    
        //inicializa campo hidden pago_proveedores_dias_horarios, si tiene valor los agrega al html
        init_hidden_dias_horarios();  
        
        //copia valores HTML de elementos
        days_list = $('select[name="pago_prov_dia"]').html();
        time_list = $('select[name="pago_prov_desde"]').html();

        //watcher btn ADD
        $("#btn_dates").click(function() {
            $("#btn_dates").removeAttr('href');      
            processData();           
        });
        
        //watcher btn BORRAR (x) item de lista de dias/horarios
        $(document).on('click', 'a[name="btn_del"]', function(){ //do stuff here })
            $(this).removeAttr('href');
            var id = $(this).attr("id");
            deleteItem(id);
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


