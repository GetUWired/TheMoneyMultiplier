<?php

/*
 * Template Name: Penn Mutual Loan Request
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
	'font-size'   => 14,
	'line-height' => 6.8,
] );

$owner_name        = implode( ' ', array_filter( $form_data['field'][1] ) );
$insured_name      = implode( ' ', array_filter( $form_data['field'][20] ) );

$phone = str_replace( [ '(', ')' ], '', $form_data['field'][9] );

/*
 * Begin PDF Generation
 *
 * For full documentation, refer to https://gravitypdf.com/documentation/v4/shop-plugin-developer-toolkit/
 */
$w->addPdf( __DIR__ . '/pdfs/Penn-Mutual-Loan.pdf' ); /* CHANGE THIS TO POINT TO YOUR PDF */
$w->addPage( 1 );

/*
 * INSURED INFORMATION
 */
$w->add( $insured_name, [ 15.6, 66.8, 185.8, 4 ] ); /* Name of Insured */

$w->addCenter( substr( $phone, 0, 3 ), [ 16.5, 77.7, 10, 4 ] ); /* Daytime Phone # (area code) */
$w->add( substr( $phone, 4 ), [ 28.5, 77.7, 78, 4 ] ); /* Daytime Phone # */
$w->add( $form_data['field'][40], [ 110, 77.7, 91, 4 ] ); /* Policy Number */
$w->add( $owner_name, [ 15.6, 87.4, 126.8, 4 ] ); /* Name of Owner */
$w->add( $form_data['field'][22], [ 146.6, 87.4, 54.6, 4 ] ); /* SSN */

/*
 * 1. POLICY LOAN - For Policies Without Indexed Accounts
 */
if ( ! empty( $form_data['field'][5] ) ) {
	$w->tick( [ 16, 106.8 ] ); /* I request the maximum policy loan available */
} else {
	$w->tick( [ 16, 101.8 ] ); /* I request a policy loan in the amount of... */
	$w->add( str_replace( '$', '', $form_data['field'][19] ), [ 80.5, 101.4, 36.7, 4 ] ); /* Loan amount */
}

/*
 * LOAD PAGE 2
 */
$w->addPage( 2 );

$date = explode( '/', $form_data['field'][10] );
$w->addRight( $date[0], [ 168, 171.2, 6.5, 4 ] ); /* Date - Month */
$w->addCenter( $date[1], [ 175.5, 171.2, 6.5, 4 ] ); /* Date - Day */
$w->add( $date[2], [ 184, 171.2, 15.2, 4 ] ); /* Date - Year */
