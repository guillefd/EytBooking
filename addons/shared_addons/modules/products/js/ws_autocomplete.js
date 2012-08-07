
// global VAR
var vec_wsaddress;
var address_n = '';
var address_r = '';

//carga REGION en regiondrop
$(document).ready(function(){
    
         //watcher dropdown cities webservice
         $('select[name="ws_address"]').change(function() { 
            var id = $('select[name="ws_address"]').val();
            //captura latitud y longitud -> pega en input correspondiente
            $('input:text[name="Latitude"]').val(vec_wsaddress.results[id].geometry.location.lat);
            $('input:text[name="Longitude"]').val(vec_wsaddress.results[id].geometry.location.lng);            
            $('input:text[name="latlng_precision"]').val(vec_wsaddress.results[id].geometry.location_type);
            address_comp = vec_wsaddress.results[id].address_components;
            for(i=0;i<=address_comp.length;i++)
            {    
                types = address_comp[i].types;
                for(j=0;j<=types.length;j++)
                {    
                    if(types[j] == 'neighborhood' || types[j] == 'colloquial_area')
                    {    
                        $('input:text[name="area"]').val(address_comp[i].short_name);               
                    }
                    if(types[j] == 'postal_code')
                    {    
                        $('input:text[name="zipcode"]').val(address_comp[i].short_name);               
                    } 
                    if(types[j] == 'street_number')
                    {    
                        address_n = address_comp[i].short_name;               
                    }
                    if(types[j] == 'route')
                    {    
                        address_r = address_comp[i].short_name;
                        if(address_n != '')
                        {
                            $('input:text[name="address_l1"]').val(address_r + ' ' + address_n);    
                        }
                    }                     
                }    
            }
         
         });
    
        //watcher btn webservice
        $('#btn_ws_latlng').click(function() {
            $('#btn_ws_latlng').removeAttr('href');
            //añade GIF LOADER
            $('select[name="ws_cities"]').after('<img src="' + SITE_URL+ 'addons/generic/images/loader.gif" style="float:left; margin:5px;" id="loader" alt="" /></div>');                        
            var form_data = {
                cityid : $('input[name="CityID"]').val(),  
                address: $('input:text[name="address_l1"]').val()                     
            };
            $.ajax({
                    type: "POST",
                    url: SITE_URL + 'admin/geoworldmap/webservice/addressgeocode',
                    data: form_data,
                    dataType: 'json',
                    success: function(result){
                        // quita el GIF
                        $('#loader').remove();                          
			if(result.status == 'OK') {
                            //copia datos en vec global
                            vec_wsaddress = result;
                            // valor vacio a proposito - para js-chosen
                            var options = '<option></option>';                            
                                for (var i = 0; i < vec_wsaddress.results.length; i++) 
                                {
                                        options += '<option value="' + i + '">' + vec_wsaddress.results[i].formatted_address + '</option>';
                                }
                            $('select[name="ws_address"]').html(options);
                            //trigger que dispara la actualizacion del dropdown CHOSEN
                            $('select[name="ws_address"]').trigger("liszt:updated");
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
        $('#btn_ws_timezone').click(function() {
            $('#btn_ws_timezone').removeAttr('href');
            //añade GIF LOADER
            $('select[name="timezoneid"]').after('<img src="' + SITE_URL+ 'addons/generic/images/loader.gif" style="float:left; margin:5px;" id="loader" alt="" /></div>');                        
            var form_data = {
                Latitude : $('input:text[name="Latitude"]').val(),                       
                Longitude : $('input:text[name="Longitude"]').val()                                                       
            };
            $.ajax({
                    type: "POST",
                    url: SITE_URL + 'admin/geoworldmap/webservice/timezone',
                    data: form_data,
                    dataType: 'json',
                    success: function(result){
                        // quita el GIF
                        $('#loader').remove();                          
			if(result.status == 'OK') {
                            // valor vacio a proposito - para js-chosen
                            var options = '<option></option>';
                            for (var i = 0; i < result.timezones.length; i++) 
                            {
                                    options += '<option value="' + result.timezones[i].timeZoneId + '" ';
                                    if ( result.obj.timezoneId == result.timezones[i].timeZoneId ) { options += 'selected="selected"';  }
                                    options += '>' + result.timezones[i].timeZoneId + ' ' + result.timezones[i].GMT_offset + ' </option>';
                            }
                            // reemplaza dropdown options por nuevo
                            $('select[name="timezoneid"]').html(options);
                            //trigger que dispara la actualizacion del dropdown CHOSEN
                            $('select[name="timezoneid"]').trigger("liszt:updated");
                            $('#btn_ws_timezone').attr('class', 'btn green');
                    } else  { 
                                $('#btn_ws_timezone').attr('class', 'btn red');                                
                            }        
                    },
                    error: function()
                    {
                       $('#loader').remove(); 
                       $('#btn_ws_timezone').attr('class', 'btn red');    
                    }
                    });
	});

});
