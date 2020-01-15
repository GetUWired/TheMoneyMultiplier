<?php

/*
 * Template Name:  Mass Mutual Direct Deposit Form
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

$owner_name      = implode( ' ', array_filter( $form_data['field'][2] ) ); /* Owner Name */
$insured_name        = implode( ' ', array_filter( $form_data['field'][38] ) ); /* Insured Name */


/*
 * Begin PDF Generation
 *
 * For full documentation, refer to https://gravitypdf.com/documentation/v4/shop-plugin-developer-toolkit/
 */


$w->addPdf( __DIR__ . '/pdfs/MassMutualDirectDeposit-1.pdf' ); /* CHANGE THIS TO POINT TO YOUR PDF */
$w->addPage( 1 );

$w->add( $form_data['field'][36], [ 49.5, 64.2, 41.4, 4 ] ); /* Mass Mutual Policy Number  */
$w->add( $insured_name, [ 86.4, 71, 41.4, 4 ] ); /* Insured Name */
$w->add( $owner_name, [ 89.5, 77.2, 41.4, 4 ] ); /* Policy Owner Name */

$w->tick( [ 97.8, 120.8] ); /* Type of Transaction: Loan is checked */

if ( ! empty( $form_data['field'][41] ) ) {
	$w->tick( [ 61.2, 127.2 ] ); /* Maximum Amount */
} else {
	$w->tick( [ 82.8, 127.2 ] ); /* Gross */
	$w->add( str_replace( '$', '', $form_data['field'][43] ), [ 118.4, 127.2, 36, 4 ] ); /* Gross Amount */
}

/* Type of Account Required */
switch ( $form_data['field'][10] ) {
	case 'Checking':
		$w->tick( [ 19.4, 139.8 ] ); /* Checking */
	break;

	case 'Savings':
		$w->tick( [ 19.4, 145.8 ] ); /* Savings */
	break;
}

$w->add( $owner_name, [ 70.4, 152.2, 94, 4 ] ); /* Policy Owner Name */
$w->add( $form_data['field'][11], [ 70.4, 158.2, 94, 4 ] ); /* Name of Financial Institution */

/* Routing Number broken down to single digits to fill in the boxes */

$routingNum = $form_data['field'][26]; /* Routing Number */
$routingLength = strlen($routingNum);
$f = 80;

for ($c = 0; $c <= $routingLength ; $c ++) { 
	# code...
	$rnum = substr($routingNum, $c, 1);

	$w->add( $rnum, [$f, 166, 40, 4]);

	$f = $f + 6.3;
}


/* Bank Account Number broken down to single digits to fill in the boxes */

$acctNum = $form_data['field'][27]; /* Bank Account Number */
$length = strlen($acctNum);
$e = 54.4;

for ($i = 0; $i <= $length ; $i ++) { 
	# code...
	$num = substr($acctNum, $i, 1);

	$w->add( $num, [$e, 175.4, 40, 4]);

	$e = $e + 6.3;
}


$w->addPage( 2 );

$w->add( $form_data['field'][36], [ 42.5, 12.7, 41.4, 4 ] ); /* Mass Mutual Policy Number  */

$w->add( $owner_name, [ 44.5, 61.7, 94, 4 ] ); /* Policy Owner Name */
$w->add( $form_data['field'][18], [ 158.5, 61.7, 41.4, 4 ] ); /* Current Date */


