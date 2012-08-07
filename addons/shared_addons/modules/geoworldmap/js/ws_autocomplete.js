
// global VAR
var vec_wscities;

//carga REGION en regiondrop
$(document).ready(function(){
    
         //watcher dropdown cities webservice
         $('select[name="ws_cities"]').change(function() { 
            var id = $('select[name="ws_cities"]').val();
            //captura latitud y longitud -> pega en input correspondiente
            $('input:text[name="Latitude"]').val(vec_wscities.results[id].geometry.location.lat);
            $('input:text[name="Longitude"]').val(vec_wscities.results[id].geometry.location.lng);            
         
         });
    
        //watcher btn webservice
        $('#btn_ws_latlng').click(function() {
            $('#btn_ws_latlng').removeAttr('href');
            //añade GIF LOADER
            $('select[name="ws_cities"]').after('<img src="' + SITE_URL+ 'addons/shared_addons/modules/geoworldmap/img/loader.gif" style="float:left; margin:5px;" id="loader" alt="" /></div>');                        
            var form_data = {
                City : $('input:text[name="City"]').val(),                       
                RegionID : $('select[name="RegionID"]').val(),  
                CountryID : $('select[name="CountryID"]').val()                  
            };
            $.ajax({
                    type: "POST",
                    url: SITE_URL + 'admin/geoworldmap/webservice/citygeocode',
                    data: form_data,
                    dataType: 'json',
                    success: function(result){
                        // quita el GIF
                        $('#loader').remove();                          
			if(result.status == 'OK') {
                            //copia datos en vec global
                            vec_wscities = result;
                            // valor vacio a proposito - para js-chosen
                            var options = '<option></option>';                            
                                for (var i = 0; i < vec_wscities.results.length; i++) 
                                {
                                        options += '<option value="' + i + '">' + vec_wscities.results[i].formatted_address + '</option>';
                                }
                            $('select[name="ws_cities"]').html(options);
                            //trigger que dispara la actualizacion del dropdown CHOSEN
                            $('select[name="ws_cities"]').trigger("liszt:updated");
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
            $('select[name="timezoneid"]').after('<img src="' + SITE_URL+ 'addons/shared_addons/modules/geoworldmap/img/loader.gif" style="float:left; margin:5px;" id="loader" alt="" /></div>');                        
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
