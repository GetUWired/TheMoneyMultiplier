<?php

/*
 * Template Name: Mass Mutual Loan Request Form
 * Version: 1.0
 * Description: A custom PDF template designed specifically for the "Loan Request" Gravity Form.
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

	</style>
<?php
$w->endStyles();

$w->configTick( [
	'font-size'   => 12,
	'line-height' => 9,
	'color' => 'red'
] );

$owner_name        = implode( ' ', array_filter( $form_data['field'][1] ) );
$insured_name      = implode( ' ', array_filter( $form_data['field'][20] ) );

/*
 * Begin PDF Generation
 *
 * For full documentation, refer to https://gravitypdf.com/documentation/v4/shop-plugin-developer-toolkit/
 */


// $w->addBlankPage([ 'sheet-size' => [ 200, 20 ] ]);
// $x = 0;
// $y = 0;

// // $w->add( 'policy num: ' . $form_data['field'][62], [ 34.5, 38.2, 41.4, 4 ] );

// foreach ($form_data['field'] as $key => $value) {
// 	# code...
// 	$w->add( 'key: ' . $key . ' = value: ' . $value, [ $x, $y, 91, 4 ]);

// 	$y = $y + 5;
// 	$w->addBlankPage([ 'sheet-size' => [ 200, 20 ] ]);

// 	foreach($value as $a => $b) {
// 		$w->add(' more keys: ' . $a . ' and values: ' . $b, [ $x, $y, 91, 4 ]);
// 		$b = $b + 5;
// 		$w->addBlankPage([ 'sheet-size' => [ 200, 20 ] ]);
// 	}
// }


$w->addPdf( __DIR__ . '/pdfs/MassMutualLoanRequest-1.pdf' ); /* CHANGE THIS TO POINT TO YOUR PDF */
$w->addPage( 1 );

$w->add( $form_data['field'][62], [ 48.5, 64.7, 41.4, 4 ] ); /* Mass Mutual Policy Number  */

$w->add( $insured_name, [ 86.5, 70.8, 91, 4 ] ); /* Insured's Name */
$w->add( $owner_name, [ 48.5, 86.7, 91, 4 ] );  /*Polcy Owner's Name */
$w->add( $form_data['field'][42], [ 86.5, 92.9, 91, 4 ] ); /* Policy Owner's SSN/EIN/TIN */
$w->add( $form_data['field'][9], [ 45.7, 98.9, 91, 4 ] ); /* Policy Owner's Phone */
$w->add( $form_data['field'][12], [ 45.7, 119.9, 91, 4 ] ); /* Policy Owner's Email */

$w->tick( [ 48.5, 186.2 ] ); /* Select "Owner" for Payee */

/* Policy Owner's Address */
$w->add( implode( ', ', array_filter( [ $form_data['field'][21]['street'], $form_data['field'][21]['street2'] ] ) ), [ 22.7, 197.8, 91, 4 ] ); /* Street Address */
$w->add( implode( ', ', array_filter( [ $form_data['field'][21]['city'], $form_data['field'][21]['state'], $form_data['field'][21]['zip'] ] ) ), [ 22.7, 203.8, 91, 4 ] ); /* City, State, Zip */


$w->addPage( 2 );

$w->add( $form_data['field'][62], [ 42.5, 11.7, 41.4, 4 ] ); /* Mass Mutual Policy Number  */
$w->tick( [ 19.5, 52.7 ] ); /* Loan Type equals "cash" */

if ( ! empty( $form_data['field'][5][0] ) ) {
	$w->tick( [ 69.2, 52.7 ] ); /* Maximum Amount */
} else {
	$w->tick( [ 90.7, 52.7 ] ); /* Gross */
	$w->add( str_replace( '$', '', $form_data['field'][19] ), [ 124.4, 52.7, 36, 4 ] ); /* Gross Amount */
}


$w->addPage( 3 );

$w->add( $form_data['field'][62], [ 42.5, 11.7, 41.4, 4 ] ); /* Mass Mutual Policy Number  */

$w->add( $owner_name, [ 46.5, 159.7, 91, 4 ] );  /*Polcy Owner's Name */
$w->add( $form_data['field'][10], [ 158.5, 159.7, 91, 4 ] );  /* Current Date under Insured Name */


$w->addPage( 4 );

$w->add( $form_data['field'][62], [ 42.5, 11.7, 41.4, 4 ] ); /* Mass Mutual Policy Number  */
$w->add( $insured_name, [ 46.5, 45.5, 91, 4 ] ); /* Insured's Name */
$w->add( $form_data['field'][10], [ 158.5, 45.5, 91, 4 ] );  /* Current Date */

$w->add( $form_data['field'][10], [ 25.5, 76.8, 91, 4 ] );  /* Current Date under Notary Stamp/Seal */
$w->add( $owner_name, [ 62.5, 76.8, 91, 4 ] );  /*Polcy Owner's Name */


$w->addPage( 5 );

$w->add( $form_data['field'][62], [ 42.5, 11.7, 41.4, 4 ] ); /* Mass Mutual Policy Number  */

$w->addPage( 6 );
$w->addPage( 7 );
$w->addPage( 8 );
$w->addPage( 9 );


