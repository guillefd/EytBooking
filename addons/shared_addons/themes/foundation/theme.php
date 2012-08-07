<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Theme_Foundation extends Theme {

    public $name		= 'Foundation Theme';
    public $author		= 'EyT Media';
    public $author_website	= 'http://eytmedia.com/';
    public $website		= 'http://eytmedia.com/';
    public $description		= 'Tema basado en Framework Foundation 2.1.4 - Cross-device - fluid width';
    public $version		= '1.0';
    public $options 		= array('show_breadcrumbs' => 	array('title'=> 'Show Breadcrumbs',
                                                                                'description'   => 'Would you like to display breadcrumbs?',
                                                                                'default'       => 'yes',
                                                                                'type'          => 'radio',
                                                                                'options'       => 'yes=Yes|no=No',
                                                                                'is_required'   => TRUE),
                                        );

	public function __construct()
	{
		$supported_lang	= Settings::get('supported_languages');

		$cufon_enabled	= $supported_lang[CURRENT_LANGUAGE]['direction'] !== 'rtl';
		$cufon_font = 'qk.font.js';

		// Translators, only if the default font is incompatible with the chars of your
		// language generate a new font (link: <http://cufon.shoqolate.com/generate/>) and add
		// your case in switch bellow. Important: use a licensed font and harmonic with design

		switch (CURRENT_LANGUAGE)
		{
			case 'zh':
				$cufon_enabled	= FALSE;
				break;
			case 'ar':
				$cufon_enabled = FALSE;
				break;
			case 'he':
				$cufon_enabled	= TRUE;
			case 'ru':
				$cufon_font = 'times.font.js';
				break;
		}

		Settings::set('theme_default', compact('cufon_enabled', 'cufon_font'));
	}
}

/* End of file theme.php */
