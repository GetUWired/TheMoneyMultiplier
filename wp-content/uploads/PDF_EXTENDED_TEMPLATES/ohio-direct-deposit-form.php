<?php

/*
 * Template Name: Ohio Direct Deposit Form
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
$address = function( $field ) {
	if ( isset( $field['country'] ) ) {
		unset( $field['country'] );
	}

	return implode( ', ', array_filter( $field ) );
};

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

$owner_name = implode( ' ', array_filter( $form_data['field'][2] ) );

/*
 * Begin PDF Generation
 *
 * For full documentation, refer to https://gravitypdf.com/documentation/v4/shop-plugin-developer-toolkit/
 */
$w->addPdf( __DIR__ . '/pdfs/Ohio-Direct-Deposit-Form.pdf' ); /* CHANGE THIS TO POINT TO YOUR PDF */
$w->addPage( 1 );

$w->add( $form_data['field'][28], [ 37.94, 44.1, 50.4, 4 ] ); /* Policy Number */

/* Type of Account Required */
switch ( $form_data['field'][10] ) {
	case 'Checking':
		$w->tick( [ 50.2, 64.4 ] ); /* Checking */
	break;

	case 'Savings':
		$w->tick( [ 112.5, 64.4 ] ); /* Savings */
	break;
}

$w->add( $owner_name, [ 12.7, 75.7, 94, 4 ] ); /* Name(s) as it appears on the account */
$w->add( $form_data['field'][11], [ 110, 75.7, 94, 4 ] ); /* Name of Financial Institution */
$w->add( $form_data['field'][26], [ 12.7, 84.5, 94, 4 ] ); /* ABA / Transit Routing Number */
$w->add( $address( $form_data['field'][31] ), [ 110, 84.5, 94, 4 ] ); /* Address of Financial Institution */
$w->add( $form_data['field'][27], [ 12.7, 93, 94, 4 ] ); /* Account Number */
$w->add( $form_data['field'][29], [ 110, 93, 94, 4 ] ); /* Telephone Number of Financial Institution */

$w->tick( [ 48, 100.6 ] ); /* Electronic Deposit */

/*
 * AUTHORIZATION
 */

/* I/we authorize Ohio National to directly deposit/wire the current disbursement request on a one-time basis. */
//$w->tick( [ 12.8, 127.4 ] );

/* I/we authorize Ohio National to use the elections on this form for all future disbursements from
 * the policies listed above.
 */
$w->tick( [ 12.8, 137.6 ] );

$w->addRight( $form_data['field'][18], [ 86, 205, 19.5, 4 ] ); /* Date */
$w->add( $form_data['field'][5], [ 127.7, 205, 65, 4 ] ); /* Daytime Phone Number of Policy Owner */
