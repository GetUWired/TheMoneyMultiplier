<?php

/*
 * Template Name: Lafayette Insurance Loan Request Form
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


// echo "<pre>";
// var_dump($form_data['field']);
// echo "</pre>";

$owner_name        = implode( ' ', array_filter( $form_data['field'][1] ) );
$insured_name      = implode( ' ', array_filter( $form_data['field'][20] ) );
$owner_spouse_name = implode( ' ', array_filter( $form_data['field'][18] ) );
// $date 			   = explode( ' / ', $form_data['field'][10]  );
$monthnum = substr($form_data['field'][10], 0, 2);
$daynum   = substr($form_data['field'][10], 3, 2);
$year  = substr($form_data['field'][10], 6, 4);


if ( $daynum == '01' || $daynum == '21' || $daynum == '31') {
	$day = $daynum . 'st';
} elseif ( $daynum == '02' || $daynum == '22' ) {
	$day = $daynum . 'nd';
} elseif ($daynum == '03' || $daynum == '23') {
	$day = $daynum . 'rd';
} else {
	$day = $daynum . 'th';
}


switch ($monthnum) {
    case '01':
        $month = 'January';
        break;
    case '02':
    	$month = 'February';
        break;
    case '03':
        $month = 'March';
        break;
    case '04':
    	$month = 'April';
        break;
    case '05':
        $month = 'May';
        break;
    case '06':
    	$month = 'June';
        break;     
    case '07':
        $month = 'July';
        break;
    case '08':
    	$month = 'August';
        break;
    case '09':
        $month = 'September';
        break;
    case '10':
    	$month = 'October';
        break;
    case '11':
        $month = 'November';
        break;
    case '12':
    	$month = 'December';
        break;
    default:
    	$month = 'month';
    	break;
    }

if($form_data['field'][64] == 'Jonah') {
    $mappingSpecialistEmail = 'jonah@themoneymultiplier.com';
} elseif ($form_data['field'][64] == 'Shannon'){
    $mappingSpecialistEmail = 'shannon@themoneymultiplier.com';   
} else {
    $mappingSpecialistEmail = 'terri@themoneymultiplier.com';
}

echo "field: " . $form_data['field'][64];
echo "mapping email: " . $mappingSpecialistEmail;


/*
 * Begin PDF Generation
 *
 * For full documentation, refer to https://gravitypdf.com/documentation/v4/shop-plugin-developer-toolkit/
 */



// $w->addBlankPage([ 'sheet-size' => [ 200, 20 ] ]);
// $x = 0;
// $y = 0;


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


$w->addPdf( __DIR__ . '/pdfs/LafayetteLoanRequest-1.pdf' ); /* CHANGE THIS TO POINT TO YOUR PDF */
$w->addPage( 1 );

$w->tick( [ 12.5, 19.6 ] ); /*  Lafayette Insurance Company */

$w->add( $form_data['field'][61], [ 48.5, 48.8, 91, 4 ] ); /* Policy Number */

$w->add( $insured_name, [ 124.5, 48.8, 91, 4 ] ); /* Insured's Name */
$w->add( $owner_name, [ 62.5, 58.5, 91, 4 ] );  /*Polcy Owner's Name */

if ( ! empty( $form_data['field'][5][0] ) ) {
	$w->tick( [ 18.2, 199.2 ] ); /* Maximum Amount */
} else {
	$w->tick( [ 18.2, 203.2 ] ); /* Gross */
	$w->add( str_replace( '$', '', $form_data['field'][19] ), [ 60.4, 202.8, 36, 4 ] ); /* Gross Amount */
}



$w->tick( [18.2, 207.5 ] ); /* Send by Electronic Transfer Fund */
$w->add( 'Send funds to EFT account on file. Contact ' . $mappingSpecialistEmail . ' with questions.', [ 56.4, 207, 150, 4 ] ); /* Special instructions */

// $w->add( 'Send funds to EFT account on file. Contact ' . $mappingSpecialistEmail . ' with questions.', [ 56.4, 207, 150, 4 ] ); /* Special instructions 



/*
 * LOAD PAGE 2
 */
$w->addPage( 2 );

/*
 * CERTIFICATION
 */

$w->add( implode( ' / ', array_filter( [ $form_data['field'][41]['street'], $form_data['field'][41]['street2'] ] ) ), [ 16.2, 203, 91, 4 ] ); /* Witness Street Address */
$w->add( implode( ', ', array_filter( [ $form_data['field'][41]['city'], $form_data['field'][41]['state'], $form_data['field'][41]['zip'] ] ) ), [ 16.2, 217.8, 91, 4 ] ); /* Witness City, State, Zip */



$w->add( $day , [ 34.6, 178.2, 41.4, 4 ] ); /* on */
$w->add( $month, [ 68.6, 178.2, 91, 4 ] ); /* month */
$w->add( $year,[ 128.6, 178.2, 91, 4 ] ); /* year */


/* Policy Owner's Address */
$w->add( implode( ' / ', array_filter( [ $form_data['field'][21]['street'], $form_data['field'][21]['street2'] ] ) ), [ 115.7, 203, 91, 4 ] ); /* Street Address */
$w->add( implode( ', ', array_filter( [ $form_data['field'][21]['city'], $form_data['field'][21]['state'], $form_data['field'][21]['zip'] ] ) ), [ 115.7, 217.8, 91, 4 ] ); /* City, State, Zip */
// $w->add( $form_data['field'][21]['country'], [ 110.7, 171.6, 91, 4 ] ); /* Country */
$w->add( $form_data['field'][42], [ 115.7, 245.4, 91, 4 ] ); /* Policy Owner's SSN/EIN/TIN */

$w->add( $form_data['field'][9], [ 115.7, 232.6, 91, 4 ] ); /* Policy Owner's Phone */




