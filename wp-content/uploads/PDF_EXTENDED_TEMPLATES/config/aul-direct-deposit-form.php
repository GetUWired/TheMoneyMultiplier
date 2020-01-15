<?php

namespace GFPDF\Templates\Config;

use GFPDF\Helper\Helper_Interface_Setup_TearDown;

use GPDFAPI;

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Aul_Direct_Deposit_Form
 *
 * @package  GFPDF\Templates\Config
 *
 * @Internal See https://gravitypdf.com/documentation/v4/developer-template-configuration-and-image/ for more information about this class
 */
class Aul_Direct_Deposit_Form implements Helper_Interface_Setup_TearDown {

	/**
	 * Runs when the template is initially installed via the PDF Template Manager
	 *
	 * @Internal Great for installing custom fonts you've shipped with your template.
	 * @Internal Recommend creating the directory structure /install/Aul_Direct_Deposit_Form/ for bundled fonts
	 *
	 * @since    1.0
	 */
	public function setUp() {
		$font_data = [
			'font_name'   => 'Univers',
			'regular'     => __DIR__ . '/../install/Aul_Direct_Deposit_Form/univers/UniversLTStd.ttf',
			'italics'     => __DIR__ . '/../install/Aul_Direct_Deposit_Form/univers/Univers-Italic.ttf',
			'bold'        => __DIR__ . '/../install/Aul_Direct_Deposit_Form/univers/UniversLTStd-Bold.ttf',
			'bolditalics' => __DIR__ . '/../install/Aul_Direct_Deposit_Form/univers/Univers-Bold-Italic.ttf',
		];

		GPDFAPI::add_pdf_font( $font_data );

		$font_data = [
			'font_name'   => 'Dancing Script',
			'regular'     => __DIR__ . '/../install/Aul_Direct_Deposit_Form/dancing-script/DancingScript-Regular.ttf',
			'bold'        => __DIR__ . '/../install/Aul_Direct_Deposit_Form/dancing-script/DancingScript-Bold.ttf',
		];

		GPDFAPI::add_pdf_font( $font_data );
	}

	/**
	 * Runs when the template is deleted via the PDF Template Manager
	 *
	 * @Internal Great for cleaning up any additional directories
	 *
	 * @since    1.0
	 */
	public function tearDown() {
		$misc = GPDFAPI::get_misc_class();
		$misc->rmdir( __DIR__ . '/../install/Aul_Direct_Deposit_Form/' );
	}
}
