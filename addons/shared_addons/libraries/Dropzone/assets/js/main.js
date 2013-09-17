/**
 * @author Guillermo Dova
 * Dropzone configuration and image manipulation
 *
 * Dropzone plugin - credit to www.dropzonejs.com
 * - generates auto drop zone for images. Sends images to server and generates preview.
 * - Server file storage run with pyrocms FILE module.
 *
 * Storage Secuence
 * 1- image is droped or selected in dropzone
 * 2- dropzone plugin sends image to server
 * 3- file is stored in TEMP folder, until ITEM is saved. Function dzAddFileIdList() updates list in form field dzfileslistid
 * 4- When ITEM is saved, files ID are stored in ITEM images field.
 *
 */

var dzLoader = '<img src="' + IMG_PATH + 'indicator.gif" style="float:right; margin:5px;" id="dzloader" alt="" /></div>';


/**
 * [genMessage Generate message text to output]
 * @param  {[type]} type   [description]
 * @param  {[type]} msgtxt [description]
 * @param  {[type]} file   [description]
 * @return {string}        [description]
 */

function genMessage(type, msgtxt, file) {
	switch (type) {
		case 'error':
			msgtxt = msgtxt.replace("<p>", "");
			msgtxt = msgtxt.replace("</p>", "");
			msg = 'Hubo un error al intentar subir el archivo <' + file.name + '>.\n';
			msg += 'Error = "' + msgtxt + '".\n';
			msg += '\nPor favor intentelo nuevamente o revise la imagen.';
			break;
	}
}

/**
 * [dzAddFileIdList add file_id to dzfileslistid form field]
 * @param  {[type]} jsonData [description]
 * @return {[type]}          [description]
 */

function dzAddFileIdList(jsonData) {
	fileslist = $('input[name="dzfileslistid"]').val();
	fileslist += jsonData.id + ';';
	$('input[name="dzfileslistid"]').val(fileslist);
}

function dzRemoveFileIdList(index) {
	fileslist = $('input[name="dzfileslistid"]').val();
    fileslist = fileslist.replace(index + ";", "");
    //update hidden field
	$('input[name="dzfileslistid"]').val(fileslist);
}

function dzInsertRowToBlock(row) {
	$('#f_dzitemBox').append(row)
}	


function dzGenerateRowImage(filedata)
{
    fsize = convertKBtoMB(filedata.filesize);
    return htmlblock = '<tr name="fItem'+ filedata.id +'" id="f_itemBlock" class="trBlock">' +
        			'<td>' + '<img src="' + thumbImagePath(filedata.path) + '" />' + '</td>' +
        			'<td>' + filedata.filename + '</td>' +
        			'<td>' + fsize.num + ' ' + fsize.magn + '</td>' +
        			'<td>' + filedata.width + ' x ' + filedata.height + ' px ' +  '</td>' + 
        			'<td><span><a name="btn_del" id="'+ filedata.id +'" class="btn red" href="'+ filedata.id +'">' + LABEL_DELETE + '</a></span></td>' +
        			'</tr>';    			  
}	

/**
 * [convertKBtoMB convert KB number to MB and ROUND 2 decimals]
 * @param  {[type]} kb [description]
 * @return {[type]}    [description]
 */

function convertKBtoMB(size)
{ 
    var fs = new fsizedata();
    size = Number(size);
	if(size < 1024)
	{
		fs.num = size.toFixed(1);
		fs.magn = 'KB';
	}
	else
	{
		num = size / 1024;
		fs.num = num.toFixed(1);
		fs.magn = 'MB'; 
	}
	return fs;
}

function fsizedata()
{
	this.num = 0;
	this.magn = '';
}


function thumbImagePath(path) {
	path = path.replace("{{ url:site }}", BASE_URL);
	path = path.replace("large", "thumb");
	return path;
}


function dzDeleteFitem(index)
{
    var name = "fItem" + index;
    $('tr[name=' + name + ']').slideUp(1000,function(){ 
        $('tr[name=' + name + ']').remove();
    });
    dzRemoveFileIdList(index);
}


/**
 *  Inicializa valores del input en html
 */
function init_images_list()
{
        var input = $('input[name="dzfileslistid"]').val();
        // trims -> split string into an array -> deletes empty element
        imgList = input.trim().split(";").filter(Number);
        for (id in imgList)
        {
        	filedata = request_file(imgList[id]);
        	// because of asynchronous result, ajax
        	filedata.success(function (result) {
	        	if(result.status == true)
	        	{
	        		row = dzGenerateRowImage(result.data);
	        		dzInsertRowToBlock(row);
	        	}        		
        	});
        }

}

function request_file(index)
{
    //img loader
    $('#f_dzitemBox').after(dzLoader);                        
    filedata = false;
    return $.ajax({
            type: "POST",
            url: SITE_URL + 'admin/products/getfile_ajax/' + index,
            //data: form_data,
            dataType: 'json',
            success: function(result){
	            if(result.status == true) 
	            {
	                $('#dzloader').remove(); 	            	
	            }              
        	},
	        error: function()
	        {
	            $('#dzloader').remove();   
	        }            
    });   
}

// END FUNCTIONS :::::::::::::::::::


$(document).ready(function() {

	//gets image already uploaded or saved
	init_images_list();

	/**
	 * [imgdropzone Dropzone configuration]
	 * @type {Object}
	 */
	Dropzone.options.imgdropzone = {
		dictFileTooBig: "La imagen es muy grande, tamaño máximo 5MB", //mensaje error archivo grande
		dictInvalidFileType: "Solo puede subir imágenes!", // mensaje error tipo de archivo
		paramName: "userfile", // nombre del campo que contiene el archivo
		acceptedMimeTypes: "image/*", //tipo de archivo permitido
		maxFilesize: 5, // tamaño maximo de archivo en MB
		init: function() 
		{
			this.on("success", function(file, jsonResponse) 
			{
				jsonResponse = JSON.parse(jsonResponse);
				if (jsonResponse.status == true) // si server responde TRUE
				{
					dzAddFileIdList(jsonResponse.data);
					imageRow = dzGenerateRowImage(jsonResponse.data);
					dzInsertRowToBlock(imageRow);

				} else // si responde FALSE
				{
					errorMessage = genMessage('error', jsonResponse.message, file);
					alert(errorMessage);
				}
			});
			this.on("error", function(file, error) {
				alert(error);
			});
			this.on("complete", function(file) {
				this.removeFile(file);
			});
		}
	}



    //watcher btn DELETE - from images list
    $(document).on('click', 'a[name="btn_del"]', function(){ //do stuff here })
        $(this).removeAttr('href');
        var id = $(this).attr("id");
        dzDeleteFitem(id);
    }); 

    // main Form submit button event. 
    // captures submit button event, of main form. (button outside form tags)
    // As dropzone prints a FORM, submit button of main form (page) is printed after dropzone, that is, outside main Form.
    $("#dzmainsubmit").click(function(){
    	$("#dzmainform").submit();
	});	


});