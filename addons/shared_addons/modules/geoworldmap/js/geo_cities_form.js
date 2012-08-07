
jQuery(document).ready(function () {
            
		$('#btn_new_country').colorbox({
			scrolling: false,
                        innerWidth: 800,
                        innerHeight: 400,
			href: SITE_URL + 'admin/geoworldmap/countries/create_ajax',
			onComplete: function() {
                                $('#msg').hide();
				$('form#newcountry').removeAttr('action');
                                $('#cboxLoadedContent').delegate('form#newcountry','submit', function(e) {
					
					var form_data = $(this).serialize();
					
					$.ajax({
						url: SITE_URL + 'admin/geoworldmap/countries/create_ajax',
						type: "POST",
                                                data: form_data,
						success: function(obj) {
							
							if(obj.status == 'ok') {							
								//succesfull db insert do this stuff
								var select = 'select[name=CountryID]';
								var opt_val = obj.CountryID;
								var opt_text = obj.Country;
								var option = '<option value="'+opt_val+'" selected="selected">'+opt_text+'</option>';
								
                                                                $(select).html(option);
                                                                //trigger que dispara la actualizacion del dropdown CHOSEN
                                                                $(select).trigger("liszt:updated");   
								
								//close the colorbox
								$.colorbox.close();
							} else {
								//append the message to the dom
								$('#cboxLoadedContent').html(obj.form);
                                                                $('#msg').html(obj.message);
                                                                $('#msg').show();
							}
						}											
					});
					e.preventDefault();
				});
				
			}
		});
                
//	});
//})(jQuery);
});



(function($) {
	$(function(){	
        $('#btn_new_region').colorbox({
                scrolling: false,
                innerWidth: 800,
                innerHeight: 450,
                href: SITE_URL + 'admin/geoworldmap/regions/create_ajax',
                onComplete: function() {
                        $('#msg').hide();                    
                        $('form#newregion').removeAttr('action');
                        $('#cboxLoadedContent').delegate('form#newregion','submit', function(e) {

                                var form_data = $(this).serialize();

                                $.ajax({
                                        url: SITE_URL + 'admin/geoworldmap/regions/create_ajax',
                                        type: "POST",
                                        data: form_data,
                                        success: function(obj) {

                                                if(obj.status == 'ok') {

                                                        //actualiza datos en combo Region
                                                        var select = 'select[name=RegionID]';
                                                        var opt_val = obj.RegionID;
                                                        var opt_text = obj.Region;
                                                        var options = '<option value="'+opt_val+'" selected="selected">'+opt_text+'</option>';								
                                                        $(select).html(options);
                                                        //trigger que dispara la actualizacion del dropdown CHOSEN
                                                        $(select).trigger("liszt:updated");                                                                                                                                
                                                        //close the colorbox
                                                        $.colorbox.close();
                                                } else {
                                                        //append the message to the dom
                                                        $('#cboxLoadedContent').html(obj.form);
                                                        $('#msg').html(obj.message);
                                                        $('#msg').show();
                                                }
                                        }												
                                });                            
                                e.preventDefault();
                        });

                }
        });
	});
})(jQuery);