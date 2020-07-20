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
	$deleteRows = "DELETE FROM MappingReport";
	// prepare
	$stmt = $conn->prepare($deleteRows);
	$stmt->execute();
	$stmt->close();

	// identify the id of the Agent Report in Infusionsoft
	$mappingReportId = 87;
	// identify the user who created the Agent Report in Infusionsoft
	$userId = 2373;
	// pull the saved search from Infusionsoft (an array)
	$allMappingReporting = $app->savedSearchAllFields($mappingReportId, $userId, 0);

	// echo "<pre>";
	// print_r($allMappingReporting);
	// echo "</pre>";


	foreach ($allMappingReporting as $key => $value) {

		// pull values from the saved search (an array)
		$ISid = $value['Id'];
		$firstName = $value['ContactName.firstName'];
		$lastName = $value['ContactName.lastName'];
		$mappingSpecialist = $value['Owner'];

		// echo $mappingSpecialist;

		$commentsWithSingleQuote = $value['ContactNotes'];
		$commentWithSub = str_replace("'", "_", $commentsWithSingleQuote);
		if ($commentWithSub == "") {
			$comments = "no extra information";			
		} else {
			$comments = $commentWithSub;
		}


		$mappingDateTime = $value['Custom_EnrolledinMappingDate'];
		$mapDateTrim = explode("T", $mappingDateTime);
		$mappingDate = $mapDateTrim[0];


		$nextMappingDateTime = $value['Custom_NextMappingDate'];
		$nextMapDateTrim = explode("T", $nextMappingDateTime);
		$nextMappingDate = $nextMapDateTrim[0];		


		$loanRequestApprovedDateTime = $value['Custom_ApprovedLoanRequestDate17'];
		$loanDateTrim = explode("T", $loanRequestApprovedDateTime);
		$loanRequestApprovedDate = $loanDateTrim[0];




		$sql = "INSERT INTO MappingReport (Id, FirstName, LastName, Comments, MappingCompleteDate, NextMappingDate, LoanRequestDate, MappingSpecialist) VALUES (?,?,?,?,?,?,?,?)";

		if(!($stmt2 = $conn->prepare($sql))) {
			echo "insert fail: " . $conn->errno . " error " . $conn->error;
		}	

		if(!$stmt2->bind_param("isssssss", $ISid, $firstName, $lastName, $comments, $mappingDate, $nextMappingDate, $loanRequestApprovedDate, $mappingSpecialist)) {

			echo "bind params failed (" . $stmt2->errno . " ) " . $stmt2->error;
		}

		$stmt2->execute();

		echo "success new records" . "<br/>";

	}

	$stmt2->close();
	//close the connection
	$conn->close();

?>

