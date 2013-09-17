<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Accounts Class
 *
 * UI for multiple files upload
 * Server side managed with pyrofiles
 *
 * @package			CodeIgniter
 * @subpackage      Libraries
 * @category        Libraries
 * @author			Guillermo Dova
 * @license			
 * @link			
 */

class Dropzone
{
	public $dzpath;

	function __construct()
	{
		$this->dzpath = "addons/shared_addons/libraries/Dropzone/";
	}

	public function loadAssetPath()
	{
		//Assets Path
	    Asset::add_path('dropzoneJS', $this->dzpath.'assets/');
	    Asset::add_path('dropzoneCSS', $this->dzpath.'assets/js/');
	}
    
    /**
     * dzFormMarkup returns FORM markup - 
     * elements = FORM: contains fields, dropzone / table: contains added or existing images. 
     * @param  string $action      [action URL]
     * @param  string $dropzoneid  [Element ID for ]
     * @param  string $fileslistid [description]
     * @return [type]              [description]
     */
	public function dzFormMarkup($action = '', $dropzoneid ='imgdropzone', $fileslistid = 'dzfileslistid' )
	{
		$form = form_open($action, 'class="dropzone" id="'.$dropzoneid.'"'); 
		$form.= form_close();
		$form.= '<div id="dzLfiles" class="dropzone-previews"></div>'
				.'<table class="dztableBox">'
					.'<tr><th>Imagen</th><th>Archivo</th><th>Tamaño</th><th>Medida</th><th width="75px">Eliminar</th></tr>'
					.'<tbody id="f_dzitemBox"></tbody>'
				.'</table>'; 		
		return $form;	
	}


    /**
     * [check_temp_folder description]
     * @return [type] [description]
     */
	public function check_temp_folder()
	{
		$tempfoldername = 'dzTemp';
		$tree = Files::folder_tree();
		$notfound = true;
		$i = 0;
		while($notfound && $i <= count($tree) )
		{
			if( $tree[$i-1]['name'] == $tempfoldername )
			{
				$notfound = false;
				$tempfolderid = $tree[$i-1]['id'];
			}	
			$i++;
		}
		if($notfound)
		{
			$result = Files::create_folder(0, $tempfoldername );
			$tempfolderid = $result['data']['id'];	
		}
		return $tempfolderid;
	}	


}