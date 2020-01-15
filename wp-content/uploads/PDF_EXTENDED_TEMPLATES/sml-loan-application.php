<?php

/*
 * Template Name: SML Loan Application
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
		.spacer {
			font-family: DejaVuSansMono, monospaced;
			letter-spacing: 3.5mm;
			font-size: 10pt;
		}
	</style>
<?php
$w->endStyles();

$w->configTick( [
	'font-size'   => 16,
	'line-height' => 11.3,
] );

$owner_name        = implode( ' ', array_filter( $form_data['field'][1] ) );
$insured_name      = implode( ' ', array_filter( $form_data['field'][20] ) );
$owner_spouse_name = implode( ' ', array_filter( $form_data['field'][18] ) );
$account_name      = ( ! empty( $form_data['field'][33] ) ) ? $insured_name : implode( ' ', array_filter( $form_data['field'][32] ) );

/*
 * Begin PDF Generation
 *
 * For full documentation, refer to https://gravitypdf.com/documentation/v4/shop-plugin-developer-toolkit/
 */
$pdf = ( strpos( $form_data['field'][11], 'I am married' ) !== false ) ? 'SML-Loan-Application-spouse.pdf' : 'SML-Loan-Application.pdf';
$w->addPdf( __DIR__ . '/pdfs/' . $pdf ); /* CHANGE THIS TO POINT TO YOUR PDF */
$w->addPage( 1 );

/*
 * SECTION ONE - Client Information and Policy Loan Information
 */
$w->add( $form_data['field'][39], [ 52.6, 60, 111, 4 ] ); /* Policy Number */
$w->add( $insured_name, [ 59.6, 68.5, 104.4, 4 ] ); /* Name of Insured(s) */

$loan_amount = ( ! empty( $form_data['field'][5] ) ) ? 'Maximum' : str_replace( '$', '', $form_data['field'][19] );
$w->add( $loan_amount, [ 95.2, 103, 20.2, 4 ] ); /* 4. Loan Amount */

/*
 * SECTION TWO – Request for "Policyowner" Taxpayer Identification Number and Certification
 */

/* 5. Social Security Number */
$ssn = explode( '-', $form_data['field'][22] );
$w->add( '<span class="spacer">' . $ssn[0] . '</span>', [ 44.4, 189.5, 17, 4 ], 'visible' );
$w->add( '<span class="spacer">' . $ssn[1] . '</span>', [ 67, 189.5, 11.8, 4 ], 'visible' );
$w->add( '<span class="spacer">' . $ssn[2] . '</span>', [ 83.6, 189.5, 24, 4 ], 'visible' );

/* 5. Employer Identification Number */
$ein = explode( '-', $form_data['field'][36] );
$w->add( '<span class="spacer">' . $ein[0] . '</span>', [ 119.4, 189.5, 11.8, 4 ], 'visible' );
$w->add( '<span class="spacer">' . $ein[1] . '</span>', [ 136.4, 189.5, 42, 4 ], 'visible' );

/* Tax Classifcation */
switch( $form_data['field'][43] ) {
	case 'Individual/sole proprietor':
		$w->tick( [ 79.5, 195 ] ); /* Individual/sole proprietor */
	break;

	case 'C Corporation':
		$w->tick( [ 116.5, 195 ] ); /* C Corporation */
	break;

	case 'S Corporation':
		$w->tick( [ 139.2, 195 ] ); /* S Corporation */
	break;

	case 'Partnership':
		$w->tick( [ 161.8, 195 ] ); /* Partnership */
	break;

	case 'Trust/estate':
		$w->tick( [ 181.6, 195 ] ); /* Trust/estate */
	break;
}

//$w->tick( [ 15, 199.4 ] ); /* LLC */

//$w->add( 'my content', [ 151, 199.7, 16.6, 4 ] ); /* Tax classification */
//$w->add( 'my content', [ 178, 199.7, 23.5, 4 ] ); /* Tax classification - other */

/*
 * LOAD PAGE 2
 */
$w->addPage( 2 );

/*
 * SECTION 3 - SIGNATURES
 */

$w->add( implode( ', ', array_filter( [ $form_data['field'][41]['city'], $form_data['field'][41]['state'] ] ) ), [ 56.5, 61.7, 80, 4 ] ); /* 6. Signed at (city, state) */
$w->add( $form_data['field'][10], [ 153.3, 61.7, 47.6, 4 ] ); /* 7. Date */
$w->add( $owner_name, [ 56.2, 87.7, 144.5, 4 ] ); /* 9. Policyowner Name (printed) */
$w->add( $form_data['field'][9], [ 68, 94.7, 132.8, 4 ] ); /* 10. Policyowner Daytime Phone # */
$w->add( $owner_spouse_name, [ 52.7, 126.7, 148.3, 4 ] ); /* 14. Spouse's Name (printed) */

/*
 *  SECTION FOUR – Request for Electronic Disbursement To Policyowner’s Checking Account
 */

/* 19. Checking Acount Information */
$w->add( $account_name, [ 47.5, 206.7, 153.8, 4 ] ); /* Name(s) on Account */
$w->add( $form_data['field'][29], [ 41.8, 219.4, 158.8, 4 ] ); /* Account Number */
$w->add( $form_data['field'][27], [ 56, 230.8, 145, 4 ] ); /* Financial Institution's Name */

$bank_address = implode( ', ', array_filter( [ $form_data['field'][31]['street'], $form_data['field'][31]['street2'] ] ) );
$w->add( $bank_address, [ 60.2, 243.8, 52.5, 4 ] ); /* Financial Institution's Address - Street */
$w->add( $form_data['field'][31]['city'], [ 114.5, 243.8, 44.5, 4 ] ); /* Financial Institution's Address - City */
$w->add( $form_data['field'][31]['state'], [ 160.2, 243.8, 24.5, 4 ] ); /* Financial Institution's Address - State */
$w->add( $form_data['field'][31]['zip'], [ 185.8, 243.8, 15.5, 4 ] ); /* Financial Institution's Address - Zip */
