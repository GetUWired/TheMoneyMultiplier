<?php

require_once 'conn.php';

//$app was set in conn.php

	$servername = "localhost";
	$username = "tmmwpu2";
	$password = "DrffeA5s6q&fYu1s";
	$database = "admin_tmmwp2";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $database);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	echo "Connected successfully" . "<br/>";

	// because we are pulling a fresh report each time, we need to delete all of the rows from the table initially
	$deleteRows = "DELETE FROM NewInforceMonthlyReport";
	// prepare
	$stmt = $conn->prepare($deleteRows);
	$stmt->execute();
	$stmt->close();


	// identify the id of the Agent Report in Infusionsoft
	$agentReportId = 35;
	// identify the user who created the Agent Report in Infusionsoft
	$userId = 2373;
	// pull the saved search from Infusionsoft (an array)
	$allNewPolicies = $app->savedSearchAllFields($agentReportId, $userId, 0);

	foreach ($allNewPolicies as $key => $value) {
		// echo '<pre>';
		// print_r($value);
		// echo '</pre>';

		// pull values from the saved search (an array)
		$ISid = $value['Id'];
		$firstName = $value['ContactName.firstName'];
		$lastName = $value['ContactName.lastName'];
		$policyAmt = $value['Custom_PolicyAmount'];


		$inforceDateTime = $value['Custom_InforceDate'];
		$inforceDateTrim = explode("T", $inforceDateTime);
		$inforceDate = $inforceDateTrim[0];

		$owner1 = $value['Custom_ComissionOwner12'];
		$explodeOwner1 = explode("|", $owner1);
		$commissionOwner1 = $explodeOwner1[0];
		$commissionPercent1 = $explodeOwner1[1];

		if ($commissionOwner1 == '' || $commissionOwner1 == ' ') {
			$new1 = '';
		} else {
			$new1 = $commissionOwner1 . ' - ' . $commissionPercent1 . '%';
		}


		$owner2 = $value['Custom_ComissionOwner2'];
		$explodeOwner2 = explode("|", $owner2);
		$commissionOwner2 = $explodeOwner2[0];
		$commissionPercent2 = $explodeOwner2[1];

		if ($commissionOwner2 == '' || $commissionOwner2 == ' ') {
			$new2 = '';
		} else {
			$new2 = $commissionOwner2 . ' - ' . $commissionPercent2 . '%';
		}


		$owner3 = $value['Custom_ComissionOwner3'];
		$explodeOwner3 = explode("|", $owner3);
		$commissionOwner3 = $explodeOwner3[0];
		$commissionPercent3 = $explodeOwner3[1];

		// echo 'commission owner 3 ' . $commissionOwner3 . '<br/>';

		if ($commissionOwner3 == '' || $commissionOwner3 == ' ') {
			$new3 = '';
		} else {
			$new3 = $commissionOwner3 . ' - ' . $commissionPercent3 . '%';
		}


		$owner4 = $value['Custom_ComissionOwner4'];
		$explodeOwner4 = explode("|", $owner4);
		$commissionOwner4 = $explodeOwner4[0];
		$commissionPercent4 = $explodeOwner4[1];

		if ($commissionOwner4 == '' || $commissionOwner4 == ' ') {
			$new4 = '';
		} else {
			$new4 = $commissionOwner4 . ' - ' . $commissionPercent4 . '%';
		}


		$owner5 = $value['Custom_ComissionOwner5'];
		$explodeOwner5 = explode("|", $owner5);
		$commissionOwner5 = $explodeOwner5[0];
		$commissionPercent5 = $explodeOwner5[1];

		if ($commissionOwner5 == '' || $commissionOwner5 == ' ') {
			$new5 = '';
		} else {
			$new5 = $commissionOwner5 . ' - ' . $commissionPercent5 . '%';
		}


		$owner6 = $value['Custom_ComissionOwner6'];
		$explodeOwner6 = explode("|", $owner6);
		$commissionOwner6 = $explodeOwner6[0];
		$commissionPercent6 = $explodeOwner6[1];

		if ($commissionOwner6 == '' || $commissionOwner6 == ' ') {
			$new6 = '';
		} else {
			$new6 = $commissionOwner6 . ' - ' . $commissionPercent6 . '%';
		}


		$owner7 = $value['Custom_ComissionOwner7'];
		$explodeOwner7 = explode("|", $owner7);
		$commissionOwner7 = $explodeOwner7[0];
		$commissionPercent7 = $explodeOwner7[1];

		if ($commissionOwner7 == '' || $commissionOwner7 == ' ') {
			$new7 = '';
		} else {
			$new7 = $commissionOwner7 . ' - ' . $commissionPercent7 . '%';
		}


		$owner8 = $value['Custom_ComissionOwner81'];
		$explodeOwner8 = explode("|", $owner8);
		$commissionOwner8 = $explodeOwner8[0];
		$commissionPercent8 = $explodeOwner8[1];

		if ($commissionOwner8 == '' || $commissionOwner8 == ' ') {
			$new8 = '';
		} else {
			$new8 = $commissionOwner8 . ' - ' . $commissionPercent8 . '%';
		}


		$owner9 = $value['Custom_ComissionOwner9'];
		$explodeOwner9 = explode("|", $owner9);
		$commissionOwner9 = $explodeOwner9[0];
		$commissionPercent9 = $explodeOwner9[1];

		if ($commissionOwner9 == '' || $commissionOwner9 == ' ') {
			$new9 = '';
		} else {
			$new9 = $commissionOwner9 . ' - ' . $commissionPercent9 . '%';
		}


		$owner10 = $value['Custom_ComissionOwner10'];
		$explodeOwner10 = explode("|", $owner10);
		$commissionOwner10 = $explodeOwner10[0];
		$commissionPercent10 = $explodeOwner10[1];

		if ($commissionOwner10 == '' || $commissionOwner10 == ' ') {
			$new10 = '';
		} else {
			$new10 = $commissionOwner10 . ' - ' . $commissionPercent10 . '%';
		}

		//insert each line into the table 
		$sql = "INSERT INTO NewInforceMonthlyReport (Id, InsuredFirstName, InsuredLastName, PolicyAmt, InforceDate, CommissionOwner1, CommissionOwner2, CommissionOwner3, CommissionOwner4, CommissionOwner5, CommissionOwner6, CommissionOwner7, CommissionOwner8, CommissionOwner9, CommissionOwner10) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

			if(!($stmt2 = $conn->prepare($sql))) {
				echo "insert fail: " . $conn->errno . " error " . $conn->error;
			}

			if(!$stmt2->bind_param("ississsssssssss", $ISid, $firstName, $lastName, $policyAmt, $inforceDate, $new1, $new2, $new3, $new4, $new5, $new6, $new7, $new8, $new9, $new10)) {

				echo "bind params failed (" . $stmt2->errno . " ) " . $stmt2->error;
			}

			$stmt2->execute();

			echo "success new records" . "<br/>";


	}


?>