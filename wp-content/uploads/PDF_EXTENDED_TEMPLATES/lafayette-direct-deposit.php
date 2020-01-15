<?php

/*
 * Template Name: Lafayette Insurance Direct Deposit Form
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
 * @param array $field
 *
 * @return string
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
	'line-height' => 8.5,
] );


/*
 * Begin PDF Generation
 *
 * For full documentation, refer to https://gravitypdf.com/documentation/v4/shop-plugin-developer-toolkit/
 */


$w->addPdf( __DIR__ . '/pdfs/LafayetteDirectDeposit-1.pdf' ); /* CHANGE THIS TO POINT TO YOUR PDF */
$w->addPage( 1 );

$w->add( $form_data['field'][37], [ 142.5, 118.2, 41.4, 4 ] ); /* Lafayette Policy Number  */

$w->add( $form_data['field'][11], [ 29.5, 156, 91, 4 ] ); /* Bank Name */


/* Financial Institution's Address */
$w->add( implode( ' / ', array_filter( [ $form_data['field'][31]['street'], $form_data['field'][31]['street2'] ] ) ), [ 29.5, 174.5, 91, 4 ] ); /* Street Address */
$w->add( implode( ', ', array_filter( [ $form_data['field'][31]['city'], $form_data['field'][31]['state'], $form_data['field'][31]['zip'] ] ) ), [ 29.5, 215.8, 91, 4 ] ); /* City, State, Zip */


if( $form_data['field'][10] == 'Checking') {
	$w->tick( [25.2, 233.5 ] );
} else {
	$w->tick( [25.2, 238.2 ] );
}

$w->add( $form_data['field'][27], [ 112.5, 156, 91, 4 ] ); /* Bank Account Number */
$w->add( $form_data['field'][18], [ 112.5, 174.5, 91, 4 ] ); /* Date Signed */
$w->add( $form_data['field'][5], [ 112.5, 234.2, 91, 4 ] ); /* Policy Owner Phone Number */





