<?php

/*
 * Template Name: Ameritas Life Insurance Corp. Loan Request with EFT
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
	'font-size'   => 16,
	'line-height' => 9.5,
] );

$owner_name   = implode( ' ', array_filter( $form_data['field'][1] ) );
$insured_name = implode( ' ', array_filter( $form_data['field'][20] ) );
$account_name = ( ! empty( $form_data['field'][33] ) ) ? $insured_name : implode( ' ', array_filter( $form_data['field'][32] ) );

$account_address = implode( ', ', array_filter( [
	implode( ', ', array_filter( [ $form_data['field'][21]['street'], $form_data['field'][21]['street2'] ] ) ),
	implode( ', ', array_filter( [ $form_data['field'][21]['city'], trim( $form_data['field'][21]['state'] . ' ' . $form_data['field'][21]['zip'] ) ] ) ),
] ) );

/*
 * Begin PDF Generation
 *
 * For full documentation, refer to https://gravitypdf.com/documentation/v4/shop-plugin-developer-toolkit/
 */
$w->addPdf( __DIR__ . '/pdfs/Ameritas-Loan-Request-with-EFT.pdf' ); /* CHANGE THIS TO POINT TO YOUR PDF */
$w->addPage( 1 );

$w->add( $form_data['field'][23], [ 34, 25, 171.5, 4 ] ); /* Ameritas Policy Number */
$w->add( $insured_name, [ 35.5, 31.6, 170, 4 ] ); /* Insured Name */

if ( ! empty( $form_data['field'][5] ) ) {
	$w->tick( [ 14.5, 84.8 ] ); /* Maximum Amount */
} else {
	$w->tick( [ 14.5, 90.2 ] ); /* Gross */
	$w->add( str_replace( '$', '', $form_data['field'][19] ), [ 22.8, 90, 31.5, 4 ] ); /* Gross Amount */
}

/*
 * LOAD PAGE 2
 */
$w->addPage( 2 );

$date = explode( '/', $form_data['field'][10] );
$w->addCenter( $date[0], [ 29.5, 124.5, 9, 4 ] ); /* Date - Month */
$w->addCenter( $date[1], [ 59.3, 124.5, 6, 4 ] ); /* Date - Day */
$w->add( $date[2], [ 85.8, 124.5, 8, 4 ] ); /* Date - Year */

$w->add( $insured_name, [ 10, 154.2, 92.8, 4 ] ); /* Insured Name */

/*
 * LOAD PAGE 3
 */
$w->addPage( 3 );

$w->add( $form_data['field'][27], [ 47.2, 171.7, 86, 4 ] ); /* Bank Name & Branch */
$w->add( $form_data['field'][34], [ 158.4, 171.7, 47.4, 4 ] ); /* Bank Phone # */
$w->add( $form_data['field'][28], [ 47.2, 178.2, 86, 4 ] ); /* Bank ABA (Routing) # */
$w->add( $form_data['field'][29], [ 160, 178.2, 45.6, 4 ] ); /* Bank Account # */
$w->add( $account_name, [ 47.2, 188, 86, 4 ] ); /* Account Owner & Name */

/* Account Type */
switch ( $form_data['field'][26] ) {
	case 'Checking':
		$w->tick( [ 159.2, 187.7 ], [ 'line-height' > 8.5 ] ); /* Checking */
	break;

	case 'Savings':
		$w->tick( [ 179.6, 187.7 ], [ 'line-height' > 8.5 ] ); /* Savings */
	break;
}

$w->add( $account_address, [ 52, 194.2, 153.6, 4 ] ); /* Account Owner Address */

$w->add( $form_data['field'][9], [ 54, 210, 52, 4 ] ); /* Policy Owner's Phone # */
$w->add( $form_data['field'][10], [ 152.6, 218, 52.8, 4 ] ); /* Date */
