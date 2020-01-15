<?php

/*
 * Template Name: Ohio National Financial Services Loan Request Form
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
] );

$owner_name        = implode( ' ', array_filter( $form_data['field'][1] ) );
$insured_name      = implode( ' ', array_filter( $form_data['field'][20] ) );
$owner_spouse_name = implode( ' ', array_filter( $form_data['field'][18] ) );

/*
 * Begin PDF Generation
 *
 * For full documentation, refer to https://gravitypdf.com/documentation/v4/shop-plugin-developer-toolkit/
 */
$w->addPdf( __DIR__ . '/pdfs/Ohio-Loan-Request-Form.pdf' ); /* CHANGE THIS TO POINT TO YOUR PDF */
$w->addPage( 1 );

$w->tick( [ 12.5, 19.6 ] ); /* Ohio National Life Insurance */

$w->add( $form_data['field'][38], [ 13.5, 53.8, 91, 4 ] ); /* Policy Number */

/* Policy Owner's Address */
$w->add( implode( ' / ', array_filter( [ $form_data['field'][21]['street'], $form_data['field'][21]['street2'] ] ) ), [ 110.7, 53.8, 91, 4 ] ); /* Street Address */
$w->add( implode( ', ', array_filter( [ $form_data['field'][21]['city'], $form_data['field'][21]['state'], $form_data['field'][21]['zip'] ] ) ), [ 110.7, 62.4, 91, 4 ] ); /* City, State, Zip */
$w->add( $form_data['field'][21]['country'], [ 110.7, 71.6, 91, 4 ] ); /* Country */

$w->add( $insured_name, [ 13.5, 65, 91, 4 ] ); /* Insured's Name */
$w->add( $owner_name, [ 13.5, 77.5, 91, 4 ] ); /* Polcy Owner's Name */
$w->add( $form_data['field'][42], [ 13.5, 91.2, 91, 4 ] ); /* Policy Owner's SSN/EIN/TIN */

$w->tick( [ 18.1, 136.2 ] ); /* Policy Loan Request */

if ( ! empty( $form_data['field'][5] ) ) {
	$w->tick( [ 23.7, 149.5 ] ); /* Maximum Amount */
} else {
	$w->tick( [ 23.7, 158 ] ); /* Gross */
	$w->add( str_replace( '$', '', $form_data['field'][19] ), [ 66.4, 157.5, 36, 4 ] ); /* Gross Amount */
}

/* Special Instructions */
$w->add( 'Please make this an electronic EFT deposit into the account attached.', [ 41.2, 218.8, 161.5, 4 ] );

/*
 * LOAD PAGE 2
 */
$w->addPage( 2 );

/*
 * CERTIFICATION
 */

$w->add( $form_data['field'][41]['city'], [ 27.5, 78.6, 88, 4 ] ); /* Dated at City */
$w->add( $form_data['field'][41]['state'], [ 118.5, 78.6, 24.1, 4 ] ); /* Dated at State */
$w->add( $form_data['field'][10], [ 149.6, 78.6, 41.4, 4 ] ); /* on */

$w->add( $owner_name, [ 14, 109.4, 83.2, 4 ] ); /* Policy Owner's Printed Name */
