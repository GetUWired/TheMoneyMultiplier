<?php

/*
 * Template Name: AUL Direct Deposit Form
 * Version: 1.0
 * Description: A custom PDF template designed specifically for the "Direct Deposit" Gravity Form.
 * Author: Gravity PDF
 * Author URI: https://gravitypdf.com
 * Group: The Money Multiplier
 * Required PDF Version: 4.4.0
 * Toolkit: true
 */

/* Prevent direct access to the template */
if ( ! class_exists( 'GFForms' ) ) {
	return;
}

/**
 * Gravity PDF Toolkit templates have access to the following variables
 *
 * @var array  $form      The current Gravity Form array
 * @var array  $entry     The raw entry data
 * @var array  $form_data The processed entry data stored in an array
 * @var array  $settings  The current PDF configuration
 * @var array  $fields    An array of Gravity Form fields which can be accessed with their ID number
 * @var array  $config    The initialised template config class – eg. /config/zadani.php
 * @var object $gfpdf     The main Gravity PDF object containing all our helper classes
 * @var array  $args      Contains an array of all variables - the ones being described right now - passed to the template
 */

/**
 * @var GFPDF\Plugins\DeveloperToolkit\Writer\Writer $w    A helper class that does the heavy lifting and PDF manipulation
 * @var \mPDF|\Mpdf\Mpdf                             $mpdf The raw Mpdf object
 */

/* Load PDF Styles */
$w->beginStyles();
?>
	<style>
		#spacer {
			font-family: DejaVuSansMono, monospaced;
			letter-spacing: 5.5mm;
			font-size: 10pt;
		}

		#signature {
			font-family: "Dancing Script", dancingscript, cursive;
			font-size: 200%;
		}
	</style>
<?php
$w->endStyles();

$w->configTick( [
	'font-size'   => 20,
	'line-height' => 8.5,
] );

$name = implode( ' ', array_filter( $form_data['field'][2] ) );

/*
 * Begin PDF Generation
 *
 * For full documentation, refer to https://gravitypdf.com/documentation/v4/shop-plugin-developer-toolkit/
 */
$w->addPdf( __DIR__ . '/pdfs/Direct-Deposit-Form-AUL_One-America-R1.pdf' ); /* CHANGE THIS TO POINT TO YOUR PDF */
$w->addPage( 1 );

$w->tick( [ 47.8, 38 ] ); /* American United Life Insurance Company (AUL) */

/*
 * A. Annuitant/Payee Information
 */
$w->add( $name, [ 27.2, 63.4, 76.5, 5 ] ); /* Name */
$w->add( $form_data['field'][4], [ 129.8, 63.4, 48, 5 ] ); /* SSN */
$w->add( $form_data['field'][25], [ 40.6, 69.8, 62.7, 5 ] ); /* Policy Number */
$w->add( $form_data['field'][5], [ 161.4, 69.8, 39.6, 5 ] ); /* Daytime Phone Number */

$mailing_address = implode( ', ', array_filter( [ $form_data['field'][6]['street'], $form_data['field'][6]['street2'] ] ) );
$c_s_z           = implode( ', ', array_filter( [ $form_data['field'][6]['city'], $form_data['field'][6]['state'], $form_data['field'][6]['zip'], $form_data['field'][6]['country'] ] ) );
$w->add( $mailing_address, [ 43.8, 76.2, 59.5, 5 ] ); /* Mailing Address */
$w->add( $c_s_z, [ 41.3, 82.4, 62, 5 ] ); /* City, State, Zip */
//$w->add( 'My content', [ 161, 76.2, 40.2, 5 ] ); /* Evening Phone Number */
//$w->add( 'My content', [ 154.2, 82.4, 43.2, 5 ] ); /* Cell Phone Number */

/*
 *  Financial Institution Information
 */

/* Account Type */
switch ( $form_data['field'][10] ) {
	case 'Checking':
		$w->tick( [ 21.2, 127 ] ); /* Checking Account */
	break;

	case 'Savings':
		$w->tick( [ 21.2, 133.8 ] ); /* Savings Account */
	break;
}

$w->add( $form_data['field'][11], [ 41.7, 145.2, 74.2, 5 ] ); /* Bank Name */
$w->add( sprintf( '<div id="spacer">%s</div>', $form_data['field'][26] ), [ 71.2, 152.2, 70, 5 ] ); /* Bank Routing (ABA) Number */
$w->add( $form_data['field'][27], [ 61, 159.4, 74.5, 5 ] ); /* Bank Account Number */

/*
 *  C. Annuitant/Payee Certification
 */
//$w->add( sprintf( '<div id="signature">%s</div>', $name ), [ 42.5, 245.4, 109.6, 5 ] ); /* Signature */
$w->add( $form_data['field'][18], [ 167.4, 246.8, 33.4, 5 ] ); /* Date */
