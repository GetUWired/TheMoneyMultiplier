<?php

/*
 * Template Name: AUL Loan Request Form
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
		.signature {
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

$owner_name        = implode( ' ', array_filter( $form_data['field'][1] ) );
$insured_name      = implode( ' ', array_filter( $form_data['field'][20] ) );
$owner_spouse_name = implode( ' ', array_filter( $form_data['field'][18] ) );

/*
 * Begin PDF Generation
 *
 * For full documentation, refer to https://gravitypdf.com/documentation/v4/shop-plugin-developer-toolkit/
 */
$pdf = ( strpos( $form_data['field'][11], 'I am married' ) !== false ) ? 'Loan-Request-AUL_One-America-R1b.pdf' : 'Loan-Request-AUL_One-America-R1.pdf';
$w->addPdf( __DIR__ . '/pdfs/' . $pdf ); /* CHANGE THIS TO POINT TO YOUR PDF */
$w->addPage( 1 );

$w->tick( [ 48.4, 37.6 ] ); /* American United Life Insurance Company (AUL) */

$w->add( $form_data['field'][3], [ 43.6, 60.6, 159, 5 ] ); /* Policy Number(s) */
$w->add( $insured_name, [ 27.6, 66.2, 78, 5 ] ); /* Insured */
$w->add( $owner_name, [ 121.6, 66.2, 81, 5 ] ); /* Owner */

if ( ! empty( $form_data['field'][4] ) ) {
	$w->tick( [ 14.5, 132.4 ] ); /* Request for Policy Loan */
}

$w->tick( [ 12.5, 142.4 ] ); /* Send check */

if ( ! empty( $form_data['field'][5] ) ) {
	$w->tick( [ 108, 142.4 ] ); /* Maximum Loan Value */
} else {
	$w->add( str_replace( '$', '', $form_data['field'][19] ), [ 44.45, 142.5, 60, 5 ] ); /* Amount */
}

/*
 * SIGNATURES
 */
//$w->add( sprintf( '<div class="signature">%s</div>', $owner_name ), [ 13.2, 194.4, 92.6, 5 ] ); /* Signature */
//$w->add( '<div class="signature">' . 'My Content' . '</div>', [ 110.5, 194.4, 92.6, 5 ] ); /* Witness Signature */
$w->add( $form_data['field'][9], [ 13.2, 214, 44, 5 ] ); /* Owner Telephone Number */
$w->add( $form_data['field'][10], [ 110.5, 214, 91.7, 5 ] ); /* Date */

/* Marital Status */
if ( strpos( $form_data['field'][11], 'I am married' ) !== false ) {
	$w->tick( [ 38.6, 230.8 ] ); /* Married */
	//$w->add( sprintf( '<div class="signature">%s</div>', $owner_spouse_name ), [ 13, 239.45, 90.5, 5 ] ); /* Signature */
}

if ( strpos( $form_data['field'][11], 'I am not married' ) !== false ) {
	$w->tick( [ 120.5, 230.8 ] ); /* Not married */
}
