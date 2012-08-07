
// global VAR
var vec_wscountries;


//carga REGION en regiondrop
$(document).ready(function(){
    
         //watcher dropdown cities webservice
         $('select[name="ws_countries"]').change(function() { 
            var id = $('select[name="ws_countries"]').val();
            //captura latitud y longitud -> pega en input correspondiente
            $('input:text[name="Latitude"]').val(vec_wscountries.results[id].geometry.location.lat);
            $('input:text[name="Longitude"]').val(vec_wscountries.results[id].geometry.location.lng);                                  
         });
    
        //watcher btn webservice
        $('#btn_ws_latlng').click(function() {
            $('#btn_ws_latlng').removeAttr('href');
            //añade GIF LOADER
            $('select[name="ws_countries"]').after('<img src="' + SITE_URL+ 'addons/shared_addons/modules/geoworldmap/img/loader.gif" style="float:left; margin:5px;" id="loader" alt="" /></div>');                        
            var form_data = {
                Country : $('input:text[name="Country"]').val()                                      
            };
            $.ajax({
                    type: "POST",
                    url: SITE_URL + 'admin/geoworldmap/webservice/countrieslist',
                    data: form_data,
                    dataType: 'json',
                    success: function(result){
                        // quita el GIF
                        $('#loader').remove();                          
			if(result.status == 'OK') {
                            //copia datos en vec global
                            vec_wscountries = result;
                            // valor vacio a proposito - para js-chosen
                            var options = '<option></option>';                            
                                for (var i = 0; i < vec_wscountries.results.length; i++) 
                                {
                                        options += '<option value="' + i + '">' + vec_wscountries.results[i].formatted_address + '</option>';
                                }
                            $('select[name="ws_countries"]').html(options);
                            //trigger que dispara la actualizacion del dropdown CHOSEN
                            $('select[name="ws_countries"]').trigger("liszt:updated");
                            $('#btn_ws_latlng').attr('class', 'btn green');
                    } else  { 
                                $('#btn_ws_latlng').attr('class', 'btn red');                                
                            }        
                    },
                    error: function()
                    {
                       $('#loader').remove(); 
                       $('#btn_ws_latlng').attr('class', 'btn red');    
                    }
                    });
	});

        //watcher 
        $('#btn_ws_political').click(function() {
            $('#btn_ws_political').removeAttr('href');
            //añade GIF LOADER
            $('#btn_ws_political').after('<img src="' + SITE_URL+ 'addons/shared_addons/modules/geoworldmap/img/loader.gif" style="float:left; margin:5px;" id="loader" alt="" /></div>');                        
            var form_data = {
                Latitude : $('input:text[name="Latitude"]').val(),                       
                Longitude : $('input:text[name="Longitude"]').val()                                                       
            };
            $.ajax({
                    type: "POST",
                    url: SITE_URL + 'admin/geoworldmap/webservice/countryinfo',
                    data: form_data,
                    dataType: 'json',
                    success: function(result){
                        // quita el GIF
                        $('#loader').remove();                          
			if(result.status == 'OK') {
                            //captura latitud y longitud -> pega en input correspondiente
                            $('input:text[name="ISO2"]').val(result.obj.country.countryCode);                                
                            $('input:text[name="FIPS104"]').val(result.obj.country.fipsCode); 
                            $('input:text[name="Internet"]').val(result.obj.country.fipsCode);
                            $('input:text[name="ISO3"]').val(result.obj.country.isoAlpha3);
                            $('input:text[name="ISON"]').val(result.obj.country.isoNumeric);                            
                            $('input:text[name="Capital"]').val(result.obj.country.capital);
                            $('input:text[name="CurrencyCode"]').val(result.obj.country.currencyCode);
                            $('input:text[name="Population"]').val(result.obj.country.population);                            
                            
                            //cambiar color boton
                            $('#btn_ws_political').attr('class', 'btn green');
                    } else  { 
                                $('#btn_ws_political').attr('class', 'btn red');                                
                            }        
                    },
                    error: function()
                    {
                       $('#loader').remove(); 
                       $('#btn_ws_political').attr('class', 'btn red');    
                    }
                    });
	});

});
