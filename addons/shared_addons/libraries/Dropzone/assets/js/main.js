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
 * 3- file is stored in TEMP folder, until ITEM is saved. Function updateFilesIdList() updates list in form field dzfileslistid
 * 4- When ITEM is saved, files ID are stored in ITEM images field.
 * 
 */

removeIcon = '<img class="dzIcon" src="' + BASE_URL + 'addons/shared_addons/libraries/Dropzone/assets/js/images/remove.png' + '" />';


$(document).ready(function() {
	

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
		init: function() {
			this.on("success", function(file, jsonResponse) { 
				jsonResponse = JSON.parse(jsonResponse);
				if(jsonResponse.status == true) // si server responde TRUE
				{
					updateFilesIdList(jsonResponse.data);
					thumbnail = generateThumbnail(jsonResponse.data);
					populatePreviewList(thumbnail);
				}
				else // si responde FALSE
					{
						errorMessage = genMessage('error', jsonResponse.message, file);
						alert(errorMessage);
					}
			});
			this.on("error", function(file,error) {
				alert(error);
			});		
			this.on("complete", function(file) {
				this.removeFile(file);
			});
		}
	}


	/**
	 * [genMessage Generate message text to output]
	 * @param  {[type]} type   [description]
	 * @param  {[type]} msgtxt [description]
	 * @param  {[type]} file   [description]
	 * @return {string}        [description]
	 */
	function genMessage(type,msgtxt,file)
	{
		switch (type)
		{
			case 'error':
						msgtxt = msgtxt.replace("<p>","");
						msgtxt = msgtxt.replace("</p>","");
						msg = 'Hubo un error al intentar subir el archivo <' + file.name + '>.\n';
						msg+= 'Error = "' + msgtxt + '".\n';
						msg+= '\nPor favor intentelo nuevamente o revise la imagen.'; 
						break;
		}
	}

	/**
	 * [updateFilesIdList add file_id to dzfileslistid form field]
	 * @param  {[type]} jsonData [description]
	 * @return {[type]}          [description]
	 */
	function updateFilesIdList(jsonData)
	{
		fileslist = $('input[name="dzfileslistid"]').val();
		fileslist+= jsonData.id + ';';
		$('input[name="dzfileslistid"]').val(fileslist);
	} 


	/**
	 * [populatePreviewList description]
	 * @param  {[type]} thumb [description]
	 * @return {[type]}       [description]
	 */
	function populatePreviewList(thumbnail)
	{
	    $('#dzLfiles').append(thumbnail)
	}


	/**
	 * [generateThumbnail Generate Thumbnail Markup with file data provided]
	 * @param  {[type]} file [description]
	 * @return {[type]}      [description]
	 */
	function generateThumbnail(filedata)
	{
		fname = filedata.filename.substr(0,14);
		thumb = '<div id="dzthumb' + filedata.id + '" class="dz-preview dz-file-preview dz-processing dz-success">'+
				 	'<div class="dz-details thumb">'+
				 		'<div class="dz-filename">'+
				 			'<span data-dz-name="">' + fname + '</span>'+
				 		'</div>'+
				 		'<div class="dz-size">'+
					 		'<a href="#">' + removeIcon + '</a>' + fname + '</div>' +
					 		'<img src="' + thumbImagePath(filedata.path) + '" />' +
				 		'</div>'+
				 		'<div class="dz-success-mark">' +
				 			'<span>x</span>' +
				 		'</div>'+
				 	'</div>'+
				 '</div>';
		return thumb;		 	

	}

	/**
	 * [convertKBtoMB convert KB number to MB and ROUND 2 decimals]
	 * @param  {[type]} kb [description]
	 * @return {[type]}    [description]
	 */
	function convertKBtoMB(kb)
	{
		mb = kb/1024;
		return mb.toFixed(1);
	}


	function thumbImagePath(path)
	{
		path = path.replace("{{ url:site }}", BASE_URL);
        path = path.replace("large", "thumb");
        return path;
	}


});