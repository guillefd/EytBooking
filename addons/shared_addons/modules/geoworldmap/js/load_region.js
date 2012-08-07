//carga REGION en regiondrop
$(document).ready(function(){   
        //watcher
        $('select[name="CountryID"]').change(function() {   
            //añade GIF LOADER
            $('select[name="RegionID"]').before('<img src="' + SITE_URL+ 'addons/generic/images/loader.gif" style="float:left; margin:5px;" id="loader" alt="" /></div>');                        
            var form_data = {
                CountryID : $('select[name="CountryID"]').val()                       
                //var_name : 'value', var_name : 'value',
            };
            $.ajax({
                    type: "POST",
                    url: SITE_URL + 'admin/geoworldmap/load_regions_ajax',
                    data: form_data,
                    dataType: 'json',
                    success: function(regions){                            
                            // quita el GIF
                            $('#loader').remove();                        
                            // valor vacio a proposito - para js-chosen
                            var options = '<option></option>';                            
                            if(regions != false)
                            {    
                                for (var i = 0; i < regions.length; i++) 
                                {
                                        options += '<option value="' + regions[i].RegionID + '">' + regions[i].Region + '</option>';
                                }
                            }
                            $('select[name="RegionID"]').html(options);
                            //trigger que dispara la actualizacion del dropdown CHOSEN
                            $('select[name="RegionID"]').trigger("liszt:updated");                                
                    }
                    });
	});

});
